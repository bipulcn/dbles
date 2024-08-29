<?php
$data = array();
$udt = $this->db->query("SELECT d.uid, d.role, g.cdate, name, intid, phone, email, session FROM user_detail d, studentgrp g WHERE g.uid=d.uid AND gid=".$lab);
$rdt = $udt->result();
$usr = array();
foreach ($rdt as $v) {
  $usr[$v->uid] = $v;
}
$pobs = "SELECT pid FROM practice_problem WHERE lid=".$id."";
$spobs = "SELECT pid, spid FROM practice_problem_similar WHERE pid in (SELECT pid FROM practice_problem WHERE lid=".$id.") ORDER BY pid, spid";
$pobs = $this->db->query($pobs);
$rpb = $pobs->result();
$spobs = $this->db->query($spobs);
$srpb = $spobs->result();
$lst = array();
foreach ($rpb as $pv) {
  $lst[] = array('pid'=>$pv->pid, 'spid'=> 0);
  foreach ($srpb as $v) {
    if($v->pid==$pv->pid)
      $lst[] = array('pid'=>$pv->pid, 'spid'=> $v->spid);
  }
}
$rs = $this->db->query("SELECT * FROM prob_answers WHERE pid in (SELECT pid FROM practice_problem WHERE lid=".$id.")");
$res = $rs->result();
// echo "<pre>";
// print_r($lst);
// echo $id."<br><br>";
// print_r($usr);
// echo "<br><br>";
// print_r($res);
// echo "<br><br>";
$usrs = array();
foreach ($res as $k => $v) {
  $usrs[$v->uid][$v->pid][$v->spid] = $v->marks;
}
$nm = 0;
foreach ($usrs as $k => $v) {
  if(array_key_exists($k, $usr)){
    $data[$nm]['user'] = $k;
    $data[$nm]['name'] = $usr[$k]->name;
    foreach ($lst as $sk => $sv) {
      if(isset($v[$sv['pid']][$sv['spid']]))
        $data[$nm]['p'.$sv['pid']."sp".$sv['spid']] = $v[$sv['pid']][$sv['spid']];
      else
        $data[$nm]['p'.$sv['pid']."sp".$sv['spid']] = 0;
    }
    $nm++;
  }
}
// $data = json_encode($data);
// echo "<pre>";
// print_r($data);
// echo "</pre>";
// die;
function cleanData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "lab_" . date('Ymd') . ".xls";

// header("Content-Disposition: attachment; filename=\"$filename\"");
// header("Content-Type: application/vnd.ms-excel");
// header("Pragma: no-cache");
// header("Expires: 0");

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$flag = false;
// echo sizeof($data)."<br>";
// foreach ($data as $k => $v) {
//   print_r($v);
//   echo "<br>";
// }
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
