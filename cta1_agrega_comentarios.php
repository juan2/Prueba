<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	if($_POST['campo3']!='') {
		$campo3=trim($_POST['campo3']);
	}else{
		$campo3='-';
	}

	$fecha_alta = date('Y-m-d');
	$fecha_completa = date('Y-n-j H:i:s');
	$link=Conectarse();
#idcomenta



	$inserta=$link->prepare("INSERT INTO ctra1_comentarios (idpras, id_estatus, id_presuntores, comentario, fechaalta, id_us) values (:idu, :campo1, :campo2, :campo3, :fecha_completa, :id_us) ");
	$inserta->execute(array(":idu"=>$_POST['idu'], ":campo1"=>$_POST['campo1'], ":campo2"=>$_POST['campo2'], ":campo3"=>$campo3, ":fecha_completa"=>$fecha_alta, ":id_us"=>$_SESSION['MM_IdUsuario']));

	$ultimo_id=$link->lastInsertId();

	$fecha_cambio_estatus='';
	if($_POST['estatus_original']!=$_POST['campo1']) {
		$fecha_cambio_estatus=", fecha_cambio_estatus='$fecha_completa' ";
	}

	$actual=$link->prepare("UPDATE ctra1_pras set id_estatus=?, id_presuntores=? $fecha_cambio_estatus WHERE id_unico=? ");
	$actual->execute(array($_POST['campo1'], $_POST['campo2'], $_POST['idu']));


#	$result1=$link->prepare("SELECT idusuario FROM ctra1_ct_usuarios WHERE enuso=1 and idusuario<>? ORDER BY idusuario ");
#	$result1->execute(array($_SESSION['MM_IdUsuario']));
	$result1=$link->query("SELECT idusuario FROM ctra1_ct_usuarios WHERE enuso=1 ORDER BY idusuario ");
	$row_count1=$result1->rowCount();

	if ($row_count1>0){
		while($row=$result1->fetch(PDO::FETCH_ASSOC)) {
			$result2=$link->prepare("SELECT idnotifica FROM ctra1_notifica WHERE idapoyo=? and idusuario=? and leido=0 ");
			$result2->execute(array($_POST['idu'], $row['idusuario']));
			$row_count2=$result2->rowCount();

			if ($row_count2==0){
				if($_SESSION['MM_IdUsuario']==$row['idusuario']){
					$leido=1;
				}else{
					$leido=0;
				}

				$inserta=$link->prepare("INSERT INTO ctra1_notifica (idapoyo, idusuario, leido, fechaalta, quienalta) values (:idapoyo, :idusuario, :leido, :fechaalta, :quienalta) ");
				$inserta->execute(array(":idapoyo"=>$_POST['idu'], ":idusuario"=>$row['idusuario'], ":leido"=>$leido, ":fechaalta"=>$fecha_alta, ":quienalta"=>$_SESSION['MM_IdUsuario']));
			}
		}
	}


	$link=null;
	echo json_encode(array('idc'=>$ultimo_id, 'idu'=>$_POST['idu']));
#	header('Location: cyn_comentarios.php?idu='.$_POST['idu']);
?>