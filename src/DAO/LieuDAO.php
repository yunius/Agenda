<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Lieu;
/**
 * Description of LieuDAO
 *
 * @author Gilou
 */
class LieuDAO extends DAO {
    
    public function find($IDlieu) {
        $sql = "SELECT * FROM lieu WHERE IDlieu=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDlieu));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de de lieu n°" . $IDlieu);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM lieu ORDER BY IDlieu";
        $result = $this->getDB()->fetchAll($sql);
        
        $lieus = array();
        foreach ($result as $row) {
            $IDlieu = $row['IDlieu'];
            $lieus[$IDlieu] = $this->buildDomainObject($row);            
        }
        return $lieus;
        
    }
    
    protected function buildDomainObject($row) {
        $lieu = new Lieu();
        $lieu->setIDlieu($row['IDlieu']);
        $lieu->setLieuLibelle($row['lieuLibelle']);
        return $lieu;
    }


}
