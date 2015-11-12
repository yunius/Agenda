<?php
include_once 'utils.php';

use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Commentaire;
use Agenda\Domain\Participant;
use Agenda\Domain\Collective;
use Agenda\Domain\CollectiveCotation;
use Agenda\Form\Type\CommentType;
use Agenda\Form\Type\ParticipantSubmitType;
use Agenda\Form\Type\CollectiveType;
use Agenda\Form\Type\CollCotSupprType;
use Agenda\Form\Type\filtreType;



$app->before(
    function (Request $request) use ($app) {
        $app['translator']->setLocale($request->getPreferredLanguage(['en', 'fr']));
    }
);


//$app->get('/', "Agenda\Controller\AcceuilController::semaineAction");
$app->match('login', "Agenda\Controller\loginController::loginAction")->bind('login');

$app->match('/', "Agenda\Controller\AcceuilController::accueilAction")->bind('accueil');

$app->match('/{semaine}', "Agenda\Controller\AcceuilController::accueilSemaineAction")->bind('accueilSemaine');

$app->match('/fichecollective/{id}', "Agenda\Controller\FicheCollectiveController::ficheCollectiveAction")->bind('fichecollective');
$app->match('/fichecollectiveInscription/{id}', "Agenda\Controller\FicheCollectiveController::ficheCollectiveAction")->bind('fichecollectiveInscription');

$app->match('/editionCollective/', "Agenda\Controller\EditionCollective::creerCollectiveAction")->bind('editionCollective');
$app->match('/modificationCollective/{id}', "Agenda\Controller\EditionCollective::modifierCollectiveAction")->bind('modificationCollective');

//***************************************************************************************************************/



//envoi la page d'edition de collective
//$app->match('/editionCollective/', function(Request $request) use ($app) {
//    
//    
//    $collective = new Collective();
//    //$collective = $app['dao.collective']->find($id);
//    
//    
//    $activites = $app['dao.typeactivite']->findAll();
//    $activiteList = array();    
//    foreach ($activites as $activite) {
//        $IDactivite = $activite->getIDtypeActivite();
//        $activiteList[$IDactivite] = $activite->getActiviteLibelle();         
//    }
//    
//    $objectifs = $app['dao.objectif']->findAll();
//    $objectifList = array();
//    foreach ($objectifs as $objectif) {
//        $IDobjectif = $objectif->getIDobjectif();
//        $objectifList[$IDobjectif] = $objectif->getObjectifLibelle();
//    }
//    
//    $secteurs = $app['dao.secteur']->findAll();
//    $secteurList = array();
//    foreach ($secteurs as $secteur) {
//        $IDsecteur = $secteur->getIDsecteur();
//        $secteurList[$IDsecteur] = $secteur->getSecteurLibelle();
//    }
//    
//    $encadrants = $app['dao.encadrant']->findAll();
//    $encadrantList = array();
//    foreach ($encadrants as $encadrant) {
//        $IDadherent = $encadrant->getAdherent()->getIDadherent();
//        $nom = $encadrant->getAdherent()->getNomAdherent();
//        $prenom = $encadrant->getAdherent()->getPrenomAdherent();
//        $encadrantList[$IDadherent] = $prenom.' '.$nom;
//    }
//    
//    $cotations = $app['dao.cotation']->findAll();
//    $cotationsList = array();
//    foreach ($cotations as $cotation) {
//        $IDcotation = $cotation->getIDcotation();
//        $libelle = $cotation->getLibelleCotation();
//        $valeur = $cotation->getValeurCotation();
//        $cotationsList[$IDcotation] =$libelle.' '.$valeur;
//    }
//    
//    $encadrantParDefaut = $app['user']->getIDadherent();
//    
//    
//    $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $secteurList), $collective, array( 'data' => array ('adherent'=> $encadrantParDefaut  )) );
//    
//    
//    
//    $activiteForm->handleRequest($request);
//    
//    if($activiteForm->isSubmitted()) {
//        $collective = new Collective();
//        //var_dump($_POST);
//        $IDactivite = $_POST['collective']['typeActivite'];
//        $typeactivite = $app['dao.typeactivite']->find($IDactivite);
//        //var_dump($typeactivite);
//        $collTitre  = $_POST['collective']['collTitre'];
//        $collDenivele = $_POST['collective']['collDenivele'];
//               
//        $collDateDebut = $_POST['collective']['collDateDebut']; 
//        $IDobjectif = $_POST['collective']['objectif'];
//        $objectif = $app['dao.objectif']->find($IDobjectif);
//        
//        $IDadherent= $_POST['collective']['adherent'];
//        $adherent = $app['dao.adherent']->find($IDadherent);
//        
//        
//        $collective->setCollTitre($collTitre);
//        $collective->setTypeActivite($typeactivite);
//        $collective->setCollDateDebut($collDateDebut);
//        $collective->setObjectif($objectif);
//        $collective->setAdherent($adherent);
//        $collective->setCollDenivele($collDenivele);
//        
//        //var_dump($collective);
//        $app['dao.collective']->save($collective);
//        $idcoll = $collective->getIDcollective();
//        
//        if(is_numeric($_POST['collective']['cotation'])) {
//            $collCotation = new CollectiveCotation();
//            $IDnewCotation = $_POST['collective']['cotation'];
//            $newCotation = $app['dao.cotation']->find($IDnewCotation);
//            $collCotation->setCotation($newCotation);
//            $collCotation->setIDcollective($idcoll);
//            $app['dao.collectivecotation']->save($collCotation);
//        }
//        
//        return $app->redirect('/modificationCollective/'.$idcoll);
//    }
//    
//    $activiteFormView = $activiteForm->createView();
//    $fil = ' / Creation d\'une nouvelle collective';
//    return $app['twig']->render('editionCollective.html.twig', array('fil' => $fil, 'activiteFormView' => $activiteFormView));
//})->bind('editionCollective');




