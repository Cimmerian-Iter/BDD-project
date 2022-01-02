<?php

require_once("connect_database.php");
require_once("functions.php");

$success = false;
$error = "Aucune erreur.";

if(isset($_POST["no_client"]) && isset($_POST["adresse_mail"])){
    $adresse_mail = filter_var($_POST["adresse_mail"], FILTER_SANITIZE_EMAIL);
    $no_client = htmlspecialchars($_POST["no_client"]);

    if(filter_var($adresse_mail, FILTER_VALIDATE_EMAIL)){

        $client_verify = sendQuery("SELECT * FROM Clients WHERE no_client = '$no_client' AND adresse_mail_client = '$adresse_mail'");

        if ($client_verify->rowCount() == 1){

            $req_client_verify = $client_verify->fetch();

            $_SESSION["no_client"] = $no_client;
            $_SESSION["adresse_mail"] = $adresse_mail;
            $_SESSION["nom"] = $req_client_verify["nom_client"];
            $_SESSION["prenom"] = $req_client_verify["prenom_client"];
            $_SESSION["num_tel"] = $req_client_verify["num_tel_client"];
            $_SESSION["adresse_postale"] = $req_client_verify["adresse_postale_client"];

            $success = true;
            header("location:espace_client.php");

        }else{
            $error = "Le compte client entré est introuvable.";
        }

    }else{
        $error = "Votre adresse mail est incorrecte.";
    }

}else{
    $error = "Vous devez remplir tous les champs.";
}

if(!$success) {
    echo "<!DOCTYPE html>
    <html lang=\"fr\">

    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

        <title>Camping Grand Large</title>
        <link rel=\"icon\" type=\"image/png\" href=\"https://samsam.go.yo.fr/avatar.png\">

        <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css\">

    </head>
    <section class=\"section\">
        <div class=\"container\">
            <p class=\"subtitle is-4\">
                Votre formulaire de connexion comporte une erreur : <strong>".$error."</strong>
            </p><br>
            <div class=\"field is-grouped\">
            <div class=\"control\">
                <a class=\"button is-link\" href=\"connexion.php\">Réessayer</a>
            </div>
            <div class=\"control\">
              <a class=\"button is-link is-light\" href=\"index.php\">Retourner à l'accueil</a>
            </div>
          </div>
        </div>
    </section>";
}