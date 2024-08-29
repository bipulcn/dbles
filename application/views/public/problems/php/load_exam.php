<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
$uid = $s_on->userid;
if ($sec == 1) {
	$dt = $db->view_data("schema_list");
	$sba = array();
	foreach ($dt as $k => $v) {
		$stdt = $db->query("SELECT * FROM schema_tables WHERE sid=" . $v->sid . " ORDER BY serial");
		$stba = array();
		$fk = array();
		foreach ($stdt as $sk => $sv) {
			$tmpdt = runSelectQuery($pdb, "DESC " . $sv->tname);
			foreach ($tmpdt['data'] as $ts => $tv) {
				$stba[$sk]['more'][$ts] = $tv->Field;
				$stba[$sk]['key'][$ts] = $tv->Key;
				if ($tv->Key == 'PRI') $fk[] = $tv->Field;
			}
			$stba[$sk]['tname'] = $sv->tname;
		}
		$sba[$v->title]['fk'] = $fk;
		$sba[$v->title]['data'] = $stba;
		$sba[$v->title]['detail'] = $v->details;
	}
	$output['schema'] = $sba;
	$els = $db->query("SELECT * FROM exam_set e, studentgrp g, student_group u WHERE e.section_id=u.sgid AND u.sgid=g.gid AND g.uid='" . $uid . "' AND e.enable=1");
	$exl = array();
	foreach ($els as $v) {
		$dts = $db->query("SELECT c.eid, c.pid, c.marks, c.title, c.details, c.solution, a.codes FROM (SELECT r.eid, r.pid, r.marks, p.title, p.details, p.solution FROM exam_qus r, practice_problem p where r.pid=p.pid AND r.eid='" . $v->eid . "') c LEFT JOIN exam_answers a ON c.eid=a.eid AND c.pid=a.pid AND a.uid='" . $uid . "'");
		$exl[$v->eid]['detail'] = $v;
		$exl[$v->eid]['quiz'] = $dts;
	}
	$output['exmList'] = $exl;
	echo json_encode($output);
}
// if($sec== 3) {
// 	$uid = $s_on->userid;
// 	$pid = $json->pid;
// 	$dt = $db->query("SELECT * FROM exam_answers WHERE uid='".$uid."' AND pid in (".$pid.")");
// 	echo json_encode($output);
// }
if ($sec == 4) {
	// $s_on->sess_destroy();
	$ary = $s_on->histQuery;
	if (sizeof($ary) == 0) {
		$qr = $db->query("SELECT queries FROM user_queries WHERE uid='" . $uid . "' ORDER BY cdate");
		$rs = $qr->result();
		$hist = array();
		foreach ($rs as $k => $v) {
			$hist[] = $v->queries;
		}
		$s_on->histQuery = $hist;
		$s_on->preQuery = $hist;
		$output = (object) $hist;
		// $output[] = "SELECT queries FROM user_queries WHERE uid='".$uid."' ORDER BY cdate";
	} else
		$output = (object)array_reverse($ary);
	echo json_encode($output);
}

if ($sec == 5) {
	$uid = $s_on->userid;
	$pid = $json->pid;
	$eid = $json->eid;
	$cod = $json->cod;
	$dt = $db->wheres('exam_answers', array('uid' => $uid, 'pid' => $pid, 'eid' => $eid));
	if (sizeof($dt) > 0) {
		$db->update('exam_answers', array('codes' => $cod), array('uid' => $uid, 'pid' => $pid, 'eid' => $eid));
	} else {
		$db->insert('exam_answers', array('codes' => $cod, 'uid' => $uid, 'pid' => $pid, 'eid' => $eid));
	}
	$output[] = 'Query Saved';
	echo json_encode($output);
}


function runSelectQuery($pdb, $que)
{
	$output['data'] = $pdb->query($que);
	$query = $pdb->rquery($que);
	$output['field'] = $query->list_fields();
	return $output;
}
