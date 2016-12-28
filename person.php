<?php

$person = $_GET['person'];
$person_name = $person['fname'].' '.$person['lname'].' ('.$person['nickname'].')';
if (isset($person['_time'])) {
    $person_time = $person['_time'];
} else {
    $person_time = null;
}
$uid = $person['uid'];
$pic = 'image/pic_'.$uid.'.png';
if (!file_exists($pic)) {
    $pic = "./image/def_{$person['gender']}.jpg";
}
echo "<br/><br/><img src='{$pic}' height='50' width='50'>".$person_name.($person_time ? ' since '.$person_time : '');
