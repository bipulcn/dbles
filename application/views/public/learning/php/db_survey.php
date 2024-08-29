<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	// $fbk->initiate_survay();
	if($sec==1) {
    $sid = (isset($json->sid))? $json->sid : 0;
    $output['survey'] = $fbk->get_survey();
    $output['question'] = $fbk->get_questions($sid);
    $output['answer'] = $fbk->get_answers(1);
    $output['opts'] = $fbk->opts;
		echo json_encode($output);
	}
	if($sec==2) {
		$sid = $json->sid;
  	$uid = $s_on->userid;
    $qid = $json->qid;
    $ans = $json->ans;
    $cmt = $json->cmt;
    $output = $fbk->save_answer($uid, $sid, $qid, $ans, $cmt);
    echo json_encode($output);
  }
	if($sec==3) {
		$sid = $json->sid;
  	$uid = $s_on->userid;
    $output = $fbk->complete_answer($uid, $sid);
    echo json_encode($output);
  }
?>
