USE camping;

INSERT INTO Clients (nom_client, prenom_client, adresse_postale_client, adresse_mail_client, num_tel_client) VALUES ('DURANT', 'Michel', '2 rue Jean Lamour, 54500 Vandoeuvre-lès-Nancy', 'michel.durant@example.com', '06 66 66 66 66');
INSERT INTO Sejours (date_debut_sejour, date_fin_sejour, ref_periode) VALUES ('2021-08-12', '2021-08-19', 'orange');
INSERT INTO Paiements (mode_paiement, pourcentage_accompte, date_echeance_accompte, date_echeance_solde, montant_sejour) VALUES ('Carte bancaire', 40, '2021-06-22','2021-07-12',513);
INSERT INTO Annulations (date_annulation, cause_annulation, montant_remboursement) VALUES ('2021-30-10', 'erreur transfert', 300);
INSERT INTO TaxesSejour (etat_taxe_sejour, montant_taxe_sejour) VALUES ('en attente', '5.52');
INSERT INTO Cautions (etat_caution, etat_des_lieux, cr_etat_des_lieux, montant_debite) VALUES ('en attente', 'en attente', 'RAS', 0);
INSERT INTO Bungalows (type_bungalow, nb_occupants, id_caution, id_taxe_sejour) VALUES ('Oasis', 4, 1, 1);
INSERT INTO Reservations (date_reservation, etat_reservation, no_client, no_bungalow, no_sejour, no_annulation, no_transaction) VALUES ('2021-10-30 20:38:00', 'en attente', 1, 1, 1, 1, 1);