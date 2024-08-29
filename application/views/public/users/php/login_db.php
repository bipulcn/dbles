<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
if ($sec == 1) {
	if ($s_on->userid != '') $output[0] = "true";
	else $output[0] = "false";
	echo json_encode($output);
}
if ($sec == 2) {
	$s_on->userid = '';
	$s_on->userrole = '';
	$uid = $json->uid;
	$pas = $json->pass;
	$enb = $db->checkUser($uid, $pas);
	$output[0] = "false";
	if (sizeof($enb) > 0) {
		$s_on->userid = $enb[0]->uid;
		if ($enb[0]->valid == 'Y') {
			$s_on->userrole = $enb[0]->role;
			$s_on->aduid = $uid;
		} else $s_on->userrole = 'G';
		$output[0] = "true";
		$inf = $db->getUserDetails($uid);
		$s_on->uname = $inf[0]->name;
		$s_on->phone = $inf[0]->phone;
		$s_on->email = $inf[0]->email;
		$s_on->session = $inf[0]->session;
	}
	echo json_encode($output);
}
if ($sec == 3) {
	$s_on->aduid = "";
	$s_on->userid = '';
	$s_on->userrole = '';
	$s_on->uname = "";
	$s_on->phone = "";
	$s_on->email = "";
	$s_on->session = "";
	echo json_encode(true);
}
