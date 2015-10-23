<?php
use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Commentaire;
use Agenda\Form\Type\CommentType;

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
        }
        $commentFormView = $commentForm->createView();
    }
    
    $commentaires = $app['dao.commentaire']->findAll($id);
    
    return $app['twig']->render('fichecollective.html.twig', ['collective' => $collective, 
                                                              'fil' => $fil,
                                                              'cotations' => $cotations,
                                                              'listemateriel' => $listemateriel,
                                                              'participantValide' => $participantValide,
                                                              'listeAttente' => $listeAttente,
                                                              'commentaires' => $commentaires,
                                                              'commentForm'  => $commentFormView
                                                             ]);
})->bind('fichecollective');


