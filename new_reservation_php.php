<?php

require_once("connect_database.php");
require_once("functions.php");

$success = false;
$error = "Aucune erreur.";

if(isset($_POST["nb_occupants"]) && isset($_POST["date_debut_sejour"]) && isset($_POST["date_fin_sejour"]) && isset($_POST["type_bungalow"]) && isset($_POST["mode_paiement"])){
    
    $nom = htmlspecialchars($_SESSION["nom"]);
	$prenom = htmlspecialchars($_SESSION["prenom"]);
	$adresse_postale = htmlspecialchars($_SESSION["adresse_postale"]);
	$num_tel = htmlspecialchars($_SESSION["num_tel"]);
	$adresse_mail = filter_var($_SESSION["adresse_mail"], FILTER_SANITIZE_EMAIL);
	$type_bungalow = htmlspecialchars($_POST["type_bungalow"]);
	$nb_occupants = htmlspecialchars($_POST["nb_occupants"]);
	$i_date_debut_sejour = htmlspecialchars($_POST["date_debut_sejour"]);
    $i_date_fin_sejour = htmlspecialchars($_POST["date_fin_sejour"]);
    $mode_paiement = htmlspecialchars($_POST["mode_paiement"]);

    $username_verify = sendQuery("SELECT * FROM Clients WHERE nom_client = '$nom' AND prenom_client = '$prenom'");

	if ($username_verify->rowCount() == 1){

        if(preg_match("#0[0-9]{9}#", $num_tel) == 1) {

            $mail_verify = sendQuery("SELECT * FROM Clients WHERE adresse_mail_client = '$adresse_mail'");

            if(filter_var($adresse_mail, FILTER_VALIDATE_EMAIL) && $mail_verify->rowCount() == 1){

                if(preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $i_date_debut_sejour) == 1){

                    if(preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $i_date_fin_sejour) == 1){

                        if($type_bungalow == "Oasis" || $type_bungalow == "Pacifique"){

                            if($nb_occupants >= 1 && $nb_occupants <= 4){

                                if($mode_paiement == "Carte bancaire" || $mode_paiement == "Chèque"){

                                    $taxe_sejour = 0.45 * $nb_occupants;
                                    $date_debut_sejour = date("Y-m-d", strtotime($i_date_debut_sejour));
                                    $date_fin_sejour = date("Y-m-d", strtotime($i_date_fin_sejour));
                                    $date_reservation = date("Y-m-d");
                                    $date_echeance_accompte = date("Y-m-d", strtotime("+2 days"));
                                    $date_echeance_solde = date("Y-m-d", strtotime($i_date_debut_sejour . "-30 days"));
                                    $now = date("Y-m-d H:i:s");  

                                    if($nb_occupants == 3) $supplement = 50;
                                    else if($nb_occupants == 4) $supplement = 100;
                                    else $supplement = 0;

                                    $annee = substr($i_date_debut_sejour, 0, 4);
                                    $mois = substr($i_date_debut_sejour, 5, 2);
                                    $jour = substr($i_date_debut_sejour, 7, 2);

                                    $f_date_debut_sejour = mktime(10, 00, 00, $mois, $jour, $annee);
                                    $date_actuelle = mktime(10, 00, 00, date("m"), date("d"), date("Y"));

                                    $debut_periode_bleu_1 = mktime(10, 00, 00, 4, 5, $annee);
                                    $debut_periode_bleu_2 = mktime(10, 00, 00, 9, 20, $annee);
                                    $fin_periode_bleu_1 = mktime(10, 00, 00, 5, 30, $annee);
                                    $fin_periode_bleu_2 = mktime(10, 00, 00, 11, 7, $annee);

                                    $debut_periode_orange_1 = mktime(10, 00, 00, 5, 31, $annee);
                                    $debut_periode_orange_2 = mktime(10, 00, 00, 8, 16, $annee);
                                    $fin_periode_orange_1 = mktime(10, 00, 00, 7, 27, $annee);
                                    $fin_periode_orange_2 = mktime(10, 00, 00, 9, 19, $annee);

                                    $debut_periode_rouge = mktime(10, 00, 00, 7, 26, $annee);
                                    $fin_periode_rouge = mktime(10, 00, 00, 8, 15, $annee);

                                    if($date_actuelle > $f_date_debut_sejour){
                                        $periode = "erreur";
                                    }else if($f_date_debut_sejour >= $debut_periode_bleu_1 && $f_date_debut_sejour <= $fin_periode_bleu_1 || $f_date_debut_sejour >= $debut_periode_bleu_2 && $f_date_debut_sejour <= $fin_periode_bleu_2){
                                        $periode = "bleu";
                                    }else if($f_date_debut_sejour >= $debut_periode_orange_1 && $f_date_debut_sejour <= $fin_periode_orange_1 || $f_date_debut_sejour >= $debut_periode_orange_2 && $f_date_debut_sejour <= $fin_periode_orange_2){
                                        $periode = "orange";
                                    }else if($f_date_debut_sejour >= $debut_periode_rouge && $f_date_debut_sejour <= $fin_periode_rouge){
                                        $periode = "rouge";
                                    }else{
                                        $periode = "fermée";
                                    }

                                    if($periode == "bleu"){

                                        if($type_bungalow == "Oasis") $montant_sejour = 374;
                                        else $montant_sejour = 420;

                                    }else if($periode == "orange"){

                                        if($type_bungalow == "Oasis") $montant_sejour = 513;
                                        else $montant_sejour = 564;
                                        
                                    }else if($periode == "rouge"){

                                        if($type_bungalow == "Oasis") $montant_sejour = 653;
                                        else $montant_sejour = 692;
                                        
                                    }else{
                                        $montant_sejour = 0;
                                    }

                                    $montant_sejour += $supplement;
                                    $verif_id_taxe_sejour = 1;
                                    $verif_id_caution = 1;
                                    $verif_no_annulation = 1;
                                    $verif_no_transaction = 1;
                                    $verif_no_sejour = 1;

                                    while($verif_id_caution != 0){
                                        $id_caution = nbRand();
                                        $test_id_caution = sendQuery("SELECT * FROM Cautions WHERE id_caution = '$id_caution'");
                                        $verif_id_caution = $test_id_caution->rowCount();
                                    }

                                    while($verif_id_taxe_sejour != 0){
                                        $id_taxe_sejour = nbRand();
                                        $test_id_taxe_sejour = sendQuery("SELECT * FROM TaxesSejour WHERE id_taxe_sejour = '$id_taxe_sejour'");
                                        $verif_id_taxe_sejour = $test_id_taxe_sejour->rowCount();
                                    }

                                    while($verif_no_annulation != 0){
                                        $no_annulation = nbRand();
                                        $test_no_annulation = sendQuery("SELECT * FROM Annulations WHERE no_annulation = '$no_annulation'");
                                        $verif_no_annulation = $test_no_annulation->rowCount();
                                    }

                                    while($verif_no_transaction != 0){
                                        $no_transaction = nbRand();
                                        $test_no_transaction = sendQuery("SELECT * FROM Paiements WHERE no_transaction = '$no_transaction'");
                                        $verif_no_transaction = $test_no_transaction->rowCount();
                                    }

                                    while($verif_no_sejour != 0){
                                        $no_sejour = nbRand();
                                        $test_no_sejour = sendQuery("SELECT * FROM Sejours WHERE no_sejour = '$no_sejour'");
                                        $verif_no_sejour = $test_no_sejour->rowCount();
                                    }
                                    
                                    if($periode == "fermée"){

                                        $error = "Le camping est fermé du 1er janvier au 4 avril inclus et du 8 novembre au 31 décembre inclus.";
                                    
                                    }else if($periode == "erreur"){
                                        
                                        $error = "La date entrée est incorrecte.";

                                    }else{

                                    
                                        sendQuery("INSERT INTO Sejours (no_sejour, date_debut_sejour, date_fin_sejour, ref_periode) VALUES ('$no_sejour', '$date_debut_sejour', '$date_fin_sejour', '$periode')");
                                        sendQuery("INSERT INTO Paiements (no_transaction, mode_paiement, pourcentage_accompte, date_echeance_accompte, date_echeance_solde, montant_sejour) VALUES ('$no_transaction', '$mode_paiement', 40, '$date_echeance_accompte','$date_echeance_solde', '$montant_sejour')");
                                        sendQuery("INSERT INTO Annulations (no_annulation, date_annulation, cause_annulation, montant_remboursement) VALUES ('$no_annulation', '2021-01-01', 'none', 0)");
                                        sendQuery("INSERT INTO TaxesSejour (id_taxe_sejour, etat_taxe_sejour, montant_taxe_sejour) VALUES ('$id_taxe_sejour', 'en attente', '$taxe_sejour')");
                                        sendQuery("INSERT INTO Cautions (id_caution, etat_caution, etat_des_lieux, cr_etat_des_lieux, montant_debite) VALUES ('$id_caution', 'en attente', 'en attente', 'none', 0)");
                                        sendQuery("INSERT INTO Bungalows (type_bungalow, nb_occupants, id_caution, id_taxe_sejour) VALUES ('$type_bungalow', '$nb_occupants', '$id_caution', '$id_taxe_sejour')");

                                        $recup_no_bungalow = sendQuery("SELECT * FROM Bungalows WHERE id_taxe_sejour = '$id_taxe_sejour'");
                                        $req_no_bungalow = $recup_no_bungalow->fetch();
                                        $no_bungalow = $req_no_bungalow["no_bungalow"];

                                        $recup_no_client = sendQuery("SELECT * FROM Clients WHERE nom_client = '$nom' AND prenom_client = '$prenom' AND adresse_mail_client = '$adresse_mail'");
                                        $req_no_client = $recup_no_client->fetch();
                                        $no_client = $req_no_client["no_client"];

                                        sendQuery("INSERT INTO Reservations (date_reservation, etat_reservation, no_client, no_bungalow, no_sejour, no_annulation, no_transaction) VALUES ('$now', 'en attente', '$no_client', '$no_bungalow', '$no_sejour', '$no_annulation', '$no_transaction')");
                                        
                                        $recup_no_reservation = sendQuery("SELECT no_reservation FROM Reservations WHERE no_client = '$no_client' AND no_transaction = '$no_transaction'");
                                        $req_no_reservation = $recup_no_reservation->fetch();
                                        $no_reservation = $req_no_reservation["no_reservation"];
                                        
                                        $success = true;
                                    }

                                }else{
                                    $error = "Le mode de paiement entré est incorrect.";
                            
                                }
                                
                            }else{
                                $error = "Le nombre d'occupants entré est incorrect.";
                        
                            }

                        }else{
                            $error = "Le type de bungalow entré est incorrect.";
                    
                        }

                    }else{
                        $error = "La date de fin de séjour entrée est incorrecte.";
                
                    }

                }else{
                    $error = "La date de début de séjour entrée est incorrecte.";
            
                }
            
            }else{
                $error = "Votre adresse mail est incorrecte.";
        
            }

        }else{
            $error = "Votre numéro de téléphone est incorrect.";
    
        }

    }else{
        $error = "Erreur concernant votre compte.";

    }

}else{
    $error = "Vous devez remplir tous les champs.";
}

