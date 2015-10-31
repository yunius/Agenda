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
	?><option selected="selected">selectionner cotation :</option><?php
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		?>
        <option value="<?php echo $row['IDcotation']; ?>"><?php echo $row['LibelleCotation']; ?> - <?php echo $row['ValeurCotation']; ?></option>
        <?php
	}
}

