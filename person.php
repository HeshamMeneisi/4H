<?php

$person = $_GET['person'];
$link = './profile.php?uid='.$person['uid'];
$person_name = $person['fname'].' '.$person['lname']." (<a href={$link}>".$person['nickname'].'</a>)';
if (isset($person['_time'])) {
    $person_time = $person['_time'];
} else {
    $person_time = null;
}
$uid = $person['uid'];
$pic = 'content/users/'.$uid.'/profile_picture.png';
if (!file_exists($pic)) {
    $pic = "./content/static/default_picture/{$person['gender']}.jpg";
}
echo "<img class='request_thumb' src='{$pic}' height='50' width='50'>".$person_name.($person_time ? '<br>Request time: '.date('l, F jS, Y', strtotime($person_time)) : '');
