<?php

$servername = 'localhost';
$database = 'hallo';
$username = 'root';
$password = 'root';

//Connection variable
$connection = 'mysql:host='.$servername.';dbname='.$database;

// Create connection
$pdo = new PDO($connection, $username, $password);
