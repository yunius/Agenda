<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Agenda\Form\Type\filtreType;
/**
 * Description of AcceuilController
 *
 * @author inpiron
 */
class AcceuilController {
    
//    public function semaineAction(Application $app) {
//        $semaine = date('W');
//        return $app->redirect('/'.$semaine);
//    }
    
    /**
     * 
     * @param Request $request
     * @param Application $app
     * @return tout les composant de la page d'accueil
     */
    public function accueilAction(Request $request, Application $app) {
        
        $semaineActuelle = date('W');
        $action = $this->accueilSemaineAction($semaineActuelle, $request, $app);
        return $action;
        
        
    }
    
    /**
     * 
     * @param type $semaine
     * @param Request $request
     * @param Application $app
     * @return tout les composants de la page d'accueil quand l'utilisateur navigue entre les semaines
     */
    public function accueilSemaineAction($semaine, Request $request, Application $app ) {
        
        //determiner les dates par defaut
        $semaineActuelle = date('W');
        $dates = afficheDateSemaine($semaine);
        $lundi = $dates['lundiString'];
        $dimanche = $dates['dimancheString'];
        if($semaine === $semaineActuelle) {
            $debut = date('Ymd');
        }else {
            $debut = $dates['lundiIso']->format('Ymd');
        }
        $fin = $dates['dimancheIso']->format('Ymd') ;
        $activite = '';
        $FiltreEntete = 'Semaine';
        $noPeriode = false;
        $choixEncadrant = '';
        $message = '';
        
        //recuperer les infos pour les filtre par defaut ( semaine reçu en get )
        $activites = $app['dao.typeactivite']->findAll();
        $activiteList = array();    
        foreach ($activites as $activite) {
            $IDactivite = $activite->getIDtypeActivite();
            $activiteList[$IDactivite] = $activite->getActiviteLibelle();         
        }

        $encadrants = $app['dao.encadrant']->findAll();
        $encadrantList = array();
        foreach ($encadrants as $encadrant) {
            $IDadherent = $encadrant->getAdherent()->getIDadherent();
            $nom = $encadrant->getAdherent()->getNomAdherent();
            $prenom = $encadrant->getAdherent()->getPrenomAdherent();
            $encadrantList[$IDadherent] = $prenom.' '.$nom;
        }

        $filtreForm = $app['form.factory']->create(new filtreType($activiteList, $encadrantList));
        $filtreForm->handleRequest($request);
        
        //traitement du filtrage de l'accueil
        $filtreHidden = 'filtreHidden';
        $filtreDateFinHidden = 'filtreDateFinHidden';
        $activiteFiltre = '';
        
        if($filtreForm->isSubmitted()) {
            $filtreHidden = '';
            
            if(!empty($request->get('filtre')['adherent'])) {
                $choixEncadrant = $request->get('filtre')['adherent'];
            }
            
            if(!empty($request->get('filtre')['debutPeriode']) && !empty($request->get('filtre')['finPeriode'])) {
                $FiltreEntete = 'Periode';
            }
            if(!empty($request->get('filtre')['typeActivite'])) {
                $activiteFiltre = $request->get('filtre')['typeActivite'];
            }
            if(!empty($request->get('filtre')['debutPeriode'])) {
                $debut = date('Y-m-d', strtotime($request->get('filtre')['debutPeriode']));
            }
            if(!empty($request->get('filtre')['finPeriode'])) {
                $fin = date('Y-m-d', strtotime($request->get('filtre')['finPeriode']));
            }else {
                $fin = '';
                $FiltreEntete = 'Jour';
            }
            if(empty($request->get('filtre')['debutPeriode']) && empty($request->get('filtre')['finPeriode'])) {
                $debut = date('Y-m-d');
                $noPeriode = true;
                $FiltreEntete = 'A partir';
            }
        }
        $filtreFormView = $filtreForm->createView();
        
        
        $collectives = $app['dao.collective']->findAllByFilter($debut, $fin, $activiteFiltre, $choixEncadrant, $noPeriode);
        if(empty($collectives)){
            $message = 'Pas de collective à cette periode';
        }
        $participantsValide = array();
        $participantsAttente = array();
        $cotations = array();

        foreach ($collectives as $collective) {
            $id = $collective->getIDcollective();
            $nbV = $app['dao.participant']->countParticipantValide($collective);
            $participantsValide[$id] = $nbV;
            $nbA = $app['dao.participant']->countParticipantAttente($collective);
            $participantsAttente[$id] = $nbA;
            $cotations[$id] = $app['dao.collectivecotation']->findAll($id);
        }

        $fil = '';
        return $app['twig']->render('index.html.twig', ['collectives' => $collectives, 
                                                        'participantsValide' => $participantsValide,
                                                        'participantsAttente' => $participantsAttente,
                                                        'cotations' => $cotations,
                                                        'fil' => $fil,
                                                        'lundi' => $lundi,
                                                        'dimanche' => $dimanche,
                                                        'semaine' => $semaine,
                                                        'semaineActuelle' => $semaineActuelle,
                                                        'filtreFormView' => $filtreFormView,
                                                        'FiltreEntete'=> $FiltreEntete,
                                                        'filtreHidden'=> $filtreHidden,
                                                        'debut' => $debut,
                                                        'fin' => $fin,
                                                        'message' => $message
                                                        ]);
    }
    
    
    public function accueilEncadrantAction($semaine, Request $request, Application $app ) {
        
        $encadrantParDefaut = $app['user']->getIDadherent();
        //determiner les dates par defaut
        $semaineActuelle = date('W');
        $dates = afficheDateSemaine($semaine);
        $lundi = $dates['debut'];
        $dimanche = $dates['fin'];
        $debut = date('Ymd') /*$dates['lundiIso']->format('Ymd')*/;
        $fin = $dates['dimancheIso']->format('Ymd') ;
        $activite = '';
        //$adherent = '';
        $FiltreEntete = 'Semaine';
        
        //recuperer les infos pour les filtre par defaut ( semaine reçu en get )
        $activites = $app['dao.typeactivite']->findAll();
        $activiteList = array();    
        foreach ($activites as $activite) {
            $IDactivite = $activite->getIDtypeActivite();
            $activiteList[$IDactivite] = $activite->getActiviteLibelle();         
        }

        $encadrants = $app['dao.encadrant']->findAll();
        $encadrantList = array();
        foreach ($encadrants as $encadrant) {
            $IDadherent = $encadrant->getAdherent()->getIDadherent();
            $nom = $encadrant->getAdherent()->getNomAdherent();
            $prenom = $encadrant->getAdherent()->getPrenomAdherent();
            $encadrantList[$IDadherent] = $prenom.' '.$nom;
        }

        $filtreForm = $app['form.factory']->create(new filtreType($activiteList, $encadrantList));
        $filtreForm->handleRequest($request);
        
        //traitement du filtrage de l'accueil
        $filtreHidden = 'filtreHidden';
        $filtreDateFinHidden = 'filtreDateFinHidden';
        $activiteFiltre = '';
        $all ='';
        if($filtreForm->isSubmitted()) {
            $filtreHidden = '';
//            if($_POST['filtre']['choixFiltre'] == 1) {
//                $filtreDateFinHidden = '';
//            }
            if(!empty($_POST['filtre']['debutPeriode']) && !empty($_POST['filtre']['finPeriode'])) {
                $FiltreEntete = 'Periode';
            }
            if(!empty($_POST['filtre']['typeActivite'])) {
                $activiteFiltre = $_POST['filtre']['typeActivite'];
            }
            if(!empty($_POST['filtre']['debutPeriode'])) {
                $debut = date('Y-m-d', strtotime($_POST['filtre']['debutPeriode']));
            }
            if(!empty($_POST['filtre']['finPeriode'])) {
                $fin = date('Y-m-d', strtotime($_POST['filtre']['finPeriode']));
            }else {
                $fin = '';
            }
        }
        $filtreFormView = $filtreForm->createView();

        
        $collectives = $app['dao.collective']->findAllByFilter($debut, $fin, $activiteFiltre);
        
        $participantsValide = array();
        $participantsAttente = array();
        $cotations = array();

        foreach ($collectives as $collective) {
            $id = $collective->getIDcollective();
            $nbV = $app['dao.participant']->countParticipantValide($collective);
            $participantsValide[$id] = $nbV;
            $nbA = $app['dao.participant']->countParticipantAttente($collective);
            $participantsAttente[$id] = $nbA;
            $cotations[$id] = $app['dao.collectivecotation']->findAll($id);
        }

        $fil = '';
        return $app['twig']->render('index.html.twig', ['collectives' => $collectives, 
                                                        'participantsValide' => $participantsValide,
                                                        'participantsAttente' => $participantsAttente,
                                                        'cotations' => $cotations,
                                                        'fil' => $fil,
                                                        'lundi' => $lundi,
                                                        'dimanche' => $dimanche,
                                                        'semaine' => $semaine,
                                                        'semaineActuelle' => $semaineActuelle,
                                                        'filtreFormView' => $filtreFormView,
                                                        'FiltreEntete'=> $FiltreEntete,
                                                        'filtreHidden'=> $filtreHidden,
                                                        'debut' => $debut,
                                                        'fin' => $fin,
                                                        ]);
    }
    
    
    public function supprimerCollectiveAction(Request $request, Application $app) {
        
        $IDcollective = $request->get('IDcollAsuppr');
        $app['dao.collective']->delete($IDcollective);
        return $app->redirect('/');
    }
    
}
