<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$actualiza1=$link->prepare("UPDATE ctra1_pras SET eliminado=:eliminado WHERE id_unico=:id_unico ");
	$actualiza1->execute(array(":eliminado"=>$_GET['est'], ":id_unico"=>$_GET['idu']));

	$link=null;

	switch ($_GET['pag']) {
	case '1':
		$pag_redirecciona="cta1_rep_basico.php?page=".$_GET['page'];
		break;
	case '2':
		$pag_redirecciona="cta1_rep_per.php?page=".$_GET['page'];
		break;
	}

	header("Location: $pag_redirecciona");
?>
