<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\DAO;

use Agenda\Domain\Encadrant;
/**
 * Description of EncadrantDAO
 *
 * @author Gilou
 */
class EncadrantDAO extends DAO {
    
    private $adherentDAO;
    private $typeActiviteDAO;
    
    public function setAdherent(AdherentDAO $adherentDAO) {
        $this->adherentDAO = $adherentDAO;
    }
    
    public function setTypeActivite(TypeActiviteDAO $typeActiviteDAO) {
        $this->typeActiviteDAO = $typeActiviteDAO;
    }
    
    public function find($IDadherent) {
        $sql = "SELECT * FROM encadrant WHERE IDadherent=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDadherent));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new \Exception("pas de d'adherent n°" . $IDadherent);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM encadrant ORDER BY IDadherent";
        $result = $this->getDB()->fetchAll($sql);
        
        $encadrants = array();
        foreach ($result as $row) {
            $IDadherent = $row['IDadherent'];
            $encadrants[$IDadherent] = $this->buildDomainObject($row);            
        }
        return $encadrants;
    }
    
    
    protected function buildDomainObject($row) {
        $encadrant = new Encadrant();
        if(array_key_exists('IDadherent', $row)) {
            $IDadherent = $row['IDadherent'];
            $adherent = $this->adherentDAO->find($IDadherent);
            $encadrant->setAdherent($adherent);
        }
        if(array_key_exists('IDtypeActivite', $row)) {
            $IDtypeActivite = $row['IDtypeActivite'];
            $typeActivite = $this->typeActiviteDAO->find($IDtypeActivite);
            $encadrant->setTypeActivite($typeActivite);
        }
        return $encadrant;
        
    }


}
