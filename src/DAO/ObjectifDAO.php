<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Objectif;
/**
 * Description of ObjectifDAO
 *
 * @author Gilou
 */
class ObjectifDAO extends DAO {
    
    private $secteurDAO;
    
    public function setSecteurDAO(SecteurDAO $secteurDAO) {
        $this->secteurDAO = $secteurDAO;
    }
    
    public function find($IDobjectif) {
        $sql = "SELECT * FROM objectif WHERE IDobjectif=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDobjectif));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de d'objectif n°" . $IDobjectif);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM objectif ORDER BY IDobjectif";
        $result = $this->getDB()->fetchAll($sql);
        
        $objectifs = array();
        foreach ($result as $row) {
            $IDobjectif = $row['IDobjectif'];
            $objectifs[$IDobjectif] = $this->buildDomainObject($row);            
        }
        return $objectifs;
        
    }

    protected function buildDomainObject($row) {
        $objectif = new Objectif();
        $objectif->setIDobjectif($row['IDobjectif']);
        $objectif->setObjectifLibelle($row['objectifLibelle']);
        if(array_key_exists('IDsecteur', $row)) {
            $IDsecteur = $row['IDsecteur'];
            $secteur = $this->secteurDAO->find($IDsecteur);
            $objectif->setSecteur($secteur);
        }
        return $objectif;
    }


}
