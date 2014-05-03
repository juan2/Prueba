<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	if ($_SESSION['MM_UserGroupID']!=1){
		header('Location: salir.php');
		exit();
	}

	$link=Conectarse();

	if ($_POST['campo1']!="") {
		$inserta=$link->prepare("INSERT INTO ctra1_catalogos (concepto, enuso, tp) values (:campo1, :campo2, :campo3) ");
		$inserta->execute(array(":campo1"=>trim($_POST['campo1']), ":campo2"=>1, ":campo3"=>$_POST['tp']));

		$pag_redirecciona="cta1_catalogos.php?tp=".$_POST['tp']."&cod=1";
	}else{
		$pag_redirecciona="cta1_catalogos.php?tp=".$_POST['tp']."&cod=2";
	}

#	$borrar=$link->prepare("DELETE FROM ar_pedimento2 WHERE id_facts=:id_facts and id_pedimento=:id_pedimento ");
#	$borrar->execute(array(":id_facts"=>$_GET['idf'], ":id_pedimento"=>$_GET['idp']));
#	$ultimo_id=$link->lastInsertId();

	$link=null;
	header("Location: $pag_redirecciona");
?>