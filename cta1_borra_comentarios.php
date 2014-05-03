<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$borra1=$link->prepare("DELETE from ctra1_comentarios WHERE idcomenta=? and idpras=? ");
	$borra1->execute(array($_GET['idc'], $_GET['idu']));

	$result1=$link->prepare("SELECT nom_arch FROM ctra1_comentarios_arch WHERE idcomenta=? and idpras=? ");
	$result1->execute(array($_GET['idc'], $_GET['idu']));
	$row_count1=$result1->rowCount();

	$ruta='archs/';
	if ($row_count1>0){
		while($row1=$result1->fetch(PDO::FETCH_ASSOC)) {
			if(file_exists($ruta.$row1['nom_arch'])) {
				unlink($ruta.$row1['nom_arch']);
			}
		}
	}

	$borra2=$link->prepare("DELETE from ctra1_comentarios_arch WHERE idcomenta=? and idpras=? ");
	$borra2->execute(array($_GET['idc'], $_GET['idu']));

	$link=null;

	header('Location: cta1_comentarios.php?idu='.$_GET['idu']);
?>
