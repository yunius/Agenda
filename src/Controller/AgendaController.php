<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Controller;

use Silex\Application;
use Agenda\Domain\Collective;
/**
 * Description of Controller
 *
 * @author Gilou
 */
abstract class AgendaController {
    
    /**
     * recupere une liste select ready de type d'activités
     * @param Application $app
     * @return array liste de type d'activités
     */
    protected function findAllActivite(Application $app) {
        
        
        $activites = $app['dao.typeactivite']->findAll();
        $activiteList = array();    
        foreach ($activites as $activite) {
            $IDactivite = $activite->getIDtypeActivite();
            $activiteList[$IDactivite] = $activite->getActiviteLibelle();
            
        }
        return $activiteList;
        
    }
    
    
    protected function findAllObjectif(Application $app) {
    
    
        $objectifs = $app['dao.objectif']->findAll();
        $objectifList = array();
        foreach ($objectifs as $objectif) {
            $IDobjectif = $objectif->getIDobjectif();
            $objectifList[$IDobjectif] = $objectif->getObjectifLibelle();
            
        }
        return $objectifList;
    }
    
    protected function findAllSecteur(Application $app) {
        $secteurs = $app['dao.secteur']->findAll();
        $secteurList = array();
        foreach ($secteurs as $secteur) {
            $IDsecteur = $secteur->getIDsecteur();
            $secteurList[$IDsecteur] = $secteur->getSecteurLibelle();
        }
        return $secteurList;
    }
    
    protected function findAllLieu(Application $app) {
        $lieus = $app['dao.lieu']->findAll();
        $lieuList = array();
        foreach ($lieus as $lieu) {
            $IDlieu = $lieu->getIDlieu();
            $lieuList[$IDlieu] = $lieu->getLieuLibelle();
        }
        return $lieuList;
    }
    
        
    protected function findAllEncadrant(Application $app)  {  
        $encadrants = $app['dao.encadrant']->findAll();
        $encadrantList = array();
        foreach ($encadrants as $encadrant) {
            $IDadherent = $encadrant->getAdherent()->getIDadherent();
            $nom = $encadrant->getAdherent()->getNomAdherent();
            $prenom = $encadrant->getAdherent()->getPrenomAdherent();
            $encadrantList[$IDadherent] = $prenom.' '.$nom;
        }
        return $encadrantList;
    }
    
    protected function findAllCotation(Application $app) {
        
        $cotations = $app['dao.cotation']->findAll();
        $cotationsList = array();
        foreach ($cotations as $cotation) {
            $IDcotation = $cotation->getIDcotation();
            $libelle = $cotation->getLibelleCotation();
            $valeur = $cotation->getValeurCotation();
            $cotationsList[$IDcotation] =$libelle.' '.$valeur;
        }
        return $cotationsList;
        
    }
    protected function findAllMateriel(Application $app) {
        $materiels = $app['dao.typemateriel']->findAll();
        $materielList = array();
        foreach ($materiels as $materiel) {
            $IDtypeMat = $materiel->getIDtypeMat();
            $typeMatLibelle = $materiel->getTypeMatLibelle();
            $materielList[$IDtypeMat] = $typeMatLibelle;
        }
        return $materielList;
    }
    protected function findAllMaterielCollective($IDcollective, Application $app) {
        $materielCollectives = $app['dao.materielcollective']->findAll($IDcollective);
        $materielCollectiveList = array();
        foreach ($materielCollectives as $materielCollective) {
            $IDtypeMat = $materielCollective->getTypeMateriel()->getIDtypeMat();
            $typeMatLibelle = $materielCollective->getTypeMateriel()->getTypeMatLibelle();
            $materielCollectiveList[$IDtypeMat] = $typeMatLibelle;
        }
        return $materielCollectiveList;
    } 
    
    protected function findAllCotationByActivity(Collective $collective, $app) {
        
        $idA = $collective->getTypeActivite()->getIDtypeActivite();
        $cotations = $app['dao.cotationList']->findAllByTypeActivite($idA);
        $cotationsList = array();
        foreach ($cotations as $cotation) {
            $IDcotation = $cotation->getCotation()->getIDcotation();
            $libelle = $cotation->getCotation()->getLibelleCotation();
            $valeur = $cotation->getCotation()->getValeurCotation();
            $cotationsList[$IDcotation] =$libelle.' '.$valeur;
        }
        return $cotationsList;
    }
    
}
