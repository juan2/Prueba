<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	if($_POST['campo1']!='') {
		$campo1=trim($_POST['campo1']);
	}else{
		$campo1='-';
	}

	if($_POST['campo9']!='') {
		$campo9=$_POST['campo9'];
	}else{
		$campo9='-';
	}

	if($_POST['campo10']!='') {
		$campo10=$_POST['campo10'];
	}else{
		$campo10='-';
	}

	if($_POST['campo11']!='') {
		$campo11=$_POST['campo11'];
	}else{
		$campo11='-';
	}

	if($_POST['campo14']!='') {
		$campo14=$_POST['campo14'];
	}else{
		$campo14=0;
	}

	if ($_POST['fecha1']!="") {
		$fecha1_paso=Explode("-", $_POST['fecha1']);
		$fecha1=$fecha1_paso[2]."-".$fecha1_paso[1]."-".$fecha1_paso[0];
	}else{
		$fecha1='1900-01-01';
	}

	if($_POST['fecha2']!='') {
		$fecha2_paso=Explode("-", $_POST['fecha2']);
		$fecha2=$fecha2_paso[2]."-".$fecha2_paso[1]."-".$fecha2_paso[0];
	}else{
		$fecha2='1900-01-01';
	}

	if($_POST['campo17']!='') {
		$campo17=$_POST['campo17'];
	}else{
		$campo17='-';
	}

	if($_POST['campo18']!='') {
		$campo18=$_POST['campo18'];
	}else{
		$campo18='-';
	}


	if($_POST['campo19']!='') {
		$campo19=$_POST['campo19'];
	}else{
		$campo19='-';
	}

switch ($_POST['tipo1']) {
case '0':
	$campo4=0;
	$campo5=0;
	break;
case '1':
	$campo4=$_POST['campo4'];
	$campo5=0;
	break;
case '2':
	$campo4=0;
	$campo5=$_POST['campo5'];
	break;
}

// switch ($_POST['tipo2']) {
// case '0':
// 	$campo7=0;
// 	$campo8=0;
// 	break;
// case '1':
// 	$campo7=$_POST['campo7'];
// 	$campo8=0;
// 	break;
// case '2':
// 	$campo7=0;
// 	$campo8=$_POST['campo8'];
// 	break;
// }

	$fecha_completa = date('Y-n-j H:i:s');
	$eliminado=0;

	$auditoria1=$_POST['campo2'];
	$ejecutora2=$_POST['campo7'];
	$ejecutora3=$_POST['campo8'];
	$presuntores=$_POST['campo12'];

	$campo2=0;
	$campo7=0;
	$campo8=0;
	$campo12=0;


	$link=Conectarse();

	$guardar=$link->prepare("CALL ctra_addPRAS(:id_unico, :pras, :id_auditoria, :id_entefis, :fondoprog, :id_fondo, :id_prog, :ejecutora, :id_dependencia, :id_mpio, :no_auditoria, :no_resultado, :descrip_observa, :solicitud_fecha, :no_proced, :id_presuntores, :nombre_presuntores, :monto_observado, :id_organo, :fecha, :resultado_final, :id_estatus, :eliminado, :fecha_completa, :id_us, @id_nuevo)");
	$guardar->bindParam(':id_unico',$_POST['idu'],PDO::PARAM_STR,11);
	$guardar->bindParam(':pras',$campo1,PDO::PARAM_STR,250);
	$guardar->bindParam(':id_auditoria',$campo2,PDO::PARAM_STR,4);
	$guardar->bindParam(':id_entefis',$_POST['campo3'],PDO::PARAM_STR,4);
	$guardar->bindParam(':fondoprog',$_POST['tipo1'],PDO::PARAM_STR,1);
	$guardar->bindParam(':id_fondo',$campo4,PDO::PARAM_STR,4);
	$guardar->bindParam(':id_prog',$campo5,PDO::PARAM_STR,4);
	$guardar->bindParam(':ejecutora',$_POST['tipo2'],PDO::PARAM_STR,1);
	$guardar->bindParam(':id_dependencia',$campo7,PDO::PARAM_STR,4);
	$guardar->bindParam(':id_mpio',$campo8,PDO::PARAM_STR,4);
	$guardar->bindParam(':no_auditoria',$campo9,PDO::PARAM_STR,250);
	$guardar->bindParam(':no_resultado',$campo10,PDO::PARAM_STR,250);
	$guardar->bindParam(':descrip_observa',$campo17,PDO::PARAM_LOB);
	$guardar->bindParam(':solicitud_fecha',$fecha1,PDO::PARAM_STR,10);
	$guardar->bindParam(':no_proced',$campo11,PDO::PARAM_STR,250);
	$guardar->bindParam(':id_presuntores',$campo12,PDO::PARAM_STR,4);
	$guardar->bindParam(':nombre_presuntores',$campo18,PDO::PARAM_STR,250);
	$guardar->bindParam(':monto_observado',$campo14,PDO::PARAM_STR,45);
	$guardar->bindParam(':id_organo',$_POST['campo15'],PDO::PARAM_STR,4);
	$guardar->bindParam(':fecha',$fecha2,PDO::PARAM_STR,10);
	$guardar->bindParam(':resultado_final',$campo19,PDO::PARAM_LOB);
	$guardar->bindParam(':id_estatus',$_POST['campo16'],PDO::PARAM_STR,4);
	$guardar->bindParam(':eliminado',$eliminado,PDO::PARAM_STR,1);
	$guardar->bindParam(':fecha_completa',$fecha_completa,PDO::PARAM_STR,25);
	$guardar->bindParam(':id_us',$_SESSION['MM_IdUsuario'],PDO::PARAM_STR,4);
	$guardar->execute();
	#$guardar->closeCursor();

	$result2=$link->query("select @id_nuevo ");
	$row2=$result2->fetch(PDO::FETCH_ASSOC);
