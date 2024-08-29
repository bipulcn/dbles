<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
date_default_timezone_set('Asia/Dhaka');
if ($sec == 1) {
	$output['group'] = $db->view_data("student_group");
	$dt = $db->query('SELECT * FROM exam_set s, student_group g WHERE s.section_id=g.sgid');
	$qset = array();
	foreach ($dt as $k => $v) {
		$qset[$v->groupname][] = $v;
	}
	$output['qsets'] = $qset;
	$eql = $db->query('SELECT pid, p.title title, p.details, solution, senb, p.utime, p.ctime, l.title ltitle, p.lid FROM practice_problem p left join lessonlist l on l.lid=p.lid ORDER BY lid');
	foreach ($eql as $k => $v) {
		$output['eqlist'][$v->ltitle][] = $v;
	}
	// SELECT pid, p.title, p.details, solution, senb, p.utime, p.ctime, l.title, p.lid FROM practice_problem p left join lessonlist l on l.lid=p.lid ORDER BY lid;

	$dts = $db->query('SELECT r.eid, r.pid, r.marks, p.title FROM exam_qus r, practice_problem p where r.pid=p.pid');
	$qsar = array();
	foreach ($dts as $v) {
		$qsar[$v->eid][] = $v;
	}
	$output['eqasign'] = $qsar;
	echo json_encode($output);
}
if ($sec == 2) {
	$eid = $json->eid;
	$ttl = $json->ttl;
	$enb = ($json->enb) ? $json->enb : false;
	$grp = $json->grp;
	$mrk = $json->mrk;
	$stm = "";
	if ($enb) $stm = date('Y-m-d h:i:s');
	if ($eid == 0)
		$db->insert("exam_set", array('title' => $ttl, 'section_id' => $grp, 'marks' => $mrk, 'enable' => $enb, 'stime' => $stm));
	else {
		if ($enb) $db->update("exam_set", array('enable' => $enb, 'stime' => $stm), array('eid' => $eid));
		else $db->update("exam_set", array('enable' => $enb), array('eid' => $eid));
		$db->blnkquery("UPDATE exam_set SET enable=0 WHERE section_id='" . $grp . "' AND eid<>" . $eid);
	}
	echo true;
}
if ($sec == 3) {
	// { section: 2, title:titl, detl:dsc, cod:sol, pid:$scope.selProblem };
	$ttl = $json->title;
	$des = $json->detl;
	$sol = $json->cod;
	$eid = $json->eid;
	$pid = $json->id;

	if ($pid != 0)
		$db->update("practice_problem", array('title' => $ttl, 'details' => $des, 'solution' => $sol), array('pid' => $pid));
	else {
		$dt = $db->wheres('practice_problem', array('title' => $ttl, 'details' => $des));
		if (sizeof($dt) == 0)
			$db->insert("practice_problem", array('title' => $ttl, 'details' => $des, 'solution' => $sol));
	}
	$dt = $db->wheres('practice_problem', array('title' => $ttl, 'details' => $des));
	$uput['pid'] = $dt[0]->pid;
	echo json_encode($uput);
}
if ($sec == 4) {
	// { section: 2, title:titl, detl:dsc, cod:sol, pid:$scope.selProblem };
	$mrk = $json->mrk;
	$eid = $json->eid;
	$pid = $json->pid;
	$db->insert('exam_qus', array('pid' => $pid, 'eid' => $eid, 'marks' => $mrk));
	echo json_encode($uput);
}
if ($sec == 5) {
	// { section: 2, title:titl, detl:dsc, cod:sol, pid:$scope.selProblem };
	$eid = $json->eid;
	$pid = $json->pid;
	$db->delete('exam_qus', array('pid' => $pid, 'eid' => $eid));
	echo json_encode($uput);
}
