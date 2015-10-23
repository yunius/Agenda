<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of TypeMateriel
 *
 * @author inpiron
 */
class TypeMateriel extends Popo {
    
    private $IDtypeMat;
    private $typeMatLibelle;
    
    public function getIDtypeMat() {
        return $this->IDtypeMat;
    }

    public function getTypeMatLibelle() {
        return $this->typeMatLibelle;
    }

    public function setIDtypeMat($IDtypeMat) {
        $this->IDtypeMat = $IDtypeMat;
    }

    public function setTypeMatLibelle($typeMatLibelle) {
        $this->typeMatLibelle = $typeMatLibelle;
    }


}