#	print "procedure returned " . $row2['@id_nuevo'] . "\n";


	$idu=$row2['@id_nuevo'];
	if($_POST['idu']!=0){
		$borra1=$link->prepare("DELETE from ctra1_cat_selecc WHERE id_pras=? ");
		$borra1->execute(array($_POST['idu']));
		$idu=$_POST['idu'];
	}

	if(count($auditoria1)>0){
		foreach($auditoria1 as $val){
			$result1=$link->query("SELECT * FROM ctra1_cat_selecc WHERE id_pras=".$idu." and id_refcat=".$val." and id_campo=1 ");
			$row_count1=$result1->rowCount();
			if ($row_count1==0){
				$inserta=$link->prepare("INSERT INTO ctra1_cat_selecc (id_pras, id_refcat, id_campo) values (:id_pras, :id_refcat, :id_campo) ");
				$inserta->execute(array(":id_pras"=>$idu, ":id_refcat"=>$val, ":id_campo"=>1));
			}
		}

	}

	if(count($ejecutora2)>0){
		foreach($ejecutora2 as $val){
			$result1=$link->query("SELECT * FROM ctra1_cat_selecc WHERE id_pras=".$idu." and id_refcat=".$val." and id_campo=2 ");
			$row_count1=$result1->rowCount();
			if ($row_count1==0){
				$inserta=$link->prepare("INSERT INTO ctra1_cat_selecc (id_pras, id_refcat, id_campo) values (:id_pras, :id_refcat, :id_campo) ");
				$inserta->execute(array(":id_pras"=>$idu, ":id_refcat"=>$val, ":id_campo"=>2));
			}
		}

	}

	if(count($ejecutora3)>0){
		foreach($ejecutora3 as $val){
			$result1=$link->query("SELECT * FROM ctra1_cat_selecc WHERE id_pras=".$idu." and id_refcat=".$val." and id_campo=3 ");
			$row_count1=$result1->rowCount();
			if ($row_count1==0){
				$inserta=$link->prepare("INSERT INTO ctra1_cat_selecc (id_pras, id_refcat, id_campo) values (:id_pras, :id_refcat, :id_campo) ");
				$inserta->execute(array(":id_pras"=>$idu, ":id_refcat"=>$val, ":id_campo"=>3));
			}
		}

	}

	if(count($presuntores)>0){
		foreach($presuntores as $val){
			$result1=$link->query("SELECT * FROM ctra1_cat_selecc WHERE id_pras=".$idu." and id_refcat=".$val." and id_campo=4 ");
			$row_count1=$result1->rowCount();
			if ($row_count1==0){
				$inserta=$link->prepare("INSERT INTO ctra1_cat_selecc (id_pras, id_refcat, id_campo) values (:id_pras, :id_refcat, :id_campo) ");
				$inserta->execute(array(":id_pras"=>$idu, ":id_refcat"=>$val, ":id_campo"=>4));
			}
		}

	}





	if($_POST['idu']!=0){
		$actualiza1=$link->prepare("UPDATE ctra1_bitacora SET actualizado=:actualizado WHERE id_acuerdo=:id_acuerdo and actualizado=:actualizado2 ");
		$actualiza1->execute(array(":actualizado"=>1, ":id_acuerdo"=>$_POST['idu'], ":actualizado2"=>0));

		if($_POST['estatus_original']!=$_POST['campo16']) {
			$actualiza2=$link->prepare("UPDATE ctra1_pras SET fecha_cambio_estatus=:fecha_cambio_estatus WHERE id_unico=:id_unico ");
			$actualiza2->execute(array(":fecha_cambio_estatus"=>$fecha_completa, ":id_unico"=>$_POST['idu']));
		}


		$link=null;
		header('Location: cta1_edita_pras.php?idu='.$_POST['idu'].'&pag='.$_POST['pag'].'&cod=1');
	}else{
		$link=null;
		header('Location: cta1_alta.php?cod=1');
	}

