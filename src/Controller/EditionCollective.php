<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Collective;
use Agenda\Domain\CollectiveCotation;
use Agenda\Domain\MaterielCollective;
use Agenda\Form\Type\CollectiveType;
use Agenda\Form\Type\CollCotSupprType;
/**
 * Description of EditionCollective
 *
 * @author inpiron
 */
class EditionCollective extends AgendaController {
    
    /**
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function editerCollectiveAction($id, Request $request, Application $app) {
        
        $encadrantParDefaut = $app['user']->getIDadherent();
        //recuperation des toute les liste d'entité pour les select non filtré
        $activiteList = $this->findAllActivite($app);
        $objectifList = $this->findAllObjectif($app);
        $encadrantList = $this->findAllEncadrant($app);
        $cotationsList = $this->findAllcotation($app);
        $secteurList = $this->findAllSecteur($app);
        $materielList = $this->findAllMateriel($app);
        
        if($id == 0) {
            $collective = new Collective();
            $collCotations = '';
            $materielCollective = '';
            $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $materielList, $secteurList), $collective, array( 'data' => array ('adherent'=> $encadrantParDefaut  )) );
        }
        else {
            $collective = $app['dao.collective']->find($id);
            $cotationsList = $this->findAllCotationByActivity($collective, $app);
            $collCotations = $app['dao.collectivecotation']->findAll($id);
            $materielCollective = $app['dao.materielcollective']->findAll($id);
            $titre = $collective->getCollTitre();
            $activite = $collective->getTypeActivite()->getIDtypeActivite();
            $date1 = strtotime($collective->getCollDateDebut());// 
            $date2 = strtotime($collective->getCollDateFin());
            $objectif = $collective->getObjectif()->getIDobjectif();
            $adherent = $collective->getAdherent()->getIDadherent();
            //$secteur = $collective->getObjectif()->getIDsecteur();
            $denivele = $collective->getCollDenivele();
            $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $materielList, $secteurList), $collective, array('data' => array( 'collTitre' => $titre,
                                                                                                                                                                                             'typeActivite' => $activite,
                                                                                                                                                                                             'collDateDebut' => $date1,
                                                                                                                                                                                             'collDateFin' => $date2,
                                                                                                                                                                                             'objectif' => $objectif ,
                                                                                                                                                                                             'adherent' => $adherent,
                                                                                                                                                                                             //'secteur' => $secteur,
                                                                                                                                                                                             'collDenivele' => $denivele
                                                                                                                                                                                            ) ) );
        }
        $activiteForm->handleRequest($request);

        if($activiteForm->isSubmitted()) {
            
            $this->traitementEdition($collective, $request, $app);
            return $app->redirect('/editionCollective/'.$id);
            
            
        }

        $activiteFormView = $activiteForm->createView();
        $CotSupprSubmitForm = $app['form.factory']->create(new CollCotSupprType($app['url_generator']));
        $CotSupprSubmitForm->handleRequest($request);
        $CotSupprSubmitFormView = $CotSupprSubmitForm->createView();
        
        $fil = ' / Creation d\'une nouvelle collective';
        return $app['twig']->render('editionCollective.html.twig', array('fil' => $fil, 
                                                                               'activiteFormView' => $activiteFormView, 
                                                                               'cotations' => $collCotations,
                                                                               'CotSupprSubmitFormView' =>$CotSupprSubmitFormView, 
                                                                               'collective' =>$collective,
                                                                               'materielCollective' => $materielCollective
                                                                               ));
    }
    
    
    public function traitementEdition(Collective $collective, Request $request , Application $app ) {
        
        $IDactivite = $request->get('collective')['typeActivite'];
        $typeactivite = $app['dao.typeactivite']->find($IDactivite);
        $collTitre  = $request->get('collective')['collTitre'];
        $collDenivele = $request->get('collective')['collDenivele'];
        $collDateDebut = date('Y-m-d', strtotime($request->get('collective')['collDateDebut']));
        $collDateFin = date('Y-m-d', strtotime($request->get('collective')['collDateFin']));
        $IDobjectif = $request->get('collective')['objectif'];
        $objectif = $app['dao.objectif']->find($IDobjectif);
        $IDadherent= $request->get('collective')['adherent'];
        $adherent = $app['dao.adherent']->find($IDadherent);

        $collective->setCollTitre($collTitre);
        $collective->setTypeActivite($typeactivite);
        $collective->setCollDateDebut($collDateDebut);
        $collective->setCollDatefin($collDateFin);
        $collective->setObjectif($objectif);
        $collective->setAdherent($adherent);
        $collective->setCollDenivele($collDenivele);

        $app['dao.collective']->save($collective);
        $idcoll = $collective->getIDcollective();

        if(is_numeric($request->get('collective')['cotation'])) {
            $collCotation = new CollectiveCotation();
            $IDnewCotation = $request->get('collective')['cotation'];
            $newCotation = $app['dao.cotation']->find($IDnewCotation);
            $collCotation->setCotation($newCotation);
            $collCotation->setIDcollective($idcoll);
            $app['dao.collectivecotation']->save($collCotation);
        }
        if(is_numeric($request->get('collective')['MaterielCollective'])) {
            $materielCollective = new MaterielCollective();
            $IDtypeMat = $request->get('collective')['MaterielCollective'];
            $typeMateriel = $app['dao.typemateriel']->find($IDtypeMat);
            $materielCollective->setTypeMateriel($typeMateriel);
            $materielCollective->setIDcollective($idcoll);
            $app['dao.materielcollective']->save($materielCollective);
        }
    }
    
    
    
    public function supprimerCotationAction(Request $request, Application $app) {
        $IDcollective = $request->get('IDcollAsuppr');
        $IDcotation =  $request->get('cotationAsuppr');
        $app['dao.collectivecotation']->delete($IDcollective, $IDcotation );
        return $app->redirect('/editionCollective/'.$IDcollective);
    }
}
