<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Lieu
 *
 * @author Gilou
 */
class Lieu extends Popo {
    
    private $IDlieu;
    private $lieuLibelle;
    
    public function getIDlieu() {
        return $this->IDlieu;
    }

    public function getLieuLibelle() {
        return $this->lieuLibelle;
    }

    public function setIDlieu($IDlieu) {
        $this->IDlieu = $IDlieu;
    }

    public function setLieuLibelle($lieuLibelle) {
        $this->lieuLibelle = $lieuLibelle;
    }


}
