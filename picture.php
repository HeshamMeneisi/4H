<?php
include 'core.php';
$target_dir = 'content/users/'.get_user()['uid'];
if (!file_exists($target_dir)) {
    mkdir($target_dir);
}
$target_file = $target_dir.'/profile_picture.png';
$upload = true;
$type = pathinfo($target_file,PATHINFO_EXTENSION);
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploaded_image"]["tmp_name"]);
    if($check !== false) {
        $upload = true;
    } else {
        $upload = false;
    }
}
if ($_FILES["uploaded_image"]["size"] > 500000) {
    $upload = false;
}
if($type != "jpg" && $type != "png" && $type != "jpeg") {
    $upload = false;
}
if ($upload) {
    move_uploaded_file($_FILES["uploaded_image"]["tmp_name"], $target_file);
} 
    header("Location: profile",303);
    exit();
?>