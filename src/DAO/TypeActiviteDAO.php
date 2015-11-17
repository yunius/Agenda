<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\TypeActivite;
/**
 * Description of TypeActiviteDAO
 *
 * @author Gilou
 */
class TypeActiviteDAO extends DAO {
    
    public function find($IDtypeActivite) {
        $sql = "SELECT * FROM type_activite WHERE IDtypeActivite=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDtypeActivite));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de type d'activité n°" . $IDtypeActivite);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM type_activite ORDER BY IDtypeActivite";
        $result = $this->getDB()->fetchAll($sql);
        
        $activites = array();
        foreach ($result as $row) {
            $IDtypeActivite = $row['IDtypeActivite'];
            $activites[$IDtypeActivite] = $this->buildDomainObject($row);            
        }
        return $activites;
        
    }

    protected function buildDomainObject($row) {
        $typeActivite = new TypeActivite();
    $typeActivite->setIDtypeActivite($row['IDtypeActivite']);
        $typeActivite->setActiviteLibelle($row['activiteLibelle']);
        $typeActivite->setIDactiviteParente($row['IDactiviteParente']);
        
        return $typeActivite;
    }

}
