<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	if($sec==1) {
    $ldt = $db->view_data("lessonlist");
    $slt = array();
    foreach ($ldt as $k => $v) {
      $slt[$v->lid]['objc'] = $db->query("SELECT * FROM lesson_objectives WHERE lid=".$v->lid." Order BY sequence");
      $slt[$v->lid]['cont'] = $db->query("SELECT * FROM lessontext WHERE lid=".$v->lid);
      $slt[$v->lid]['dt'] = $v;
    }
    $output['lesson'] = $slt;
		echo json_encode($output);
	}
	if($sec==2) {
		$lid = $json->lid;
    $lvl = $json->lvl;
    $ttl = $json->ttl;
    $dsc = $json->dsc;
		if($lid!=-1){
			$db->update('lessonlist', array('title'=>$ttl, 'level'=>$lvl, 'details'=>$dsc), array('lid'=>$lid));
			$msg = "Data Updated";
		}
		else {
			$db->insert('lessonlist', array('title'=>$ttl, 'level'=>$lvl, 'details'=>$dsc, 'order'=>'1'));
			$msg = "Data Inserted";
		}
    $output['saved'] = $msg;
		echo json_encode($output);
	}
	if($sec==3) {
		$lid = $json->lsid;
    $ord = $json->ord;
    $ttl = $json->ttl;
    $oid = $json->orid;
		if($oid!=-1){
			$db->update('lesson_objectives', array('title'=>$ttl), array('obid'=>$oid));
			$msg = "Data Updated";
		}
		else {
			$db->insert('lesson_objectives', array('title'=>$ttl, 'lid'=>$lid, 'sequence'=>$ord));
			$oid = $db->lstAutoId();
			$msg = "Data Inserted";
		}
		$dt = $db->query('SELECT * FROM lesson_objectives WHERE sequence>='.$ord.' AND lid='.$lid);
		foreach ($dt as $k => $v) {
			$db->update('lesson_objectives', array('sequence'=>$ord), array('obid'=>$oid));
			$oid = $v->obid;
			$ord++;
		}
    $output['saved'] = $msg;
		echo json_encode($output);
	}
	if($sec==4) {
		$lid = $json->lid;
    $ord = $json->ord;
    $typ = $json->typ;
    $ttl = $json->ttl;
    $tid = $json->ltid;
		if($tid!=-1) {
			$db->update('lessontext', array('detail'=>$ttl), array('ltid'=>$tid));
			$msg = "Data Updated";
		}
		else {
			$db->insert('lessontext', array('detail'=>$ttl, 'sequence'=>$ord, 'lid'=>$lid, 'type'=>$typ));
			$oid = $db->lstAutoId();
			$msg = "Data Inserted";
		}
		$dt = $db->query('SELECT * FROM lessontext WHERE sequence>='.$ord.' AND lid='.$lid);
		foreach ($dt as $k => $v) {
			$db->update('lessontext', array('sequence'=>$ord), array('ltid'=>$tid));
			$oid = $v->ltid;
			$ord++;
		}
    $output['saved'] = $msg;
	}
?>
