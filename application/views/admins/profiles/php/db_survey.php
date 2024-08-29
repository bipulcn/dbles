<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	$fbk->initiate_survay();
	if($sec==1) {
    $output['survey'] = $fbk->get_survey();
    $output['question'] = $fbk->get_questions();
    $output['answer'] = $fbk->get_answers(1);
		echo json_encode($output);
	}
	if($sec==2) {
    $ett = $json->ett;
    $btt = $json->btt;
    $dtl = $json->dtl;
    $enb = (isset($json->enb))? $json->enb: 0;
    $sid = $json->sid;
    if($sid==0) $fbk->save_survey($ett, $btt, $dtl, $enb);
    else $fbk->update_survey($sid, $ett, $btt, $dtl, $enb);
		$output = $sid.", ".$ett.", ".$btt.", ".$dtl.", ".$enb;
		echo json_encode($output);
	}
	if($sec==3) {
    $sid = $json->sid;
    $ett = $json->ett;
    $btt = $json->btt;
    $dtl = $json->dtl;
		$qid = $json->qid;
		$enb = (isset($json->enb))? (($json->enb=='T' || $json->enb==true) ? 'T': 'F'): 'F';
		$output[] = $enb;
    if($qid==0) $output[] = $fbk->add_question($sid, $ett, $btt, $dtl, $enb);  // we can add comment and reting range
    else $output[] = $fbk->update_question($qid, $sid, $ett, $btt, $dtl, $enb);
		echo json_encode($output);
	}
?>
