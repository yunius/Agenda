
INSERT INTO `agenda`.`type_activite` (`IDtypeActivite`, `activiteLibelle`, `IDactiviteParente`) 
VALUES 
(NULL, 'randonnée', NULL),
(NULL, 'alpinisme', NULL),
(NULL, 'escalade', NULL),
(NULL, 'canyoning', NULL),
(NULL, 'spéléologie', NULL),
(NULL, 'vtt', NULL);



INSERT INTO `agenda`.`type_de_materiel` (`IDtypeMat`, `typeMatLibelle`) 
VALUES
(NULL, 'baton de marche'),
(NULL, 'chaussure alpinisme'),
(NULL, 'baudrier'),
(NULL, 'casque'),
(NULL, 'descendeur'),
(NULL, 'noeud auto bloquant'),
(NULL, '2 mousqueton a vis'),
(NULL, 'crampons'),
(NULL, 'pelle'),
(NULL, 'dva-sonde'),
(NULL, 'fond de sac'),
(NULL, 'piolet');

INSERT INTO `agenda`.`cotation` (`IDcotation`, `LibelleCotation`, `ValeurCotation`) 
VALUES 
(NULL, 'alpinisme', 'F'),
(NULL, 'alpinisme', 'AD'),
(NULL, 'alpinisme', 'TD'),
(NULL, 'Physique', '2'),
(NULL, 'Physique', '3'),
(NULL, 'Physique', '4'),
(NULL, 'technique', '2'),
(NULL, 'technique', '3'),
(NULL, 'technique', '4'),
(NULL, 'alpinisme', 'PD');

INSERT INTO `agenda`.`pays` (`IDpays`, `nomPays`) 
VALUES 
(NULL, 'espagne'),
(NULL, 'france');

INSERT INTO `agenda`.`commune` (`IDcommune`, `nomCommune`, `codePostal`, `IDpays`) 
VALUES
(NULL, 'bordeaux', '33000', '1'), 
(NULL, 'cauterets', '65110', '1'),
(NULL, 'lescun', '64490', '1'),
(NULL, 'gavarnie', '65120', '1'),
(NULL, 'laruns', '64440', '1'),
(NULL, 'pau', '64000', '1');


INSERT INTO `agenda`.`club` (`IDclub`, `nomClub`, `clubSecteur`, `clubNumTel`, `IDcommune`) 
VALUES 
(NULL, 'CAF de pau', 'Pau et vallée d''ossau', '0559000000', '1');

INSERT INTO `agenda`.`role` (`IDrole`, `RoleLibelle`, `RoleDescription`) 
VALUES 
(NULL, 'participant', 'peut consulter les collectives et poster une candidature'),
(NULL, 'contributeur', 'peut rediger du contenu');

INSERT INTO `agenda`.`encadrant_professionnel` (`IDencadrantPro`, `encProNom`, `encProPrenom`, `encProDateNaiss`, `encProGenre`, `encProMail`, `encProLibelleRue`, `encProNumRue`, `encProNumTel`, `IDcommune`) 
VALUES 
(NULL, 'Lafargue', 'Jean-pierre', '1970-10-15', 'H', 'Lafargue@caramail.com', NULL, NULL, '0559000000', NULL);

INSERT INTO `agenda`.`lieu` (`IDlieu`, `lieuLibelle`) 
VALUES 
(NULL, 'Parking meuble Laclau'),
(NULL, 'Parking pont d''Oly');

INSERT INTO `agenda`.`secteur` (`IDsecteur`, `secteurLibelle`, `IDcommune`) 
VALUES 
(NULL, 'vallée d''ossau', '1');
(NULL, 'cirque de gavarnie', '5');
(NULL, 'cirque de lescun', '4');
(NULL, 'cauterets', '3');

INSERT INTO `agenda`.`objectif` (`IDobjectif`, `objectifLibelle`, `IDsecteur`) 
VALUES 
(NULL, 'Le Lurien', '1'),
(NULL, 'Le Taillon', '2'),
(NULL, 'pic Marboré', '2'),
(NULL, 'Le Pic d''Er', '1'),
(NULL, 'la table des trois rois', '3'),
(NULL, 'le petit vignemale', '4'),
(NULL, 'Ossau face nord', '1');


