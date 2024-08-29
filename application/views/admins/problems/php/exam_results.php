<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
if ($sec == 1) {
	$dt = $db->view_data("exam_set");
	$resl = array();
	foreach ($dt as $k => $v) {
		$probs[$v->section_id][] = $v;
	}
	$output['prob'] = $probs;
	$output['group'] = $db->view_data("student_group");
	echo json_encode($output);
}
if ($sec == 4) {
	$eid = $json->eid;
	// $dt = $db->wheres("exam_set", array('eid' => $eid));
	$quy = "SELECT u.uid, u.name, unid, a.eid, a.pid, a.marks, a.utime FROM exam_answers a, user_detail u WHERE a.eid=" . $eid . " AND a.uid=u.uid";
	$dt = $db->query($quy);
	$resl = array();
	$user = array();
	$prob = array();
	foreach ($dt as $k => $v) {
		$ttl = isset($user[$v->uid]['total'])? $user[$v->uid]['total']: 0;
		$user[$v->uid] = array('uid' => $v->uid, 'name' => $v->name, 'unid' => $v->unid, 'total' => $ttl + $v->marks);
		$resl[$v->uid][$v->pid] = $v->marks;
		if(!in_array($v->pid, $prob)) $prob[] = $v->pid;
	}
	$output = array('prob' => $prob, 'user' => $user, 'result' => $resl);
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
