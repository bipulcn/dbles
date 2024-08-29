<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
if ($sec == 1) {
	$dt = $db->view_data("exam_set");
	foreach ($dt as $k => $v) {
		$prob = $db->query("SELECT p.pid, title, details, solution, marks FROM exam_qus e, practice_problem p WHERE eid=" . $v->eid . " AND e.pid=p.pid");
		$answ = $db->wheres("exam_answers", array('eid' => $v->eid));
		$probs[$v->section_id][] = array('data' => $v, 'prob' => $prob, 'answer' => $answ);
	}
	// $udt = $db->query("SELECT uid, name, intid, phone, email, session FROM user_detail");
	$output['prob'] = $probs;
	// $output['user'] = $udt;
	$output['group'] = $db->view_data("student_group");
	echo json_encode($output);
}
if ($sec == 2) {
	$uid = $json->uid;
	$udt = $db->wheres("exam_answers", array('uid' => $uid));
	$rdt = array();
	foreach ($udt as $v) {
		$rdt[$v->eid][$v->pid] = $v;
	}
	$output = $rdt;
	echo json_encode($output);
}
if ($sec == 3) {
	$uid = $json->uid;
	$pid = $json->pid;
	$eid = $json->eid;
	$mrk = $json->mrk;
	$db->update("exam_answers", array('marks' => $mrk), array('uid' => $uid, 'pid' => $pid, 'eid' => $eid));
	echo json_encode('updated');
}

if ($sec == 4) {
	$output = $db->query("SELECT u.uid, u.role, valid, name, intid, phone, email, session FROM users u, user_detail d, studentgrp s WHERE u.uid=d.uid AND s.uid = u.uid AND s.gid = " . $json->gid);
	echo json_encode($output);
}
