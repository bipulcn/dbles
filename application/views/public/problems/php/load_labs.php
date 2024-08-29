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
	$tmdt = $db->query("SELECT g.enable FROM studentgrp d, student_group g WHERE uid='" . $uid . "' AND g.sgid=d.gid");
	$lsid = $tmdt[0]->enable;
	// $output['tst_data'] = $lsid;
	if (strlen($lsid) > 0) $ldt = $db->query("SELECT * FROM lessonlist WHERE lid in (" . $lsid . ")");
	else $ldt = $db->query("SELECT * FROM lessonlist ORDER BY lid LIMIT 1");
	$slt = array();
	foreach ($ldt as $v) {
		$slt[$v->lid]['object'] = $db->wheres('lesson_objectives', array('lid' => $v->lid));
		// $slt[$v->lid]['problems'] = getProblems($db, $uid, $v->lid);
		$slt[$v->lid]['data'] = $v;
	}
	$output['lesson'] = $slt;
	echo json_encode($output);
}
if($sec == 2) {
	$lid = $json->lid;
	$output = getProblems($db, $uid, $lid);
	echo json_encode($output);
}

function getProblems($db, $uid, $lid)
{
	$problems = [];
	$pdt = $db->query("SELECT * FROM practice_problem WHERE lid=" . $lid);
	foreach ($pdt as $p => $d) {
		$par = $db->wheres('practice_problem_similar', array('pid' => $d->pid));
		$ans = $db->wheres('prob_answers', array('uid' => $uid, 'pid' => $d->pid, 'spid' => 0));
		$code = "";
		foreach ($ans as $co)
			$code = $co->codes;
		$d->answer = $code;
		$sary = array();
		foreach ($par as $s => $sv) {
			$sans = $db->wheres('prob_answers', array('uid' => $uid, 'pid' => $d->pid, 'spid' => $sv->spid));
			$code = "";
			foreach ($sans as $co)
				$code = $co->codes;
			$sv->answer = $code;
			$sary[] = $sv;
		}
		$problems[] = array('same' => $sary, 'data' => $d);
	}
	return $problems;
}

function runSelectQuery($pdb, $que)
{
	$output['data'] = $pdb->query($que);
	$query = $pdb->rquery($que);
	$output['field'] = $query->list_fields();
	return $output;
}

