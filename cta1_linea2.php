<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$query1="SELECT co.idcomenta, co.idpras, co.id_estatus, co.id_presuntores, co.comentario, date_format(co.fechaalta,'%Y,%m,%d') as fechaalta,  ";
	$query1.="us.nombre, ";
	$query1.="ct1.concepto as concepto1, ";
	$query1.="ct2.concepto as concepto2 ";
	$query1.="FROM ctra1_comentarios co ";
	$query1.="LEFT JOIN ctra1_ct_usuarios us ON us.idusuario=co.id_us ";
	$query1.="LEFT JOIN ctra1_catalogos ct1 ON ct1.id_unico=co.id_estatus ";
	$query1.="LEFT JOIN ctra1_catalogos ct2 ON ct2.id_unico=co.id_presuntores ";
	$query1.="WHERE co.idpras=? ";
	$query1.="ORDER BY co.fechaalta ";
	$result1=$link->prepare($query1);
	$result1->execute(array($_GET['idu']));
	$result1->setFetchMode(PDO::FETCH_ASSOC);
	$row1=$result1->fetchAll();
	$row_count1=$result1->rowCount();

/*
	$result99="SELECT com.IdComenta, com.Comentario, date_format(com.FechaAlta,'%Y,%m,%d') as Fecha1, ";
	$result99.="u.Nombre, ";
	$result99.="st.Status ";
	$result99.=" FROM cyn_ac_comentarios com ";
	$result99.=" LEFT JOIN Usuarios u ON u.IdUsuario = com.QuienAlta ";
	$result99.=" LEFT JOIN cyn_ac_ct_status st ON st.IdStatus = com.status ";
	$result99.=" WHERE com.IdApoyo=".$_GET['id']." ";
	$result99.=" ORDER BY com.FechaAlta ";
	$rsComenta=mysql_query($result99,$link);
*/

	if ($row_count1>0){
		foreach ($row1 as $row) {
			$fechainicial=$row['fechaalta'];
			break;
#			echo $row['fechaalta'];

		}
	}
#	$fechainicial="2013,03,11";


	$result2=$link->prepare("SELECT pras FROM ctra1_pras WHERE id_unico=? ");
	$result2->execute(array($_GET['idu']));
	$objrs2=$result2->fetchObject();

	$_json = array();

	if ($row_count1>0){

		$_json = array('timeline'=>array(
			"headline"=>strip_tags($objrs2->pras),
			"type"=>"default",
			"text"=>strip_tags($objrs2->pras),
			"startDate"=>$fechainicial,
			"date" =>array()
		));

		foreach ($row1 as $row) {
			$result3=$link->prepare("SELECT * FROM ctra1_comentarios_arch WHERE idcomenta=? and idpras=? ORDER BY id_archivo LIMIT 1 ");
			$result3->execute(array($row['idcomenta'], $_GET['idu']));
			$objrs3=$result3->fetchObject();
			$row_count3=$result3->rowCount();

			if ($row_count3>0){
				$imagen_temp='archs/'.$objrs3->nom_arch;
			}else{
				$imagen_temp='';
			}

			$_json['timeline']['date'][]=array(
					"startDate"=>$row['fechaalta'],
					"headline"=>$row['nombre'].' - '.$row['concepto1'],
//strip_tags(substr($row['Comentario'], 0,50))
					"text"=>$row['comentario'],
					"asset"=>array(
							"media"=>$imagen_temp,
							"credit"=>"",
							"caption"=>""
						)
			);
		}
	}

	$link=null;

	echo json_encode($_json);
?>