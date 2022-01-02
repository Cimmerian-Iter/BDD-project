<?php

date_default_timezone_set("Europe/Paris");
session_start();

$host = "localhost";
$user = "zeucvrrg_root";
$pass = "O8^Q@QmF@w^5C,5mC0";
$name = "zeucvrrg_camping";

try{
	$db = new PDO("mysql:host=".$host.";dbname=".$name.";charset=utf8", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));             
}catch(PDOException $e){
	echo "Erreur de connexion avec la base de données : ".$e;
}