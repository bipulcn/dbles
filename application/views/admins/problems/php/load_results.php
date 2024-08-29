<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
if ($sec == 1) {
	$output = $db->view_data("student_group");	
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

if ($sec == 4) {
	$sec = $json->sec;
	$output = $db->query("SELECT * FROM users u, user_detail d, studentgrp s WHERE s.uid = u.uid AND s.gid = " . $sec . " AND u.uid=d.uid AND u.role='S'");
	echo json_encode($output);
}
if ($sec == 5) {
	/*

	$dt = $db->view_data("lessonlist");
	$output['result'] = array();
	foreach ($dt as $k => $v) {
		$probs[$v->lid]['title'] = $v->title;
		$pdt = $db->wheres("practice_problem", array('lid' => $v->lid));
		foreach ($pdt as $s => $sv) {
			// $output['result'][$v->lid][$sv->pid][0][] = 0;
			$spdt = $db->wheres('practice_problem_similar', array('pid' => $sv->pid));
			$pdt[$s]->sprob = $spdt;
			// foreach ($spdt as $p => $d) {
			// 	$output['result'][$v->lid][$sv->pid][$d->spid][] = 0;
			// }
		}
		$probs[$v->lid]['prob'] = $pdt;
	}

	// $udt = $db->query("SELECT u.uid, u.role, cdate, valid, name, intid, phone, email, session FROM users u, user_detail d WHERE u.uid=d.uid");
	$output['prob'] = $probs;
	// $output['user'] = $udt;

	*/
	// add the user information or list to load details about the answers.
	$les = $json->les;
	$dt = $db->wheres("lessonlist", array('lid' => $les));
	$output = array();
	$output[$les] = array();
	// $probs = array();
	// foreach ($dt as $k => $v) {
	$pdt = $db->wheres("practice_problem", array('lid' => $les));
	foreach ($pdt as $s => $sv) {
		$output[$les][$sv->pid][0][] = 0;
		$spdt = $db->wheres('practice_problem_similar', array('pid' => $sv->pid));
		foreach ($spdt as $p => $d) {
			$output[$les][$sv->pid][$d->spid][] = 0;
		}
	}
	// }


	// foreach ($dt as $kl => $l) {
		$res = $db->query("SELECT a.pid, a.spid, a.uid, a.codes, a.utime, a.marks FROM prob_answers a, practice_problem p WHERE p.pid=a.pid AND p.lid=" . $les);
		foreach ($res as $k => $v) {
			if (isset($output[$les][$v->pid][$v->spid])) {
				$output[$les][$v->pid][$v->spid][$v->uid]['mark'] = $v->marks;
				if (isset($output[$les][$v->uid]['total']))
					$output[$les][$v->uid]['total'] += $v->marks;
				else $output[$les][$v->uid]['total'] = $v->marks;
			}
		}
	// }
	echo json_encode($output);
}
if ($sec == 6) {
	$dt = $db->view_data("lessonlist");
	$output['result'] = array();
	foreach ($dt as $k => $v) {
		$probs[$v->lid]['title'] = $v->title;
		$pdt = $db->wheres("practice_problem", array('lid' => $v->lid));
		foreach ($pdt as $s => $sv) {
			// $output['result'][$v->lid][$sv->pid][0][] = 0;
			$spdt = $db->wheres('practice_problem_similar', array('pid' => $sv->pid));
			$pdt[$s]->sprob = $spdt;
			// foreach ($spdt as $p => $d) {
			// 	$output['result'][$v->lid][$sv->pid][$d->spid][] = 0;
			// }
		}
		$probs[$v->lid]['prob'] = $pdt;
	}

	// $udt = $db->query("SELECT u.uid, u.role, cdate, valid, name, intid, phone, email, session FROM users u, user_detail d WHERE u.uid=d.uid");
	$output = $probs;
	// $output['user'] = $udt;
	// $output['group'] = $db->view_data("student_group");
	
	echo json_encode($output);
}