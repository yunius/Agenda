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
    private $objectifDAO;
    private $adherentDAO;
    private $rvdDAO;
    
    
    public function setTypeActivite(TypeActiviteDAO $typeActiviteDAO) {
        $this->typeActiviteDAO = $typeActiviteDAO;
    }
    
    public function setObjectif(ObjectifDAO $objectifDAO) {
        $this->objectifDAO = $objectifDAO;
    }
    
    public function setAdherent(AdherentDAO $adherentDAO) {
        $this->adherentDAO = $adherentDAO;
    }
    public function setRdvDAO(RdvDAO $rdvDAO) {
        $this->rvdDAO =$rdvDAO;
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
        
        
        if (array_key_exists('IDtypeActivite', $row)) {
            $IDtypeActivite = $row['IDtypeActivite'];
            $typeactivite = $this->typeActiviteDAO->find($IDtypeActivite);
            $collective->setTypeActivite($typeactivite);
        }
        if (array_key_exists('IDobjectif', $row)) {
            $IDobjectif = $row['IDobjectif'];
            $objectif = $this->objectifDAO->find($IDobjectif);
            $collective->setObjectif($objectif);
        }
        if(array_key_exists('IDadherent', $row)) {
            $IDadherent = $row['IDadherent'];
            $adherent = $this->adherentDAO->find($IDadherent);
            $collective->setAdherent($adherent);
        }
        
        $IDcollective = $row['IDcollective'];
        $rdv = $this->rvdDAO->findAll($IDcollective);
        $collective->setRdv($rdv);
        
        return $collective;
    }
}
