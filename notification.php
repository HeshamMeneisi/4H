<?php

if (isset($_GET['c']) && isset($_GET['l'])) {
    $caption = $_GET['c'];
    $link = $_GET['l'];
    echo "<div class='notification'><a href={$link}>{$caption}</a></div><br>";
}
