<?php

if (isset($_GET['c']) && isset($_GET['l'])) {
    $caption = $_GET['c'];
    $link = $_GET['l'];
    echo "<a href={$link}>{$caption}</a><br>";
}
