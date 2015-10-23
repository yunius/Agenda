<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Commentaire
 *
 * @author inpiron
 */
class Commentaire {
    
    private $comCompteur;
    private $contenu;
    private $comHorodateur;
    private $adherent;
    private $IDcollective;
    
    public function getComCompteur() {
        return $this->comCompteur;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getComHorodateur() {
        return $this->comHorodateur;
    }

    public function getAdherent() {
        return $this->adherent;
    }

    public function getIDcollective() {
        return $this->IDcollective;
    }

    public function setComCompteur($comCompteur) {
        $this->comCompteur = $comCompteur;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function setComHorodateur($comHorodateur) {
        $this->comHorodateur = $comHorodateur;
    }
    /**
     * 
     * @param \Agenda\Domain\Adherent $adherent
     */
    public function setAdherent(Adherent $adherent) {
        $this->adherent = $adherent;
    }

    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }


}
