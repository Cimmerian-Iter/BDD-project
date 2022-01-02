<?php

require_once("connect_database.php");
require_once("functions.php");

if (!isset($_SESSION["no_client"])){
	header("location: connexion.php");
}

$success = false;
$error = "Aucune erreur.";

if(isset($_GET["no_reservation"])){
    $no_reservation = intval(htmlspecialchars($_GET["no_reservation"]));

    $reservation_verify = sendQuery("SELECT * FROM Reservations WHERE no_reservation = '$no_reservation'");

    if ($reservation_verify->rowCount() == 1){

        $req = $reservation_verify->fetch();

        if($req["etat_reservation"] != "annulée"){

            $no_annulation = $req["no_annulation"];
            $no_sejour = $req["no_sejour"];
            $date_annulation = date("Y-m-d H:i:s"); 
            $cause_annulation = "client";

            $recup_dates_sejour = sendQuery("SELECT * FROM Sejours WHERE no_sejour = '$no_sejour'");
            $req_dates_sejour = $recup_dates_sejour->fetch();
            $date_debut_sejour = $req_dates_sejour["date_debut_sejour"];

            $date_echeance_annulation = date("Y-m-d", strtotime($date_debut_sejour . "-30 days"));

            $annee = substr($date_echeance_annulation, 0, 4);
            $mois = substr($date_echeance_annulation, 5, 2);
            $jour = substr($date_echeance_annulation, 7, 2);

            $max_annulation = mktime(10, 00, 00, $mois, $jour, $annee);
            $date_actuelle = mktime(10, 00, 00, date("m"), date("d"), date("Y"));

            if ($date_actuelle < $max_annulation || date("Y") < $annee) $pourcentage_remboursement = 20;
            else $pourcentage_remboursement = 0;

            $recup_prix_sejour = sendQuery("SELECT * FROM Paiements WHERE no_transaction = '$no_transaction'");
            $req_prix_sejour = $recup_prix_sejour->fetch();
            $prix_sejour = $req_prix_sejour["montant_sejour"];

            $montant_remboursement = $pourcentage_remboursement;

            sendQuery("UPDATE Annulations SET date_annulation = '$date_annulation' WHERE no_annulation = '$no_annulation'");
            sendQuery("UPDATE Annulations SET cause_annulation = '$cause_annulation' WHERE no_annulation = '$no_annulation'");
            sendQuery("UPDATE Annulations SET montant_remboursement = '$montant_remboursement' WHERE no_annulation = '$no_annulation'");
            
            sendQuery("UPDATE Reservations SET etat_reservation = 'annulée' WHERE no_reservation = '$no_reservation'");
            header("location: espace_client.php");

        }else{
            header("location: connexion.php");
        }

    }else{
        header("location: connexion.php");
    }

}else{
    header("location: connexion.php");
}