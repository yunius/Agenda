<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Cotation
 *
 * @author Gilou
 */
class Cotation extends Popo {
    
    private $IDcotation;
    private $LibelleCotation;
    private $ValeurCotation;
    
    public function getIDcotation() {
        return $this->IDcotation;
    }

    public function getLibelleCotation() {
        return $this->LibelleCotation;
    }

    public function getValeurCotation() {
        return $this->ValeurCotation;
    }

    public function setIDcotation($IDcotation) {
        $this->IDcotation = $IDcotation;
    }

    public function setLibelleCotation($LibelleCotation) {
        $this->LibelleCotation = $LibelleCotation;
    }

    public function setValeurCotation($ValeurCotation) {
        $this->ValeurCotation = $ValeurCotation;
    }


}
