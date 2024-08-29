<?php
ini_set('memory_limit', '-1');
$output[0] = "";
$userid = $s_no->userid;
$loc = $_POST['dir'];
$dir = getcwd();
$url = $dir . "/assets" . $_POST['dir'];
if (!empty($_FILES['image'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $img = $userid . '.' . $ext;
    if (file_exists($url . $img)) {
        unlink($url . $img);
    }
    if (move_uploaded_file($_FILES['image']['tmp_name'], $url . $img)) {
        $output[0] = " was Uploaded";
        chmod($url . $img, 0777);
        $db->saveImg($userid, $img);
    } else {
        $output[0] = "File was not uploaded";
    }
} else {
    $output[0] = "No File";
}
echo json_encode($output);
