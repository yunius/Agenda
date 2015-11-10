<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Rdv;
/**
 * Description of RdvDAO
 *
 * @author inpiron
 */
class RdvDAO extends DAO {
    
    
    private $lieuDAO;
    
    public function setLieuDAO(LieuDAO $lieuDAO) {
        $this->lieuDAO = $lieuDAO;
    }
    
    public function find($IDlieu, $IDcollective) {
        $sql = "SELECT * FROM rdv WHERE IDlieu=? AND IDcollective=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDlieu, $IDcollective));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de rdv correspondant");
        }
    }
    
    
    public function findAll($IDcollective) {
        $sql = "SELECT * FROM rdv WHERE IDcollective=? ORDER BY heureRDV";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        $rdvs = array();
        foreach ($result as $row) {
            $IDlieu = $row['IDlieu'];
            $rdvs[$IDlieu] = $this->buildDomainObject($row);            
        }
        return $rdvs;
        
    }
    
    protected function buildDomainObject($row) {
        $rdv = new Rdv();
        $rdv->setHeureRDV($row['heureRDV']);
        $rdv->setIDcollective($row['IDcollective']);
        if(array_key_exists('IDlieu', $row)) {
            $IDlieu = $row['IDlieu'];
            $lieu = $this->lieuDAO->find($IDlieu);
            $rdv->setLieu($lieu);
        }
        
        return $rdv;
    }


}
