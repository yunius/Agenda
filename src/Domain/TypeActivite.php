<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of TypeActivite
 *
 * @author Gilou
 */
class TypeActivite extends Popo {
    
    private $IDtypeActivite;
    private $activiteLibelle;
    private $IDactiviteParente;
    
    
    public function getIDtypeActivite() {
        return $this->IDtypeActivite;
    }

    public function getActiviteLibelle() {
        return $this->activiteLibelle;
    }

    public function getIDactiviteParente() {
        return $this->IDactiviteParente;
    }

    public function setIDtypeActivite($IDtypeActivite) {
        $this->IDtypeActivite = $IDtypeActivite;
    }

    public function setActiviteLibelle($activiteLibelle) {
        $this->activiteLibelle = $activiteLibelle;
    }

    public function setIDactiviteParente($IDactiviteParente) {
        $this->IDactiviteParente = $IDactiviteParente;
    }


}
