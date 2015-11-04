<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;


use Agenda\Domain\Collective;
use Symfony\Component\Security\Acl\Exception\Exception;
/**
 * Description of CollectivesDAO
 *
 * @author inpiron
 */
class CollectiveDAO extends DAO {
    
    /**
     *
     * @var Agenda\Domain\TypeActiviteDAO 
     */
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
    
    public function exists($IDcollective) {
        $sql = "SELECT count(*) AS count FROM collectives WHERE IDcollective=?";
        $req = $this->getDB()->fetchAssoc($sql, array($IDcollective));
        return $req['count'];
    }
    
    public function find($IDcollective) {
        $sql = "SELECT * FROM collectives WHERE IDcollective=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDcollective));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new \Exception("pas de collective n°" . $IDcollective);
        }
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
    
    public function findAllByFilter($debut = NULL, $fin = NULL, $activite = NULL, $IDadherent = NULL) {
        if (isset($debut) && isset($fin)) {
            $where1 = 'WHERE collDateDebut BETWEEN ? AND ?';
        }else {
            $where1 = '';
        }
        $sql = "SELECT * FROM collectives ".$where1." ORDER BY collDateDebut ";
        $result = $this->getDB()->fetchAll($sql, array($debut, $fin ));

        $collectives = array();
        foreach ($result as $row) {
            $IDcollective = $row['IDcollective'];
            $collectives[$IDcollective] = $this->buildDomainObject($row);            
        }
        return $collectives;
        
    }
    
    
    public function save(Collective $collective) {
        $typeactivite = $collective->getTypeActivite();
        $IDtypeactivite = $typeactivite->getIDtypeActivite();
//        $originalDate = $collective->getCollDateDebut();
//        $newDate = date("Y-m-d", strtotime($originalDate));
        $collectiveData = array(
            'collTitre' => $collective->getCollTitre(),
            'collDateDebut' => $collective->getCollDateDebut(),
            'collDatefin' => $collective->getCollDatefin(),
            'collDenivele' => $collective->getCollDenivele(),
            'collDureeCourseEstim' => $collective->getCollDureeCourseEstim(),
            'collObservations' => $collective->getCollObservations(),
            'collPublie' => $collective->getCollPublie(),
            'collNbParticipantMax' => $collective->getCollNbParticipantMax(),
            'collNbLongueurs' => $collective->getCollNbLongueurs(),
            'collHeureDepartTerrain' => $collective->getCollHeureDepartTerrain(),
            'collHeureRetourTerrain' => $collective->getCollHeureRetourTerrain(),
            'collDureeCourse' => $collective->getCollDureeCourse(),
            'collConditionMeteo' => $collective->getCollConditionMeteo(),
            'collInfoComplementaire' => $collective->getCollInfoComplementaire(),
            'coll_incident_accident' => $collective->getColl_incident_accident(),
            'collTypeRocher' => $collective->getCollTypeRocher(),
            'collDureeApproche' => $collective->getCollDureeApproche(),
            'collCondition_neige_rocher_glace' => $collective->getCollCondition_neige_rocher_glace(),
            'collEtatNeige' => $collective->getCollEtatNeige(),
            'collConditionTerrain' => $collective->getCollConditionTerrain(),
            'collCR_Horodateur' => $collective->getCollCR_Horodateur(),
            'IDtypeActivite' => $IDtypeactivite,
            'IDobjectif' => $collective->getObjectif()->getIDobjectif(),
            'IDadherent' => $collective->getAdherent()->getIDadherent(),
            );
        
        if($collective->getIDcollective()) {
            $this->getDB()->update('collectives', $collectiveData, array( 
                                                                        'IDcollective' => $collective->getIDcollective() 
                                                                        )  
                                  );
        } else {
            $this->getDB()->insert('collectives', $collectiveData);
            $id = $this->getDB()->lastInsertId();
            $collective->setIDcollective($id);
           
        }
        
    }
    
    public function delete($IDcollective) {
        $this->getDB()->delete('collectives', array('IDcollective' => $IDcollective));
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
