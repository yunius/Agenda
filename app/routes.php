<?php

$app->get('/', function () use($app) {
    $collectives = $app['dao.collective']->findAll();
    
    return $app['twig']->render('index.html.twig', array('collectives' => $collectives ));
})->bind('Acceuil');

