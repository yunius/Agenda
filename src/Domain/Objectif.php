<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Objectif
 *
 * @author inpiron
 */
class Objectif extends Popo{
    
    private $IDobjectif;
    private $IDsecteur;
    private $objectifLibelle;
    
    public function getIDobjectif() {
        return $this->IDobjectif;
    }

    public function getIDsecteur() {
        return $this->IDsecteur;
    }

    public function getObjectifLibelle() {
        return $this->objectifLibelle;
    }

    public function setIDobjectif($IDobjectif) {
        $this->IDobjectif = $IDobjectif;
    }

    public function setIDsecteur($IDsecteur) {
        $this->IDsecteur = $IDsecteur;
    }

    public function setObjectifLibelle($objectifLibelle) {
        $this->objectifLibelle = $objectifLibelle;
    }


}
