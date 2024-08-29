<?php
$data = file_get_contents("php://input");
$json = json_decode($data);

$url = "http://66.45.237.70/api.php";
// $number= $json->phone;
// $otp= $json->otp;
$userid= isset($json->userid) ? $json->userid : '';
$phone= isset($json->phone) ? $json->phone: '';

if ($db->bool_query("SELECT * FROM user_detail WHERE uid='".$userid."' AND phone='".$phone."'")) {
  $otp = rand(10000, 99999);
  // $res = $cks->result();
  // $dtl = $db->wheres('userdetail', array('email'=>$res->email));
  // $cks = $db->query("SELECT * FROM sysuser WHERE (uname<>'' AND email<>'') AND (uname='".$userid."' OR email='".$email."')");
  // $dtl = $db->wheres('userdetail', array('email'=>$cks[0]->email));
  // $phone = $dtl[0]->phone;
  // if ($phone=='') {
  //   echo json_encode(array('kinds'=>2, 'message'=>"No phone number was added with this account."));
  // }
  // else {
    $text="Your OTP is: ".$otp.". use this OTP to reset your password on hscict.org.";
    $data= array('username'=>"01511200215", 'password'=>"64CS785F", 'number'=>"$phone", 'message'=>"$text");
    $sendstatus = 'failed';
    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);
    $p = explode("|",$smsresult ?? '');
    $sendstatus = $p[0];

    echo json_encode(array('kinds'=>1, 'message'=>$otp."|".$phone."|".$sendstatus, 'status'=>$sendstatus));
  // }
}
else {
  echo json_encode(array('message'=>"User does not exist", 'kinds'=>0));
}

