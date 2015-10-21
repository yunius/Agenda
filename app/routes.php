<?php
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
$app->get('/fichecollective/{id}', function ($id) use ($app) {
    $collective = $app['dao.collective']->find($id);
    $titre = $collective->getCollTitre();
    $fil = ' / Fiche de sortie collective "'.$titre.'"';
    $listemateriel = $app['dao.materielcollective']->findAll($id);
    $cotations = $app['dao.collectivecotation']->findAll($id);
    $participantValide = $app['dao.participant']->findAllValide($collective);
    $listeAttente = $app['dao.participant']->findAllAttente($collective);
    
    return $app['twig']->render('fichecollective.html.twig', ['collective' => $collective, 
                                                              'fil' => $fil,
                                                              'cotations' => $cotations,
                                                              'listemateriel' => $listemateriel,
                                                              'participantValide' => $participantValide,
                                                              'listeAttente' => $listeAttente
                                                             ]);
})->bind('fichecollective');


