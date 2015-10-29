<?php
use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Commentaire;
use Agenda\Domain\Participant;
use Agenda\Domain\Collective;
use Agenda\Domain\CollectiveCotation;
use Agenda\Form\Type\CommentType;
use Agenda\Form\Type\ParticipantSubmitType;
use Agenda\Form\Type\CollectiveType;
use Agenda\Form\Type\CollCotSupprType;


$app->before(
    function (Request $request) use ($app) {
        $app['translator']->setLocale($request->getPreferredLanguage(['en', 'fr']));
    }
);
//envoi un formulaire d'authentification
$app->get('/login', function(Request $request) use($app) {
    $fil = ' / page d\'authentification';
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
        'fil' => $fil
    ));
})->bind('login');

//***************************************************************************************************************/



//envoi l'accueil
$app->get('/', function () use($app) {
    $collectives = $app['dao.collective']->findAll();
    $participants = array();
    $cotations = array();
    
    foreach ($collectives as $collective) {
        $id = $collective->getIDcollective();
        $nb = $app['dao.participant']->countParticipant($collective);
        $participants[$id] = $nb;
        $cotations[$id] = $app['dao.collectivecotation']->findAll($id);
    }
    
    $fil = '';
    return $app['twig']->render('index.html.twig', ['collectives' => $collectives, 
                                                    'participants' => $participants,
                                                    'cotations' => $cotations,
                                                    'fil' => $fil
                                                    ]);
})->bind('Acceuil');


//***************************************************************************************************************/


//envoi la page détaillée sur une collective
$app->match('/fichecollective/{id}', function ($id, Request $request) use ($app) {
    
    $collective = $app['dao.collective']->find($id);
    $titre = $collective->getCollTitre();
    $fil = ' / Fiche de sortie collective "'.$titre.'"';
    $listemateriel = $app['dao.materielcollective']->findAll($id);
    $cotations = $app['dao.collectivecotation']->findAll($id);
    $participantValide = $app['dao.participant']->findAllValide($collective);
    $listeAttente = $app['dao.participant']->findAllAttente($collective);
    
    $commentFormView = null;
    if($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
        
        $comment = new Commentaire();
        $comment->setIDcollective($id);
        $user = $app['user'];
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
                                                              'participantSubmit' => $ParticipantSubmitView
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
        
        $collCotation = new CollectiveCotation();
        $IDnewCotation = $_POST['collective']['cotation'];
        $newCotation = $app['dao.cotation']->find($IDnewCotation);
        $collCotation->setCotation($newCotation);
        $collCotation->setIDcollective($idcoll);
        $app['dao.collectivecotation']->save($collCotation);
        
        return $app->redirect('/modificationCollective/'.$idcoll);
    }
    
    $activiteFormView = $activiteForm->createView();
    $fil = ' / Creation d\'une nouvelle collective';
    return $app['twig']->render('editionCollective.html.twig', array('fil' => $fil, 'activiteFormView' => $activiteFormView));
})->bind('editionCollective');




/***************************************************************************************************************/


//envoi la page de modification collective
$app->match('/modificationCollective/{id}', function ($id, Request $request) use ($app) {
    
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
    //$collective = new Collective();
    $collective = $app['dao.collective']->find($id);
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
        $IDnewCotation = $_POST['collective']['cotation'];
        $newCotation = $app['dao.cotation']->find($IDnewCotation);
        $collCotation->setCotation($newCotation);
        $collCotation->setIDcollective($id);
        $app['dao.collectivecotation']->save($collCotation);
        //$idcoll = $collective->getIDcollective();
        return $app->redirect('/modificationCollective/'.$id);
    }
    $activiteFormView = $activiteForm->createView();
    
    $CotSupprSubmitForm = $app['form.factory']->create(new CollCotSupprType($app['url_generator']));
    $CotSupprSubmitForm->handleRequest($request);
    $CotSupprSubmitFormView = $CotSupprSubmitForm->createView();
    
    $fil = ' / Creation d\'une nouvelle collective';
    return $app['twig']->render('modificationCollective.html.twig', array('fil' => $fil, 'activiteFormView' => $activiteFormView, 'cotations' => $collCotations, 'CotSupprSubmitFormView' =>$CotSupprSubmitFormView));
})->bind('modificationCollective');




$app->match('/CollectiveCotationAsuppr/', function(Request $request) use($app) {
    var_dump($_POST);
    return $app['twig']->render('CollectiveCotationAsuppr.html.twig');
})->bind('CollectiveCotationAsuppr');