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
 * @author Gilou
 */
class Objectif extends Popo{
    
    private $IDobjectif;
    private $secteur;
    private $objectifLibelle;
    
    public function getIDobjectif() {
        return $this->IDobjectif;
    }

    public function getSecteur() {
        return $this->secteur;
    }

    public function getObjectifLibelle() {
        return $this->objectifLibelle;
    }

    public function setIDobjectif($IDobjectif) {
        $this->IDobjectif = $IDobjectif;
    }

    public function setSecteur(Secteur $secteur) {
        $this->secteur = $secteur;
    }

    public function setObjectifLibelle($objectifLibelle) {
        $this->objectifLibelle = $objectifLibelle;
    }


}
