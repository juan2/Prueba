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
		$actual=$link->prepare("UPDATE ctra1_catalogos set concepto=? WHERE id_unico=? and tp=? ");
		$actual->execute(array(trim($_POST['campo1']), $_POST['id_ct'], $_POST['tp']));

		$pag_redirecciona="cta1_catalogos.php?tp=".$_POST['tp']."&ex=".$_POST['id_ct']."#".$_POST['id_ct'];
	}else{
		$pag_redirecciona="cta1_catalogos.php?tp=".$_POST['tp']."&ex=".$_POST['id_ct']."&cod=2#".$_POST['id_ct'];
	}

	$link=null;
	header("Location: $pag_redirecciona");
?>