<?php	

require_once("connect_database.php");
require_once("functions.php");

if (!isset($_SESSION["no_client"])){
	header("location: connexion.php");
}

$no_client = $_SESSION["no_client"];

$recup_resa = sendQuery("SELECT * FROM Reservations WHERE no_client = '$no_client'");

while ($data = $recup_resa->fetch()){
    $no_sejour = $data['no_sejour'];
    $no_transaction = $data['no_transaction'];
    $no_bungalow = $data['no_bungalow'];
    $no_annulation = $data['no_annulation'];

    $recup_info_bungalow = sendQuery("SELECT * FROM Bungalows WHERE no_bungalow = '$no_bungalow'");
    $req_info_bungalow = $recup_info_bungalow->fetch();

    $id_taxe_sejour = $req_info_bungalow['id_taxe_sejour'];
    $id_caution = $req_info_bungalow['id_caution'];

    sendQuery("DELETE FROM Bungalows WHERE no_bungalow = '$no_bungalow'");
    sendQuery("DELETE FROM Sejours WHERE no_sejour = '$no_sejour'");
    sendQuery("DELETE FROM Paiements WHERE no_transaction = '$no_transaction'");
    sendQuery("DELETE FROM TaxesSejour WHERE id_taxe_sejour = '$id_taxe_sejour'");
    sendQuery("DELETE FROM Cautions WHERE id_caution = '$id_caution'");
    sendQuery("DELETE FROM Annulations WHERE no_annulation = '$no_annulation'");
}

sendQuery("DELETE FROM Reservations WHERE no_client = '$no_client'");
sendQuery("DELETE FROM Clients WHERE no_client = '$no_client'");

unset($_SESSION["no_client"]);
unset($_SESSION["adresse_mail"]);
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);
unset($_SESSION["num_tel"]);
unset($_SESSION["adresse_postale"]);

session_destroy();

header("Location:index.php");