<?php
	$data = file_get_contents("php://input");
	$json = json_decode($data);
	$output = array();
	$sec = $json->section;
	$uid = $s_on->userid;
	if($sec==2) {
    	$que = $json->que;
		$typ = detectQuery($pdb, $que);
    	$output[] = $typ;
		if ($typ=='insert' || $typ=='delete' || $typ=='update') {
			$tab = exeQuery($pdb, $que);
			$rque = addslashes($que);
			$output = runSelectQuery($pdb, "SELECT * FROM ".$tab);
		}
		else if($typ=='ctable') {
			$pattern = '/create(.*)table/i';
			$que = preg_replace($pattern, "create temporary table", $que);
			runCreateQuery($pdb, $que);
			preg_match_all('/table.([a-zA-Z\_0-9]+)./i', $que, $mat, PREG_PATTERN_ORDER);
			$tab = $mat[1][0];
			$output = runSelectQuery($pdb, "DESC ".$tab);
			// $output[] = $mat;
		}
		else if($typ=='cfunct') {
			// $mat = preg_match('drop', $que);
			preg_match_all('/function.([a-zA-Z][a-zA-Z_0-9]+)(\(|\s)/i', $que, $mat, PREG_PATTERN_ORDER);
			$fun = $mat[1][0];
			exeQuery($pdb, 'DROP FUNCTION IF EXISTS '.$fun.'_'.$uid);
			runCreateQuery($pdb, $que);
			$output[] = $mat;
		}
		else if($typ=='cprocd') {
			// $mat = preg_match('drop', $que);
			preg_match_all('/procedure.([a-zA-Z][a-zA-Z_0-9]+)(\(|\s)/i', $que, $mat, PREG_PATTERN_ORDER);
			$fun = $mat[1][0];
			exeQuery($pdb, 'DROP PROCEDURE IF EXISTS '.$fun.'_'.$uid);
			runCreateQuery($pdb, $que);
			$output[] = $mat;
		}
		else if ($typ=='select' || $typ=='desc' || $typ=='funsel'){
			preg_match_all('/select\s([a-zA-Z0-9_.*]*[\s|,])*from\s([a-zA-Z][a-zA-Z_0-9]+)(\(|\s)/i', $que, $mat, PREG_PATTERN_ORDER);
			$ck = $mat[2];
			if(sizeof($ck)>1){
				preg_match_all('/'.$ck[0].'/i', $que, $agn, PREG_PATTERN_ORDER);
				if(sizeof($agn[0])==2){
					$que = preg_replace('/'.$ck[0].'/i', $ck[0].'_tm', $que, 1);
					$pdb->insert("CREATE TEMPORARY TABLE IF NOT EXISTS ".$ck[0]."_tm AS (SELECT * FROM ".$ck[0]."_bk)");
				}
				else {
				$que = preg_replace('/'.$ck[1].'/i', $ck[1].'_tm', $que, 1);
				$pdb->insert("CREATE TEMPORARY TABLE IF NOT EXISTS ".$ck[1]."_tm AS (SELECT * FROM ".$ck[1]."_bk)");
				}
			}
			// $output[] = $que;
			$output = runSelectQuery($pdb, $que);
      // $output[] = $mat;
		}
		else if ($typ=='calls'){
			$output = runCallQuery($pdb, $que);
			$output[] = $que;
		}
		// $s_on->preQuery = $qar;
		// $s_on->histQuery = $hist;
		$output[] = $this->db->error();
		// $output[] = $typ;
    	echo json_encode($output);
	}
	if($sec==3) {
		$que = $json->que;
    $output[] = detectQuery($pdb, $que);
		echo json_encode($output);
	}

	function runSelectQuery($pdb, $que) {
		$output['data'] = $pdb->query($que);
		$query = $pdb->rquery($que);
		$output['field'] = $query->list_fields();
		return $output;
	}

	function runCallQuery($pdb, $que) {
		$dt = $pdb->query($que);
		$output['data'] = $dt;
		foreach ($dt[0] as $k => $v) {
			$list[] = $k;
		}
		$output['field'] = $list;
		return $output;
	}

	function runCreateQuery($pdb, $que) {
		$output['data'] = $pdb->insert($que);
		return $output;
	}
	function exeQuery($pdb, $que) {
		$pdb->insert($que);
		$tab = '';
		foreach ($pdb->tables as $y => $v) {
			if (strpos($que, " ".$v." ") !== false)
				$tab = $v;
		}
		return $tab;
	}
	function detectQuery($pdb, $que) {
		$typ = '';
		$re = array(
			'cfunct'=>'/((create)((\n|.)+)(function))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			'cprocd'=>'/((create)((\n|.)+)(procedure))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			'ctable'=>'/((create)((\n|.)+)(table))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			'cview'=>'/((create)((\n|\s)+)(view))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			'insert'=>'/((insert)((\n|\s)+)(into))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)((\n|.)+)(values)/im',
			'delete'=>'/((delete)((\n|\s)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			'select'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			'calls'=>'/(call)((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/im',
			// 'funsel'=>'/(select)(\s)+([a-zA-Z]+)([a-z|A-Z|0-9]+)/im',
			'update'=>'/(update)((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?(\n|\s)+)(set)/im',
			'desc'=>'/(desc)(\n|\s)+[\`|\"|\']?(\w+)[\`|\"|\']?/im',
		);

		$sle = array(
			'gen'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)/i',
			'sim'=>'/((select)((\n|.)+)(from))((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(where)/i',
			'mor'=>'/((select)((\n|.)+)(from))(((\n|\s)+(\`|\"|\')?\w+(\`|\"|\')?)(,?))+((\n|\s)+)(where)/i',
		);
		foreach ($re as $k => $v) {
			if(preg_match($v, $que, $matches, PREG_OFFSET_CAPTURE)){
				$output[$k] = $matches[0][0];
				$typ = $k;
				break;
			}
		}
		return $typ;
  }
?>
