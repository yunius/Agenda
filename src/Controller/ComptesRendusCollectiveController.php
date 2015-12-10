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
            
            if($collective->getObjectif()) {
                $objectif = $collective->getObjectif()->getIDobjectif();
                $secteur = $collective->getObjectif()->getSecteur()->getIDsecteur();
            } else {
                $objectif = null;
                $secteur = null;
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
                                                                                                                                                                                                                       'nbMax' => $nbMax
                                                                                                                                                                                                                       )));
        }
        $activiteForm->handleRequest($request);

        if($activiteForm->isSubmitted()) {
//            $typeActivite = $collective->getTypeActivite()->getActiviteLibelle();
//            $encadrant = $collective->getAdherent()->getPrenomAdherent().' '.$collective->getAdherent()->getNomAdherent();
//            $dateDebut = $collective->getCollDateDebut();
//            if(file_exists('comptes rendus/'.utf8_decode($typeActivite).'.xlsx')) {
//                $objPHPExcel = \PHPExcel_IOFactory::load('dir2/'.utf8_decode($typeActivite).'.xlsx');
//                $sheet = $objPHPExcel->setActiveSheetIndex(0);
//                $lastEntry = $sheet->getHighestDataRow();
//                $row = $lastEntry+1;
//            }
//            else {
//                $objPHPExcel = new \PHPExcel();
//                $row = 2;
//                // Set document properties
//                $objPHPExcel->getProperties()->setCreator("$encadrant")
//                                             ->setLastModifiedBy("$encadrant")
//                                             ->setTitle("Compte rendu test")
//                                             ->setSubject("Compte rendu test")
//                                             ->setDescription("Compte rendu test")
//                                              ->setKeywords("Compte rendu test")
//                                             ->setCategory("Compte rendu test");
//                // Add Data in your file
//                $objPHPExcel->setActiveSheetIndex(0)
//                            ->setCellValue('A1', 'Titre')
//                            ->setCellValue('B1', 'date')
//                            ->setCellValue('C1', 'activité')
//                            ->setCellValue('D1', 'encadrant');
//            }
//            
//            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row.'', $collective->getCollTitre());
//            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row.'', $dateDebut);
//            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row.'', $typeActivite);
//            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row.'', $encadrant);
//            $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
//            $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);



//            // Rename worksheet
//            $objPHPExcel->getActiveSheet()->setTitle('Compte Rendu');
//
//
//            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
//            $objPHPExcel->setActiveSheetIndex(0);
//
//
//            // Save Excel 2007 file
//
//            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//            if(!file_exists('comptes rendus')) {
//                mkdir('comptes rendus', 0777);
//            }
//            $objWriter->save('comptes rendus/'.utf8_decode($typeActivite).'.xlsx');
            
            
            $idcoll = $this->traitementEdition($collective, $request, $app);
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
                                                                               'activites' => $activites
                                                                               ));
    }
    
    
    public function traitementEdition(Collective $collective, Request $request , Application $app ) {
        
        
        
        $IDactivite = $request->get('collective')['typeActivite'];
        $typeactivite = $app['dao.typeactivite']->find($IDactivite);
        $collTitre  = $request->get('collective')['collTitre'];
        $observation = $request->get('collective')['observation'];
        $collDenivele = $request->get('collective')['collDenivele'];
        $collDateDebut = date('Y-m-d', strtotime($request->get('collective')['collDateDebut']));
        $collDateFin = NULL;
        if($request->get('collective')['collDateFin'] != '') {
            $collDateFin = date('Y-m-d', strtotime($request->get('collective')['collDateFin']));
        }
        $nbMax = $request->get('collective')['nbMax'];
        
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

        $collective->setCollTitre($collTitre);
        $collective->setCollObservations($observation);
        $collective->setTypeActivite($typeactivite);
        $collective->setCollDateDebut($collDateDebut);
        $collective->setCollDatefin($collDateFin);
        $collective->setObjectif($objectif);
        $collective->setAdherent($adherent);
        $collective->setCollDenivele($collDenivele);
        $collective->setCollNbParticipantMax($nbMax);

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
