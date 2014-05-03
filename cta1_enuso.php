<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	if ($_SESSION['MM_UserGroupID']!=1){
		header('Location: salir.php');
		exit();
	}

	$link=Conectarse();

	if($_GET['est']==0){
		$est=1;
	}else{
		$est=0;
	}

	$actual=$link->prepare("UPDATE ctra1_catalogos set enuso=? WHERE id_unico=? and tp=? ");
	$actual->execute(array($est, $_GET['id_ct'], $_GET['tp']));

	$link=null;
	$pag_redirecciona="cta1_catalogos.php?tp=".$_GET['tp']."&ex=".$_GET['id_ct']."#".$_GET['id_ct'];
	header("Location: $pag_redirecciona");
?>