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
///
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Intl());
    return $twig;
}));

//recuperer le service de mailing
$app->register(new Silex\Provider\SwiftmailerServiceProvider);
$app['swiftmailer.options'] = array(
	'host' => 'smtp.gmail.com',
	'port' => 465,
	'username' => 'gilou2501@gmail.com',
	'password' => '*gilou2501*',
	'encryption' => 'ssl',
	'auth_mode' => 'login'
);
//$app['twig']->addExtension(new Twig_Extensions_Extension_Intl());
///
$app->register(new Silex\Provider\ValidatorServiceProvider());
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
    'security.role_hierarchy' => array(
        'ROLE_REDACTEUR' => array('ROLE_USER')
    ),
    'security.access_rules' => array(
        array('^/editionCollective', 'ROLE_REDACTEUR'),
        array('/fichecollective_maCollective', 'ROLE_REDACTEUR'),
        array('/fichecollectiveInscription', 'ROLE_USER')
    )
));
            

  
///recuperer les services pour les generation de formulaire           
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());



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

$app['dao.commentaire'] = $app->share ( function ($app) {
    $commentaireDAO = new Agenda\DAO\CommentaireDAO($app['db']);
    $commentaireDAO->setAdherentDAO($app['dao.adherent']);
    return $commentaireDAO;
});

$app['dao.encadrant'] = $app->share ( function ($app) {
    $encadrantDAO = new Agenda\DAO\EncadrantDAO($app['db']);
    $encadrantDAO->setAdherent($app['dao.adherent']);
    $encadrantDAO->setTypeActivite($app['dao.typeactivite']);
    return $encadrantDAO;
});

$app['dao.cotationList'] = $app->share ( function ($app) {
    $cotationListDAO = new Agenda\DAO\CotationListDAO($app['db']);
    $cotationListDAO->setCotationDAO($app['dao.cotation']);
    return $cotationListDAO;
});

$app['dao.listtypemateriel'] =$app->share (function($app) {
    $listTypeMateriel = new Agenda\DAO\ListTypeMaterielDAO($app['db']);
    $listTypeMateriel->setTypeMaterielDAO($app['dao.typemateriel']);
    $listTypeMateriel->setTypeActiviteDAO($app['dao.typeactivite']);
    return $listTypeMateriel;
});