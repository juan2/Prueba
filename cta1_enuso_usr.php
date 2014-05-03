<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	if($_GET['est']==0){
		$est=1;
	}else{
		$est=0;
	}


	$actual=$link->prepare("UPDATE ctra1_ct_usuarios set enuso=? WHERE idusuario=? ");
	$actual->execute(array($est, $_GET['id_ct']));

	$link=null;
	header('Location: cta1_cat_usuarios.php?ex='.$_GET['id_ct'].'#'.$_GET['id_ct']);
?>