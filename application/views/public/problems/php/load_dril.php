<?php
$data = file_get_contents("php://input");
$json = json_decode($data);
$output = array();
$sec = $json->section;
if ($sec == 1) {
	$ldt = $db->view_data("lessonlist");
	$dt = $db->view_data("schema_list");
	$sba = array();
	foreach ($dt as $k => $v) {
		$sba[$v->title]['data'] = $db->query("SELECT * FROM schema_tables WHERE sid=" . $v->sid);
		$sba[$v->title]['detail'] = $v->details;
	}
	$output['schema'] = $sba;
	$slt = array();
	foreach ($ldt as $k => $v) {
		$slt[$k]['problems'] = $db->query("SELECT * FROM problemlist WHERE lid=" . $v->lid);
		$slt[$k]['data'] = $v;
	}
	$output['lesson'] = $slt;
	echo json_encode($output);
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
// 	if ($typ=='select' || $typ=='desc'){
// 		$output = runSelectQuery($pdb, $que);
// 		// $hist[] = $que;
// 	}
// 	if ($typ=='insert' || $typ=='delete' || $typ=='update') {
// 		$tab = exeQuery($pdb, $que);
// 		$rque = addslashes($que);
// 		if($tab!="" && $uid!="")
// 			$this->db->query("INSERT INTO user_queries (uid, queries) VALUES ('".$uid."', '".$rque."')");
// 		// $qar[] = $que;
// 		// $hist[] = $que;
// 		$output = runSelectQuery($pdb, "SELECT * FROM ".$tab);
// 	}
// 	// $s_on->preQuery = $qar;
// 	// $s_on->histQuery = $hist;
// 	$output[] = $this->db->error();
//   echo json_encode($output);
// }
// if($sec==3) {
// 	$que = $json->que;
// 	$re = array(
// 		'ctable'=>'/((create)((\n|.)+)(table))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'cview'=>'/((create)((\n|\s)+)(view))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'insert'=>'/((insert)((\n|\s)+)(into))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)((\n|.)+)(values)/im',
// 		'delete'=>'/((delete)((\n|\s)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'select'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'update'=>'/(update)((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?(\n|\s)+)(set)/im',
// 		'desc'=>'/(desc)\s+[\`|\"|\']?(\w+)[\`|\"|\']?/im',
// 	);
// 	$sle = array(
// 		'gen'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'sim'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(where)/im',
// 		'mor'=>'/((select)((\n|.)+)(from))(((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(,?))+((\n|\s)+)(where)/im',
// 	);
// 	foreach ($re as $k => $v) {
// 		if(preg_match($v, $que, $matches, PREG_OFFSET_CAPTURE)){
// 			$output[$k] = $matches[0][0];
// 			if($k=='select'){
// 				foreach ($sle as $sk => $sv) {
// 					if(preg_match($sv, $que, $submatch, PREG_OFFSET_CAPTURE))
// 						$output[$sk] = $submatch[0][0];
// 				}
// 			}
// 		}
// 	}
// 	echo json_encode($output);
// }

// function runSelectQuery($pdb, $que) {
// 	$output['data'] = $pdb->query($que);
// 	$query = $pdb->rquery($que);
// 	$output['field'] = $query->list_fields();
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
// 		'ctable'=>'/((create)((\n|.)+)(table))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'cview'=>'/((create)((\n|\s)+)(view))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'insert'=>'/((insert)((\n|\s)+)(into))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)((\n|.)+)(values)/im',
// 		'delete'=>'/((delete)((\n|\s)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
// 		'select'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
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
