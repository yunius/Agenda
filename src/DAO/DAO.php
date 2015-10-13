<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Doctrine\DBAL\Connection;
/**
 * Description of DAO
 *
 * @author inpiron
 */
abstract class DAO {
    
    private $db;
    
    public function __construct(Connection $db) {
        $this->db = $db;
    }
    
    protected function getDB() {
        return $this->db;
    }
    
    /*protected abstract function buildDomainObject($row);*/
    
}
