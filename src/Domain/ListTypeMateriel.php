<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Domain;

/**
 * Description of ListTypeMateriel
 *
 * @author inpiron
 */
class ListTypeMateriel extends Popo{
    
    private $typeActivite;
    private $typemateriel;
    
    public function getTypeActivite() {
        return $this->typeActivite;
    }

    public function getTypemateriel() {
        return $this->typemateriel;
    }

    public function setTypeActivite(TypeActivite $typeActivite) {
        $this->typeActivite = $typeActivite;
    }

    public function setTypemateriel(TypeMateriel  $typemateriel) {
        $this->typemateriel = $typemateriel;
    }
}