// if($sec==2) {
// 	// $s_on->sess_destroy();
//   $que = $json->que;
//   // $qar = $s_on->preQuery;
//   // $hist = $s_on->histQuery;
// 	// if(sizeof($qar)>0)
//   // foreach ($qar as $k => $v)
//   //   $tmp = exeQuery($pdb, $v);
// 	$typ = detectQuery($pdb, $que);
// 	if ($typ=='insert' || $typ=='delete' || $typ=='update') {
// 		$tab = exeQuery($pdb, $que);
// 		$rque = addslashes($que);
// 		// if($tab!="" && $uid!="")
// 		// 	$this->db->query("INSERT INTO user_queries (uid, queries) VALUES ('".$uid."', '".$rque."')");
// 		// $qar[] = $que;
// 		// $hist[] = $que;
// 		$output = runSelectQuery($pdb, "SELECT * FROM ".$tab);
// 	}
// 	else if($typ=='ctable') {
// 		$pattern = '/create(.*)table/i';
// 		$que = preg_replace($pattern, "create temporary table", $que);
// 		runCreateQuery($pdb, $que);
// 		preg_match_all('/table.([a-zA-Z\_0-9]+)./i', $que, $mat, PREG_PATTERN_ORDER);
// 		$tab = $mat[1][0];
// 		$output = runSelectQuery($pdb, "DESC ".$tab);
// 		// $output[] = $mat;
// 	}
// 	else if($typ=='cfunct') {
// 		// $mat = preg_match('drop', $que);
// 		preg_match_all('/function.([a-zA-Z][a-zA-Z_0-9]+)(\(|\s)/i', $que, $mat, PREG_PATTERN_ORDER);
// 		$fun = $mat[1][0];
// 		exeQuery($pdb, 'DROP FUNCTION IF EXISTS '.$fun);
// 		runCreateQuery($pdb, $que);
// 		$output[] = $mat;
// 	}
// 	else if($typ=='cprocd') {
// 		// $mat = preg_match('drop', $que);
// 		preg_match_all('/procedure.([a-zA-Z][a-zA-Z_0-9]+)(\(|\s)/i', $que, $mat, PREG_PATTERN_ORDER);
// 		$fun = $mat[1][0];
// 		exeQuery($pdb, 'DROP PROCEDURE IF EXISTS '.$fun);
// 		runCreateQuery($pdb, $que);
// 		$output[] = $mat;
// 	}
// 	else if ($typ=='select' || $typ=='desc' || $typ=='funsel'){
// 		preg_match_all('/select\s[a-zA-Z0-9_]+\sfrom\s([a-zA-Z][a-zA-Z_0-9]+)(\(|\s)/i', $que, $mat, PREG_PATTERN_ORDER);
// 		$ck = $mat[1];
// 		if(sizeof($ck)>1){
// 			$que = preg_replace('/'.$ck[0].'/i', $ck[0].'_tm', $que, 1);
// 			$pdb->insert("CREATE TEMPORARY TABLE IF NOT EXISTS ".$ck[0]."_tm AS (SELECT * FROM ".$ck[0]."_bk)");
// 		}
// 		// "select first_name from employees where first_name like '%st%' or last_name like '%t' union all select first_name from employees where first_name like '%st%' or last_name like '%t'"
// 		$output = runSelectQuery($pdb, $que);
// 		// $output[] = $que;
// 		// $hist[] = $que;
// 	}
// 	else if ($typ=='calls'){
// 		$output = runCallQuery($pdb, $que);
// 		$output[] = $que;
// 	}
// 	// $s_on->preQuery = $qar;
// 	// $s_on->histQuery = $hist;
// 	$output[] = $this->db->error();
// 	// $output[] = $typ;
//   echo json_encode($output);
// }
// if($sec==3) {
// 	// $que = $json->que;
// 	// $re = array(
// 	// 	'cfunct'=>'/((create)((\n|.)+)(function))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 	// 	'ctable'=>'/((create)((\n|.)+)(table))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 	// 	'cview'=>'/((create)((\n|\s)+)(view))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 	// 	'insert'=>'/((insert)((\n|\s)+)(into))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)((\n|.)+)(values)/im',
// 	// 	'delete'=>'/((delete)((\n|\s)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 	// 	'select'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 	// 	'funsel'=>'/(select)(\s)+([a-zA-Z]+)([a-z|A-Z|0-9]+)/im',
// 	// 	'update'=>'/(update)((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?(\n|\s)+)(set)/im',
// 	// 	'desc'=>'/(desc)\s+[\`|\"|\']?(\w+)[\`|\"|\']?/im',
// 	// );
// 	// $sle = array(
// 	// 	'gen'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 	// 	'sim'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(where)/im',
// 	// 	'mor'=>'/((select)((\n|.)+)(from))(((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(,?))+((\n|\s)+)(where)/im',
// 	// );
// 	// foreach ($re as $k => $v) {
// 	// 	if(preg_match($v, $que, $matches, PREG_OFFSET_CAPTURE)){
// 	// 		$output[$k] = $matches[0][0];
// 	// 		if($k=='select'){
// 	// 			foreach ($sle as $sk => $sv) {
// 	// 				if(preg_match($sv, $que, $submatch, PREG_OFFSET_CAPTURE))
// 	// 					$output[$sk] = $submatch[0][0];
// 	// 			}
// 	// 		}
// 	// 	}
// 	// }
// 	// echo json_encode($output);
// }
//
//
// function runCallQuery($pdb, $que) {
// 	$dt = $pdb->query($que);
// 	$output['data'] = $dt;
// 	foreach ($dt[0] as $k => $v) {
// 		$list[] = $k;
// 	}
// 	$output['field'] = $list;
// 	return $output;
// }
//
// function runCreateQuery($pdb, $que) {
// 	$output['data'] = $pdb->insert($que);
// 	return $output;
// }
// function exeQuery($pdb, $que) {
// 	$pdb->insert($que);
// 	$tab = '';
// 	foreach ($pdb->tables as $y => $v) {
// 		if (strpos($que, " ".$v." ") !== false)
// 			$tab = $v;
// 	}
// 	return $tab;
// }
// function detectQuery($pdb, $que) {
// 	$typ = '';
// 	$re = array(
// 		'cfunct'=>'/((create)((\n|.)+)(function))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'cprocd'=>'/((create)((\n|.)+)(procedure))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'ctable'=>'/((create)((\n|.)+)(table))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'cview'=>'/((create)((\n|\s)+)(view))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'insert'=>'/((insert)((\n|\s)+)(into))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)((\n|.)+)(values)/im',
// 		'delete'=>'/((delete)((\n|\s)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'select'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'calls'=>'/(call)((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		// 'funsel'=>'/(select)(\s)+([a-zA-Z]+)([a-z|A-Z|0-9]+)/im',
// 		'update'=>'/(update)((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?(\n|\s)+)(set)/im',
// 		'desc'=>'/(desc)(\n|\s)+[\`|\"|\']?(\w+)[\`|\"|\']?/im',
// 	);
//
// 	$sle = array(
// 		'gen'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/i',
// 		'sim'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(where)/i',
// 		'mor'=>'/((select)((\n|.)+)(from))(((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(,?))+((\n|\s)+)(where)/i',
// 	);
// 	foreach ($re as $k => $v) {
// 		if(preg_match($v, $que, $matches, PREG_OFFSET_CAPTURE)){
// 			$output[$k] = $matches[0][0];
// 			$typ = $k;
// 			break;
// 		}
// 	}
// 	return $typ;
// }
if ($sec == 4) {
	// $s_on->sess_destroy();
	$ary = $s_on->histQuery;
	if (sizeof($ary) == 0) {
		$qr = $this->db->query("SELECT queries FROM user_queries WHERE uid='" . $uid . "' ORDER BY cdate");
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
	$sid = $json->sid;
	$cod = $json->cod;
	$dt = $db->wheres('prob_answers', array('uid' => $uid, 'pid' => $pid, 'spid' => $sid));
	if (sizeof($dt) > 0) {
		$db->update('prob_answers', array('codes' => $cod), array('uid' => $uid, 'pid' => $pid, 'spid' => $sid));
	} else {
		$db->insert('prob_answers', array('codes' => $cod, 'uid' => $uid, 'pid' => $pid, 'spid' => $sid));
	}
	$output[] = 'Query Saved';
	echo json_encode($output);
}
if($sec == 6) {
	$id = $json->id;
	$uid = $s_on->userid;
	$output = $db->wheres('prob_answers', array('uid' => $uid, 'pid'=>$id));
	echo json_encode($output);
}
// $array1 = [["bat", "cat","dog","sun", "hut", "gut"], ["bat", "cat","dog","sun", "hut",125]];
// $array2 = [["bat", "cat","dog","sun", "hut", "gut"], ["bat", "cat","dog","sun", "hut",1252]];
// if( $array1 === $array2) echo "are same";
// else echo "are not same";