if($success) {
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
                Votre demande de réservation <strong>a bien été prise en compte</strong>.
            </p><br>
            <p class=\"subtitle is-5\">
                Veuillez trouver ci-dessous vos <strong>informations de connexion</strong> : <br>
                <ul>
                    <li>Votre numéro de client : ". $no_client ."</li>
                    <li>Votre adresse mail : ". $adresse_mail ."</li>
                    <li>Votre numéro de réservation : ". $no_reservation ."</li>
                </ul>
            </p><br>
            <div class=\"field is-grouped\">
            <div class=\"control\">
                <a class=\"button is-link\" href=\"espace_client.php\">Retourner à l'espace client</a>
            </div>
            <div class=\"control\">
              <a class=\"button is-link is-light\" href=\"index.php\">Aller à l'accueil</a>
            </div>
          </div>
        </div>
    </section>";
}else{
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
                Votre formulaire de réservation comporte une erreur : <strong>".$error."</strong>
            </p><br>
            <div class=\"field is-grouped\">
            <div class=\"control\">
                <a class=\"button is-link\" href=\"new_reservation.php\">Réessayer</a>
            </div>
            <div class=\"control\">
              <a class=\"button is-link is-light\" href=\"espace_client.php\">Retourner à l'espace client</a>
            </div>
          </div>
        </div>
    </section>";
}