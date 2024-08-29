<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;

	if($sec==1) {
    $output['users'] = $tk->getUsers();
    $output['agents'] = $tk->getAgents();
    $output['pages'] = $tk->getPages();
		echo json_encode($output);
	}
?>
