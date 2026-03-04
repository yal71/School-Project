
-- creation de la bdd si elle existe pas
CREATE DATABASE IF NOT EXISTS timeguessr
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- selection de la base de données
USE timeguessr;


-- Table des images
-- stocke les photos utilisées dans le jeu

CREATE TABLE IF NOT EXISTS images (
    id          INT PRIMARY KEY AUTO_INCREMENT    COMMENT 'identifiant unique de l image',
    chemin      VARCHAR(500) NOT NULL             COMMENT 'url ou chemin local vers la photo',
    annee       INT NOT NULL                      COMMENT 'année réelle où la photo a été prise',
    description VARCHAR(255) DEFAULT NULL         COMMENT 'courte description de la photo'
);


-- table des parties
-- stocke chaque partie jouée

CREATE TABLE IF NOT EXISTS parties (
    id             INT PRIMARY KEY AUTO_INCREMENT COMMENT 'identifiant unique de la partie',
    date_creation  DATETIME DEFAULT NOW()         COMMENT 'date et heure de début de la partie',
    score_total    INT DEFAULT 0                  COMMENT 'score total sur 5000 points'
);

-- table des manches
-- stocke chaque manche d'une partie

CREATE TABLE IF NOT EXISTS manches (
    id              INT PRIMARY KEY AUTO_INCREMENT COMMENT 'identifiant unique de la manche',
    partie_id       INT NOT NULL                   COMMENT 'référence à la table parties',
    image_id        INT NOT NULL                   COMMENT 'référence à la table images',
    numero_manche   INT NOT NULL                   COMMENT 'numéro de la manche dans la partie (1 à 5)',
    annee_estimee   INT DEFAULT NULL               COMMENT 'année devinée par le joueur (NULL si pas encore joué)',
    score           INT DEFAULT 0                  COMMENT 'score obtenu pour cette manche (0 à 1000)',

    -- clés étrangères // une manche appartient à une partie et utilise une image
    FOREIGN KEY (partie_id) REFERENCES parties(id),
    FOREIGN KEY (image_id)  REFERENCES images(id)
);