/***************************************************************************************************************/


//envoi la page de modification collective
//$app->match('/modificationCollective/{id}', function ($id, Request $request) use ($app) {
//    
//    $collective = $app['dao.collective']->find($id);
//    
//    $activites = $app['dao.typeactivite']->findAll();
//    $activiteList = array();    
//    foreach ($activites as $activite) {
//        $IDactivite = $activite->getIDtypeActivite();
//        $activiteList[$IDactivite] = $activite->getActiviteLibelle();         
//    }
//    
//    $objectifs = $app['dao.objectif']->findAll();
//    $objectifList = array();
//    foreach ($objectifs as $objectif) {
//        $IDobjectif = $objectif->getIDobjectif();
//        $objectifList[$IDobjectif] = $objectif->getObjectifLibelle();
//    }
//    
//    $secteurs = $app['dao.secteur']->findAll();
//    $secteurList = array();
//    foreach ($secteurs as $secteur) {
//        $IDsecteur = $secteur->getIDsecteur();
//        $secteurList[$IDsecteur] = $secteur->getSecteurLibelle();
//    }
//    
//    
//    $encadrants = $app['dao.encadrant']->findAll();
//    $encadrantList = array();
//    foreach ($encadrants as $encadrant) {
//        $IDadherent = $encadrant->getAdherent()->getIDadherent();
//        $nom = $encadrant->getAdherent()->getNomAdherent();
//        $prenom = $encadrant->getAdherent()->getPrenomAdherent();
//        $encadrantList[$IDadherent] = $prenom.' '.$nom;
//    }
//     
//    $idA = $collective->getTypeActivite()->getIDtypeActivite();
//    $cotations = $app['dao.cotationList']->findAllByTypeActivite($idA);
//    $cotationsList = array();
//    foreach ($cotations as $cotation) {
//        $IDcotation = $cotation->getCotation()->getIDcotation();
//        $libelle = $cotation->getCotation()->getLibelleCotation();
//        $valeur = $cotation->getCotation()->getValeurCotation();
//        $cotationsList[$IDcotation] =$libelle.' '.$valeur;
//    }
//    //$collective = new Collective();
//    
//    $collCotations = $app['dao.collectivecotation']->findAll($id);
//    //var_dump($collective);
//    $titre = $collective->getCollTitre();
//    $activite = $collective->getTypeActivite()->getIDtypeActivite();
//    $date = strtotime($collective->getCollDateDebut());//        
//    $objectif = $collective->getObjectif()->getIDobjectif();
//    $adherent = $collective->getAdherent()->getIDadherent();
//    //$secteur = $collective->getObjectif()->getIDsecteur();
//    $denivele = $collective->getCollDenivele();
//    
//    
//    $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $secteurList), $collective, array('data' => array( 'collTitre' => $titre,
//                                                                                                                                                       'typeActivite' => $activite,
//                                                                                                                                                       'collDateDebut' => $date,
//                                                                                                                                                       'objectif' => $objectif ,
//                                                                                                                                                       'adherent' => $adherent,
//                                                                                                                                                       //'secteur' => $secteur,
//                                                                                                                                                       'collDenivele' => $denivele
//                                                                                                                                                          ) ) );
//    $activiteForm->handleRequest($request);
//    
//    if($activiteForm->isSubmitted()) {
//        //$collective = new Collective();
//        
//        //var_dump($_POST);
//        $IDactivite = $_POST['collective']['typeActivite'];
//        $newtypeactivite = $app['dao.typeactivite']->find($IDactivite);
//        //var_dump($typeactivite);
//        $newcollTitre  = $_POST['collective']['collTitre'];
//               
//        $newcollDateDebut = $_POST['collective']['collDateDebut']; 
//        $IDobjectif = $_POST['collective']['objectif'];
//        $newobjectif = $app['dao.objectif']->find($IDobjectif);
//        
//        $IDadherent= $_POST['collective']['adherent'];
//        $newadherent = $app['dao.adherent']->find($IDadherent);
//        
//        
//        $collective->setCollTitre($newcollTitre);
//        $collective->setTypeActivite($newtypeactivite);
//        $collective->setCollDateDebut($newcollDateDebut);
//        $collective->setObjectif($newobjectif);
//        $collective->setAdherent($newadherent);
//        
//        //var_dump($collective);
//        $app['dao.collective']->save($collective);
//        
//        $collCotation = new CollectiveCotation();
//        
//        if(is_numeric($_POST['collective']['cotation'])) {
//            $IDnewCotation = $_POST['collective']['cotation'];
//            $newCotation = $app['dao.cotation']->find($IDnewCotation);
//            $collCotation->setCotation($newCotation);
//            $collCotation->setIDcollective($id);
//            $app['dao.collectivecotation']->save($collCotation);
//        }
//        
//        //$idcoll = $collective->getIDcollective();
//        return $app->redirect('/modificationCollective/'.$id);
//    }
//    $activiteFormView = $activiteForm->createView();
//    
//    $CotSupprSubmitForm = $app['form.factory']->create(new CollCotSupprType($app['url_generator']));
//    $CotSupprSubmitForm->handleRequest($request);
//    $CotSupprSubmitFormView = $CotSupprSubmitForm->createView();
//    
//    $fil = ' / Creation d\'une nouvelle collective';
//    return $app['twig']->render('modificationCollective.html.twig', array('fil' => $fil, 
//                                                                           'activiteFormView' => $activiteFormView, 
//                                                                           'cotations' => $collCotations,
//                                                                           'CotSupprSubmitFormView' =>$CotSupprSubmitFormView, 
//                                                                           'collective' =>$collective,
//                                                                           ));
//})->bind('modificationCollective');




