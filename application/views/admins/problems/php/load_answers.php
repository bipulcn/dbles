<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
if ($sec == 1) {
	$dt = $db->view_data("lessonlist");
	foreach ($dt as $k => $v) {
		$probs[$v->lid]['title'] = $v->title;
		$pdt = $db->wheres("practice_problem", array('lid' => $v->lid));
		foreach ($pdt as $s => $sv) {
			$pdt[$s]->sprob = $db->wheres('practice_problem_similar', array('pid' => $sv->pid));
		}
		$probs[$v->lid]['prob'] = $pdt;
	}
	// $udt = $db->query("SELECT u.uid, u.role, cdate, valid, name, intid, phone, email, session FROM users u, user_detail d WHERE u.uid=d.uid");
	$output['prob'] = $probs;
	// $output['user'] = $udt;
	$output['group'] = $db->view_data("student_group");
	echo json_encode($output);
}
if ($sec == 2) {
	$uid = $json->uid;
	$udt = $db->wheres("prob_answers", array('uid' => $uid));
	$rdt = array();
	foreach ($udt as $v) {
		$rdt[$v->pid][$v->spid] = $v;
	}
	$output = $rdt;
	echo json_encode($output);
}
if ($sec == 3) {
	$uid = $json->uid;
	$pid = $json->pid;
	$spid = $json->spid;
	$mrk = $json->mrk;
	$db->update("prob_answers", array('marks' => $mrk), array('uid' => $uid, 'pid' => $pid, 'spid' => $spid));
	echo json_encode('updated');
}

if($sec == 4) {
	$output = $db->query("SELECT u.uid, u.role, valid, name, intid, phone, email, session FROM users u, user_detail d, studentgrp s WHERE u.uid=d.uid AND s.uid = u.uid AND s.gid = " . $json->gid);
	echo json_encode($output);
}
