<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Participant
 *
 * @author Gilou
 */
class Participant extends Popo {
    
    private $IDetats;
    private $adherent;
    private $IDcollective;
    private $lieuLibelle;
    private $heureRDV;
    
    public function getIDetats() {
        return $this->IDetats;
    }

    public function getAdherent() {
        return $this->adherent;
    }

    public function getIDcollective() {
        return $this->IDcollective;
    }

    public function setIDetats($IDetats) {
        $this->IDetats = $IDetats;
    }

    public function setAdherent(Adherent $adherent) {
        $this->adherent = $adherent;
    }

    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }
    
    public function getLieuLibelle() {
        return $this->lieuLibelle;
    }

    public function getHeureRDV() {
        return $this->heureRDV;
    }

    public function setLieuLibelle($lieuLibelle) {
        $this->lieuLibelle = $lieuLibelle;
    }

    public function setHeureRDV($heureRDV) {
        $this->heureRDV = $heureRDV;
    }




}
