<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;



/**
 * Description of Collective
 *
 * @author inpiron
 */
class Collective extends Popo {
    
    private $IDcollective;
    private $collTitre;
    private $collDateDebut;
    private $collDatefin;
    private $collDenivele;
    private $collDureeCourseEstim;
    private $collObservations;
    private $collPublie;
    private $collNbParticipantMax;
    private $collNbLongueurs;
    private $collHeureDepartTerrain;
    private $collHeureRetourTerrain;
    private $collDureeCourse;
    private $collConditionMeteo;
    private $collInfoComplementaire;
    private $collTypeRocher;
    private $collDureeApproche;
    private $collCondition_neige_rocher_glace;
    private $collEtatNeige;
    private $collConditionTerrain;
    private $collCR_Horodateur;
    private $IDtypeActivite;
    private $IDobjectif;
    private $IDadherent;
    
    
    
    public function getIDcollective() {
        return $this->IDcollective;
    }
    
    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }

    public function getCollTitre() {
        return $this->collTitre;
    }
    
    public function setCollTitre($collTitre) {
        $this->collTitre = $collTitre;
    }

    public function getCollDateDebut() {
        $date = $this->date2FullFr($this->collDateDebut);
        return $date ;
    }
    
    public function setCollDateDebut($collDateDebut) {
        $this->collDateDebut = $collDateDebut;
    }


    public function getCollDatefin() {
        return $this->collDatefin;
    }
    
    public function setCollDatefin($collDatefin) {
        $this->collDatefin = $collDatefin;
    }

    public function getCollDenivele() {
        return $this->collDenivele;
    }
    
    public function setCollDenivele($collDenivele) {
        $this->collDenivele = $collDenivele;
    }

    public function getCollDureeCourseEstim() {
        return $this->collDureeCourseEstim;
    }
    
    public function setCollDureeCourseEstim($collDureeCourseEstim) {
        $this->collDureeCourseEstim = $collDureeCourseEstim;
    }

    public function getCollObservations() {
        return $this->collObservations;
    }
    
    public function setCollObservations($collObservations) {
        $this->collObservations = $collObservations;
    }

    public function getCollPublie() {
        return $this->collPublie;
    }
    
    public function setCollPublie($collPublie) {
        $this->collPublie = $collPublie;
    }

    public function getCollNbParticipantMax() {
        return $this->collNbParticipantMax;
    }
    
    public function setCollNbParticipantMax($collNbParticipantMax) {
        $this->collNbParticipantMax = $collNbParticipantMax;
    }

    public function getCollNbLongueurs() {
        return $this->collNbLongueurs;
    }
    
    public function setCollNbLongueurs($collNbLongueurs) {
        $this->collNbLongueurs = $collNbLongueurs;
    }

    public function getCollHeureDepartTerrain() {
        return $this->collHeureDepartTerrain;
    }
    
    public function setCollHeureDepartTerrain($collHeureDepartTerrain) {
        $this->collHeureDepartTerrain = $collHeureDepartTerrain;
    }

    public function getCollHeureRetourTerrain() {
        return $this->collHeureRetourTerrain;
    }
    
    public function setCollHeureRetourTerrain($collHeureRetourTerrain) {
        $this->collHeureRetourTerrain = $collHeureRetourTerrain;
    }

    public function getCollDureeCourse() {
        return $this->collDureeCourse;
    }
    
    public function setCollDureeCourse($collDureeCourse) {
        $this->collDureeCourse = $collDureeCourse;
    }

    public function getCollConditionMeteo() {
        return $this->collConditionMeteo;
    }
    
    public function setCollConditionMeteo($collConditionMeteo) {
        $this->collConditionMeteo = $collConditionMeteo;
    }

    public function getCollInfoComplementaire() {
        return $this->collInfoComplementaire;
    }
    
    public function setCollInfoComplementaire($collInfoComplementaire) {
        $this->collInfoComplementaire = $collInfoComplementaire;
    }

    public function getCollTypeRocher() {
        return $this->collTypeRocher;
    }
    
    public function setCollTypeRocher($collTypeRocher) {
        $this->collTypeRocher = $collTypeRocher;
    }

    public function getCollDureeApproche() {
        return $this->collDureeApproche;
    }
    
    public function setCollDureeApproche($collDureeApproche) {
        $this->collDureeApproche = $collDureeApproche;
    }

    public function getCollCondition_neige_rocher_glace() {
        return $this->collCondition_neige_rocher_glace;
    }
    
    public function setCollCondition_neige_rocher_glace($collCondition_neige_rocher_glace) {
        $this->collCondition_neige_rocher_glace = $collCondition_neige_rocher_glace;
    }

    public function getCollEtatNeige() {
        return $this->collEtatNeige;
    }
    
    public function setCollEtatNeige($collEtatNeige) {
        $this->collEtatNeige = $collEtatNeige;
    }

    public function getCollConditionTerrain() {
        return $this->collConditionTerrain;
    }
    
    public function setCollConditionTerrain($collConditionTerrain) {
        $this->collConditionTerrain = $collConditionTerrain;
    }

    public function getCollCR_Horodateur() {
        return $this->collCR_Horodateur;
    }
    
    public function setCollCR_Horodateur($collCR_Horodateur) {
        $this->collCR_Horodateur = $collCR_Horodateur;
    }

    public function getIDtypeActivite() {
        return $this->IDtypeActivite;
    }
    
    public function setIDtypeActivite($IDtypeActivite) {
        $this->IDtypeActivite = $IDtypeActivite;
    }

    public function getIDobjectif() {
        return $this->IDobjectif;
    }
    
    public function setIDobjectif($IDobjectif) {
        $this->IDobjectif = $IDobjectif;
    }

    public function getIDadherent() {
        return $this->IDadherent;
    }
    
    public function setIDadherent($IDadherent) {
        $this->IDadherent = $IDadherent;
    } 
}

    

    

    
    

    


    

    

    

    

    

    
