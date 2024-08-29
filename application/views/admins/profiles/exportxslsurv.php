<?php
$data = array();
$rdt = $fbk->get_answers_array($fbkid);
$nm = 0;
$rky = array_reverse($fbk->opts, false);
foreach ($rdt as $v) {
  $data[$nm]['Question'] = $v['qus']->etitle;
  $data[$nm]['Number'] = $v['num'];
  foreach ($v['res'] as $k=>$r) {
    $data[$nm][$rky[$k]] = $r;
  }
  $nm++;
}

function cleanData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  $str = preg_replace("/\,/", "", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

$filename = "survey_data_" . date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
header("Pragma: no-cache");
header("Expires: 0");


$flag = false;
foreach($data as $row) {
  if(!$flag) {
    echo implode("\t", array_keys($row)) . "\r\n";
    $flag = true;
  }
  array_walk($row, __NAMESPACE__ . '\cleanData');
  echo implode("\t", array_values($row)) . "\r\n";
}
exit;

?>