INSERT INTO `agenda`.`adherents` (`IDadherent`, `numLicence`, `statut`, `nomAdherent`, `prenomAdherent`, `pseudoAdherent`, `motDePasseAdherent`, `DateNaissAdherent`, `genreAdherent`, `MailAdherent`, `adherentLibelleRue`, `adherentNumRue`, `adherentNumTel`, `Vehicule`, `co_voitureur`, `CompteActif`, `IDcommune`, `IDclub`, `IDrole`) 
VALUES 
(NULL, '9265478', 'adherent', 'trump', 'donald', 'donald', '54321', '1966-05-22', 'H', 'trump@mail.com', 'rue somwhere', '32', '0559000000', NULL, NULL, NULL, '1', '1', '1'),
(NULL, '9265478', 'encadrant', 'prolix', 'remi', 'remi', '12345', '1972-07-02', 'H', 'prolix@mail.com', 'rue bidule', '12', '0559000000', NULL, NULL, NULL, '1', '1', '2');
(NULL, '1284832', 'adherent', 'Martin', 'Alexia', 'Alexia', '2501', '1959-04-30', 'F', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');
(NULL, '383783', 'adherent', 'Bonnet', 'Guillaume', 'Guillaume', '2501', '1959-04-30', 'H', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');
(NULL, '37837838', 'adherent', 'Mestres', 'Annabelle', 'Annabelle', '2501', '1959-04-30', 'F', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');
(NULL, '78383', 'adherent', 'Guisset', 'Anthony', 'Anthony', '2501', '1959-04-30', 'H', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');
(NULL, '933433', 'adherent', 'Fourcade', 'Laurie', 'Laurie', '2501', '1959-04-30', 'F', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');
(NULL, '38343943', 'adherent', 'Maury', 'Étienne', 'Étienne', '2501', '1959-04-30', 'H', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');
(NULL, '3434389', 'adherent', 'Roque', 'Marianne', 'Marianne', '2501', '1959-04-30', 'F', 'paupiette@mail.com', 'rue truc', '06', '0559000000', NULL, NULL, NULL, '1', '1', '1');

INSERT INTO `agenda`.`collectives` (`IDcollective`, `collTitre`, `collDateDebut`, `collDateFin`, `collDenivele`, `collDureeCourseEstim`, `collObservations`, `collPublie`, `collNbparticipantMax`, `collNblongueurs`, `collHeureDepartTerrain`, `collHeureRetourTerrain`, `collDureeCourse`, `collConditionMeteo`, `collInfoComplementaire`, `coll_incident_accident`, `collTypeRocher`, `collDureeApproche`, `collCondition_neige_rocher_glace`, `collEtatNeige`, `collConditionTerrain`, `collCR_Horodateur`, `IDtypeActivite`, `IDobjectif`, `IDadherent`) 
VALUES 
(NULL, 'Ma super excursion', '2015-11-11', NULL, '1200', '8', 'super ballade jusqu''au Lurien', '1', '8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', '1');
(NULL, 'arête passet', '2015-11-11', NULL, '600', '7', 'course très exigente', '1', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '7', '10');
(NULL, 'La table des trois rois', '2015-11-02', NULL, '1300', '6', 'excursion jusqu''a la frontiere espagnole ', '1', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '1');

INSERT INTO `agenda`.`encadrant` (`IDadherent`, `IDtypeActivite`) 
VALUES 
('1', '1'),
('10', '2');

INSERT INTO `agenda`.`rdv` (`heureRDV`, `IDlieu`, `IDcollective`) 
VALUES 
('06:45:00', '1', '3'),
('07:00:00', '2', '2'),
('07:30:00', '1', '1');

INSERT INTO `agenda`.`etats` (`IDetats`, `libelleEtat`) 
VALUES 
(NULL, 'en attente'), (NULL, 'validé');

INSERT INTO `agenda`.`participants` (`IDetats`, `IDadherent`, `IDcollective`) 
VALUES 
('2', '2', '1'),
('2', '3', '1'),
('2', '4', '1'),
('2', '5', '1'),
('2', '1', '2'),
('2', '3', '2'),
('2', '5', '2'),
('2', '6', '3'),
('2', '7', '3'),
('2', '8', '3');

INSERT INTO `agenda`.`co_encadrant` (`IDadherent`, `IDcollective`) 
VALUES 
('3', '1');

INSERT INTO `agenda`.`commentaire` (`ComCompteur`, `contenu`, `comHorodateur`, `IDadherent`, `IDcollective`) 
VALUES 
('1', 'ça l''air sympa cette sortie', CURRENT_TIME(), '1', '1'),
('2', 'il faut absolument que je sois là !', CURRENT_TIMESTAMP, '1', '1');

INSERT INTO `agenda`.`encadrantpro_liste` (`IDencadrantPro`, `IDcollective`) 
VALUES 
('1', '1');

INSERT INTO `agenda`.`liste_de_materiel_type` (`IDtypeMat`, `IDtypeActivite`) 
VALUES 
('1', '1');

INSERT INTO `agenda`.`liste_de_materiel_collective` (`IDtypeMat`, `IDcollective`) 
VALUES 
('1', '1');

INSERT INTO `agenda`.`liste_de_cotation` (`IDtypeActivite`, `IDcotation`) 
VALUES 
('1', '5'),
('1', '6'),
('1', '7'),
('1', '8'),
('1', '9'),
('1', '10');

INSERT INTO `agenda`.`collcotations` (`IDcollective`, `IDcotation`) 
VALUES 
('1', '5'),
('1', '8'),
('2', '3'),
('3', '6'),
('3', '9');


INSERT INTO `agenda`.`emprunt_location` (`IDadherent`, `IDtypeMat`, `IDcollective`) 
VALUES 
('1', '1', '1');

