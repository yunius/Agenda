<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;


use Agenda\Domain\Collective;
/**
 * Description of CollectivesDAO
 *
 * @author inpiron
 */
class CollectiveDAO extends DAO {
    
    public function findAll() {
        $sql = "SELECT * FROM collectives ORDER BY collDateDebut";
        $result = $this->getDB()->fetchAll($sql);
        
        $collectives = array();
        foreach ($result as $row) {
            $IDcollective = $row['IDcollective'];
            $collectives[$IDcollective] = $this->buildDomainObject($row);
        }
        return $collectives;
        
    }
    
    protected function buildDomainObject($row) {
        $collective = new Collective();
        $collective->setCollTitre($row['collTitre']);
        $collective->setCollObservations($row['collObservations']);
        $collective->setCollNbParticipantMax($row['collNbParticipantMax']);
        return $collective;
    }
}
