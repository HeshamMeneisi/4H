<?php

$person = $_GET['person'];
$link = './profile?uid='.$person['uid'];
$person_name = $person['fname'].' '.$person['lname']."<div class='nickname'>(<a href={$link}>".$person['nickname'].'</a>)</div>';

if (isset($person['_time'])) {
    $person_time = $person['_time'];
} else {
    $person_time = null;
}

$uid = $person['uid'];
$pic = 'content/users/'.$uid.'/profile_picture.png';

if (isset($_GET['f'])) {
    $ttext = 'Friends since';
} else {
    $ttext = 'Request time';
}

if (!file_exists($pic)) {
    $pic = "./content/static/default_picture/{$person['gender']}.jpg";
}

echo "<div class='person'>
    <img class='request_thumb' src='{$pic}' height='50' width='50'>".$person_name.($person_time ? '<div id="friend_detail">'.$ttext.': '.date('l, F jS, Y', strtotime($person_time)).'</div>' : '').'</div>';
