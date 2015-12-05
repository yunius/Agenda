<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\MaterielCollective;
/**
 * Description of MaterielCollectiveDAO
 *
 * @author Gilou
 */
class MaterielCollectiveDAO extends DAO {
    
    private $TypeMaterielDAO;
    
    public function setTypeMateriel(TypeMaterielDAO $TypeMaterielDAO){
        $this->TypeMaterielDAO = $TypeMaterielDAO;
    }
    
     
    public function findAll($IDcollective) {
        $sql = "SELECT * FROM liste_de_materiel_collective WHERE IDcollective=? ORDER BY IDtypeMat";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        $listeMateriel = array();
        $count = 0;
        foreach ($result as $row) {
            $count++;
            //$heureRDV = $row['heureRDV'];
            $listeMateriel[$count] = $this->buildDomainObject($row);            
        }
        return $listeMateriel;
    }
    
    public function find($IDtypeMat, $IDcollective) {
        $sql = "SELECT * FROM liste_de_materiel_collective WHERE IDtypeMat=? AND IDcollective=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDtypeMat, $IDcollective));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de type de materiel correspondant");
        }
    }
    
   
    
    public function save(MaterielCollective $materielCollective) {
        
            $materielCollectiveData = array(
                'IDcollective' => $materielCollective->getIDcollective(),
                'IDtypeMat' => $materielCollective->getTypeMateriel()->getIDtypeMat(),
            );
            $this->getDB()->insert('liste_de_materiel_collective', $materielCollectiveData);
    }
    
    public function delete($IDcollective, $IDtypeMat) {
        $this->getDB()->delete('liste_de_materiel_collective', array('IDcollective' => $IDcollective, 'IDtypeMat' => $IDtypeMat));
    }
    
    protected function buildDomainObject($row) {
        $materielCollective = new MaterielCollective();
        $materielCollective->setIDcollective($row['IDcollective']);
        if(array_key_exists('IDtypeMat', $row)) {
            $IDtypeMat = $row['IDtypeMat'];
            $TypeMateriel = $this->TypeMaterielDAO->find($IDtypeMat);
            $materielCollective->setTypeMateriel($TypeMateriel);
        }
        
        return $materielCollective;
    }
}
