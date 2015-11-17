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
 * @author Gilou
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
            'lieuLibelle' => $participant->getLieuLibelle(),
            'heureRDV' => $participant->getHeureRDV()
        );
        
            $this->getDB()->insert('participants', $participantData);
        
    }
    public function updateEtat($value, $IDcollective, $IDadherent) {
        $participantData = array ( 'IDetats' => $value );
        $this->getDB()->update('participants', $participantData, array( 'IDcollective' => $IDcollective,
                                                                        'IDadherent' => $IDadherent
                                                                        ));
    }
    
    public function delete($IDadherent, $IDcollective) {
        $this->getDB()->delete('participants', array('IDadherent' => $IDadherent, 'IDcollective' => $IDcollective));
    }
    
    public function find($IDadherent, $IDcollective) {
        $sql = "SELECT * FROM participants WHERE IDadherent=? AND IDcollective=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDadherent, $IDcollective));
        
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
    
    public function countParticipantValide(Collective $collective) {
        $IDcollective = $collective->getIDcollective();
        $sql = "SELECT count(*) AS nbParticipant FROM participants WHERE IDcollective=? AND IDetats=2";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        foreach ($result as $row) {
               $nb = $row['nbParticipant'];      
        }
        return $nb;
    }
    
    public function countParticipantAttente(Collective $collective) {
        $IDcollective = $collective->getIDcollective();
        $sql = "SELECT count(*) AS nbParticipant FROM participants WHERE IDcollective=? AND IDetats=1";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        foreach ($result as $row) {
               $nb = $row['nbParticipant'];      
        }
        return $nb;
    }
    
    public function exists($IDcollective, $IDadherent) {
        $sql = "SELECT count(*) AS count FROM participants WHERE IDcollective=? AND IDadherent=?";
        $req = $this->getDB()->fetchAssoc($sql, array($IDcollective, $IDadherent));
        return (bool)$req['count'];
    }
    
    public function existsByDate($date, $IDadherent) {
        $sql = "SELECT count(*) AS count FROM participants
                JOIN collectives ON participants.IDcollective = collectives.IDcollective
                WHERE collDateDebut=?
                AND participants.IDadherent=?
               ";
        $req = $this->getDB()->fetchAssoc($sql, array($date, $IDadherent));
        return (bool)$req['count'];
    }


    protected function buildDomainObject($row) {
        $participant = new Participant();
        $participant->setIDcollective($row['IDcollective']);
        $participant->setIDetats($row['IDetats']);
        $participant->setLieuLibelle($row['lieuLibelle']);
        $participant->setHeureRDV($row['heureRDV']);
        
        if(array_key_exists('IDadherent', $row)) {
            $IDadherent = $row['IDadherent'];
            $adherent = $this->adherentDAO->find($IDadherent);
            $participant->setAdherent($adherent);
        }
        return $participant;
    }


}
