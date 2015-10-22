<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Secteur
 *
 * @author inpiron
 */
class Secteur extends Popo {
    
    private $IDsecteur;
    private $secteurLibelle;
    private $IDcommune;
    
    public function getIDsecteur() {
        return $this->IDsecteur;
    }

    public function getSecteurLibelle() {
        return $this->secteurLibelle;
    }

    public function getIDcommune() {
        return $this->IDcommune;
    }

    public function setIDsecteur($IDsecteur) {
        $this->IDsecteur = $IDsecteur;
    }

    public function setSecteurLibelle($secteurLibelle) {
        $this->secteurLibelle = $secteurLibelle;
    }

    public function setIDcommune($IDcommune) {
        $this->IDcommune = $IDcommune;
    }


}
