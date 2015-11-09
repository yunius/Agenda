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
        
        //determiner les parametre de dates par defaut
        /*$semaineActuelle = date('W');
        $semaine = date('W');
        $dates = afficheDateSemaine($semaineActuelle);
        $lundi = $dates['lundiString'];
        $dimanche = $dates['dimancheString'];
        $debut = $dates['lundiIso']->format('Ymd');
        $fin = $dates['dimancheIso']->format('Ymd') ;
        $activite = '';
        //$adherent = '';
        $FiltreEntete = 'Semaine';
        
        //recuperer les infos pour les filtre par defaut (semaine presente)
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
        
        //traitement du formulaire de filtrage de l'accueil
        $filtreHidden = 'filtreHidden';
        $filtreDateFinHidden = 'filtreDateFinHidden';
        $activiteFiltre = '';
        if($filtreForm->isSubmitted()) {
            $filtreHidden = '';
            //var_dump($_POST);
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
                
            }
        }
        $filtreFormView = $filtreForm->createView();

        
        
        $collectives = $app['dao.collective']->findAllByFilter($debut, $fin, $activiteFiltre);
        $participants = array();
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
                                                        'FiltreEntete' => $FiltreEntete,
                                                        'filtreHidden' => $filtreHidden,
                                                        'filtreDateFinHidden' => $filtreDateFinHidden
                                                        ]);*/
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
        $debut = $dates['lundiIso']->format('Ymd');
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
        if($filtreForm->isSubmitted()) {
            $filtreHidden = '';
            //var_dump($_POST);
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
                                                        'filtreHidden'=> $filtreHidden
                                                        ]);
    }
    
}
