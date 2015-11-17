<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\DAO;

use Agenda\Domain\CotationList;

/**
 * Description of CotationListDAO
 *
 * @author Gilou
 */
class CotationListDAO extends DAO{
    
    private $cotationDAO;
    
    public function setCotationDAO (CotationDAO $cotationDAO) {
        $this->cotationDAO = $cotationDAO;
    }
    
    public function findAllByTypeActivite($IDtypeActivite) {
        $sql = "SELECT * FROM liste_de_cotation WHERE IDtypeActivite=?";
        $result = $this->getDB()->fetchAll($sql, array($IDtypeActivite));
               
        $cotations = array();
        foreach ($result as $row) {
            $IDcotation = $row['IDcotation'];
            $cotations[$IDcotation] = $this->buildDomainObject($row);            
        }
        return $cotations;
    }
    
    protected function buildDomainObject($row) {
        $cotationList = new CotationList();
        $cotationList->setIDtypeActivite($row['IDtypeActivite']);
        if(array_key_exists('IDcotation', $row)) {
            $IDcotation = $row['IDcotation'];
            $cotation = $this->cotationDAO->find($IDcotation);
            $cotationList->setCotation($cotation);
        }
        
        return $cotationList;
    }

}
