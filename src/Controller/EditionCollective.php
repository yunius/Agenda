<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Commentaire;
use Agenda\Domain\Participant;
use Agenda\Domain\Collective;
use Agenda\Domain\CollectiveCotation;
use Agenda\Form\Type\CommentType;
use Agenda\Form\Type\ParticipantSubmitType;
use Agenda\Form\Type\CollectiveType;
use Agenda\Form\Type\CollCotSupprType;
use Agenda\Form\Type\filtreType;
/**
 * Description of EditionCollective
 *
 * @author inpiron
 */
class EditionCollective {
    
    /**
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function creerCollectiveAction(Request $request, Application $app){
        
        $collective = new Collective();
    //$collective = $app['dao.collective']->find($id);
    

        $encadrantParDefaut = $app['user']->getIDadherent();
        $activiteList = $this->findAllActivite($app);
        $objectifList = $this->findAllObjectif($app);
        $encadrantList = $this->findAllEncadrant($app);
        $cotationsList = $this->findAllcotation($app);
        $secteurList = $this->findAllSecteur($app);

        $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $secteurList), $collective, array( 'data' => array ('adherent'=> $encadrantParDefaut  )) );



        $activiteForm->handleRequest($request);

        if($activiteForm->isSubmitted()) {
            $collective = new Collective();
            //var_dump($_POST);
            $IDactivite = $_POST['collective']['typeActivite'];
            $typeactivite = $app['dao.typeactivite']->find($IDactivite);
            //var_dump($typeactivite);
            $collTitre  = $_POST['collective']['collTitre'];
            $collDenivele = $_POST['collective']['collDenivele'];

            $collDateDebut = $_POST['collective']['collDateDebut']; 
            $IDobjectif = $_POST['collective']['objectif'];
            $objectif = $app['dao.objectif']->find($IDobjectif);

            $IDadherent= $_POST['collective']['adherent'];
            $adherent = $app['dao.adherent']->find($IDadherent);


            $collective->setCollTitre($collTitre);
            $collective->setTypeActivite($typeactivite);
            $collective->setCollDateDebut($collDateDebut);
            $collective->setObjectif($objectif);
            $collective->setAdherent($adherent);
            $collective->setCollDenivele($collDenivele);

            //var_dump($collective);
            $app['dao.collective']->save($collective);
            $idcoll = $collective->getIDcollective();

            if(is_numeric($_POST['collective']['cotation'])) {
                $collCotation = new CollectiveCotation();
                $IDnewCotation = $_POST['collective']['cotation'];
                $newCotation = $app['dao.cotation']->find($IDnewCotation);
                $collCotation->setCotation($newCotation);
                $collCotation->setIDcollective($idcoll);
                $app['dao.collectivecotation']->save($collCotation);
            }

            return $app->redirect('/modificationCollective/'.$idcoll);
        }

        $activiteFormView = $activiteForm->createView();
        $fil = ' / Creation d\'une nouvelle collective';
        return $app['twig']->render('editionCollective.html.twig', array('fil' => $fil, 'activiteFormView' => $activiteFormView));

    }
    
    
    /**
     * 
     * @param type $id
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function modifierCollectiveAction($id, Request $request, Application $app) {
        
        $collective = $app['dao.collective']->find($id);
    
        $activiteList = $this->findAllActivite($app);
        $objectifList = $this->findAllObjectif($app);
        $encadrantList = $this->findAllEncadrant($app);
        //$cotationsList = $this->findAllcotation($app);
        $secteurList = $this->findAllSecteur($app);

        $idA = $collective->getTypeActivite()->getIDtypeActivite();
        $cotations = $app['dao.cotationList']->findAllByTypeActivite($idA);
        $cotationsList = array();
        foreach ($cotations as $cotation) {
            $IDcotation = $cotation->getCotation()->getIDcotation();
            $libelle = $cotation->getCotation()->getLibelleCotation();
            $valeur = $cotation->getCotation()->getValeurCotation();
            $cotationsList[$IDcotation] =$libelle.' '.$valeur;
        }
        //$collective = new Collective();

        $collCotations = $app['dao.collectivecotation']->findAll($id);
        //var_dump($collective);
        $titre = $collective->getCollTitre();
        $activite = $collective->getTypeActivite()->getIDtypeActivite();
        $date = strtotime($collective->getCollDateDebut());//        
        $objectif = $collective->getObjectif()->getIDobjectif();
        $adherent = $collective->getAdherent()->getIDadherent();
        //$secteur = $collective->getObjectif()->getIDsecteur();
        $denivele = $collective->getCollDenivele();


        $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $secteurList), $collective, array('data' => array( 'collTitre' => $titre,
                                                                                                                                                           'typeActivite' => $activite,
                                                                                                                                                           'collDateDebut' => $date,
                                                                                                                                                           'objectif' => $objectif ,
                                                                                                                                                           'adherent' => $adherent,
                                                                                                                                                           //'secteur' => $secteur,
                                                                                                                                                           'collDenivele' => $denivele
                                                                                                                                                              ) ) );
        $activiteForm->handleRequest($request);

        if($activiteForm->isSubmitted()) {
            //$collective = new Collective();

            //var_dump($_POST);
            $IDactivite = $_POST['collective']['typeActivite'];
            $newtypeactivite = $app['dao.typeactivite']->find($IDactivite);
            //var_dump($typeactivite);
            $newcollTitre  = $_POST['collective']['collTitre'];

            $newcollDateDebut = $_POST['collective']['collDateDebut']; 
            $IDobjectif = $_POST['collective']['objectif'];
            $newobjectif = $app['dao.objectif']->find($IDobjectif);

            $IDadherent= $_POST['collective']['adherent'];
            $newadherent = $app['dao.adherent']->find($IDadherent);


            $collective->setCollTitre($newcollTitre);
            $collective->setTypeActivite($newtypeactivite);
            $collective->setCollDateDebut($newcollDateDebut);
            $collective->setObjectif($newobjectif);
            $collective->setAdherent($newadherent);

            //var_dump($collective);
            $app['dao.collective']->save($collective);

            $collCotation = new CollectiveCotation();

            if(is_numeric($_POST['collective']['cotation'])) {
                $IDnewCotation = $_POST['collective']['cotation'];
                $newCotation = $app['dao.cotation']->find($IDnewCotation);
                $collCotation->setCotation($newCotation);
                $collCotation->setIDcollective($id);
                $app['dao.collectivecotation']->save($collCotation);
            }

            //$idcoll = $collective->getIDcollective();
            return $app->redirect('/modificationCollective/'.$id);
        }
        $activiteFormView = $activiteForm->createView();

        $CotSupprSubmitForm = $app['form.factory']->create(new CollCotSupprType($app['url_generator']));
        $CotSupprSubmitForm->handleRequest($request);
        $CotSupprSubmitFormView = $CotSupprSubmitForm->createView();

        $fil = ' / Creation d\'une nouvelle collective';
        return $app['twig']->render('modificationCollective.html.twig', array('fil' => $fil, 
                                                                               'activiteFormView' => $activiteFormView, 
                                                                               'cotations' => $collCotations,
                                                                               'CotSupprSubmitFormView' =>$CotSupprSubmitFormView, 
                                                                               'collective' =>$collective,
                                                                               ));

    }
    
    
    public function findAllActivite(Application $app) {
        
        
        $activites = $app['dao.typeactivite']->findAll();
        $activiteList = array();    
        foreach ($activites as $activite) {
            $IDactivite = $activite->getIDtypeActivite();
            $activiteList[$IDactivite] = $activite->getActiviteLibelle();
            
        }
        return $activiteList;
        
    }
    
    
    public function findAllObjectif(Application $app) {
    
    
        $objectifs = $app['dao.objectif']->findAll();
        $objectifList = array();
        foreach ($objectifs as $objectif) {
            $IDobjectif = $objectif->getIDobjectif();
            $objectifList[$IDobjectif] = $objectif->getObjectifLibelle();
            
        }
        return $objectifList;
    }
    
    public function findAllSecteur(Application $app) {
        $secteurs = $app['dao.secteur']->findAll();
        $secteurList = array();
        foreach ($secteurs as $secteur) {
            $IDsecteur = $secteur->getIDsecteur();
            $secteurList[$IDsecteur] = $secteur->getSecteurLibelle();
        }
        return $secteurList;
    }
    
        
    public function findAllEncadrant(Application $app)  {  
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
    
    public function findAllCotation(Application $app) {
        
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
    
    public function findAllCotationByActivity(Collective $collective, $app) {
        
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
