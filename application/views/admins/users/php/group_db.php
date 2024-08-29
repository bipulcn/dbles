<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
$s_on->name = 'Home';
if ($sec == 1) {
	$tmp = $db->query("SELECT * FROM student_group g LEFT JOIN (SELECT gid, count(*) members FROM studentgrp GROUP BY gid) d ON sgid=gid");
	$output = [];
	foreach ($tmp as $vl) {
		$output[$vl->sgid] = $vl;
	}
	echo json_encode($output);
}
// if ($sec == 2) {
// 	$gid = $json->gid;
// 	$nam = $json->gname;
// 	$query = "SELECT * FROM student_group WHERE groupname='" . $nam . "'";
// 	$cks = $db->bool_query($query);

// 	if ($cks) {
// 		if ($gid != 0) {
// 			$qry2 = "SELECT * FROM student_group WHERE groupname='" . $nam . "' AND sgid=" . $gid;
// 			$cks2 = $db->bool_query($qry2);
// 			if ($cks2) echo json_encode(['ok']);
// 		} else echo json_encode(['no']);
// 	} else echo json_encode(['ok']);
// }
// if ($sec == 3) {
// 	$dtl = (isset($json->descr)) ? $json->descr : '';
// 	$nam = $json->gname;
// 	$gid = $json->gid;
// 	if ($gid == 0)
// 		$db->insert('student_group', array('groupname' => $nam, 'description' => $dtl, 'crid' => $this->session->userid));
// 	else $db->update('student_group', array('groupname' => $nam, 'description' => $dtl, 'crid' => $this->session->userid), array('sgid' => $gid));
// 	echo 'saved';
// }
if ($sec == 4) {
	$gid = $json->gid;
	$yer = $json->yer;
	$grp = $json->grp;
	$des = isset($json->descr)? $json->descr : '';
	$squ = (isset($json->squ)) ? $json->squ : 0;
	$dta = $db->query("SELECT intid FROM user_detail WHERE uid='" . $s_on->userid . "'");
	$iid = $dta[0]->intid;
	if ($gid == 0) {
		$name = getName($db, $s_on->userid, $yer, $grp);
		$query = "SELECT * FROM student_group WHERE groupname='" . $name . "'";
		echo json_encode($query);
		$cks = $db->bool_query($query);
		if (!$cks) {
			$db->insert('student_group', array('groupname' => $name, 'description' => $des, 'intid' => $iid));
			echo json_encode(['ok']);
		} else echo json_encode(['no']);
	} else {
		$name = getName($db, $s_on->userid, $yer, $grp, $squ);
		$query = "SELECT * FROM student_group WHERE groupname='" . $name . "' AND sgid<>" . $gid;
		$cks = $db->bool_query($query);
		if (!$cks) {
			$db->update('student_group', array('groupname' => $name, 'description' => $des, 'intid' => $iid), array('sgid' => $gid));
			echo json_encode(['ok']);
		} else echo json_encode(['no']);
	}
	// echo json_encode($name);
}
if ($sec == 5) {
	$uid = $json->uid;
	echo $uid;
	$db->update('users', array('role' => 'S'), array('uid' => $uid));
	echo json_decode($uid);
}

function getName($db, $uid, $yer, $sec, $squ = 0)
{
	$dta = $db->query("SELECT intid FROM user_detail WHERE uid='" . $uid . "'");
	$iid = $dta[0]->intid;
	$name = $iid . "_" . substr($yer, -2) . "_" . $sec;
	if ($squ == 0) {
		$dta = $db->query("SELECT groupname FROM student_group WHERE groupname LIKE '%" . $name . "%'");
		// return $dta;
		$mx = 0;
		foreach ($dta as $vl) {
			$spl = explode("_", $vl->groupname);
			if (sizeof($spl) >= 4)
				if ($mx < $spl[3]) $mx = $spl[3];
		}
		$mx++;
		$name = $name . "_" . $mx;
		return $name;
	} else {
		$name = $name . "_" . $squ;
		return $name;
	}
}
// ALTER TABLE student_group CHANGE COLUMN cdate cdate DATETIME NULL DEFAULT CURRENT_TIMESTAMP ;
