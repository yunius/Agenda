<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;


use Agenda\Domain\Collective;
/**
 * Description of CollectivesDAO
 *
 * @author inpiron
 */
class CollectiveDAO extends DAO {
    
    private $typeActiviteDAO;
    
    public function setTypeActivite(TypeActiviteDAO $typeActiviteDAO) {
        $this->typeActiviteDAO = $typeActiviteDAO;
    }
    
    public function findAll() {
        $sql = "SELECT * FROM collectives ORDER BY collDateDebut";
        $result = $this->getDB()->fetchAll($sql);
        
        $collectives = array();
        foreach ($result as $row) {
            $IDcollective = $row['IDcollective'];
            $collectives[$IDcollective] = $this->buildDomainObject($row);            
        }
        return $collectives;
        
    }
    
    protected function buildDomainObject($row) {
        $collective = new Collective();
        $collective->setIDcollective($row['IDcollective']);
        $collective->setCollTitre($row['collTitre']);
        $collective->setCollDateDebut($row['collDateDebut']);
        $collective->setCollDatefin($row['collDateFin']);
        $collective->setCollDenivele($row['collDenivele']);
        $collective->setCollDureeCourseEstim($row['collDureeCourseEstim']);
        $collective->setCollObservations($row['collObservations']);
        $collective->setCollPublie($row['collPublie']);
        $collective->setCollNbParticipantMax($row['collNbParticipantMax']);
        $collective->setCollNbLongueurs($row['collNbLongueurs']);
        $collective->setCollHeureDepartTerrain($row['collHeureDepartTerrain']);
        $collective->setCollHeureRetourTerrain($row['collHeureRetourTerrain']);
        $collective->setCollDureeCourse($row['collDureeCourse']);
        $collective->setCollConditionMeteo($row['collConditionMeteo']);
        $collective->setCollInfoComplementaire($row['collInfoComplementaire']);
        $collective->setColl_incident_accident($row['coll_incident_accident']);
        $collective->setCollTypeRocher($row['collTypeRocher']);
        $collective->setCollDureeApproche($row['collDureeApproche']);
        $collective->setCollCondition_neige_rocher_glace($row['collCondition_neige_rocher_glace']);
        $collective->setCollEtatNeige($row['collEtatNeige']);
        $collective->setCollConditionTerrain($row['collConditionTerrain']);
        $collective->setCollCR_Horodateur($row['collCR_Horodateur']);
        $collective->setIDobjectif($row['IDobjectif']);
        $collective->setIDadherent($row['IDadherent']);
        
        if (array_key_exists('IDtypeActivite', $row)) {
            $IDtypeActivite = $row['IDtypeActivite'];
            $typeactivite = $this->typeActiviteDAO->find($IDtypeActivite);
            $collective->setTypeActivite($typeactivite);
        }
        return $collective;
    }
}
