<?php
include_once 'utils.php';
include_once 'PHPExcel.php';
include_once 'PHPExcel/IOFactory.php';

use Symfony\Component\HttpFoundation\Request;

$app->before(
    function (Request $request) use ($app) {
        $app['translator']->setLocale($request->getPreferredLanguage(['en', 'fr']));
    }
);


//$app->get('/', "Agenda\Controller\AcceuilController::semaineAction");
$app->match('login', "Agenda\Controller\LoginController::loginAction")->bind('login');

$app->match('/', "Agenda\Controller\AcceuilController::accueilAction")->bind('accueil');

$app->match('/semaine-{semaine}', "Agenda\Controller\AcceuilController::accueilSemaineAction")->bind('accueilSemaine');

$app->match('/CollectiveAsuppr/', "Agenda\Controller\AcceuilController::supprimerCollectiveAction")->bind('CollectiveAsuppr');
$app->match('CollectiveAcreer/', "Agenda\Controller\AcceuilController::creerCollectiveAction")->bind('CollectiveAcreer');

$app->match('/fichecollective/{id}', "Agenda\Controller\FicheCollectiveController::ficheCollectiveAction")->bind('fichecollective');
$app->match('/fichecollectiveInscription/{id}', "Agenda\Controller\FicheCollectiveController::ficheCollectiveAction")->bind('fichecollectiveInscription');
$app->match('/fichecollective_maCollective/{id}', "Agenda\Controller\FicheCollectiveController::ficheCollectiveAction")->bind('fichecollective_maCollective');


$app->match('/editionCollective/{id}', "Agenda\Controller\EditionCollectiveController::editerCollectiveAction")->bind('editionCollective');
$app->match('/CollectiveCotationAsuppr/', "Agenda\Controller\EditionCollectiveController::supprimerCotationAction")->bind('CollectiveCotationAsuppr');
$app->match('/materielAsuppr/', "Agenda\Controller\EditionCollectiveController::supprimerMaterielAction")->bind('materielAsuppr');

$app->match('/CompteRendu/{id}', "Agenda\Controller\ComptesRendusCollectiveController::ComptesRendusCollectiveAction")->bind('CompteRendu');

//***************************************************************************************************************/



//reçoit une requete de suppression CollectiveCotation et renvoi vers la page de modification


//reçoit une requete de suppression Collective et renvoi vers l'index
//$app->match('/CollectiveAsuppr/', function(Request $request) use($app) {
//    $IDcollective = $request->get('IDcollAsuppr');
//    $app['dao.collective']->delete($IDcollective);
//    return $app->redirect('/');
//})->bind('CollectiveAsuppr');

$app->match('/desinscription/', function(Request $request) use($app) {
    $IDcollective = $request->get('IDcollective');
    $IDadherent = $request->get('IDadherent');
    $app['dao.participant']->delete($IDadherent, $IDcollective);
    return $app->redirect('/fichecollective/'.$IDcollective);
})->bind('desinscription');

$app->match('/validerInscription/', function(Request $request) use($app) {
    $IDadherent = $request->get('IDadherentValide');
    $IDcollective = $request->get('IDcollectiveValide');
    $app['dao.participant']->updateEtat(2, $IDcollective, $IDadherent);
    return $app->redirect('/fichecollective/'.$IDcollective);
})->bind('validerInscription');


$app->match('/cotation/', "Agenda\Controller\CotationListController::cotationListAction")->bind('cotation');
$app->match('/materiel/', "Agenda\Controller\ListTypeMaterielController::ListTypeMaterielAction")->bind('materiel');

