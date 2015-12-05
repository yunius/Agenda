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
 * Description of ListTypeMaterielController
 *
 * @author inpiron
 */
class ListTypeMaterielController {
    
    public function listTypeMaterielAction(Request $request, Application $app) {
        
        if($request->get('idA')) {
            if($request->get('materielAsuppr')) {
                $IDaSuppr = $request->get('materielAsuppr');
            }else{
                $IDaSuppr = '';
            }
            $htmlOutput = '';
            $idtypeActivite=$request->get('idA');
            $typeMateriels = $app['dao.listtypemateriel']->findAll($idtypeActivite);
            

            foreach ($typeMateriels as $typeMateriel) {
                $libelle = $typeMateriel->getTypeMateriel()->getTypeMatLibelle();
                $ID = $typeMateriel->getTypeMateriel()->getIDtypeMat();
                if($ID != $IDaSuppr) {
                    $htmlOutput .='<div class="col-md-6 cartouchePieceMat listMatEdit">
                                    '.$libelle.'
                                    <span class="pull-right" data-toggle="tooltip" data-trigger="hover" title="Supprimer cet equipement">
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#SuppCotDialog'.$ID.'"><span class="glyphicon glyphicon-remove"></span></button>
                                    </span>
                                    </div>

                                    <div class="modal fade" id="SuppCotDialog'.$ID.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                Voulez vous vraiment supprimer l\'equipement "'.$libelle.'"?
                                            </div>
                                            <div class="modal-footer">
                                                <form></form>
                                                <form id="MatTempDeleteForm" method="post">
                                                    <input id="materielAsuppr" type="hidden" name="materielAsuppr" value="'.$ID.'" />
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button  form="MatTempDeleteForm" type="submit" class="btn btn-danger">Confirmer</button>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->';
                }
            }
                
            return $htmlOutput;
        }
    }
}
