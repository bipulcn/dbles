<?php

/**
 *
 */
class User extends CI_Model
{
	var $data;
	var $tuser = "users";
	var $tdetail = "user_detail";
	function __construct()
	{
		parent::__construct();
		$this->data = array(
			"datafile" => "SELECT * FROM datafile"
		);
	}
	function checkUser($id, $pass)
	{
		// $haspas = md5($pass);
		if (!filter_var($id, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[\'\"\s=<>&^]/"))) && !filter_var($pass, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[\'\"\s=<>]/")))) {
			$id = substr($id, 0, 64);
			// $fild = 'email';
			// if (!filter_var($id, FILTER_VALIDATE_EMAIL))
			// 	$fild = 'uname';
			$qur = $this->db->query("SELECT salts FROM " . $this->tuser . " WHERE uid='" . $id . "'");
			if ($qur->num_rows() > 0) {
				$res = $qur->result();
				$salt = $res[0]->salts;
				$haspas = hash("sha256", $pass . $salt, false);
				$qur = "SELECT * FROM " . $this->tuser . " WHERE uid='" . $id;
				$qur .= "' AND password='" . $haspas . "'";
				$query = $this->db->query($qur);
				if ($query->num_rows() > 0) {
					return $query->result();
				} else {
					$haspas = md5($pass);
					$qur = "SELECT * FROM " . $this->tuser . " WHERE uid='" . $id . "' AND password='" . $haspas . "'";
					$query = $this->db->query($qur);
					if ($query->num_rows() > 0) {
						$this->securePass($pass, $id);
						return $query->result();
					} else {
						return [];
					}
				}
			} else return [];
		} else
			return [];
	}
	function checkDetails($uid)
	{
		$qur = $this->db->query("SELECT * FROM " . $this->tdetail . " WHERE uid='" . $uid . "'");
		if (sizeof($qur->result()) == 0)
			$this->db->query("INSERT INTO " . $this->tdetail . " (uid) VALUES ('" . $uid . "')");
	}

	function createUser($id, $pas, $nam, $uni, $rol, $pho, $ema, $ses, $iid, $dep, $des)
	{
		$salt = substr(md5(rand()), 0, 7);
		$pass = hash("sha256", $pas . $salt, false);
		$ins = "INSERT INTO " . $this->tuser . " (uid, salts, password, role, valid, cdate, udate) VALUES ('" . $id . "','" . $salt . "','" . $pass . "','G','N', now(), now())";
		$this->db->query($ins);
		$this->db->query("INSERT INTO " . $this->tdetail . "(uid, name, unid, role, phone, email, session, intid, department, designation, udate) VALUES ('" . $id . "','" . $nam . "','" . $uni . "','" . $rol . "','" . $pho . "','" . $ema . "','" . $ses . "','" . $iid . "','" . $dep . "','" . $des . "', now())");
	}
	function getUserDetails($id)
	{
		$qur = $this->db->query("SELECT * FROM " . $this->tdetail . " WHERE uid='" . $id . "'");
		return $qur->result();
	}
	function saveImg($uid, $img)
	{
		$ins = "UPDATE " . $this->tdetail . " SET imgs='" . $img . "' WHERE uid='" . $uid . "'";
		$this->db->query($ins);
	}
	function userNotExist($id)
	{
		$not = true;
		if ($this->userIdExist($id))
			$not = false;
		return $not;
	}
	function userIdExist($uid)
	{
		$quer = $this->db->query("SELECT * FROM " . $this->tuser . " WHERE uid='" . $uid . "'");
		$output = false;
		if ($quer->num_rows() > 0)
			$output = true;
		return $output;
	}
	function securePass($pass, $id)
	{ // 608f0b988db4a96066af7dd8870de96c
		$salt = substr(md5(rand()), 0, 7);
		$password = hash("sha256", $pass . $salt, false);
		$qur = "UPDATE " . $this->tuser . " SET salts='" . $salt . "', password='" . $password . "' WHERE uid='" . $id . "'";
		$this->db->query($qur);
		if (!$this->checkupdatePass($id, $password, $salt)) {
			$this->db->query($qur);
		}
	}
	function checkupdatePass($id, $pass, $salt)
	{
		$haspas = hash("sha256", $pass . $salt, false);
		$qur = "SELECT * FROM " . $this->tuser . " WHERE uid='" . $id . "' AND password='" . $haspas . "'";
		$cks = $this->ifexist($qur);
		return $cks;
	}
	function updatePass($id, $opas, $pass)
	{
		$cks = $this->checkUser($id, $opas);
		if (sizeof($cks) > 0) {
			$this->securePass($pass, $id);
			return true;
		} else
			return false;
	}
	function changePass($uid, $pass)
	{
		$this->securePass($pass, $uid);
		return true;
	}
	function checkUserName($id)
	{
		if (!preg_match("/^[a-zA-Z0-9_.]*$/", $id))
			echo "Only letters, numbers and _ . allowed";
		else
			echo "You are with current format";
	}
	function userOtherInfos($table, $dta)
	{
		// $this->db-insert($table, $dta);
	}
	function runqury($query)
	{
		$query = $this->db->query($query);
		return $this->db->insert_id();
	}
	function blankqury($query)
	{
		$this->db->query($query);
	}
	function lstAutoId()
	{
		return $this->db->insert_id();
	}
	function getResults($qur)
	{
		$query = $this->db->query($qur);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return NULL;
		}
	}
	function ifexist($qur)
	{
		$query = $this->db->query($qur);
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function checkColExist($nm)
	{
		$quer = $this->db->query("SELECT intid FROM institutes WHERE name='" . $nm . "'");
		if ($quer->num_rows() > 0) {
			$res = $quer->result();
			return $res[0]->intid;
		} else {
			$nnm = join("|", array_filter(explode(" ", preg_replace('/college|madrasa|school/i', '', $nm)), 'strlen'));
			return $this->db->query("SELECT * FROM institutes WHERE name RegExp '" . $nnm . "' ORDER BY name")->result();
		}
	}
	function getInstitute($uid)
	{
		$res = $this->db->query("SELECT inid FROM " . $this->tdetail . " WHERE uid='" . $uid . "'")->result();
		if (sizeof($res) > 0)
			return $res[0]->institute;
		else
			return null;
	}
	function deleteUser($id)
	{
		$this->db->delete('users', array('email' => $id));
		$this->db->delete('user_detail', array('email' => $id));
	}
}
