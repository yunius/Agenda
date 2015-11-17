<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of MaterielCollective
 *
 * @author Gilou
 */
class MaterielCollective extends Popo{
    
    private $IDcollective;
    private $TypeMateriel;
    
    public function getIDcollective() {
        return $this->IDcollective;
    }

    public function getTypeMateriel() {
        return $this->TypeMateriel;
    }

    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }

    public function setTypeMateriel(TypeMateriel $TypeMateriel) {
        $this->TypeMateriel = $TypeMateriel;
    }


}
