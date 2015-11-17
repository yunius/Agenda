<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Rdv
 *
 * @author Gilou
 */
class Rdv extends Popo {
    
    private $heureRDV;
    private $lieu;
    private $IDcollective;
    
    public function getHeureRDV() {
        return $this->heureRDV;
    }

    public function getLieu() {
        return $this->lieu;
    }

    public function getIDcollective() {
        return $this->IDcollective;
    }

    public function setHeureRDV($heureRDV) {
        $this->heureRDV = $heureRDV;
    }

    public function setLieu(Lieu $lieu) {
        $this->lieu = $lieu;
    }

    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }


}
