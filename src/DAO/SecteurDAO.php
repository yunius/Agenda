<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Secteur;
/**
 * Description of SecteurDAO
 *
 * @author Gilou
 */
class SecteurDAO extends DAO {
    
    public function find($IDsecteur) {
        $sql = "SELECT * FROM secteur WHERE IDsecteur=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDsecteur));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de secteur n°" . $IDsecteur);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM secteur ORDER BY IDsecteur";
        $result = $this->getDB()->fetchAll($sql);
        
        $secteurs = array();
        foreach ($result as $row) {
            $IDsecteur = $row['IDsecteur'];
            $secteurs[$IDsecteur] = $this->buildDomainObject($row);            
        }
        return $secteurs;
        
    }
    
    public function save(Secteur $secteur) {
        $secteurData = array(
            'secteurLibelle' => $secteur->getSecteurLibelle()
        );
        $this->getDB()->insert('secteur', $secteurData);
        $id = $this->getDB()->lastInsertId();
        $secteur->setIDsecteur($id);
    }
    
    protected function buildDomainObject($row) {
        $secteur = new Secteur();
        $secteur->setIDsecteur($row['IDsecteur']);
        $secteur->setSecteurLibelle($row['secteurLibelle']);
        $secteur->setIDcommune($row['IDcommune']);
        return $secteur;
    }
}
