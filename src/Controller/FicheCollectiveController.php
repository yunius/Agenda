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
 * Description of FicheCollectiveController
 *
 * @author inpiron
 */
class FicheCollectiveController {
    
    public function ficheCollectiveAction($id, Request $request, Application $app) {
        //var_dump($_POST);
        //Initialisation de toute les donnée conçernant la collective
        $collective = $app['dao.collective']->find($id);
        $titre = $collective->getCollTitre();
        $fil = ' / Fiche de sortie collective "'.$titre.'"';
        $listemateriel = $app['dao.materielcollective']->findAll($id);
        $cotations = $app['dao.collectivecotation']->findAll($id);
        $participantValide = $app['dao.participant']->findAllValide($collective);
        $listeAttente = $app['dao.participant']->findAllAttente($collective);

        //pour gerer les utilisateur déja inscrit a cette collective, ou à une collective de la même date
        $participantActuel = '';
        if($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $app['user'];
            $IDuser = $user->getIDadherent();
            
            if($app['dao.participant']->exists($id, $IDuser)) {
                $participantActuel = $app['dao.participant']->find($IDuser, $id);
                $inscrit = 1;
            }else {
                $inscrit = 0;
            }
            $dateverif = $collective->getCollDateDebut();
            if($app['dao.participant']->existsByDate($dateverif, $IDuser)) {
                $inscritAlaMemeDate = 1;
            }else{
                $inscritAlaMemeDate = 0;
            }
        }else {
            $inscrit = '';
            $inscritAlaMemeDate = '';
        }




        $commentFormView = null;
        if($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {

            $comment = new Commentaire();
            $comment->setIDcollective($id);
            $comment->setAdherent($user);
            $commentForm = $app['form.factory']->create(new CommentType(), $comment);
            $commentForm->handleRequest($request);
            if($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.commentaire']->save($comment);
                return $app->redirect('/fichecollective/'.$id);

            }
            $commentFormView = $commentForm->createView();
        }

        $ParticipantSubmitView = null;
        if($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {

            $participant = new Participant();
            $participant->setIDcollective($id);
            $user = $app['user'];
            $participant->setAdherent($user);
//            $rdvList = array();
//            $rdvs = $app['dao.rdv']->findAll($id);
//            foreach ($rdvs as $rdv) {
//                $idlieu = $rdv->getLieu()->getIdlieu();
//                $rdvList[$idlieu]['lieu'] = $rdv->getLieu()->getLieuLibelle();
//                $rdvList[$idlieu]['heure'] = $rdv->getHeureRDV();
//            }
            

            $ParticipantSubmitForm = $app['form.factory']->create(new ParticipantSubmitType(), $participant);
            $ParticipantSubmitForm->handleRequest($request);
            if($ParticipantSubmitForm->isSubmitted() && $ParticipantSubmitForm->isValid()) {
                if(isset($_POST['rdv'])) {
                    $IDlieu = $_POST['rdv'];
                    $rdv = $app['dao.rdv']->find($IDlieu, $id);
                    $heureRDV = $rdv->getHeureRDV();
                    $lieuLibelle = $rdv->getLieu()->getLieuLibelle();
                    $participant->setHeureRDV($heureRDV);
                    $participant->setLieuLibelle($lieuLibelle);
                }
                                
                $app['dao.participant']->save($participant);
                $message = \Swift_Message::newInstance()
                        ->setSubject('Agenda : Nouveau Participant')
                        ->setFrom(array('noreply@agenda.com'))
                        ->setTo(array('yunius@msn.com'))
                        ->setBody('bonjour, il y a un nouveau participant en attente de validation sur votre collective <a href="http://agenda/fichecollective/'.$id.'">"'.$titre.'"</a>', 'text/html');
                        
                $app['mailer']->send($message);
                return $app->redirect('/fichecollective/'.$id);

            }
            $ParticipantSubmitView = $ParticipantSubmitForm->createView();
        }

        $commentaires = $app['dao.commentaire']->findAll($id);
        //var_dump($ParticipantSubmitView);
        //echo '-------------------------------------';
        //var_dump($commentFormView);
        return $app['twig']->render('fichecollective.html.twig', ['collective' => $collective, 
                                                                  'fil' => $fil,
                                                                  'cotations' => $cotations,
                                                                  'listemateriel' => $listemateriel,
                                                                  'participantValide' => $participantValide,
                                                                  'listeAttente' => $listeAttente,
                                                                  'commentaires' => $commentaires,
                                                                  'commentForm'  => $commentFormView,
                                                                  'participantSubmit' => $ParticipantSubmitView,
                                                                  'inscrit' => $inscrit,
                                                                  'inscritAlaMemeDate' => $inscritAlaMemeDate,
                                                                  'participantActuel' => $participantActuel
                                                                 ]);
    }
    
    public function ficheCollectiveInscriptionAction($id, Request $request, Application $app) {
        
        $this->ficheCollectiveAction($id, $request, $app);
    }
    
    
}
