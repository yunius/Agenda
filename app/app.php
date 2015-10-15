<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

//recuperer les erreurs et exceptions
ErrorHandler::register();
ExceptionHandler::register();

//recuperer les services Silex/symfony
///recuperer le service de connexion
$app->register(new Silex\Provider\DoctrineServiceProvider());
///recuperer le service de moteur de template Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

//recuperer les service
$app['dao.collective'] = $app->share( function ($app) {
    $collectiveDAO = new Agenda\DAO\CollectiveDAO($app['db']);
    $collectiveDAO->setTypeActivite($app['dao.typeactivite']);
    return $collectiveDAO;
});

$app['dao.typeactivite'] = $app->share( function ($app) {
    return new Agenda\DAO\TypeActiviteDAO($app['db']);
});