/*
	$inserta=$link->prepare("INSERT INTO ctra1_pras (pras, fond_pro, fecha, estatus, eliminado, fecha_completa, id_us) values (:campo1, :tipo1, :fecha1, :campo16, :eliminado, :fecha_completa, :id_us) ");
	$inserta->execute(array(":campo1"=>$campo1, ":tipo1"=>$_POST['tipo1'], ":fecha1"=>$fecha1, ":campo16"=>$_POST['campo16'], ":eliminado"=>0, ":fecha_completa"=>$fecha_completa, ":id_us"=>$_SESSION['MM_IdUsuario']));

	$guardar = $link->prepare("CALL ctra_addPRAS(:pras, @out_string)");
	$guardar->bindParam(':pras', 'hello');
	$guardar->execute();
	$outputArray = $this->link->query("select @out_string")->fetch(PDO::FETCH_ASSOC);
	print "procedure returned " . $outputArray['@out_string'] . "\n";


	$insertSQL="CALL ctra_addPRAS(".$_POST['id_a'].", '".$CveAcuerdo."', '".$Evento."', ".$_POST['Beneficiarios'].", ".$_POST['TipoInstruccion'].", '".$Lugar."', '".$Fecha1_fecha."', '".$Fecha1_hora."', '".$Nombre."', '".$Cargo."', '".$Organizacion."', ".$_POST['Municipio'].", ".$_POST['Tema'].", ".$_POST['Filtro'].", '".$Descripcion."', '".$Telefono."', '".$Instruccion."', ".$_POST['Dependencia'].", '".$cadena_res."', '".$cadena_res_secre."', '".$cadena_res_secre_xsecre."', '".$Fecha2_fecha."', '".$Fecha3_fecha."', ".$_POST['Status'].", ".$Apoyo_sol.", ".$Apoyo_apro.", '".$fecha_completa."', '".$CveProyecto."', ".$_SESSION['MM_IdUsuario'].", @id_nuevo)";
	$Result1 = mysql_query($insertSQL, $link) or die(mysql_error());

	if($_POST['id_a']!=0){
		mysql_query("update cyn_ac_bitacora set actualizado=1 where id_acuerdo=".$_POST['id_a']." and actualizado=0 and id_us=".$_SESSION['MM_IdUsuario']." ", $link);
		$link=null;
		header('Location: cta1_edita.php?id_a='.$_POST['id_a'].'&pag='.$_POST['pag'].'&cod=1');
	}else{
		$Result1=mysql_query("SELECT @id_nuevo");
		$row=mysql_fetch_row($Result1);

		$result_busca1=mysql_query("select IdAcuerdo, Clave FROM cyn_ac_acuerdos where Clave='".$CveAcuerdo."' and IdAcuerdo<>".$row[0]." ",$link);

		if (mysql_num_rows($result_busca1)>0){
			$rsAcuerdo=mysql_query("SELECT max(Clave) as ultima FROM cyn_ac_acuerdos ",$link);
			$row_rsAcuerdo = mysql_fetch_assoc($rsAcuerdo);
			$ultima_clave=Explode("-", $row_rsAcuerdo['ultima']);
			$ultima_consec_sig="CO-".date('y')."-".zerofill((((int)$ultima_clave[2])+1),4);
			mysql_query("update cyn_ac_acuerdos set Clave='".$ultima_consec_sig."' where IdAcuerdo=".$row[0]." and id_us=".$_SESSION['MM_IdUsuario']." ", $link);
		}

		$link=null;
		header('Location: cta1_alta.php?cod=1');
	}
*/
?>