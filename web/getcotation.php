<?php
include('dbconfig.php');
if($_POST['idA'])
{
	$id=$_POST['idA'];
		
	$stmt = $DB_con->prepare("SELECT * FROM liste_de_cotation 
                                           JOIN cotation ON  liste_de_cotation.IDcotation = cotation.IDcotation
                                  WHERE IDtypeActivite=:id
                                  ORDER BY LibelleCotation");
	$stmt->execute(array(':id' => $id));
	?><option selected="selected">-cotation à ajouter-</option><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <option value="<?php echo $row['IDcotation']; ?>"><?php echo $row['LibelleCotation']; ?> - <?php echo $row['ValeurCotation']; ?></option>
        <?php
	}
}

//use Agenda\Domain\CotationList;
//use Agenda\DAO\CotationListDAO;
//
//if($_POST['idA']) {
//    $cotationlistDAO = new CotationListDAO;
//    $idtypeActivite=$_POST['idA'];
//    $cotations = $cotationlistDAO->findAllByTypeActivite($idtypeActivite);
//    //$cotationsList = array();
//    ?><!--<option selected="selected">-cotation à ajouter-</option><?php
//    foreach ($cotations as $cotation) {
//        $IDcotation = $cotation->getCotation()->getIDcotation();
//        $libelle = $cotation->getCotation()->getLibelleCotation();
//        $valeur = $cotation->getCotation()->getValeurCotation();
//        //$cotationsList[$IDcotation] =$libelle.' '.$valeur;
//        ?><option value="<?php //echo $IDcotation; ?>"><?php //echo $libelle; ?> - <?php //echo $valeur; ?></option><?php
//    }
//}
