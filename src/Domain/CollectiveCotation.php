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
 * @author inpiron
 */
class CollectiveCotation extends Popo {
    
    private $IDcollective;
    private $cotation;
    
    public function getIDcollective() {
        return $this->IDcollective;
    }

    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }
    
    public function getCotation() {
        return $this->cotation;
    }
    
    public function setCotation(Cotation $cotation) {
        $this->cotation = $cotation;
    }


    
    
            
}
