<?php
use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Commentaire;
use Agenda\Domain\Participant;
use Agenda\Domain\Collective;
use Agenda\Form\Type\CommentType;
use Agenda\Form\Type\ParticipantSubmitType;
use Agenda\Form\Type\CollectiveType;


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
$app->match('/editionCollective/{id}', function($id, Request $request) use ($app) {
    $collective = new Collective();
    //$collective = $app['dao.collective']->find($id);
    
    $activites = $app['dao.typeactivite']->findAll();
    $activiteList = array();    
    foreach ($activites as $activite) {
        $id = $activite->getIDtypeActivite();
        $activiteList[$id] = $activite->getActiviteLibelle();         
    }
    
    $objectifs = $app['dao.objectif']->findAll();
    $objectifList = array();
    foreach ($objectifs as $objectif) {
        $id = $objectif->getIDobjectif();
        $objectifList[$id] = $objectif->getObjectifLibelle();
    }
    
    $encadrants = $app['dao.encadrant']->findAll();
    $encadrantList = array();
    foreach ($encadrants as $encadrant) {
        $id = $encadrant->getAdherent()->getIDadherent();
        $nom = $encadrant->getAdherent()->getNomAdherent();
        $prenom = $encadrant->getAdherent()->getPrenomAdherent();
        $encadrantList[$id] = $prenom.' '.$nom;
    }
    
    $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList), $collective, array('data' => array('collTitre' => 'mon super test',
                                                                                                                                                       'typeActivite' => 1 ) ) );
    $activiteForm->handleRequest($request);
    
    if($activiteForm->isSubmitted()) {
        
        $IDactivite = $_POST['collective']['typeActivite'];
        $typeactivite = $app['dao.typeactivite']->find($IDactivite);
        
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
        return $app->redirect('/editionCollective/'.$idcoll);
    }
    
    $activiteFormView = $activiteForm->createView();
    $fil = ' / Creation d\'une nouvelle collective';
    return $app['twig']->render('editionCollective.html.twig', array('fil' => $fil, 'activiteFormView' => $activiteFormView));
})->bind('editionCollective');