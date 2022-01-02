<?php

require_once("connect_database.php");
require_once("functions.php"); 

if (!isset($_SESSION["no_client"])){
	header("location: connexion.php");
}

include_once("header.php");
include_once("navbar.php");
?>
    <section class="section">
        <div class="container">
            <p class="subtitle is-3">
                Bienvenue sur votre espace client <strong><?= $_SESSION["prenom"] ?> <?= $_SESSION["nom"] ?></strong>.
            </p><br>
            <p class="subtitle is-4">
                Vos <strong>coordonnées</strong> :<br>
                <div class="table-container">
                <table class="table is-striped is-narrow is-hoverable">
                <thead>
                    <tr>
                        <th>Num. client</th>
                        <th>Adresse postale</th>
                        <th>Adresse mail</th>
                        <th>Num. téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tr>
                    <th><?= $_SESSION["no_client"] ?></th>
                    <td><?= $_SESSION["adresse_postale"] ?></td>
                    <td><?= $_SESSION["adresse_mail"] ?></td>
                    <td><?= $_SESSION["num_tel"] ?></td>
                    <td>
                    <div class="buttons">
                    <a class="button is-info is-static" href="">
                    <span class="icon">
                        <i class="fas fa-edit"></i>
                    </span>
                    <span>
                    Editer mes informations
                    </span>    
                    </a>
                    <a class="button is-danger" href="delete_account.php?no_client=<?= $_SESSION["no_client"] ?>">
                    <span class="icon">
                        <i class="fas fa-window-close"></i>
                    </span>
                    <span>
                    Supprimer mon compte
                    </span>    
                    </a>
                    </div>
                    </td>
                </tr>
                </table><br><br>
            <p class="subtitle is-4">
                Vos <strong>réservations</strong> :
                <div class="table-container">
                <table class="table is-striped is-fullwidth is-narrow is-hoverable" style="table-layout: fixed; min-width: 2600px;">
                <thead>
                    <tr>
                        <th>Num. réservation</th>
                        <th>Etat réservation</th>
                        <th>Num. bungalow</th>
                        <th>Nb. occupants</th>
                        <th>Type bungalow</th>
                        <th>Date réservation</th>
                        <th>Dates séjour</th>
                        <th>Période séjour</th>
                        <th>Prix séjour</th>
                        <th>Prix taxe de séjour</th>
                        <th>Num. annulation</th>
                        <th>Date annulation</th>
                        <th>Cause annulation</th>
                        <th>Montant remboursement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php

                $no_client = $_SESSION['no_client'];

                $recup_resa = sendQuery("SELECT * FROM Reservations WHERE no_client = '$no_client'");
                $counter = 0;

                while ($data = $recup_resa->fetch()){
                    $counter++;

                    $no_sejour = $data['no_sejour'];
                    $no_transaction = $data['no_transaction'];
                    $no_bungalow = $data['no_bungalow'];
                    $no_annulation = $data['no_annulation'];

                    $recup_dates_sejour = sendQuery("SELECT * FROM Sejours WHERE no_sejour = '$no_sejour'");
                    $req_dates_sejour = $recup_dates_sejour->fetch();
                    $dates_sejour = "du ".formatDate($req_dates_sejour["date_debut_sejour"])." au ".formatDate($req_dates_sejour["date_fin_sejour"]);
                    $periode_sejour = $req_dates_sejour["ref_periode"];

                    $date_debut_sejour = $req_dates_sejour["date_debut_sejour"];
                    $date_fin_sejour = $req_dates_sejour["date_fin_sejour"];
                    $annee_debut = substr($date_debut_sejour, 0, 4);
                    $mois_debut = substr($date_debut_sejour, 5, 2);
                    $jour_debut = substr($date_debut_sejour, 7, 2);

                    $annee_fin = substr($date_fin_sejour, 0, 4);
                    $mois_fin = substr($date_fin_sejour, 5, 2);
                    $jour_fin = substr($date_fin_sejour, 7, 2);

                    $max_annulation = mktime(10, 00, 00, $mois_debut, $jour_debut, $annee_debut);
                    $fin_sejour = mktime(10, 00, 00, $mois_fin, $jour_fin, $annee_fin);
                    $date_actuelle = mktime(10, 00, 00, date("m"), date("d"), date("Y"));

                    $recup_prix_sejour = sendQuery("SELECT * FROM Paiements WHERE no_transaction = '$no_transaction'");
                    $req_prix_sejour = $recup_prix_sejour->fetch();
                    $prix_sejour = $req_prix_sejour["montant_sejour"]."€";

                    $recup_info_bungalow = sendQuery("SELECT * FROM Bungalows WHERE no_bungalow = '$no_bungalow'");
                    $req_info_bungalow = $recup_info_bungalow->fetch();
                    $nb_occupants = $req_info_bungalow["nb_occupants"];
                    $type_bungalow = $req_info_bungalow["type_bungalow"];
                    $id_taxe_sejour = $req_info_bungalow['id_taxe_sejour'];

                    $recup_info_taxe_sejour = sendQuery("SELECT * FROM TaxesSejour WHERE id_taxe_sejour = '$id_taxe_sejour'");
                    $req_info_taxe_sejour = $recup_info_taxe_sejour->fetch();
                    $montant_taxe_sejour = $req_info_taxe_sejour["montant_taxe_sejour"]."€";
                    $montant_taxe_sejour = str_replace(".", ",", $montant_taxe_sejour);

                    $recup_info_annulation = sendQuery("SELECT * FROM Annulations WHERE no_annulation = '$no_annulation'");
                    $req_info_annulation = $recup_info_annulation->fetch();
                    $date_annulation = $req_info_annulation["date_annulation"];
                    $cause_annulation = $req_info_annulation["cause_annulation"];
                    $montant_remboursement = $req_info_annulation["montant_remboursement"]."%";

                    $date_annulation_part_1 = formatDate(substr($date_annulation, 0, 10));
                    $date_annulation_part_2 = formatHour(substr($date_annulation, 11));
                    $date_annulation = "le ".$date_annulation_part_1." à ".$date_annulation_part_2;

                    $date_reservation_part_1 = formatDate(substr($data["date_reservation"], 0, 10));
                    $date_reservation_part_2 = formatHour(substr($data["date_reservation"], 11));
                    $date_reservation = "le ".$date_reservation_part_1." à ".$date_reservation_part_2;
                ?>

                <tr>
                    <th><?= $data["no_reservation"] ?></th>
                    <td><?= $data["etat_reservation"] ?></td>
                    <td><?= $no_bungalow ?></td>
                    <td><?= $nb_occupants ?></td>
                    <td><?= $type_bungalow ?></td>
                    <td><?= $date_reservation ?></td>
                    <td><?= $dates_sejour ?></td>
                    <td><?= $periode_sejour ?></td>
                    <td><?= $prix_sejour ?></td>
                    <td><?= $montant_taxe_sejour ?></td>
                    
                    <?php if($data["etat_reservation"] == "annulée") { ?>

                        <td><?= $no_annulation ?></td>
                        <td><?= $date_annulation ?></td>
                        <td><?= $cause_annulation ?></td>
                        <td><?= $montant_remboursement ?></td>

                    <?php }else{ ?>

                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>

                    <?php } ?>
                    <td>
                    <?php if($data["etat_reservation"] != "annulée" && $date_actuelle < $max_annulation) { ?>
                        <div class="control">
                            <a class="button is-danger" href="annulation.php?no_reservation=<?= $data["no_reservation"] ?>">
                            <span class="icon">
                                <i class="fas fa-window-close"></i>
                            </span>
                            <span>
                            Annuler la réservation
                            </span>
                        </a>
                        </div>
                    <?php }else if($data["etat_reservation"] == "annulée"){ ?>
                        <div class="control">
                            <a class="button is-danger is-light is-static" href="">
                            <span class="icon">
                                <i class="fas fa-ban"></i>
                            </span>
                            <span>
                            Réservation annulée
                            </span>
                            </a>
                        </div>
                    <?php }else if($data["etat_reservation"] != "annulée" && $date_actuelle >= $max_annulation && $date_actuelle <= $fin_sejour){ ?>
                        <div class="control">
                            <a class="button is-info is-light is-static" href="">
                            <span class="icon">
                                <i class="fas fa-spinner"></i>
                            </span>
                            <span>
                            Réservation en cours
                            </span>
                            </a>
                        </div>
                    <?php }else{ ?>

                        <div class="control">
                            <a class="button is-success is-light is-static" href="">
                            <span class="icon">
                                <i class="fas fa-check-square"></i>
                            </span>
                            <span>
                            Séjour terminé
                            </span>
                            </a>
                        </div>

                    <?php } ?>    

                    </td>
                </tr>
                
                    <?php } ?> 

                </table>
                </div>
            </p><br>
            <div class="field is-grouped">
            <div class="control">
                <a class="button is-link" href="new_reservation.php">
                <span class="icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span>
                            
                    Effectuer une nouvelle réservation
                            </span>
                </a>
            </div>
            <div class="control">
              <a class="button is-link is-light" href="index.php">Retourner à l'accueil</a>
            </div>
          </div>
        </div>
    </section>
</html>