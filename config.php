<?php 
session_start();
$base = 'http://localhost/devsbook';

$maxWidth = 800;
$maxHeight = 800;

$db_name = 'devsbook';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);