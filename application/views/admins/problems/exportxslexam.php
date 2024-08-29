<?php
$data = array();
$udt = $this->db->query("SELECT d.uid, d.role, g.cdate, name, intid, phone, email, session FROM user_detail d, studentgrp g WHERE g.uid=d.uid AND gid=".$grp);
$rdt = $udt->result();
$usr = array();
foreach ($rdt as $v) {
  $usr[$v->uid] = $v;
}
$pobs = "SELECT pid FROM exam_qus WHERE eid=".$exm."";
$pobs = $this->db->query($pobs);
$rpb = $pobs->result();
$lst = array();
$usrs = array();
foreach ($rpb as $pv) {
  $rs = $this->db->get_where("exam_answers", array('eid'=>$exm, 'pid'=>$pv->pid));
  $res = $rs->result();
  foreach ($res as $k => $v) {
    $usrs[$v->uid][$exm][$v->pid] = $v->marks;
  }
}
$nm = 0;
foreach ($usrs as $k => $v) {
  if(array_key_exists($k, $usr)){
    $data[$nm]['user'] = $k;
    $data[$nm]['name'] = $usr[$k]->name;
    foreach ($v[$exm] as $sk => $sv) {
      if(isset($v[$exm][$sk]))
        $data[$nm]['Ques:'.$sk] = $v[$exm][$sk];
      else
        $data[$nm]['Ques:'.$sk] = 0;
    }
    $nm++;
  }
}
function cleanData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "exam_" . date('Ymd') . ".xls";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$flag = false;
foreach($data as $row) {
  if(!$flag) {
    // display field/column names as first row
    echo implode("\t", array_keys($row)) . "\r\n";
    $flag = true;
  }
  array_walk($row, __NAMESPACE__ . '\cleanData');
  echo implode("\t", array_values($row)) . "\r\n";
}
exit;
