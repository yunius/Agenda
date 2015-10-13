<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Doctrine\DBAL\Connection; 
use Agenda\Domain\Collective;
/**
 * Description of CollectivesDAO
 *
 * @author inpiron
 */
class CollectivesDAO {
    
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    
    
    public function findAll() {
        $sql = "SELECT * FROM collectives order by collDateDebut";
        $result = $this->db->fetchAll($sql);
        
        $collectives = array();
        foreach ($result as $row) {
            $IDcollective = $row['IDcollective'];
            $collectives[$IDcollective] = $this->buildCollective($row);
        }
        return $collectives;
        
    }
    
    public function buildCollective(array $row) {
        $collective = new Collective();
        $collective->setCollTitre($row['collTitre']);
        $collective->setCollObservations($row['collObservations']);
        $collective->setCollNbParticipantMax($row['collNbParticipantMax']);
        return $collective;
    }
}
