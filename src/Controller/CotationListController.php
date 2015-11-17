<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of newPHPClass
 *
 * @author Gilou
 */
class CotationListController {
    
    
    public function cotationListAction(Request $request, Application $app) {
        
        if($_POST['idA']) {
            $htmlOutput = '';
            $idtypeActivite=$_POST['idA'];
            $cotations = $app['dao.cotationList']->findAllByTypeActivite($idtypeActivite);
            //$cotationsList = array();
            
            $htmlOutput ='<option selected="selected">-cotation à ajouter-</option>';

            foreach ($cotations as $cotation) {
                $IDcotation = $cotation->getCotation()->getIDcotation();
                $libelle = $cotation->getCotation()->getLibelleCotation();
                $valeur = $cotation->getCotation()->getValeurCotation();
                //$cotationsList[$IDcotation] =$libelle.' '.$valeur;
                $htmlOutput .= '<option value='.$IDcotation.'>'.$libelle.' - '.$valeur.'</option>';
            }
            return $htmlOutput;
        }
    }
}
