<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	if($sec==1) {
    $dt = $db->view_data("lessonlist");
    foreach ($dt as $k => $v) {
      $output[$v->lid]['title'] = $v->title;
      $pdt = $db->wheres("practice_problem", array('lid'=>$v->lid));
			foreach ($pdt as $s => $sv) {
				$pdt[$s]->sprob = $db->wheres('practice_problem_similar', array('pid'=>$sv->pid));
			}
			$output[$v->lid]['prob'] = $pdt;
    }
		echo json_encode($output);
	}
	if($sec==2) {
		// { section: 2, title:titl, detl:dsc, cod:sol, pid:$scope.selProblem };
		$ttl = $json->title;
		$sol = $json->cod;
		$des = $json->detl;
		$pid = $json->pid;
		$lid = $json->lid;
		$enb = ($json->senb==1)? 'T':'F';
		if($pid < 0) {
			$db->insert("practice_problem", array('title'=>$ttl, 'details'=>$des, 'solution'=>$sol, 'lid'=>$lid, 'senb'=>$enb));
		}
		else {
			$db->update("practice_problem", array('title'=>$ttl, 'details'=>$des, 'solution'=>$sol, 'lid'=>$lid, 'senb'=>$enb), array('pid'=>$pid));
		}
		// echo $db->lstQuery();
		echo true;
	}
	if($sec==3) {
		// { section: 2, title:titl, detl:dsc, cod:sol, pid:$scope.selProblem };
		$des = $json->detl;
		$sol = $json->cod;
		$pid = $json->pid;
		$sid = $json->sid;
		$enb = ($json->enb)? 'T': 'F';
		if($sid < 0) {
			$db->insert("practice_problem_similar", array('details'=>$des, 'solution'=>$sol, 'pid'=>$pid, 'senb'=>$enb));
		}
		else {
			$db->update("practice_problem_similar", array('details'=>$des, 'solution'=>$sol, 'pid'=>$pid, 'senb'=>$enb), array('spid'=>$sid));
		}
		echo $db->lstQuery();
		echo true;
	}
	if($sec==4) {
		$pid = $json->pid;
		$spid = $json->spid;
		if($spid==-1) {
			$db->delete("practice_problem", array('pid'=>$pid));
			$spid = 0;
		}
		else $db->delete("practice_problem_similar", array('pid'=>$pid, 'spid'=>$spid));
		$db->delete("prob_answers", array('pid'=>$pid, 'spid'=>0));
		echo json_encode("done");
	}
	if($sec==5) {
		$output['group'] = $db->query("SELECT * FROM student_group g LEFT JOIN (SELECT gid, count(*) memb FROM studentgrp WHERE aproved='Y' GROUP BY gid) d ON sgid=d.gid");
		echo json_encode($output);
	}
	if($sec==6) {
		$gid = $json->gid;
		$enb = $json->enb;
		$db->update('student_group', array('enable'=>$enb), array('sgid'=>$gid));
		echo $gid." Saved lesson ".$enb;
	}

?>
