<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
$s_on->name = 'Home';
if ($sec == 1) {
	$dts = $db->getResults("SELECT * FROM institutes");
	echo json_encode($dts);
}
if ($sec == 2) {
	$ttyp = 'G';
	$typ = (isset($json->typ)) ? $json->typ : "G";
	$ins = (isset($json->ins)) ? $json->ins : '';
	$dep = (isset($json->dep)) ? $json->dep : '';
	$sem = (isset($json->sem)) ? $json->sem : '';
	$nam = (isset($json->nam)) ? $json->nam : '';
	$des = (isset($json->des)) ? $json->des : '';
	$nid = (isset($json->nid)) ? $json->nid : '';  // university id
	$pho = (isset($json->pho)) ? $json->pho : '';
	$ema = (isset($json->ema)) ? $json->ema : '';
	$uid = (isset($json->uid)) ? $json->uid : '';
	$pas = (isset($json->pas)) ? $json->pas : '';
	$dt = $db->userNotExist($uid);
	if ($dt) {  // use User model to secure password 
		$db->createUser($uid, $pas, $nam, $nid, $typ, $pho, $ema, $sem, $ins, $dep, $des);
		// $db->insert('users', array('uid' => $uid, 'password' => md5($pas), 'role' => $ttyp, 'valid' => 'N'));
		// $db->insert('user_detail', array('uid' => $uid, 'name' => $nam, 'unid'=>$nid, 'designation'=> $des, 'role' => $typ, 'phone' => $pho, 'email' => $ema, 'intid' => $ins, 'department' => $dep, 'semester' => $sem));
		$s_on->userid = $uid;
		$s_on->userrole = $typ;
		echo json_encode(true);
	} else {
		echo json_encode(false);
	}
}
if ($sec == 3) {
	$uid = $json->uid;
	if($uid!='') {
		$dt = $db->userIdExist($uid);
		echo json_encode($dt);
	}
	else { echo false; }
}
if ($sec == 4) {
	$uid = $s_on->userid;
	$dt = $db->getResults("SELECT name, intid, phone, email, designation, department, imgs, session, u.role, valid FROM user_detail d, users u WHERE u.uid=d.uid AND u.uid='".$uid."'");
	echo json_encode($dt);
}
if ($sec == 5) {
	$uid = $json->uid;
	$nam = (isset($json->nam)) ? $json->nam : "";
	$ses = (isset($json->ses)) ? $json->ses : "";
	// $db->getResults('SELECT * FROM user_detail WHERE uid="' . $uid . '"', array('name' => $nam, 'session' => $ses), array('uid' => $uid));
	echo "true";
}
if ($sec == 6) {
	$uid = $s_on->userid;
	$opas = $json->opas;
	$pas = $json->pas;
	$dt = $db->updatePass($uid,$opas,$pas);
	echo json_encode($dt);
}
if ($sec == 7) {
	$inst = $json->inst;
	$output = $db->getResults("SELECT * FROM student_group WHERE intid='". $inst."'" );
	echo json_encode($output);
}
if ($sec == 8) {
	$int = $json->inst;
	$yea = $json->yea;
	$sec = $json->sec;
	$gru = $json->gru;
	$nam = $int."_".$yea."_".$sec."_".$gru;
	$output = $db->getResults("SELECT * FROM student_group WHERE groupname='". $nam."'" );
	$id = sizeof($output)>0 ? $output[0]->sgid : 0;
	$res = $db->getResults("SELECT * FROM studentgrp WHERE gid=". $id ." AND uid = '". $s_on->userid ."'");
	if($res==NULL)
		$res = $db->runqury("INSERT INTO studentgrp (gid, uid, request, aproved, cdate) VALUES (". $id .", '". $s_on->userid ."', 'Y', 'N', NOW())" );
	echo json_encode($res);
}

if ($sec == 9) {
	$nam = $json->name;
	$dep = $json->depar;
	$des = $json->desig;
	$ema = $json->email;
	$pho = $json->phone;
	$rol = $json->rol;
	$inst = $json->inst;
	$cks = $db->getResults("SELECT * FROM user_detail WHERE uid = '". $s_on->userid ."'");
	if($cks==NULL) $iid = $db->runqury("INSERT INTO user_detail (uid, name, department, designation, email, phone, role, intid) VALUES ('". $s_on->userid ."', '". $nam ."', '". $dep ."', '". $des ."', '". $ema ."', '". $pho ."', '". $rol ."')" );
	$res = $db->getResults("UPDATE user_detail SET name = '". $nam ."', department = '". $dep ."', designation = '". $des ."', email = '". $ema ."', phone = '". $pho ."', role='".$rol."', intid = '". $inst ."' WHERE uid = '". $s_on->userid ."'");
	echo json_encode($res);
}
if ($sec == 10) {
	$output = $db->getResults("SELECT * FROM studentgrp left join student_group on studentgrp.gid = student_group.sgid WHERE uid = '". $s_on->userid ."'");
	if($output==NULL) $output = [];
	echo json_encode($output);
}
if ($sec == 11) {
	$gid = $json->gid;
	$db->blankqury("DELETE FROM studentgrp WHERE gsid = ". $gid);
	echo json_encode('deleted');
}

if($sec==12){
	$uid = $json->uid;
	$pass = $json->pass;
	$output = $db->securePass($pass, $uid);
	echo json_encode([1]);
}
if($sec==13){
	$uid = $json->uid;
	$pass = $json->pass;
	$output = $db->checkUser($uid, $pass);
	if(sizeof($output)==0)
		echo json_encode([0]);
	else
		echo json_encode([1]);
}