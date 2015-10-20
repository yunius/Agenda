<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Cotation;
/**
 * Description of CotationDAO
 *
 * @author inpiron
 */
class CotationDAO extends DAO{
    
    public function find($IDcotation) {
        $sql = "SELECT * FROM cotation WHERE IDcotation=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDcotation));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de cotation n°" . $IDcotation);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM cotation ORDER BY IDcotation";
        $result = $this->getDB()->fetchAll($sql);
        
        $cotations = array();
        foreach ($result as $row) {
            $IDcotation = $row['IDcotation'];
            $cotations[$IDcotation] = $this->buildDomainObject($row);            
        }
        return $cotations;
        
    }

    protected function buildDomainObject($row) {
        $cotation = new Cotation();
        $cotation->setIDcotation($row['IDcotation']);
        $cotation->setLibelleCotation($row['LibelleCotation']);
        $cotation->setValeurCotation($row['ValeurCotation']);
        
        return $cotation;
    }
}
