<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of CotationList
 *
 * @author inpiron
 */
class CotationList {
    
    private $cotation;
    private $IDtypeActivite;
    
    public function getCotation() {
        return $this->cotation;
    }

    public function getIDtypeActivite() {
        return $this->IDtypeActivite;
    }

    public function setCotation(Cotation $cotation) {
        $this->cotation = $cotation;
    }

    public function setIDtypeActivite($IDtypeActivite) {
        $this->IDtypeActivite = $IDtypeActivite;
    }


}
