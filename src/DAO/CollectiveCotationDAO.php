<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\CollectiveCotation;
/**
 * Description of CollectiveCotationDAO
 *
 * @author inpiron
 */
class CollectiveCotationDAO extends DAO {
    
    private $cotationDAO;
    
    public function setCotationDAO(CotationDAO $cotationDAO) {
        $this->cotationDAO = $cotationDAO;
    }
    
//    public function find($IDcollective) {
//        $sql = "SELECT * FROM rdv WHERE IDlieu=? AND IDcollective=?";
//        $row = $this->getDB()->fetchAssoc($sql, array($IDlieu, $IDcollective));
//        
//        if($row) {
//            return $this->buildDomainObject($row);
//        }
//        else {
//            throw new Exception("pas de de rdv correspondant");
//        }
//    }
    public function save(CollectiveCotation $collectiveCotation) {
        
            $collectiveCotationData = array(
                'IDcollective' => $collectiveCotation->getIDcollective(),
                'IDcotation' => $collectiveCotation->getCotation()->getIDcotation()
            );
            $this->getDB()->insert('collcotations', $collectiveCotationData);
    }
    
    public function findAll($IDcollective) {
        $sql = "SELECT * FROM collcotations WHERE IDcollective=? ORDER BY IDcotation";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        $cotations = array();
        $count = 0;
        foreach ($result as $row) {
            $count++;
            //$IDcollective = $row['IDcollective'];
            $cotations[$count] = $this->buildDomainObject($row);            
        }
        return $cotations;
        
    }
    
    
    public function delete($IDcollective, $IDcotation) {
        $this->getDB()->delete('collcotations', array('IDcollective' => $IDcollective, 'IDcotation' => $IDcotation));
    }
    
    
    protected function buildDomainObject($row) {
        $collectiveCotation = new CollectiveCotation();
        $collectiveCotation->setIDcollective($row['IDcollective']);
        if(array_key_exists('IDcotation', $row)) {
            $IDcotation= $row['IDcotation'];
            $cotation = $this->cotationDAO->find($IDcotation);
            $collectiveCotation->setCotation($cotation);
        }
        
        return $collectiveCotation;
    }
}
