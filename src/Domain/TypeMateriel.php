<?php

namespace Agenda\Domain;
/**
 * Description of TypeMateriel
 *
 * @author Gilou
 */
class TypeMateriel extends Popo {
    /**
     * Id en base d'un type de materiel alpin
     * @var int 
     */
    private $IDtypeMat;
    /**
     * Libelle en base d'un type de materiel alpin
     * @var String
     */
    private $typeMatLibelle;
    /**
     * recupere l'id d'un type de materiel alpin
     * @return String
     */
    public function getIDtypeMat() {
        return $this->IDtypeMat;
    }
    /**
     * recupere le libellé d'une type de materiel alpin
     * @return String
     */
    public function getTypeMatLibelle() {
        return $this->typeMatLibelle;
    }
    /**
     * parametrer l'id d'un type de materiel
     * @param type $IDtypeMat
     */
    public function setIDtypeMat($IDtypeMat) {
        $this->IDtypeMat = $IDtypeMat;
    }
    /**
     * parametrer le libelle d'un type de materiel
     * @param type $typeMatLibelle
     */
    public function setTypeMatLibelle($typeMatLibelle) {
        $this->typeMatLibelle = $typeMatLibelle;
    }
}
