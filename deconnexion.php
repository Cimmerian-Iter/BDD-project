<?php
require_once("connect_database.php");
require_once("functions.php");

unset($_SESSION["no_client"]);
unset($_SESSION["adresse_mail"]);
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);
unset($_SESSION["num_tel"]);
unset($_SESSION["adresse_postale"]);

session_destroy();

header("Location:index.php");