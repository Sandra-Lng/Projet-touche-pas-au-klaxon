-- Création de la base "touche_pas_au_klaxon"
DROP DATABASE IF EXISTS touche_pas_au_klaxon;
CREATE DATABASE touche_pas_au_klaxon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE touche_pas_au_klaxon;

CREATE TABLE agence (
  id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_agence_nom (nom)
) ENGINE=InnoDB;

CREATE TABLE utilisateur (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nom          VARCHAR(100) NOT NULL,
  prenom       VARCHAR(100) NOT NULL,
  telephone    VARCHAR(20)  NOT NULL,
  email        VARCHAR(190) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  role         ENUM('employe','admin') NOT NULL DEFAULT 'employe',
  PRIMARY KEY (id),
  UNIQUE KEY uq_utilisateur_email (email)
) ENGINE=InnoDB;

CREATE TABLE trajet (
  id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  agence_depart_id  INT UNSIGNED NOT NULL,
  agence_arrivee_id INT UNSIGNED NOT NULL,
  date_depart       DATETIME NOT NULL,
  date_arrivee      DATETIME NOT NULL,
  places_total      SMALLINT UNSIGNED NOT NULL,
  places_dispo      SMALLINT UNSIGNED NOT NULL,
  auteur_id         INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY idx_trajet_depart (date_depart),
  CONSTRAINT fk_trajet_agence_depart  FOREIGN KEY (agence_depart_id)  REFERENCES agence (id) ON DELETE RESTRICT,
  CONSTRAINT fk_trajet_agence_arrivee FOREIGN KEY (agence_arrivee_id) REFERENCES agence (id) ON DELETE RESTRICT,
  CONSTRAINT fk_trajet_auteur         FOREIGN KEY (auteur_id)         REFERENCES utilisateur (id) ON DELETE CASCADE,
  CONSTRAINT ck_trajet_agences CHECK (agence_depart_id <> agence_arrivee_id),
  CONSTRAINT ck_trajet_dates   CHECK (date_arrivee > date_depart),
  CONSTRAINT ck_trajet_places  CHECK (places_dispo <= places_total)
) ENGINE=InnoDB;
