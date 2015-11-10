DROP DATABASE if exists Agenda;

CREATE DATABASE if not exists Agenda CHARACTER SET utf8 COLLATE utf8_general_ci;

USE Agenda;

CREATE TABLE type_de_materiel(
        IDtypeMat      Int NOT NULL auto_increment ,
        typeMatLibelle Varchar (45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        PRIMARY KEY (IDtypeMat )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE type_activite(
        IDtypeActivite   Int NOT NULL auto_increment,
        activiteLibelle  Varchar (25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        IDactiviteParente Int,
        PRIMARY KEY (IDtypeActivite )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE cotation(
        IDcotation      Int NOT NULL auto_increment,
        LibelleCotation Varchar (10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        ValeurCotation  Varchar (10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        PRIMARY KEY (IDcotation )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE adherents(
        IDadherent         Int NOT NULL auto_increment,
        numLicence         Int (14) NOT NULL,
        statut             Varchar (25) CHARACTER SET utf8 COLLATE utf8_general_ci ,
        nomAdherent        Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        prenomAdherent     Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        pseudoAdherent     Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci ,
        motDePasseAdherent Varchar (88) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        adherent_salt      Varchar(23) NOT NULL,
        DateNaissAdherent  Date NOT NULL ,
        genreAdherent      Char (6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        MailAdherent       Varchar (60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        adherentLibelleRue Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        adherentNumRue     Int NOT NULL ,
        adherentNumTel     Int NOT NULL ,
        Vehicule           Bool ,
        co_voitureur       Bool ,
        CompteActif        Bool ,
        IDcommune          Int NOT NULL ,
        IDclub             Int NOT NULL ,
        roleAdherent       Varchar(50) NOT NULL DEFAULT 'ROLE_USER',
        PRIMARY KEY (IDadherent )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE commune(
        IDcommune  Int NOT NULL auto_increment ,
        nomCommune Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        codePostal Char (5) NOT NULL ,
        IDpays     Int NOT NULL ,
        PRIMARY KEY (IDcommune )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE pays(
        IDpays  Int NOT NULL auto_increment,
        nomPays Char (25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        PRIMARY KEY (IDpays )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE club(
        IDclub      Int NOT NULL auto_increment,
        nomClub     Char (25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        clubSecteur Varchar (25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        clubNumTel  Int NOT NULL ,
        IDcommune   Int NOT NULL ,
        PRIMARY KEY (IDclub )
)ENGINE=InnoDB;



CREATE TABLE encadrant_professionnel(
        IDencadrantPro   Int NOT NULL auto_increment,
        encProNom        Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        encProPrenom     Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        encProDateNaiss  Date NOT NULL ,
        encProGenre      Char (5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        encProMail       Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        encProLibelleRue Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci ,
        encProNumRue     Int ,
        encProNumTel     Int NOT NULL ,
        IDcommune        Int ,
        PRIMARY KEY (IDencadrantPro )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE secteur(
        IDsecteur      Int NOT NULL auto_increment,
        secteurLibelle Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        IDcommune      Int NOT NULL ,
        PRIMARY KEY (IDsecteur )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE objectif(
        IDobjectif      Int NOT NULL auto_increment,
        objectifLibelle Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        IDsecteur       Int NOT NULL ,
        PRIMARY KEY (IDobjectif )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE lieu(
        IDlieu      Int NOT NULL auto_increment,
        lieuLibelle Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        PRIMARY KEY (IDlieu )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE collectives(
        IDcollective                     Int NOT NULL auto_increment,
        collTitre                        Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
        collDateDebut                    Date NOT NULL ,
        collDateFin                      Date ,
        collDenivele                     Int ,
        collDureeCourseEstim             Float ,
        collObservations                 Text CHARACTER SET utf8 COLLATE utf8_general_ci  ,
        collPublie                       Bool ,
        collNbParticipantMax             Int ,
        collNbLongueurs                  Int ,
        collHeureDepartTerrain           Time ,
        collHeureRetourTerrain           Time ,
        collDureeCourse                  Float ,
        collConditionMeteo               Varchar (100) CHARACTER SET utf8 COLLATE utf8_general_ci  ,
        collInfoComplementaire           Text CHARACTER SET utf8 COLLATE utf8_general_ci ,
        coll_incident_accident           Text CHARACTER SET utf8 COLLATE utf8_general_ci ,
        collTypeRocher                   Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci ,
        collDureeApproche                Float ,
        collCondition_neige_rocher_glace Text CHARACTER SET utf8 COLLATE utf8_general_ci ,
        collEtatNeige                    Varchar (50) CHARACTER SET utf8 COLLATE utf8_general_ci ,
        collConditionTerrain             Text CHARACTER SET utf8 COLLATE utf8_general_ci ,
        collCR_Horodateur                TimeStamp ,
        IDtypeActivite                   Int NOT NULL ,
        IDobjectif                       Int NOT NULL ,
        IDadherent                       Int NOT NULL ,
        PRIMARY KEY (IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE encadrant(
        IDadherent     Int NOT NULL ,
        IDtypeActivite Int NOT NULL ,
        PRIMARY KEY (IDadherent )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




-- CREATE TABLE Role(
--         IDrole          Int NOT NULL auto_increment ,
--         RoleLibelle     Varchar (15) CHARACTER SET utf8 COLLATE utf8_general_ci ,
--         RoleDescription Text CHARACTER SET utf8 COLLATE utf8_general_ci ,
--         PRIMARY KEY (IDrole )
-- )ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE liste_de_materiel_type(
        IDtypeMat      Int NOT NULL ,
        IDtypeActivite Int NOT NULL ,
        PRIMARY KEY (IDtypeMat ,IDtypeActivite )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE liste_de_cotation(
        IDtypeActivite Int NOT NULL ,
        IDcotation     Int NOT NULL ,
        PRIMARY KEY (IDtypeActivite ,IDcotation )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE rdv(
        heureRDV     Time NOT NULL ,
        IDlieu       Int NOT NULL ,
        IDcollective Int NOT NULL ,
        PRIMARY KEY (IDlieu ,IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE etats(
        IDetats     Int NOT NULL auto_increment,
        libelleEtat Varchar (25) NOT NULL ,
        PRIMARY KEY (IDetats )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE participants(
        IDetats      Int NOT NULL DEFAULT 1 ,
        IDadherent   Int NOT NULL ,
        IDcollective Int NOT NULL ,
        IDlieu       Int NOT NULL ,
        heureRDV     Int NOT NULL ,
        PRIMARY KEY (IDadherent ,IDcollective)
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE TABLE encadrantpro_liste(
        IDencadrantPro Int NOT NULL ,
        IDcollective   Int NOT NULL ,
        PRIMARY KEY (IDencadrantPro ,IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE co_encadrant(
        IDadherent   Int NOT NULL ,
        IDcollective Int NOT NULL ,
        PRIMARY KEY (IDadherent ,IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;




CREATE TABLE commentaire(
        ComCompteur   int NOT NULL,
        contenu       Text CHARACTER SET utf8 COLLATE utf8_general_ci ,
        comHorodateur TIMESTAMP NOT NULL,
        IDadherent    Int NOT NULL ,
        IDcollective  Int NOT NULL ,
        PRIMARY KEY (ComCompteur, IDadherent ,IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE TABLE emprunt_location(
        IDadherent   Int NOT NULL ,
        IDtypeMat    Int NOT NULL ,
        IDcollective Int NOT NULL ,
        PRIMARY KEY (IDadherent ,IDtypeMat ,IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE liste_de_materiel_collective(
        IDtypeMat    Int NOT NULL ,
        IDcollective Int NOT NULL ,
        PRIMARY KEY (IDtypeMat ,IDcollective )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE collcotations(
        IDcollective Int NOT NULL ,
        IDcotation   Int NOT NULL ,
        PRIMARY KEY (IDcollective ,IDcotation )
)ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE type_activite ADD CONSTRAINT FK_type_activite_IDactiviteParente FOREIGN KEY (IDactiviteParente) REFERENCES type_activite(IDtypeActivite);
ALTER TABLE adherents ADD CONSTRAINT FK_adherents_IDcommune FOREIGN KEY (IDcommune) REFERENCES commune(IDcommune);
ALTER TABLE adherents ADD CONSTRAINT FK_adherents_IDclub FOREIGN KEY (IDclub) REFERENCES club(IDclub);
ALTER TABLE commune ADD CONSTRAINT FK_commune_IDpays FOREIGN KEY (IDpays) REFERENCES pays(IDpays);
ALTER TABLE club ADD CONSTRAINT FK_club_IDcommune FOREIGN KEY (IDcommune) REFERENCES commune(IDcommune);
ALTER TABLE encadrant_professionnel ADD CONSTRAINT FK_encadrant_professionnel_IDcommune FOREIGN KEY (IDcommune) REFERENCES commune(IDcommune);
ALTER TABLE secteur ADD CONSTRAINT FK_secteur_IDcommune FOREIGN KEY (IDcommune) REFERENCES commune(IDcommune);
ALTER TABLE objectif ADD CONSTRAINT FK_objectif_IDsecteur FOREIGN KEY (IDsecteur) REFERENCES secteur(IDsecteur);
ALTER TABLE collectives ADD CONSTRAINT FK_collectives_IDtypeActivite FOREIGN KEY (IDtypeActivite) REFERENCES type_activite(IDtypeActivite);
ALTER TABLE collectives ADD CONSTRAINT FK_collectives_IDobjectif FOREIGN KEY (IDobjectif) REFERENCES objectif(IDobjectif);
ALTER TABLE collectives ADD CONSTRAINT FK_collectives_IDadherent FOREIGN KEY (IDadherent) REFERENCES adherents(IDadherent);
ALTER TABLE encadrant ADD CONSTRAINT FK_encadrant_IDadherent FOREIGN KEY (IDadherent) REFERENCES adherents(IDadherent);
ALTER TABLE encadrant ADD CONSTRAINT FK_encadrant_IDtypeActivite FOREIGN KEY (IDtypeActivite) REFERENCES type_activite(IDtypeActivite);
ALTER TABLE liste_de_materiel_type ADD CONSTRAINT FK_liste_de_materiel_type_IDtypeMat FOREIGN KEY (IDtypeMat) REFERENCES type_de_materiel(IDtypeMat);
ALTER TABLE liste_de_materiel_type ADD CONSTRAINT FK_liste_de_materiel_type_IDtypeActivite FOREIGN KEY (IDtypeActivite) REFERENCES type_activite(IDtypeActivite);
ALTER TABLE liste_de_cotation ADD CONSTRAINT FK_liste_de_cotation_IDtypeActivite FOREIGN KEY (IDtypeActivite) REFERENCES type_activite(IDtypeActivite);
ALTER TABLE liste_de_cotation ADD CONSTRAINT FK_liste_de_cotation_IDcotation FOREIGN KEY (IDcotation) REFERENCES cotation(IDcotation);
ALTER TABLE rdv ADD CONSTRAINT FK_rdv_IDlieu FOREIGN KEY (IDlieu) REFERENCES lieu(IDlieu);
ALTER TABLE rdv ADD CONSTRAINT FK_rdv_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE participants ADD CONSTRAINT FK_participants_IDadherent FOREIGN KEY (IDadherent) REFERENCES adherents(IDadherent);
ALTER TABLE participants ADD CONSTRAINT FK_participants_IDetats FOREIGN KEY (IDetats) REFERENCES etats(IDetats);
ALTER TABLE participants ADD CONSTRAINT FK_participants_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE encadrantpro_liste ADD CONSTRAINT FK_encadrantpro_liste_IDencadrantPro FOREIGN KEY (IDencadrantPro) REFERENCES encadrant_professionnel(IDencadrantPro);
ALTER TABLE encadrantpro_liste ADD CONSTRAINT FK_encadrantpro_liste_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE co_encadrant ADD CONSTRAINT FK_co_encadrant_IDadherent FOREIGN KEY (IDadherent) REFERENCES adherents(IDadherent);
ALTER TABLE co_encadrant ADD CONSTRAINT FK_co_encadrant_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE commentaire ADD CONSTRAINT FK_commentaire_IDadherent FOREIGN KEY (IDadherent) REFERENCES adherents(IDadherent);
ALTER TABLE commentaire ADD CONSTRAINT FK_commentaire_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE emprunt_location ADD CONSTRAINT FK_emprunt_location_IDadherent FOREIGN KEY (IDadherent) REFERENCES adherents(IDadherent);
ALTER TABLE emprunt_location ADD CONSTRAINT FK_emprunt_location_IDtypeMat FOREIGN KEY (IDtypeMat) REFERENCES type_de_materiel(IDtypeMat);
ALTER TABLE emprunt_location ADD CONSTRAINT FK_emprunt_location_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE liste_de_materiel_collective ADD CONSTRAINT FK_liste_de_materiel_collective_IDtypeMat FOREIGN KEY (IDtypeMat) REFERENCES type_de_materiel(IDtypeMat);
ALTER TABLE liste_de_materiel_collective ADD CONSTRAINT FK_liste_de_materiel_collective_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE collcotations ADD CONSTRAINT FK_collcotations_IDcollective FOREIGN KEY (IDcollective) REFERENCES collectives(IDcollective) ON DELETE CASCADE;
ALTER TABLE collcotations ADD CONSTRAINT FK_collcotations_IDcotation FOREIGN KEY (IDcotation) REFERENCES cotation(IDcotation);

