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
///recuperer le service d'ecriture pour les lien / bind
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
///recuperer les services du système d'authentification de symfony
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new Agenda\DAO\AdherentDAO($app['db']);
            }),
        ),
    ),
));


//recuperer les service
$app['dao.collective'] = $app->share( function ($app) {
    $collectiveDAO = new Agenda\DAO\CollectiveDAO($app['db']);
    $collectiveDAO->setTypeActivite($app['dao.typeactivite']);
    $collectiveDAO->setObjectif($app['dao.objectif']);
    $collectiveDAO->setAdherent($app['dao.adherent']);
    $collectiveDAO->setRdvDAO($app['dao.rdv']);
    return $collectiveDAO;
});

$app['dao.typeactivite'] = $app->share( function ($app) {
    return new Agenda\DAO\TypeActiviteDAO($app['db']);
});

$app['dao.secteur'] = $app->share( function ($app) {
    return new Agenda\DAO\SecteurDAO($app['db']);
});

$app['dao.objectif'] = $app->share ( function ($app) {
   $objectifDAO = new Agenda\DAO\ObjectifDAO($app['db']); 
   $objectifDAO->setSecteurDAO($app['dao.secteur']);
   return $objectifDAO;
});

$app['dao.adherent'] = $app->share (function ($app) {
    return new Agenda\DAO\AdherentDAO($app['db']);
});

$app['dao.lieu'] = $app->share ( function ($app) {
    return new Agenda\DAO\LieuDAO($app['db']);
});

$app['dao.rdv'] = $app->share ( function ($app) {
    $rdvDAO = new Agenda\DAO\RdvDAO($app['db']);
    $rdvDAO->setLieuDAO($app['dao.lieu']);
    return $rdvDAO;
});

$app['dao.participant'] = $app->share ( function ($app) {
    $participantDAO = new Agenda\DAO\ParticipantDAO($app['db']);
    $participantDAO->setAdherentDAO($app['dao.adherent']);
    return $participantDAO;
});

$app['dao.cotation'] = $app->share ( function ($app) {
    return new Agenda\DAO\CotationDAO($app['db']);
});

$app['dao.collectivecotation'] = $app->share ( function ($app) {
    $collectiveCotationDAO = new Agenda\DAO\CollectiveCotationDAO($app['db']);
    $collectiveCotationDAO->setCotationDAO($app['dao.cotation']);
    return $collectiveCotationDAO;
});

$app['dao.typemateriel'] = $app->share ( function ($app) {
    return new Agenda\DAO\TypeMaterielDAO($app['db']);
});

$app['dao.materielcollective'] = $app->share ( function ($app) {
    $materielCollectiveDAO = new Agenda\DAO\MaterielCollectiveDAO($app['db']);
    $materielCollectiveDAO->setTypeMateriel($app['dao.typemateriel']);
    return $materielCollectiveDAO;
});







