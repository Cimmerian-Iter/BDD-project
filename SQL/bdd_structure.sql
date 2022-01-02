CREATE DATABASE camping CHARSET=utf8mb4;

USE camping;

CREATE TABLE Clients (
  no_client INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nom_client VARCHAR(128),
  prenom_client VARCHAR(128),
  adresse_postale_client VARCHAR(256),
  adresse_mail_client VARCHAR(256),
  num_tel_client VARCHAR(128))
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE Sejours (
  no_sejour INT(6) ZEROFILL UNSIGNED NOT NULL PRIMARY KEY,
  date_debut_sejour DATE,
  date_fin_sejour DATE,
  ref_periode VARCHAR(56))
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE Annulations (
  no_annulation INT(6) ZEROFILL UNSIGNED NOT NULL PRIMARY KEY,
  date_annulation TIMESTAMP,
  cause_annulation VARCHAR(256),
  montant_remboursement DOUBLE)
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE Paiements (
  no_transaction INT(6) ZEROFILL UNSIGNED NOT NULL PRIMARY KEY,
  mode_paiement VARCHAR(128),
  pourcentage_accompte INT,
  date_echeance_accompte DATE,
  date_echeance_solde DATE,
  montant_sejour DOUBLE)
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE Cautions (
  id_caution INT(6) ZEROFILL UNSIGNED NOT NULL PRIMARY KEY,
  etat_caution VARCHAR(128),
  etat_des_lieux VARCHAR(128),
  cr_etat_des_lieux VARCHAR(256),
  montant_debite DOUBLE)
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE TaxesSejour (
  id_taxe_sejour INT(6) ZEROFILL UNSIGNED NOT NULL PRIMARY KEY,
  etat_taxe_sejour VARCHAR(128),
  montant_taxe_sejour DOUBLE)
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE Bungalows (
  no_bungalow INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  type_bungalow VARCHAR(56),
  nb_occupants INT UNSIGNED,
  id_caution INT UNSIGNED NOT NULL,
  id_taxe_sejour INT UNSIGNED NOT NULL,
  CONSTRAINT fk_id_caution
  FOREIGN KEY (id_caution)
  REFERENCES Cautions(id_caution) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_id_taxe_sejour
  FOREIGN KEY (id_taxe_sejour)
  REFERENCES TaxesSejour(id_taxe_sejour) ON DELETE CASCADE ON UPDATE CASCADE)
  ENGINE InnoDB CHARSET utf8mb4;

CREATE TABLE Reservations (
  no_reservation INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  date_reservation TIMESTAMP,
  etat_reservation VARCHAR(64),
  no_client INT UNSIGNED NOT NULL,
  no_sejour INT UNSIGNED NOT NULL,
  no_transaction INT UNSIGNED NOT NULL,
  no_annulation INT UNSIGNED NOT NULL,
  no_bungalow INT UNSIGNED NOT NULL,
  CONSTRAINT fk_no_client
  FOREIGN KEY (no_client)
  REFERENCES Clients(no_client) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_no_sejour
  FOREIGN KEY (no_sejour)
  REFERENCES Sejours(no_sejour) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_no_transaction
  FOREIGN KEY (no_transaction)
  REFERENCES Paiements(no_transaction) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_no_annulation
  FOREIGN KEY (no_annulation)
  REFERENCES Annulations(no_annulation) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_no_bungalow
  FOREIGN KEY (no_bungalow)
  REFERENCES Bungalows(no_bungalow) ON DELETE CASCADE ON UPDATE CASCADE)
  ENGINE InnoDB CHARSET utf8mb4;