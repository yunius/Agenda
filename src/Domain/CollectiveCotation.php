<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of CollectiveCotation
 *
 * @author Gilou
 */
class CollectiveCotation {
    /**
     *
     * @var int 
     */
    private $IDcollective;
    /**
     *
     * @var Object de type Cotation
     */
    private $cotation;
    /**
     * Recuper l'id d'un object de type CollectiveCotation
     * @return int
     */
    public function getIDcollective() {
        return $this->IDcollective;
    }
    /**
     * Parametre l'id d'un objet de type CollectiveCotation
     * @param type $IDcollective
     */
    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }
    
    /**
     * Recupere un objet de type Cotation
     * @return Object Cotation
     */
    public function getCotation() {
        return $this->cotation;
    }
    /**
     * Parametre un objet de type Cotation
     * @param \Agenda\Domain\Cotation $cotation
     */
    public function setCotation(Cotation $cotation) {
        $this->cotation = $cotation;
    }      
}
