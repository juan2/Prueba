<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
if ($_POST['Campo5']!="" && $_POST['Campo7']!="") {
	$link=Conectarse();

	$fecha_completa = date('Y-n-j H:i:s');

	if($_POST['Campo2']!='') {
		$Campo2=trim($_POST['Campo2']);
	}else{
		$Campo2='-';
	}

	if($_POST['Campo3']!='') {
		$Campo3=trim($_POST['Campo3']);
	}else{
		$Campo3='-';
	}

	if($_POST['Campo4']!='') {
		$Campo4=trim($_POST['Campo4']);
	}else{
		$Campo4='-';
	}


	$inserta=$link->prepare("INSERT INTO ctra1_ct_usuarios (usuario, password, idprivilegio, modulo1, modulo2, modulo3, nombre, paterno, materno, iddependencia, email, fechaalta, ultimo_acceso) values (:usuario, :password, :idprivilegio, :modulo1, :modulo2, :modulo3, :nombre, :paterno, :materno, :iddependencia, :email, :fechaalta, :ultimo_acceso) ");
	$inserta->execute(array(":usuario"=>$_POST['Campo5'], ":password"=>hash('sha256', $_POST['Campo7']), ":idprivilegio"=>$_POST['tipo1'], ":modulo1"=>1, ":modulo2"=>0, ":modulo3"=>0, ":nombre"=>$Campo2, ":paterno"=>$Campo3, ":materno"=>$Campo4, ":iddependencia"=>$_POST['Campo8'], ":email"=>'-', ":fechaalta"=>$fecha_completa, ":ultimo_acceso"=>$fecha_completa));

	$idu=$link->lastInsertId();


/*	if($_POST['idu']!=0){
		$borra1=$link->prepare("DELETE from ctra1_cat_selecc WHERE id_pras=? ");
		$borra1->execute(array($_POST['idu']));
		$idu=$_POST['idu'];
	}*/

	if($_POST['tipo1']=='3') {
		$organo_ctrl=$_POST['Campo8'];

		$inserta=$link->prepare("INSERT INTO ctra1_cat_selecc (id_pras, id_refcat, id_campo) values (:id_pras, :id_refcat, :id_campo) ");
		$inserta->execute(array(":id_pras"=>$idu, ":id_refcat"=>$organo_ctrl, ":id_campo"=>5));
	}else{
		$organo_ctrl=$_POST['Campo1'];

		if(count($organo_ctrl)>0){
			foreach($organo_ctrl as $val){
				$inserta=$link->prepare("INSERT INTO ctra1_cat_selecc (id_pras, id_refcat, id_campo) values (:id_pras, :id_refcat, :id_campo) ");
				$inserta->execute(array(":id_pras"=>$idu, ":id_refcat"=>$val, ":id_campo"=>5));
			}

		}
	}


	$link=null;
	header('Location: cta1_cat_usuarios.php?cod=1');
}else{
	header('Location: cta1_cat_usuarios.php');
}
?>