<?php
	/**
	*
	*/
	class Survey extends CI_Model
	{
		var $data;
		var $opts;
		function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Dhaka");
			$this->data = array(  // create a sql trigger to get the information when the data is inserted on a table by whome.
				"fbk_survey"=>"CREATE TABLE fbk_survey (fbkid INT NOT NULL AUTO_INCREMENT, etitle VARCHAR(256) NULL, btitle VARCHAR(256) NULL, detail VARCHAR(512) NULL, active VARCHAR(3) NULL, ctime TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, utime TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (fbkid))",
				"fbk_questions"=>"CREATE TABLE fbk_questions (fbqid INT NOT NULL AUTO_INCREMENT, fbkid INT NOT NULL, etitle VARCHAR(256) NULL, btitle VARCHAR(256) NULL, detail VARCHAR(512) NULL, ratings INT NULL DEFAULT 7, cenble VARCHAR(1) NULL DEFAULT 'F', utime TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (fbqid))",
				"fbk_answers"=>"CREATE TABLE fbk_answers (uid VARCHAR(64) NOT NULL, fbqid INT NOT NULL, answer INT NULL DEFAULT 0, comments VARCHAR(512) NULL, ctime TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (uid, fbqid))",
        "fbk_user"=>"CREATE TABLE fbk_user_list (uid VARCHAR(64) NOT NULL, fbkid INT NOT NULL, numqus INT NULL, done VARCHAR(1) NULL DEFAULT 'N', utime TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (uid, fbkid)) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_bin"
			);
			$this->opts = array("Agree Strongly", "Agree Moderately", "Agree Slightly", "Neither Agree nor Disagree", "Disagree Slightly", "Disagree Moderately", "Disagree Strongly");
		}
		function initiate_survay() {  // init the table and data
			$tst = $this->db->table_exists('fbk_user_list');
			if (!$tst) {
				$this->db->query($this->data['fbk_survey']);
				$this->db->query($this->data['fbk_questions']);
				$this->db->query($this->data['fbk_answers']);
				$this->db->query($this->data['fbk_user']);
			}
		}
		function servey_exist($etit, $btit) {
			$exist = 0;
			$dt = $this->db->get_where('fbk_survey', array('etitle'=>$etit, 'btitle'=>$btit));
			if($dt->num_rows() > 0){
				$exist = 1;
			}
			else {
				$dt = $this->db->get_where('fbk_survey', array('etitle'=>$etit));
				if($dt->num_rows() > 0){
					$exist = 2;
				}
				$dt = $this->db->get_where('fbk_survey', array('btitle'=>$btit));
				if($dt->num_rows() > 0){
					$exist = 3;
				}
			}
			return $exist;
		}
		function save_survey($etit, $btit, $dtl, $act='F') {
			if($this->servey_exist($etit, $btit) == 0){
				$this->db->insert('fbk_survey', array('etitle'=>$etit, 'btitle'=>$btit, 'detail'=>$dtl, 'active'=>$act));
				return true;
			}
			return false;
		}
		function update_survey($sid, $etit, $btit, $dtl, $act='F') {
			$this->db->where(array('fbkid'=>$sid));
			$this->db->update('fbk_survey', array('etitle'=>$etit, 'btitle'=>$btit, 'detail'=>$dtl, 'active'=>$act));
			return true;
		}
		function question_exist($sid, $etit, $btit) {
			$exist = 0;
			$dt = $this->db->get_where('fbk_questions', array('fbkid'=>$sid, 'etitle'=>$etit, 'btitle'=>$btit));
			if($dt->num_rows() > 0){
				$exist = 1;
			}
			else {
				$dt = $this->db->get_where('fbk_questions', array('fbkid'=>$sid, 'etitle'=>$etit));
				if($dt->num_rows() > 0 && $etit!=""){
					$exist = 2;
				}
				$dt = $this->db->get_where('fbk_questions', array('fbkid'=>$sid, 'btitle'=>$btit));
				if($dt->num_rows() > 0 && $btit!=""){
					$exist = 3;
				}
			}
			return $exist;
		}
		function add_question($sid, $etit, $btit, $dtl, $cen='F', $rat=7) {
			if($this->question_exist($sid, $etit, $btit) == 0){
				$this->db->insert('fbk_questions', array('fbkid'=>$sid, 'etitle'=>$etit, 'btitle'=>$btit, 'detail'=>$dtl, 'cenble'=>$cen, 'ratings'=>$rat));
				return true;
			}
			// return $this->db->last_query();
			return false;
		}
		function update_question($qid, $sid, $etit, $btit, $dtl, $cen='F', $rat=7) {
			$this->db->where(array('fbqid'=>$qid, 'fbkid'=>$sid));
			$this->db->update('fbk_questions', array('fbkid'=>$sid, 'etitle'=>$etit, 'btitle'=>$btit, 'detail'=>$dtl, 'cenble'=>$cen, 'ratings'=>$rat));
			return true;
		}
		function save_answer($uid, $sid, $qid, $ans=0, $com='') {
			$dtu = $this->db->get_where('fbk_user_list', array('uid'=>$uid, 'fbkid'=>$sid));
			if($dtu->num_rows()==0)
				$this->db->insert('fbk_user_list', array('uid'=>$uid, 'fbkid'=>$sid, 'numqus'=>$qid));
			else{
				$this->db->where(array('uid'=>$uid, 'fbkid'=>$sid));
				$this->db->update('fbk_user_list', array('numqus'=>$qid));
			}
			$uid = md5($uid);
			$dt = $this->db->get_where('fbk_answers', array('uid'=>$uid, 'fbqid'=>$qid));
			if($dt->num_rows() == 0){
				$this->db->insert('fbk_answers', array('uid'=>$uid, 'fbqid'=>$qid, 'answer'=>$ans, 'comments'=>$com));
			}
			else {
				$this->db->where(array('uid'=>$uid, 'fbqid'=>$qid));
				$this->db->update('fbk_answers', array('answer'=>$ans, 'comments'=>$com));
			}
			return true;
		}
		function complete_answer($uid, $sid, $qid=0) {
			$dtu = $this->db->get_where('fbk_user_list', array('uid'=>$uid, 'fbkid'=>$sid));
			if($dtu->num_rows()==0)
				$this->db->insert('fbk_user_list', array('uid'=>$uid, 'fbkid'=>$sid, 'numqus'=>$qid));
			else{
				$this->db->where(array('uid'=>$uid, 'fbkid'=>$sid));
				$this->db->update('fbk_user_list', array('done'=>'Y'));
			}
		}
		function get_survey($sid=0) {
			if($sid==0) {
				$dt = $this->db->get('fbk_survey');
			}
			else {
				$dt = $this->db->get_where('fbk_survey', array('fbkid'=>$sid));
			}
			return $dt->result();
		}
		function get_questions($sid=0) {
			$output = array();
			if($sid==0) {
				$this->db->order_by('fbkid', "DESC");
				$dt = $this->db->get('fbk_questions');
				$res = $dt->result();
				foreach ($res as $k => $val) {
					$output[$val->fbkid][$val->fbqid] = $val;
				}
			}
			else {
				$dt = $this->db->get_where('fbk_questions', array('fbkid'=>$sid));
				$res = $dt->result();
				foreach ($res as $k => $val) {
					$output[$val->fbqid] = $val;
				}
			}
			return $output;
		}
		function get_answers($sid, $qid=0, $uid='') {
			$output = array();
			if($qid==0 && $uid=='') {
				$dt = $this->db->query('SELECT * FROM fbk_questions q, fbk_answers a WHERE q.fbqid=a.fbqid and q.fbkid='.$sid.' ORDER BY q.fbqid');
			}
			else {
				if($qid!=0 && $uid!='') {
					$dt = $this->db->query('SELECT * FROM fbk_questions q, fbk_answers a WHERE q.fbqid=a.fbqid and q.fbkid='.$sid.' AND a.uid="'.$uid.'" AND fbqid="'.$qid.'" ORDER BY q.fbqid');
				}
				else if($qid!=0) {
					$dt = $this->db->query('SELECT * FROM fbk_questions q, fbk_answers a WHERE q.fbqid=a.fbqid and q.fbkid='.$sid.' AND fbqid="'.$qid.'" ORDER BY q.fbqid');
				}
				else if($uid!='') {
					$dt = $this->db->query('SELECT * FROM fbk_questions q, fbk_answers a WHERE q.fbqid=a.fbqid and q.fbkid='.$sid.' AND a.uid="'.$uid.'" ORDER BY q.fbqid');
				}
			}
			return $dt->result();
		}
		function get_answers_array($sid) {
			$output = array();
			$qdt = $this->db->query("SELECT * FROM fbk_questions WHERE fbkid=".$sid);
			$qres = $qdt->result();
			foreach ($qres as $v) {
				$dt = $this->db->query('SELECT * FROM fbk_answers WHERE fbqid='.$v->fbqid.' ORDER BY fbqid');
				$res = $dt->result();
				$resa = array(0, 0, 0, 0, 0, 0, 0);
				foreach ($res as $vl) {
					$resa[$vl->answer] += 1;
				}
				$output[$v->fbqid]= array('qus'=>$v, 'ans'=>$res, 'res'=>$resa, 'num'=>$dt->num_rows());
			}
			return $output;
		}
	}
?>
