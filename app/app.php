<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

//recuperer les erreurs et exceptions
ErrorHandler::register();
ExceptionHandler::register();

//recuperer les services Silex/symfony
///recuperer le service de connexion
$app->register(new Silex\Provider\DoctrineServiceProvider());

//recuperer les service
$app['dao.collective'] = $app->share( function ($app) {
    return new Agenda\DAO\CollectivesDAO($app['db']);
});

