<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	$s_on->name = 'Home';
	if($sec==1) {
		$src = (isset($json->serc))? $json->serc: '';
		$qur = "SELECT * FROM user_detail d LEFT JOIN student_group g ON d.session=g.sgid WHERE d.name LIKE '%".$src."%' OR d.uid LIKE '%".$src."%' OR email LIKE '%".$src."%' OR phone LIKE '%".$src."%'";
		$dt = $db->query($qur);
		echo json_encode($dt);
	}
	if($sec==2) {
		$uid = $json->uid;
		$pas = $json->pass;
		$enb = $db->wheres("users", array('uid'=>$uid));
		if(sizeof($enb)>0) {
			$db->update("users", array('password'=>md5($pas)), array('uid'=>$uid));
			echo json_encode(["ok"]);
		}
		else {
			echo json_encode(["failed"]);
		}
	}
	if($sec==3) {
		$uid = $json->uid;
		$pas = $json->pass;
		$enb = $db->wheres("users", array('uid'=>$uid, 'password'=>md5($pas)));
		if(sizeof($enb)>0) {
			echo json_encode(["ok"]);
		}
		else {
			echo json_encode(["failed"]);
		}
	}

	if($sec==4) {
		$uid = $json->uid;
		$enb = $db->wheres("users", array('uid'=>$uid));
		if(sizeof($enb)>0) {
			$db->delete("users", array('uid'=>$uid));
			$db->delete("user_detail", array('uid'=>$uid));
			$db->delete("tk_users", array('uid'=>$uid));
			$db->delete("prob_answers", array('uid'=>$uid));
			echo json_encode(["ok"]);
		}
		else {
			echo json_encode(["failed"]);
		}
	}

	if($sec==5) {
		$uid = $json->uid;
		$enb = $db->query("SELECT count(*) num, sum(actime) sec, max(utime) let, min(utime) sta FROM tk_users WHERE uid='".$uid."'");
		$ans = $db->query("SELECT count(*) num, sum(marks) sec, max(utime) let, min(utime) sta FROM prob_answers WHERE uid='".$uid."'");
		echo json_encode(['trk'=>$enb[0], 'ans'=>$ans[0]]);
	}

?>