/**********************************************************************************************************************/



//reçoit une requete de suppression CollectiveCotation et renvoi vers la page de modification
$app->match('/CollectiveCotationAsuppr/', function(Request $request) use($app) {
    $IDcollective = $_POST['IDcollAsuppr'];
    $IDcotation = $_POST['cotationAsuppr'];
    $app['dao.collectivecotation']->delete($IDcollective, $IDcotation );
    return $app->redirect('/modificationCollective/'.$IDcollective);
})->bind('CollectiveCotationAsuppr');

//reçoit une requete de suppression Collective et renvoi vers l'index
$app->match('/CollectiveAsuppr/', function(Request $request) use($app) {
    $IDcollective = $_POST['IDcollAsuppr'];
    $app['dao.collective']->delete($IDcollective);
    return $app->redirect('/');
})->bind('CollectiveAsuppr');

$app->match('/desinscription/', function(Request $request) use($app) {
    $IDcollective = $_POST['IDcollective'];
    $IDadherent = $_POST['IDadherent'];
    $app['dao.participant']->delete($IDadherent, $IDcollective);
    return $app->redirect('/fichecollective/'.$IDcollective);
})->bind('desinscription');

$app->match('/validerInscription/', function(Request $request) use($app) {
    $IDadherent = $_POST['IDadherentValide'];
    $IDcollective = $_POST['IDcollectiveValide'];
    $app['dao.participant']->updateEtat(2, $IDcollective, $IDadherent);
    return $app->redirect('/fichecollective/'.$IDcollective);
})->bind('validerInscription');


$app->match('/cotation/', "Agenda\Controller\CotationListController::cotationListAction")->bind('cotation');
