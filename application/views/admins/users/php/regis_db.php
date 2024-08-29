<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	$s_on->name = 'Home';
	if($sec==1) {
		$uid = (isset($json->uid))? $json->uid: '';
		$dt = $db->bool_query("SELECT * FROM users WHERE uid='".$uid."'");
		echo json_encode($dt);
	}
	if($sec==2) {
		$uid = (isset($json->uid))? $json->uid: '';
		$pas = (isset($json->pas))? $json->pas: '';
		$rol = (isset($json->rol))? $json->rol: 'G';
		$db->insert('users', array('uid'=>$uid, 'password'=>md5($pas), 'role'=>$rol, 'valid'=>'N'));
		echo json_encode(true);
	}
	if($sec==3) {
		$output = $db->query("SELECT u.uid, u.role urole, d.role drole, d.unid, name, phone, email, session, imgs, valid, department, designation, intid FROM users u, user_detail d WHERE (u.role<>d.role OR valid='N') AND d.uid=u.uid ORDER BY d.udate DESC");
		echo json_encode($output);
	}
	if($sec==4) {
		$uid = $json->uid;
		$db->update('users', array('valid'=>'Y'), array('uid'=>$uid));
		echo json_decode($uid);
	}
	if($sec==5) {
		$uid = $json->uid;
		$out = $db->query("SELECT role FROM users WHERE uid='".$uid."'");
		$db->update('user_detail', array('role'=>$out[0]->role), array('uid'=>$uid));
		echo json_decode($uid);
	}
	if($sec==6) {
		$uid = $json->uid;
		$out = $db->query("SELECT role FROM user_detail WHERE uid='".$uid."'");
		$db->update('users', array('valid'=>'Y', 'role'=>$out[0]->role), array('uid'=>$uid));
		echo json_decode($uid);
	}
	if($sec==7) {
		$uid = $json->uid;
		$db->update('users', array('valid'=>'Y', 'role'=>'G'), array('uid'=>$uid));		
		$db->update('user_detail', array('role'=>'G'), array('uid'=>$uid));
		echo json_decode($uid);
	}
	if($sec==8) {
		$uid = $s_on->userid;
		$udtls = $db->wheres('user_detail', array('uid'=>$uid));
		$whr = "";
		if($udtls[0]->intid != '') $whr = " WHERE d.intid = '".$udtls[0]->intid."'";
		$grps = $db->query("SELECT * FROM studentgrp s INNER JOIN user_detail d ON d.uid=s.uid LEFT JOIN student_group g on g.sgid=s.gid ".$whr);
		echo json_encode($grps);
	}
	if($sec==9) {
		$gid = $json->gid;
		$db->delete('studentgrp', array('gsid'=>$gid));
		echo json_decode('deleted');
	}
	if($sec==10) {
		$gid = $json->gid;
		$t=time();
		$db->update('studentgrp', array('aproved'=>'Y', 'adate'=>date("Y-m-d h:i:s a",$t)), array('gsid'=>$gid));
		echo json_decode('updated');
	}