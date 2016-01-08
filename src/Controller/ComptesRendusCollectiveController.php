<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Agenda\Domain\Collective;
use Agenda\Domain\CollectiveCotation;
use Agenda\Domain\MaterielCollective;
use Agenda\Form\Type\CollectiveType;
use Agenda\Form\Type\CollCotSupprType;
use Agenda\Domain\Rdv;
use Agenda\Domain\Secteur;
use Agenda\Domain\Objectif;

/**
 * Description of EditionCollective
 *
 * @author Gilou
 */
class ComptesRendusCollectiveController extends AgendaController {
    
    /**
     * 
     * @param Request $request
     * @param Application $app
     * @return type
     */
    public function ComptesRendusCollectiveAction($id, Request $request, Application $app) {
        $nbCR = '';
        if($app['user']) {
            $IDencadrant = $app['user']->getIDadherent();
            $now = date('Ymd');
            if($app['dao.collective']->findAllCompteRenduEnAttente($IDencadrant, $now)) {
                $compteRenduEnAttente = 1;
                $nbCR = count($array = $app['dao.collective']->findAllCompteRenduEnAttente($IDencadrant, $now));
            } else {
                $compteRenduEnAttente = 0;
            }
        } else {
            $compteRenduEnAttente = 0;
        }
        
        
        $encadrantParDefaut = $app['user']->getIDadherent();
        //recuperation des toute les liste d'entité pour les select non filtré
        $activiteList = $this->findAllActivite($app);
        $objectifList = $this->findAllObjectif($app);
        $encadrantList = $this->findAllEncadrant($app);
        $cotationsList = $this->findAllcotation($app);
        $secteurList = $this->findAllSecteur($app);
        $materielList = $this->findAllMateriel($app);
        $lieuList = $this->findAllLieu($app);
        
        
        if($id == 0) {
            $collective = new Collective();
            $collCotations = '';
            $materielCollective = '';
            $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $materielList, $lieuList, $secteurList), $collective, array( 'data' => array ('adherent'=> $encadrantParDefaut  )) );
        }
        else {
            $collective = $app['dao.collective']->find($id);
            $participantValide = $app['dao.participant']->findAllValide($collective);
            $cotationsList = $this->findAllCotationByActivity($collective, $app);
            $collCotations = $app['dao.collectivecotation']->findAll($id);
            $activite = $collective->getTypeActivite()->getIDtypeActivite();
            $materielCollective = $app['dao.materielcollective']->findAll($id);
//          
            if(empty($materielCollective)) {
                $listeType = $app['dao.listtypemateriel']->findAll($activite);
                $materielCollective = $app['dao.materielcollective']->ListTypeToMaterielCollective($id, $listeType );
            }
            $titre = $collective->getCollTitre();
            $nbMax = $collective->getCollNbParticipantMax();
            
            if($collective->getCollDateDebut()) {
                $date1 = strtotime($collective->getCollDateDebut());
            }else {
                $date1 = null;
            }
            
            
            if($collective->getCollDateFin()==null) {
                $date2 = null;
            }else {
                $date2 = strtotime($collective->getCollDateFin());
            }
            
            if($collective->getCollHeureDepartTerrain()==null) {
                $collHeureDepartTerrain = null;
            }else {
                $collHeureDepartTerrain = strtotime($collective->getCollHeureDepartTerrain());
            }
            
            if($collective->getCollHeureRetourTerrain()==null) {
                $collHeureRetourTerrain = null;
            }else {
                $collHeureRetourTerrain = strtotime($collective->getCollHeureRetourTerrain());
            }
            
            if($collective->getCollDureeApproche()==null) {
                $collDureeApproche = null;
            }else {
                $collDureeApproche = strtotime($collective->getCollDureeApproche());
            }
            
            
            if($collective->getObjectif()) {
                $objectif = $collective->getObjectif()->getIDobjectif();
                $secteur = $collective->getObjectif()->getSecteur()->getIDsecteur();
            } else {
                $objectif = null;
                $secteur = null;
            }
            
            if($collective->getCollDureeCourse()==null) {
                $collDureeCourse = null;
            }else {
                $collDureeCourse = strtotime($collective->getCollDureeCourse());
            }
            
            if($collective->getCollDureeCourse()==null) {
                $collDureeCourseAlpi = null;
            }else {
                $collDureeCourseAlpi = strtotime($collective->getCollDureeCourse());
            }
            
            
            $observation = $collective->getCollObservations();
            $adherent = $collective->getAdherent()->getIDadherent();
            
            $denivele = $collective->getCollDenivele();
            $activiteForm = $app['form.factory']->create(new CollectiveType($activiteList, $objectifList, $encadrantList, $cotationsList, $materielList, $lieuList, $secteurList), $collective, array('data' => array ( 'collTitre' => $titre,
                                                                                                                                                                                                                       'typeActivite' => $activite,
                                                                                                                                                                                                                       'collDateDebut' => $date1,
                                                                                                                                                                                                                       'collDateFin' => $date2,
                                                                                                                                                                                                                       'objectif' => $objectif ,
                                                                                                                                                                                                                       'observation' => $observation,
                                                                                                                                                                                                                       'adherent' => $adherent,
                                                                                                                                                                                                                       'secteur' => $secteur,
                                                                                                                                                                                                                       'collDenivele' => $denivele,
                                                                                                                                                                                                                       'nbMax' => $nbMax,
                                                                                                                                                                                                                       'collHeureDepartTerrain' => $collHeureDepartTerrain,
                                                                                                                                                                                                                       'collHeureRetourTerrain' => $collHeureRetourTerrain,
                                                                                                                                                                                                                       'collConditionMeteo' => $collective->getCollConditionMeteo(),
                                                                                                                                                                                                                       'coll_incident_accident' => $collective->getColl_incident_accident(),
                                                                                                                                                                                                                       'collInfoComplementaire' => $collective->getCollInfoComplementaire(),
                                                                                                                                                                                                                       'collDureeApproche' => $collDureeApproche,
                                                                                                                                                                                                                       'collDureeCourse' => $collDureeCourse,
                                                                                                                                                                                                                       'collDureeCourseAlpi' => $collDureeCourseAlpi,
                                                                                                                                                                                                                       'collCondition_neige_rocher_glace' => $collective->getCollCondition_neige_rocher_glace()
                                                                                                                                                                                                                       )));
        }
        $activiteForm->handleRequest($request);

        if($activiteForm->isSubmitted()) {
            
            $idcoll = $this->traitementEdition($collective, $request, $app);
            $this->creerCompteRendu($idcoll, $request, $app);
            return $app->redirect('/CompteRendu/'.$idcoll); 
        }

        $activiteFormView = $activiteForm->createView();
        $CotSupprSubmitForm = $app['form.factory']->create(new CollCotSupprType($app['url_generator']));
        $CotSupprSubmitForm->handleRequest($request);
        $CotSupprSubmitFormView = $CotSupprSubmitForm->createView();
        $activites = $app['dao.typeactivite']->findAll();
        $fil = ' / Creation d\'une nouvelle collective';
        return $app['twig']->render('ComptesRendusCollective.html.twig', array('fil' => $fil, 
                                                                               'activiteFormView' => $activiteFormView, 
                                                                               'cotations' => $collCotations,
                                                                               'CotSupprSubmitFormView' =>$CotSupprSubmitFormView, 
                                                                               'collective' =>$collective,
                                                                               'materielCollective' => $materielCollective,
                                                                               'participantValide' => $participantValide,
                                                                               'activites' => $activites,
                                                                               'compteRenduEnAttente' => $compteRenduEnAttente,
                                                                               'nbCR' => $nbCR
                                                                               ));
    }
    
    
    public function traitementEdition(Collective $collective, Request $request , Application $app ) {
        $IDactivite = $request->get('collective')['typeActivite'];
        $typeactivite = $app['dao.typeactivite']->find($IDactivite);
        $collTitre  = $request->get('collective')['collTitre'];
        $collDenivele = $request->get('collective')['collDenivele'];
        $collDateDebut = date('Y-m-d', strtotime($request->get('collective')['collDateDebut']));
        $collDateFin = NULL;
        if($request->get('collective')['collDateFin'] != '') {
            $collDateFin = date('Y-m-d', strtotime($request->get('collective')['collDateFin']));
        }
        
        
        if(is_numeric($request->get('collective')['secteur'])){
            $secteur = $app['dao.secteur']->find($request->get('collective')['secteur']);
        } else {
            $secteur = new Secteur;
            $secteur->setSecteurLibelle($request->get('collective')['secteur']);
            $app['dao.secteur']->save($secteur);
        }
        
        if(is_numeric($request->get('collective')['objectif'])) {
            $IDobjectif = $request->get('collective')['objectif'];
            $objectif = $app['dao.objectif']->find($IDobjectif);
            $objectif->setSecteur($secteur);
            $app['dao.objectif']->save($objectif);
        }else {
            $objectif = new Objectif;
            $objectif->setObjectifLibelle($request->get('collective')['objectif']);
//            $secteur = $app['dao.secteur']->find(1);
            $objectif->setSecteur($secteur);
            $app['dao.objectif']->save($objectif);
            
        }
        
        $IDadherent= $request->get('collective')['adherent'];
        $adherent = $app['dao.adherent']->find($IDadherent);
        
        $collHeureDepartTerrain = $request->get('collective')['collHeureDepartTerrain'];
        $collHeureRetourTerrain = $request->get('collective')['collHeureRetourTerrain'];
        $collConditionMeteo = $request->get('collective')['collConditionMeteo'];
        $coll_incident_accident = $request->get('collective')['coll_incident_accident'];
        $collInfoComplementaire = $request->get('collective')['collInfoComplementaire'];
        $collDureeApproche = $request->get('collective')['collDureeApproche'];
        if(isset($request->get('collective')['collDureeCourse'])) {
            $collDureeCourse = $request->get('collective')['collDureeCourse'];
        } else {
            $collDureeCourse = $request->get('collective')['collDureeCourseAlpi'];
        }
        $collCondition_neige_rocher_glace =  $request->get('collective')['collCondition_neige_rocher_glace'];
        $collCR_Horodateur = date('Y-m-d H:i:s');

        $collective->setCollTitre($collTitre);
        $collective->setTypeActivite($typeactivite);
        $collective->setCollDateDebut($collDateDebut);
        $collective->setCollDatefin($collDateFin);
        $collective->setObjectif($objectif);
        $collective->setAdherent($adherent);
        $collective->setCollDenivele($collDenivele);
        
        $collective->setCollHeureDepartTerrain($collHeureDepartTerrain);
        $collective->setCollHeureRetourTerrain($collHeureRetourTerrain);
        $collective->setCollConditionMeteo($collConditionMeteo);
        $collective->setColl_incident_accident($coll_incident_accident);
        $collective->setCollInfoComplementaire($collInfoComplementaire);
        $collective->setCollDureeApproche($collDureeApproche);
        $collective->setCollDureeCourse($collDureeCourse);
        $collective->setCollCondition_neige_rocher_glace($collCondition_neige_rocher_glace);
        
        $collective->setCollCR_Horodateur($collCR_Horodateur);
        
        $app['dao.collective']->save($collective);
        $idcoll = $collective->getIDcollective();

        if(is_numeric($request->get('collective')['cotation'])) {
            $collCotation = new CollectiveCotation();
            $IDnewCotation = $request->get('collective')['cotation'];
            $newCotation = $app['dao.cotation']->find($IDnewCotation);
            $collCotation->setCotation($newCotation);
            $collCotation->setIDcollective($idcoll);
            $app['dao.collectivecotation']->save($collCotation);
        }
        
        if(is_numeric($request->get('collective')['MaterielCollective'])) {
            $materielCollective = new MaterielCollective();
            $IDtypeMat = $request->get('collective')['MaterielCollective'];
            $typeMateriel = $app['dao.typemateriel']->find($IDtypeMat);
            $materielCollective->setTypeMateriel($typeMateriel);
            $materielCollective->setIDcollective($idcoll);
            $app['dao.materielcollective']->save($materielCollective);
        }
        if(!empty($request->get('collective')['heureRDV']) && !empty($request->get('collective')['lieuRDV'])) {
            $rdv = new Rdv;
            $horaireRecu = $request->get('collective')['heureRDV'];
            $heureRDV = $horaireRecu.':00';
            $IDlieu = $request->get('collective')['lieuRDV'];
            $lieu = $app['dao.lieu']->find($IDlieu);
            $rdv->setHeureRDV($heureRDV);
            $rdv->setLieu($lieu);
            $rdv->setIDcollective($idcoll);
            $app['dao.rdv']->save($rdv);
        }
        return $idcoll;
    }
    
    public function creerCompteRendu($idcoll, Request $request, Application $app) {
        $collective = $app['dao.collective']->find($idcoll);
        $typeActivite = $collective->getTypeActivite()->getActiviteLibelle();
        $encadrant = $collective->getAdherent()->getPrenomAdherent().' '.$collective->getAdherent()->getNomAdherent();
        $dateDebut = $collective->getCollDateDebut();
        
        
        $materielCollective = $request->get('MaterielCollective');
        $materielList = '';
        foreach ($materielCollective as $materiel)
        {
            $materielList .= $materiel.' - ';
        }
        $participants = $request->get('participant');
        $participantList = '';
        foreach ($participants as $participant)
        {
            $participantList .= $participant.' - ';
        }
        $cotation = $request->get('cotation')[1];
        
        if(file_exists('comptes rendus/'.utf8_decode($typeActivite).'.xlsx')) {
            $objPHPExcel = \PHPExcel_IOFactory::load('dir2/'.utf8_decode($typeActivite).'.xlsx');
            $sheet = $objPHPExcel->setActiveSheetIndex(0);
            $lastEntry = $sheet->getHighestDataRow();
            $row = $lastEntry+1;
        }
        else {
            $objPHPExcel = new \PHPExcel();
            $row = 2;
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("$encadrant")
                                         ->setLastModifiedBy("$encadrant")
                                         ->setTitle("Compte rendu test")
                                         ->setSubject("Compte rendu test")
                                         ->setDescription("Compte rendu test")
                                          ->setKeywords("Compte rendu test")
                                         ->setCategory("Compte rendu test");
            // Add Data in your file
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Horodateur')
                        ->setCellValue('B1', 'Activité')
                        ->setCellValue('C1', 'Nom et prénom du responsable de sortie')
                        ->setCellValue('D1', 'Date de sortie (premier jour)')
                        ->setCellValue('E1', 'Date de sortie (dernier jour)')
                        ->setCellValue('F1', 'Secteur')
                        ->setCellValue('G1', 'But')
                        ->setCellValue('H1', 'Heure de départ sur le terrain')
                        ->setCellValue('I1', 'Heure de retour sur le terrain')
                        ->setCellValue('J1', 'Durée de l\'approche')
                        ->setCellValue('K1', 'Durée de la course (hors approche et retour)')
                        ->setCellValue('L1', 'Cotation')
                        ->setCellValue('M1', 'Conditions météo')
                        ->setCellValue('N1', 'Conditions neige / rocher / glace')
                        ->setCellValue('O1', 'Matériel utilisé')
                        ->setCellValue('P1', 'Incidents/Accidents?')
                        ->setCellValue('Q1', 'Observations particulières (sécurité, balisage, refuge, accès, comportement, etc.)')
                        ->setCellValue('R1', 'Participants');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row.'', $collective->getCollCR_Horodateur());
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row.'', $typeActivite);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row.'', $encadrant);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row.'', $dateDebut);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row.'', $collective->getCollDatefin());
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row.'', $collective->getObjectif()->getSecteur()->getSecteurLibelle());
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row.'', $collective->getObjectif()->getObjectifLibelle());
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row.'', $collective->getCollHeureDepartTerrain());
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$row.'', $collective->getCollHeureRetourTerrain());
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row.'', $collective->getCollDureeApproche());
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$row.'', $collective->getCollDureeCourse());
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$row.'', $cotation);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$row.'', $collective->getCollConditionMeteo());
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$row.'', $collective->getCollCondition_neige_rocher_glace());
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$row.'', $materielList);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$row.'', $collective->getColl_incident_accident());
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row.'', $collective->getCollInfoComplementaire());
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row.'', $participantList);
        $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
//        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Compte Rendu');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save Excel 2007 file
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if(!file_exists('comptes rendus')) {
            mkdir('comptes rendus', 0777);
        }
        $objWriter->save('comptes rendus/'.utf8_decode($typeActivite).'.xlsx');
    }
    
    public function supprimerCotationAction(Request $request, Application $app) {
        $IDcollective = $request->get('IDcollAsuppr');
        $IDcotation =  $request->get('cotationAsuppr');
        $app['dao.collectivecotation']->delete($IDcollective, $IDcotation );
        return $app->redirect('/CompteRendu/'.$IDcollective);
    }
    
    public function supprimerMaterielAction(Request $request, Application $app) {
        $IDcollective = $request->get('IDcollAsuppr');
        $IDtypeMat =  $request->get('materielAsuppr');
        $app['dao.materielcollective']->delete($IDcollective, $IDtypeMat );
        return $app->redirect('/CompteRendu/'.$IDcollective);
    }
}
