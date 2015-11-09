<?php
include_once 'utils.php';

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



$app->before(
    function (Request $request) use ($app) {
        $app['translator']->setLocale($request->getPreferredLanguage(['en', 'fr']));
    }
);


//$app->get('/', "Agenda\Controller\AcceuilController::semaineAction");
$app->match('login', "Agenda\Controller\loginController::loginAction")->bind('login');

$app->match('/', "Agenda\Controller\AcceuilController::accueilAction")->bind('accueil');

$app->match('/{semaine}', "Agenda\Controller\AcceuilController::accueilSemaineAction")->bind('accueilSemaine');




//***************************************************************************************************************/

//***************************************************************************************************************/


//envoi la page détaillée sur une collective
$app->match('/fichecollective/{id}', function ($id, Request $request) use ($app) {
    //Initialisation de toute les donnée conçernant la collective
    $collective = $app['dao.collective']->find($id);
    $titre = $collective->getCollTitre();
    $fil = ' / Fiche de sortie collective "'.$titre.'"';
    $listemateriel = $app['dao.materielcollective']->findAll($id);
    $cotations = $app['dao.collectivecotation']->findAll($id);
    $participantValide = $app['dao.participant']->findAllValide($collective);
    $listeAttente = $app['dao.participant']->findAllAttente($collective);
    
    //pour gerer les utilisateur déja inscrit a cette collective, ou à une collective de la même date
    if($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
        $user = $app['user'];
        $IDuser = $user->getIDadherent();
        if($app['dao.participant']->exists($id, $IDuser)) {
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
        
        $ParticipantSubmitForm = $app['form.factory']->create(new ParticipantSubmitType(), $participant);
        $ParticipantSubmitForm->handleRequest($request);
        if($ParticipantSubmitForm->isSubmitted() && $ParticipantSubmitForm->isValid()) {
            $app['dao.participant']->save($participant);
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
                                                              'inscritAlaMemeDate' => $inscritAlaMemeDate
                                                             ]);
})->bind('fichecollective');


//***************************************************************************************************************/


//envoi la page d'edition de collective
$app->match('/editionCollective/', function(Request $request) use ($app) {
    $collective = new Collective();
    //$collective = $app['dao.collective']->find($id);
    
    
    $activites = $app['dao.typeactivite']->findAll();
    $activiteList = array();    
    foreach ($activites as $activite) {
        $IDactivite = $activite->getIDtypeActivite();
        $activiteList[$IDactivite] = $activite->getActiviteLibelle();         
    }
    
    $objectifs = $app['dao.objectif']->findAll();
    $objectifList = array();
    foreach ($objectifs as $objectif) {
        $IDobjectif = $objectif->getIDobjectif();
        $objectifList[$IDobjectif] = $objectif->getObjectifLibelle();
    }
    
    $encadrants = $app['dao.encadrant']->findAll();
    $encadrantList = array();
    foreach ($encadrants as $encadrant) {
        $IDadherent = $encadrant->getAdherent()->getIDadherent();
        $nom = $encadrant->getAdherent()->getNomAdherent();
        $prenom = $encadrant->getAdherent()->getPrenomAdherent();
        $encadrantList[$IDadherent] = $prenom.' '.$nom;
    }
    
    $cotations = $app['dao.cotation']->findAll();
    $cotationsList = array();
    foreach ($cotations as $cotation) {
        $IDcotation = $cotation->getIDcotation();
        $libelle = $cotation->getLibelleCotation();
        $valeur = $cotation->getValeurCotation();
        $cotationsList[$IDcotation] =$libelle.' '.$valeur;
    }
    
    $encadrantParDefaut = $app['user']->getIDadherent();
    
    
    $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList), $collective, array( 'data' => array ('adherent'=> $encadrantParDefaut  )) );
    
    
    
    $activiteForm->handleRequest($request);
    
    if($activiteForm->isSubmitted()) {
        $collective = new Collective();
        //var_dump($_POST);
        $IDactivite = $_POST['collective']['typeActivite'];
        $typeactivite = $app['dao.typeactivite']->find($IDactivite);
        //var_dump($typeactivite);
        $collTitre  = $_POST['collective']['collTitre'];
               
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
})->bind('editionCollective');




/***************************************************************************************************************/


//envoi la page de modification collective
$app->match('/modificationCollective/{id}', function ($id, Request $request) use ($app) {
    
    $collective = $app['dao.collective']->find($id);
    
    $activites = $app['dao.typeactivite']->findAll();
    $activiteList = array();    
    foreach ($activites as $activite) {
        $IDactivite = $activite->getIDtypeActivite();
        $activiteList[$IDactivite] = $activite->getActiviteLibelle();         
    }
    
    $objectifs = $app['dao.objectif']->findAll();
    $objectifList = array();
    foreach ($objectifs as $objectif) {
        $IDobjectif = $objectif->getIDobjectif();
        $objectifList[$IDobjectif] = $objectif->getObjectifLibelle();
    }
    
    $encadrants = $app['dao.encadrant']->findAll();
    $encadrantList = array();
    foreach ($encadrants as $encadrant) {
        $IDadherent = $encadrant->getAdherent()->getIDadherent();
        $nom = $encadrant->getAdherent()->getNomAdherent();
        $prenom = $encadrant->getAdherent()->getPrenomAdherent();
        $encadrantList[$IDadherent] = $prenom.' '.$nom;
    }
     
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
    
    
    $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList), $collective, array('data' => array( 'collTitre' => $titre,
                                                                                                                                                       'typeActivite' => $activite,
                                                                                                                                                       'collDateDebut' => $date,
                                                                                                                                                       'objectif' => $objectif ,
                                                                                                                                                       'adherent' => $adherent
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
})->bind('modificationCollective');




/**********************************************************************************************************************/



//reçoit une requete de suppression CollectiveCotation et renvoi vers la page de modification
$app->match('/CollectiveCotationAsuppr/', function(Request $request) use($app) {
    $IDcollective = $_POST['IDcollAsuppr'];
    $IDcotation = $_POST['cotationAsuppr'];
    $app['dao.collectivecotation']->delete($IDcollective, $IDcotation );
    return $app->redirect('/modificationCollective/'.$IDcollective);
})->bind('CollectiveCotationAsuppr');

//reçoit une requete de suppression Collective et renvoi vers l'index
$app->match('/CollectiveAsuppr/', function(Request $request) use($app) {
    $IDcollective = $_POST['IDcollAsuppr'];
    $app['dao.collective']->delete($IDcollective);
    return $app->redirect('/');
})->bind('CollectiveAsuppr');


$app->match('/cotation/', "Agenda\Controller\CotationListController::cotationListAction")->bind('cotation');
