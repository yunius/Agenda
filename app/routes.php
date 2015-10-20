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
    
    
    return $app['twig']->render('index.html.twig', ['collectives' => $collectives, 
                                                    'participants' => $participants,
                                                    'cotations' => $cotations
                                                    ]);
})->bind('Acceuil');

//envoi la page détaillé sur une collective
$app->get('/fichecollective/{id}', function ($id) use ($app) {
    $collective = $app['dao.collective']->find($id);
    return $app['twig']->render('fichecollective.html.twig', ['collective' => $collective]);
})->bind('fichecollective');


