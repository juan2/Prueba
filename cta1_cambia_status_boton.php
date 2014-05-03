<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$estatus=$_GET['est'];
	$fecha=date('Y-m-d');

	$actual=$link->prepare("UPDATE ctra1_pras set id_estatus=? WHERE id_unico=? ");
	$actual->execute(array($_GET['est'], $_GET['idu']));

	$link=null;
	switch ($_GET['pag']) {
	case '1':
		$pag_redirecciona="cta1_rep_basico.php?page=".$_GET['page'].'#'.$_GET['idu'];
		break;
	case '2':
		$pag_redirecciona="cta1_rep_per.php?page=".$_GET['page'].'#'.$_GET['idu'];
		break;
	}

	header("Location: $pag_redirecciona");
?>