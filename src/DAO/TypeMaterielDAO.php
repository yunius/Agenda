<?php

namespace Agenda\DAO;

use Agenda\Domain\TypeMateriel;
/**
 * Description of TypeMaterielDAO
 *
 * @author Gilou
 */
class TypeMaterielDAO extends DAO {
    
    /**
     * recuperer un objet de type TypeMateriel spécifique
     * @param type $IDtypeMat
     * @return Object TypeMateriel
     * @throws Exception
     */
    public function find($IDtypeMat) {
        $sql = "SELECT * FROM Type_de_materiel WHERE IDtypeMat=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDtypeMat));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de type de materiel n°" . $IDtypeMat);
        }
    }
    
    /**
     * recupere une liste d'objet de type TypeMateriel
     * @return Array of Object TypeMateriel
     */
    public function findAll() {
        $sql = "SELECT * FROM Type_de_materiel ORDER BY IDtypeMat";
        $result = $this->getDB()->fetchAll($sql);
        
        $typeMateriels = array();
        foreach ($result as $row) {
            $IDtypeMat = $row['IDtypeMat'];
            $typeMateriels[$IDtypeMat] = $this->buildDomainObject($row);            
        }
        return $typeMateriels; 
        
    }
    /**
     * Construit un Objet de type TypeMateriel
     * @param type $row
     * @return Object TypeMateriel
     */
    protected function buildDomainObject($row) {
        $typeMateriel = new TypeMateriel();
        $typeMateriel->setIDtypeMat($row['IDtypeMat']);
        $typeMateriel->setTypeMatLibelle($row['typeMatLibelle']);
        
        
        return $typeMateriel;
    }
    
}
