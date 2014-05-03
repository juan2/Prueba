<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	if($_POST['nombre']!='') {
		$nombre=$_POST['nombre'];
	}else{
		$nombre='-';
	}

	if($_POST['params']!='') {
		$params=$_POST['params'];
	}else{
		$params='-';
	}

	$fecha_completa = date('Y-n-j H:i:s');
	$link=Conectarse();

	$inserta=$link->prepare("INSERT INTO ctra1_fav_reportes (nombre, reporte, fecha_completa, id_us) values (:nombre, :reporte, :fecha_completa, :id_us) ");
	$inserta->execute(array(":nombre"=>$nombre, ":reporte"=>$params, ":fecha_completa"=>$fecha_completa, ":id_us"=>$_SESSION['MM_IdUsuario']));

	$link=null;
	echo json_encode(array('valor'=>'grabado'));
?>