<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Domain;

/**
 * Description of Encadrant
 *
 * @author Gilou
 */
class Encadrant extends Popo {
    
    private $adherent;
    private $typeActivite;
    
    public function getAdherent() {
        return $this->adherent;
    }

    public function getTypeActivite() {
        return $this->typeActivite;
    }

    public function setAdherent(Adherent $adherent) {
        $this->adherent = $adherent;
    }

    public function setTypeActivite(TypeActivite $typeActivite) {
        $this->typeActivite = $typeActivite;
    }


}
