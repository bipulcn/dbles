<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
date_default_timezone_set('Asia/Dhaka');
if ($sec == 1) {
	$eid = $json->eid;
	$enb = ($json->enb) ? $json->enb : false;
	$stm = "";
	if ($enb) $stm = date('Y-m-d h:i:s');
	if ($enb) $db->update("exam_set", array('enable' => 1, 'stime' => $stm), array('eid' => $eid));
	else $db->update("exam_set", array('enable' => 0), array('eid' => $eid));
	echo $enb . ", " . $eid;
	echo true;
}
