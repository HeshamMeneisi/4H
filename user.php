<?php

session_start();

function is_logged()
{
    return isset($_SESSION['user']);
}

function get_user()
{
    return $_SESSION['user'];
}
