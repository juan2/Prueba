<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$borra1=$link->prepare("DELETE from ctra1_fav_reportes WHERE id_rep=? and id_us=? ");
	$borra1->execute(array($_GET['id_r'], $_SESSION['MM_IdUsuario']));

	$link=null;

	header('Location: cta1_rep_prdefin.php');
?>