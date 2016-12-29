<?php

if (isset($_GET['c']) && isset($_GET['l'])) {
    $nickname = $_GET['n'];
    $caption = $_GET['c'];
    $link = $_GET['l'];
    echo "<div class='notification'>{$nickname} <a href={$link}>{$caption}</a></div><br>";
}
