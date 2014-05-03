<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
if ($_POST['Campo5']!="") {
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


	if($_POST['Campo7']!='') {
		$actual=$link->prepare("UPDATE ctra1_ct_usuarios set usuario=?, password=?, idprivilegio=?, nombre=?, paterno=?, materno=?, iddependencia=? WHERE idusuario=? and idusuario<>24 ");
		$actual->execute(array($_POST['Campo5'], hash('sha256', $_POST['Campo7']), $_POST['tipo1'], $Campo2, $Campo3, $Campo4, $_POST['Campo8'], $_POST['id_ct']));
	}else{
		$actual=$link->prepare("UPDATE ctra1_ct_usuarios set usuario=?, idprivilegio=?, nombre=?, paterno=?, materno=?, iddependencia=? WHERE idusuario=? and idusuario<>24 ");
		$actual->execute(array($_POST['Campo5'], $_POST['tipo1'], $Campo2, $Campo3, $Campo4, $_POST['Campo8'], $_POST['id_ct']));
	}

	$borra1=$link->prepare("DELETE from ctra1_cat_selecc WHERE id_pras=? and id_campo=5 ");
	$borra1->execute(array($_POST['id_ct']));
	$idu=$_POST['id_ct'];


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