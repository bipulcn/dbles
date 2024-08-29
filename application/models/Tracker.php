<?php
	/**
	*
	*/
	class Tracker extends CI_Model
	{
		var $data;
		var $now;
		function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Dhaka");
			$this->now = date('Y-m-d H:i:s');
			$this->data = array(  // create a sql trigger to get the information when the data is inserted on a table by whome.
				"tk_agents"=>"CREATE TABLE tk_agents ( tkid INT NOT NULL AUTO_INCREMENT, sid VARCHAR(64) NULL, agents VARCHAR(192) NULL, ipadd VARCHAR(16) NULL, ports VARCHAR(16) NULL, rtime  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (tkid)) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_bin",
				"tk_users"=>"CREATE TABLE tk_users ( tuid INT NOT NULL AUTO_INCREMENT, tkid INT NOT NULL, uid VARCHAR(128) NOT NULL, actime VARCHAR(3) NULL, utime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (tuid, tkid, uid)) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_bin",
				"tk_pages"=>"CREATE TABLE tk_pages ( tuid INT NOT NULL, referer_url VARCHAR(128) NOT NULL, seconds INT NOT NULL, ntimes INT NULL, active VARCHAR(1) NULL, utime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (tuid, referer_url))",
				"tk_activity"=>"CREATE TABLE tk_activity ( tuid INT NOT NULL, tag VARCHAR(64) NOT NULL, url_con VARCHAR(128) NOT NULL, ntimes INT NULL, utime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (tuid, url_con))",
				"ip"=>$_SERVER['REMOTE_ADDR'],
				"agent"=>$_SERVER['HTTP_USER_AGENT'],
				"url"=>substr($_SERVER['REQUEST_URI'], 0, 127),
				"rurl"=>substr($_SERVER['PHP_SELF'], 0, 127),
				"port"=>$_SERVER['REMOTE_PORT'],
				"rtime"=>$_SERVER['REQUEST_TIME'],
				"sid"=>(isset($this->session->s_id))? $this->session->s_id: ''
			);
			$this->initiate_tracker();
			if(!isset($this->session->s_id))
				$this->session->s_id = session_id();
			else {   // Shoud i remove this part
				$dt = $this->db->get_where('tk_agents', array('sid'=>$this->session->s_id));
				$row = $dt->result();
				$this->session->tkid = $row[0]->tkid;
				$this->user_update();
				$this->page_viewed();
			}
		}
		function initiate_tracker() {  // init the table and data
			$tst = $this->db->table_exists('tk_activity');
			if (!$tst) {
				$this->db->query($this->data['tk_agents']);
				$this->db->query($this->data['tk_users']);
				$this->db->query($this->data['tk_pages']);
				$this->db->query($this->data['tk_activity']);
			}
			$dt = $this->db->get_where('tk_agents', array('sid'=>$this->session->s_id));
			if($dt->num_rows() == 0){
				$this->db->insert('tk_agents', array('sid'=>$this->session->s_id, 'agents'=>$this->data['agent'],  'ipadd'=>$this->data['ip'], "ports"=>$this->data['port'], 'rtime'=>$this->now));
				$this->session->tkid = $this->db->insert_id();
				$this->user_update();
			}
		}
		function user_update() {
			$uid = ($this->session->userid=='')? 'visitor': $this->session->userid;
			$dt = $this->db->get_where('tk_users', array('tkid'=>$this->session->tkid, 'uid'=>$uid));
			if($dt->num_rows() == 0)
				$this->db->insert('tk_users', array('tkid'=>$this->session->tkid, 'uid'=>$uid, "actime"=>0, 'utime'=>$this->now));
			else {
				$row = $dt->result();
				$act = $row[0]->actime;
				$tim = $row[0]->utime;
				$tuid = $row[0]->tuid;
				$this->session->tuid = $tuid;
				$ntdt = $this->db->query("SELECT TIMESTAMPDIFF(second,'".$tim."', '".$this->now."') tmsec");
				$nrw = $ntdt->result();
				$act += $nrw[0]->tmsec;
				$this->db->where(array('tuid'=>$tuid));
	      		$this->db->update('tk_users', array( "actime"=>$act, 'utime'=>$this->now));
			}
			$this->getTuid();
		}
		function page_viewed() {
			$tuid = $this->getTuid();
			$dt = $this->db->get_where('tk_pages', array('tuid'=>$tuid, 'referer_url'=>$this->data['rurl']));
			if($dt->num_rows()==0)
				$this->db->insert('tk_pages', array('tuid'=>$tuid, 'referer_url'=>$this->data['rurl'], 'seconds'=>0, 'ntimes'=>1, 'active'=>'Y', 'utime'=>$this->now));
			else {  // when row exist in database so, check if its yes then update the time else
				$row = $dt->result();
				$sec = $row[0]->seconds;  // becareful about the time when we change between pages. I have to select the last page which was opened by selecting active.
				$tim = $row[0]->utime;
				$num = $row[0]->ntimes+1;
				$act = $row[0]->active;
				if($act!='Y') { // if it was not active then update with old time and update updatetime
					$ndt = $this->db->get_where('tk_pages', array('tuid'=>$tuid, 'active'=>'Y'));
					$nrow = $ndt->result(); // we considerd that user haven't hide the browser
					$nsec = $nrow[0]->seconds;
					$utim = $nrow[0]->utime;
					$rurl = $nrow[0]->referer_url;
					$ntdt = $this->db->query("SELECT TIMESTAMPDIFF(second,'".$utim."', '".$this->now."') tmsec");
					$nrw = $ntdt->result();
					$nsec += $nrw[0]->tmsec;
					$this->db->where(array('tuid'=>$tuid, 'referer_url'=>$rurl));
		      		$this->db->update('tk_pages', array( "seconds"=>$nsec, 'active'=>'N', 'utime'=>$this->now));
					$this->db->where(array('tuid'=>$tuid, 'referer_url'=>$this->data['rurl']));
		      		$this->db->update('tk_pages', array("ntimes"=>$num, 'active'=>'Y', 'utime'=>$this->now));
				}
				else { // update and add current times
					$ntdt = $this->db->query("SELECT TIMESTAMPDIFF(second,'".$tim."', '".$this->now."') tmsec");
					$nrw = $ntdt->result();
					$sec += $nrw[0]->tmsec;
					$this->db->where(array('tuid'=>$tuid, 'referer_url'=>$this->data['rurl']));
	      			$this->db->update('tk_pages', array( "seconds"=>$sec, "active"=>'Y', 'utime'=>$this->now));
				}
			}
		}
		function activityTracker($dt, $tag) {
			$tuid = $this->getTuid();
			$dt = $this->db->get_where('tk_activity', array('tuid'=>$tuid, 'url_con'=>$dt, 'tag'=>$tag));
			if($dt->num_rows()==0)
				$this->db->insert('tk_activity', array('tuid'=>$tuid, 'url_con'=>$dt, 'tag'=>$tag, 'ntimes'=>1, 'utime'=>$this->now));
			else {
				$nrow = $ndt->result();
				$nnum = $nrow[0]->ntimes+1;
				$this->db->update('tk_activity', array('ntimes'=>$nnum), array('tuid'=>$tuid, 'url_con'=>$dt, 'tag'=>$tag));
			}
		}
		function getTuid() {
			$uid = ($this->session->userid=='')? 'visitor': $this->session->userid;
			$dt = $this->db->get_where('tk_users', array('tkid'=>$this->session->tkid, 'uid'=>$uid));
			$row = $dt->result();
			$tuid = $row[0]->tuid;
			$this->session->tuid = $tuid;
			return $tuid;
		}
	}
?>
