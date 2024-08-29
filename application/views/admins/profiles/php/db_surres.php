<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	$fbk->initiate_survay();
	if($sec==1) {
    $output['survey'] = $fbk->get_survey();
    $output['question'] = $fbk->get_questions();
		echo json_encode($output);
	}
	if($sec==2) {
		$sid = $json->sid;
		$ans = $fbk->get_answers($sid);
		$com = array();
		$qus = array();
		$all = array();

		foreach ($ans as $k => $v) {
			$all[] = $v;
			if($v->cenble=='F') {
				$qus[$v->fbqid]['ans'][] = $v->answer;
			}
			else {
				$com[$v->fbqid]['txt'][] = $v->comments;
			}
			$qus[$v->fbqid]['title'] = array('e'=>$v->etitle, 'b'=>$v->btitle);
		}
		$output['com'] = $com;
		$output['qus'] = $qus;
		$output['all'] = $all;
		echo json_encode($output);
	}
	if($sec==3) {
		echo json_encode($output);
	}
?>
