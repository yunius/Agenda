<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Participant;
use Agenda\Domain\Collective;
/**
 * Description of ParticipantDAO
 *
 * @author inpiron
 */
class ParticipantDAO extends DAO{
    
    private $adherentDAO;
    
    public function setAdherentDAO(AdherentDAO $adherentDAO) {
        $this->adherentDAO = $adherentDAO;
    }
    
    public function save(Participant $participant) {
        $participantData = array(
            'IDcollective' => $participant->getIDcollective(),
            'IDadherent' => $participant->getAdherent()->getIDadherent(),
        );
        if(!$participant->getAdherent()) {
            $this->getDB()->insert('participant', $participantData);
        }
    }
    
    public function find($IDadherent) {
        $sql = "SELECT * FROM participants WHERE IDadherent=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDadherent));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("ce participant n'existe pas");
        }
    }
    
    
    public function findAll(Collective $collective) {
        $IDcollective = $collective->getIDcollective();
        $sql = "SELECT * FROM participants WHERE IDcollective=? ORDER BY IDadherent";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        $participants = array();
        foreach ($result as $row) {
            $IDadherent = $row['IDadherent'];
            $participants[$IDadherent] = $this->buildDomainObject($row);            
        }
        return $participants;
    }
    
    public function findAllValide(Collective $collective) {
        $IDcollective = $collective->getIDcollective();
        $sql = "SELECT * FROM participants WHERE IDcollective=? AND IDetats=2 ORDER BY IDadherent";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        $participants = array();
        foreach ($result as $row) {
            $IDadherent = $row['IDadherent'];
            $participants[$IDadherent] = $this->buildDomainObject($row);            
        }
        return $participants;
    }
    
    public function findAllAttente(Collective $collective) {
        $IDcollective = $collective->getIDcollective();
        $sql = "SELECT * FROM participants WHERE IDcollective=? AND IDetats=1 ORDER BY IDadherent";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        $participants = array();
        foreach ($result as $row) {
            $IDadherent = $row['IDadherent'];
            $participants[$IDadherent] = $this->buildDomainObject($row);            
        }
        return $participants;
    }
    
    public function countParticipant(Collective $collective) {
        $IDcollective = $collective->getIDcollective();
        $sql = "SELECT count(*) AS nbParticipant FROM participants WHERE IDcollective=?";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        
        foreach ($result as $row) {
               $nb = $row['nbParticipant'];      
        }
        return $nb;
    }


    protected function buildDomainObject($row) {
        $participant = new Participant();
        $participant->setIDcollective($row['IDcollective']);
        $participant->setIDetats($row['IDetats']);
        
        if(array_key_exists('IDadherent', $row)) {
            $IDadherent = $row['IDadherent'];
            $adherent = $this->adherentDAO->find($IDadherent);
            $participant->setAdherent($adherent);
        }
        return $participant;
    }


}
