<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\DAO;

use Agenda\Domain\ListTypeMateriel;
/**
 * Description of ListTypeMaterielDAO
 *
 * @author inpiron
 */
class ListTypeMaterielDAO extends DAO {
    
    private $typeMaterielDAO;
    private $typeActiviteDAO;
    
    public function setTypeMaterielDAO(TypeMaterielDAO $typeMaterielDAO) {
        $this->typeMaterielDAO = $typeMaterielDAO;
    }
    
    public function setTypeActiviteDAO(TypeActiviteDAO $typeActiviteDAO) {
        $this->typeActiviteDAO = $typeActiviteDAO;
    }
    
    public function findAll($IDtypeActivite) {
        $sql = "SELECT * FROM liste_de_materiel_type WHERE IDtypeActivite=?";
        $result = $this->getDB()->fetchAll($sql, array($IDtypeActivite));
        
        $listTypeMateriel = array();
        
        foreach ($result as $row) {
        $IDtypeMat = $row['IDtypeMat'];
            $listTypeMateriel[$IDtypeMat] = $this->buildDomainObject($row);            
        }
        return $listTypeMateriel;
    }
    
    protected function buildDomainObject($row) {
        $ListTypeMateriel = new ListTypeMateriel();
        if(array_key_exists('IDtypeMat', $row)){
            $IDtypeMat = $row['IDtypeMat'];
            $typemateriel = $this->typeMaterielDAO->find($IDtypeMat);
            $ListTypeMateriel->setTypemateriel($typemateriel);
        }
        if(array_key_exists('IDtypeActivite', $row)){
            $IDtypeActivite = $row['IDtypeActivite'];
            $typeActivite = $this->typeActiviteDAO->find($IDtypeActivite);
            $ListTypeMateriel->setTypeActivite($typeActivite);
        }
        return $ListTypeMateriel;
    }

}
