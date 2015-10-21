<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\TypeMateriel;
/**
 * Description of TypeMaterielDAO
 *
 * @author inpiron
 */
class TypeMaterielDAO extends DAO {
    
    
    public function find($IDtypeMat) {
        $sql = "SELECT * FROM Type_de_materiel WHERE IDtypeMat=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDtypeMat));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de type de materiel n°" . $IDtypeMat);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM Type_de_materiel ORDER BY IDtypeMat";
        $result = $this->getDB()->fetchAll($sql);
        
        $typeMateriels = array();
        foreach ($result as $row) {
            $IDtypeMat = $row['IDtypeMat'];
            $typeMateriels[$IDtypeMat] = $this->buildDomainObject($row);            
        }
        return $typeMateriels;
        
    }

    protected function buildDomainObject($row) {
        $typeMateriel = new TypeMateriel();
        $typeMateriel->setIDtypeMat($row['IDtypeMat']);
        $typeMateriel->setTypeMatLibelle($row['typeMatLibelle']);
        
        
        return $typeMateriel;
    }
    
}
