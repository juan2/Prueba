<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	if(trim($_GET['params'])!=''){
		$_POST=unserialize($_GET['params']);
	}

	$result3=$link->query("SELECT * FROM ctra1_catalogos WHERE enuso=1 ORDER BY tp, concepto ");
	$result3->execute();
	$row3=$result3->fetchAll(PDO::FETCH_ASSOC);

	$conceptos=array();
	foreach ($row3 as $row1) {
		$conceptos[$row1['id_unico']]=$row1['concepto'];
	}


	if(trim($_POST['pras'])!=''){
		$cadena1=Explode(" ", trim($_POST['pras']));
		if(count($cadena1)>1){
			$donde1=" and (pr.pras like " ;
			$donde1_pag=" and (pr.pras like " ;
			foreach($cadena1 as $val){
				$donde1.=" '%".$val."%' or pr.pras like " ;
				$donde1_pag.=" '%".$val."%' or pr.pras like " ;
			}
			$len1=strlen($donde1);
			$donde1=substr($donde1,0,($len1-17)).")";
			$donde1_pag=substr($donde1_pag,0,($len1-17)).")";
		}else{
			$donde1=" and pr.pras like '%".trim($_POST['pras'])."%' " ;
			$donde1_pag=" and pr.pras like '%".trim($_POST['pras'])."%' " ;
		}
		$donde1_texto="PRAS:<font color=navy>".trim($_POST['pras'])."</font>, ";
	}else{
		$donde1="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['auditoria']!=''){
		$cadena1=$_POST['auditoria'];
		if(count($cadena1)>1){
			$donde2=" and ((ct0.id_refcat = " ;
			$donde2_pag=" and (ct0.id_refcat = " ;
			foreach($cadena1 as $val){
				$donde2.=" ".$val." or ct0.id_refcat = " ;
				$donde2_pag.=" ".$val." or ct0.id_refcat = " ;
			}
			$len1=strlen($donde2);
			$len1_pag=strlen($donde2_pag);
			$donde2=substr($donde2,0,($len1-20)).") and ct0.id_campo=1)";
			$donde2_pag=substr($donde2,0,($len1-20)).") and ct0.id_campo=1)";
		}else{
			$donde2=" and ((ct0.id_refcat = ".$cadena1[0].") and ct0.id_campo=1) " ;
			$donde2_pag=" and ((ct0.id_refcat = ".$cadena1[0].") and ct0.id_campo=1) " ;
		}

		$paso2=$_POST['auditoria'];
		$donde2_texto.="Auditoría Ejercicio:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde2_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde2_texto.="</font>";

	}else{
		$donde2="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['ente']!=''){
		$cadena1=$_POST['ente'];
		if(count($cadena1)>1){
			$donde3=" and (pr.id_entefis = " ;
			$donde3_pag=" and (pr.id_entefis = " ;
			foreach($cadena1 as $val){
				$donde3.=" ".$val." or pr.id_entefis = " ;
				$donde3_pag.=" ".$val." or pr.id_entefis = " ;
			}
			$len1=strlen($donde3);
			$len1_pag=strlen($donde3_pag);
			$donde3=substr($donde3,0,($len1-20)).")";
			$donde3_pag=substr($donde3_pag,0,($len1_pag-20)).")";
		}else{
			$donde3=" and pr.id_entefis = ".$cadena1[0]." " ;
			$donde3_pag=" and pr.id_entefis = ".$cadena1[0]." " ;
		}

		$paso2=$_POST['ente'];
		$donde3_texto.="Ente fiscalizador:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde3_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde3_texto.="</font>";

	}else{
		$donde3="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['fondoprog1']!=''){
		$cadena1=$_POST['fondoprog1'];
		if(count($cadena1)>1){
			$donde4=" and (pr.id_fondo = " ;
			$donde4_pag=" and (pr.id_fondo = " ;
			foreach($cadena1 as $val){
// $result1=$link->query("SELECT * FROM ctra1_catalogos WHERE id_unico=".$val." and tp=2 ");
// $result1->execute();
// $row_count1=$result1->rowCount();
// if ($row_count1>0){
				$donde4.=" ".$val." or pr.id_fondo = " ;
				$donde4_pag.=" ".$val." or pr.id_fondo = " ;
			}
			$len1=strlen($donde4);
			$len1_pag=strlen($donde4_pag);
			$donde4=substr($donde4,0,($len1-18)).")";
			$donde4_pag=substr($donde4_pag,0,($len1_pag-18)).")";
		}else{
			$donde4=" and pr.id_fondo = ".$cadena1[0]." " ;
			$donde4_pag=" and pr.id_fondo = ".$cadena1[0]." " ;
		}

		$paso2=$_POST['fondoprog1'];
		$donde4_texto.="Fondo:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde4_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde4_texto.="</font>";

	}else{
		$donde4="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['fondoprog2']!=''){
		$cadena1=$_POST['fondoprog2'];
		if(count($cadena1)>1){
			$donde5=" and (pr.id_prog = " ;
			$donde5_pag=" and (pr.id_prog = " ;
			foreach($cadena1 as $val){
				$donde5.=" ".$val." or pr.id_prog = " ;
				$donde5_pag.=" ".$val." or pr.id_prog = " ;
			}
			$len1=strlen($donde5);
			$len1_pag=strlen($donde5_pag);
			$donde5=substr($donde5,0,($len1-17)).")";
			$donde5_pag=substr($donde5_pag,0,($len1_pag-17)).")";
		}else{
			$donde5=" and pr.id_prog = ".$cadena1[0]." " ;
			$donde5_pag=" and pr.id_prog = ".$cadena1[0]." " ;
		}

		$paso2=$_POST['fondoprog2'];
		$donde5_texto.="Programa:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde5_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde5_texto.="</font>";

	}else{
		$donde5="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['ejecutora1']!=''){
		$cadena1=$_POST['ejecutora1'];
		if(count($cadena1)>1){
			$donde7=" and ((ct0.id_refcat = " ;
			$donde7_pag=" and (ct0.id_refcat = " ;
			foreach($cadena1 as $val){
				$donde7.=" ".$val." or ct0.id_refcat = " ;
				$donde7_pag.=" ".$val." or ct0.id_refcat = " ;
			}
			$len1=strlen($donde7);
			$len1_pag=strlen($donde7_pag);
			$donde7=substr($donde7,0,($len1-20)).") and (ct0.id_campo=2 or ct0.id_campo=3))";
			$donde7_pag=substr($donde7,0,($len1-20)).") and (ct0.id_campo=2 or ct0.id_campo=3))";
		}else{
			$donde7=" and ((ct0.id_refcat = ".$cadena1[0].") and (ct0.id_campo=2 or ct0.id_campo=3)) " ;
			$donde7_pag=" and ((ct0.id_refcat = ".$cadena1[0].") and (ct0.id_campo=2 or ct0.id_campo=3)) " ;
		}

		$paso2=$_POST['ejecutora1'];
		$donde7_texto.="Ejecutora Dependencia o Municipio:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde7_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde7_texto.="</font>";

	}else{
		$donde7="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['noaudito'])!=''){
		$cadena1=Explode(" ", trim($_POST['noaudito']));
		if(count($cadena1)>1){
			$donde8=" and (pr.no_auditoria like " ;
			$donde8_pag=" and (pr.no_auditoria like " ;
			foreach($cadena1 as $val){
				$donde8.=" '%".$val."%' or pr.no_auditoria like " ;
				$donde8_pag.=" '%".$val."%' or pr.no_auditoria like " ;
			}
			$len1=strlen($donde8);
			$donde8=substr($donde8,0,($len1-25)).")";
			$donde8_pag=substr($donde8_pag,0,($len1-25)).")";
		}else{
			$donde8=" and pr.no_auditoria like '%".trim($_POST['noaudito'])."%' " ;
			$donde8_pag=" and pr.no_auditoria like '%".trim($_POST['noaudito'])."%' " ;
		}
		$donde8_texto="PRAS:<font color=navy>".trim($_POST['noaudito'])."</font>, ";
	}else{
		$donde8="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['noresultado'])!=''){
		$cadena1=Explode(" ", trim($_POST['noresultado']));
		if(count($cadena1)>1){
			$donde9=" and (pr.no_resultado like " ;
			$donde9_pag=" and (pr.no_resultado like " ;
			foreach($cadena1 as $val){
				$donde9.=" '%".$val."%' or pr.no_resultado like " ;
				$donde9_pag.=" '%".$val."%' or pr.no_resultado like " ;
			}
			$len1=strlen($donde9);
			$donde9=substr($donde9,0,($len1-25)).")";
			$donde9_pag=substr($donde9_pag,0,($len1-25)).")";
		}else{
			$donde9=" and pr.no_resultado like '%".trim($_POST['noresultado'])."%' " ;
			$donde9_pag=" and pr.no_resultado like '%".trim($_POST['noresultado'])."%' " ;
		}
		$donde9_texto="PRAS:<font color=navy>".trim($_POST['noresultado'])."</font>, ";
	}else{
		$donde9="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['descrip_observa'])!=''){
		$cadena1=Explode(" ", trim($_POST['descrip_observa']));
		if(count($cadena1)>1){
			$donde10=" and (pr.descrip_observa like " ;
			$donde10_pag=" and (pr.descrip_observa like " ;
			foreach($cadena1 as $val){
				$donde10.=" '%".$val."%' or pr.descrip_observa like " ;
				$donde10_pag.=" '%".$val."%' or pr.descrip_observa like " ;
			}
			$len1=strlen($donde10);
			$donde10=substr($donde10,0,($len1-28)).")";
			$donde10_pag=substr($donde10_pag,0,($len1-28)).")";
		}else{
			$donde10=" and pr.descrip_observa like '%".trim($_POST['descrip_observa'])."%' " ;
			$donde10_pag=" and pr.descrip_observa like '%".trim($_POST['descrip_observa'])."%' " ;
		}
		$donde10_texto="PRAS:<font color=navy>".trim($_POST['descrip_observa'])."</font>, ";
	}else{
		$donde10="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['fecha1'])!=''){
		$fecha1_paso=Explode("-", $_POST['fecha1']);
		$fecha1=$fecha1_paso[2]."-".$fecha1_paso[1]."-".$fecha1_paso[0];
		$donde11=" and pr.solicitud_fecha = '".$fecha1."' " ;
		$donde11_pag=" and pr.solicitud_fecha = '".$fecha1."' " ;
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['noprocede'])!=''){
		$cadena1=Explode(" ", trim($_POST['noprocede']));
		if(count($cadena1)>1){
			$donde12=" and (pr.no_proced like " ;
			$donde12_pag=" and (pr.no_proced like " ;
			foreach($cadena1 as $val){
				$donde12.=" '%".$val."%' or pr.no_proced like " ;
				$donde12_pag.=" '%".$val."%' or pr.no_proced like " ;
			}
			$len1=strlen($donde12);
			$donde12=substr($donde12,0,($len1-22)).")";
			$donde12_pag=substr($donde12_pag,0,($len1-22)).")";
		}else{
			$donde12=" and pr.no_proced like '%".trim($_POST['noprocede'])."%' " ;
			$donde12_pag=" and pr.no_proced like '%".trim($_POST['noprocede'])."%' " ;
		}
		$donde12_texto="PRAS:<font color=navy>".trim($_POST['noprocede'])."</font>, ";
	}else{
		$donde12="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['depe_presunto']!=''){
		$cadena1=$_POST['depe_presunto'];
		if(count($cadena1)>1){
			$donde14=" and ((ct0.id_refcat = " ;
			$donde14_pag=" and (ct0.id_refcat = " ;
			foreach($cadena1 as $val){
				$donde14.=" ".$val." or ct0.id_refcat = " ;
				$donde14_pag.=" ".$val." or ct0.id_refcat = " ;
			}
			$len1=strlen($donde14);
			$len1_pag=strlen($donde14_pag);
			$donde14=substr($donde14,0,($len1-20)).") and ct0.id_campo=4)";
			$donde14_pag=substr($donde14,0,($len1-20)).") and ct0.id_campo=4)";
#			$donde14_pag=substr($donde14_pag,0,($len1_pag-20)).")";
		}else{
			$donde14=" and ((ct0.id_refcat = ".$cadena1[0].") and ct0.id_campo=4) " ;
			$donde14_pag=" and ((ct0.id_refcat = ".$cadena1[0].") and ct0.id_campo=4) " ;
#			$donde14_pag=" and ct0.id_refcat = ".$cadena1[0]." " ;
		}

		$paso2=$_POST['depe_presunto'];
		$donde14_texto.="Dependencia Presunto Responsable:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde14_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde14_texto.="</font>";

	}else{
		$donde14="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['nombre_presunto'])!=''){
		$cadena1=Explode(" ", trim($_POST['nombre_presunto']));
		if(count($cadena1)>1){
			$donde15=" and (pr.nombre_presuntores like " ;
			$donde15_pag=" and (pr.nombre_presuntores like " ;
			foreach($cadena1 as $val){
				$donde15.=" '%".$val."%' or pr.nombre_presuntores like " ;
				$donde15_pag.=" '%".$val."%' or pr.nombre_presuntores like " ;
			}
			$len1=strlen($donde15);
			$donde15=substr($donde15,0,($len1-31)).")";
			$donde15_pag=substr($donde15_pag,0,($len1-31)).")";
		}else{
			$donde15=" and pr.nombre_presuntores like '%".trim($_POST['nombre_presunto'])."%' " ;
			$donde15_pag=" and pr.nombre_presuntores like '%".trim($_POST['nombre_presunto'])."%' " ;
		}
		$donde15_texto="PRAS:<font color=navy>".trim($_POST['nombre_presunto'])."</font>, ";
	}else{
		$donde15="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['monto_observa'])!=''){
		$cadena1=Explode(" ", trim($_POST['monto_observa']));
		if(count($cadena1)>1){
			$donde16=" and (pr.monto_observado like " ;
			$donde16_pag=" and (pr.monto_observado like " ;
			foreach($cadena1 as $val){
				$donde16.=" '%".$val."%' or pr.monto_observado like " ;
				$donde16_pag.=" '%".$val."%' or pr.monto_observado like " ;
			}
			$len1=strlen($donde16);
			$donde16=substr($donde16,0,($len1-31)).")";
			$donde16_pag=substr($donde16_pag,0,($len1-31)).")";
		}else{
			$donde16=" and pr.monto_observado like '%".trim($_POST['monto_observa'])."%' " ;
			$donde16_pag=" and pr.monto_observado like '%".trim($_POST['monto_observa'])."%' " ;
		}
		$donde16_texto="PRAS:<font color=navy>".trim($_POST['monto_observa'])."</font>, ";
	}else{
		$donde16="";
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['organo']!=''){
		$cadena1=$_POST['organo'];
		if(count($cadena1)>1){
			$donde17=" and (pr.id_organo = " ;
			$donde17_pag=" and (pr.id_organo = " ;
			foreach($cadena1 as $val){
				$donde17.=" ".$val." or pr.id_organo = " ;
				$donde17_pag.=" ".$val." or pr.id_organo = " ;
			}
			$len1=strlen($donde17);
			$len1_pag=strlen($donde17_pag);
			$donde17=substr($donde17,0,($len1-19)).")";
			$donde17_pag=substr($donde17_pag,0,($len1_pag-19)).")";
		}else{
			$donde17=" and pr.id_organo = ".$cadena1[0]." " ;
			$donde17_pag=" and pr.id_organo = ".$cadena1[0]." " ;
		}

		$paso2=$_POST['organo'];
		$donde17_texto.="Programa:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde17_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde17_texto.="</font>";

	}else{
		$donde17="";
	}

#------------------------------------------------------------------------------------------
	if(trim($_POST['fecha2'])!=''){
		$fecha2_paso=Explode("-", $_POST['fecha2']);
		$fecha2=$fecha2_paso[2]."-".$fecha2_paso[1]."-".$fecha2_paso[0];
		$donde18=" and pr.fecha = '".$fecha2."' " ;
		$donde18_pag=" and pr.fecha = '".$fecha2."' " ;
	}

#------------------------------------------------------------------------------------------
	$cadena1='';
	$len1='';
	$len1_pag='';
	if($_POST['status']!=''){
		$cadena1=$_POST['status'];
		if(count($cadena1)>1){
			$donde19=" and (pr.id_estatus = " ;
			$donde19_pag=" and (pr.id_estatus = " ;
			foreach($cadena1 as $val){
				$donde19.=" ".$val." or pr.id_estatus = " ;
				$donde19_pag.=" ".$val." or pr.id_estatus = " ;
			}
			$len1=strlen($donde19);
			$len1_pag=strlen($donde19_pag);
			$donde19=substr($donde19,0,($len1-20)).")";
			$donde19_pag=substr($donde19_pag,0,($len1_pag-20)).")";
		}else{
			$donde19=" and pr.id_estatus = ".$cadena1[0]." " ;
			$donde19_pag=" and pr.id_estatus = ".$cadena1[0]." " ;
		}

		$paso2=$_POST['status'];
		$donde19_texto.="Estatus:<font color=navy>";
		foreach ($row3 as $row1) {
			foreach($paso2 as $val2){
				if ($val2==$row1['id_unico']){
					$donde19_texto.=$row1['concepto'].", ";
					break;
				}
			}
		}
		$donde19_texto.="</font>";

	}else{
		$donde19="";
	}


	$filtroxsecre='';
	$filtroxsecre_pag='';
	if ($_SESSION['MM_UserGroupID']!=1){
		$filtroxsecre=" and pr.id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5 and id_pras=".$_SESSION['MM_IdUsuario'].")";
		$filtroxsecre_pag=" and pr.id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5 and id_pras=".$_SESSION['MM_IdUsuario'].")";
		$filtroxsecre_sin=" and id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5 and id_pras=".$_SESSION['MM_IdUsuario'].")";
	}


	#paginacion
    include_once ('jquery/paginator2/function_joins.php');
	$page=(int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit=10;
	$startpoint=($page * $limit) - $limit;
	$statement = " , pr.*, ct0.* FROM ctra1_pras pr
		LEFT JOIN ctra1_cat_selecc ct0 ON ct0.id_pras=pr.id_unico
	  	WHERE pr.eliminado=0 $filtroxsecre_pag
	  	$donde1_pag $donde2_pag $donde3_pag $donde4_pag $donde5_pag $donde7_pag $donde8_pag $donde9_pag $donde10_pag $donde11_pag $donde12_pag $donde14_pag $donde15_pag $donde16_pag $donde17_pag $donde18_pag $donde19_pag
	  	GROUP BY pr.id_unico ";
	$url=$_SERVER[$_SCRIPT_NAME]."?params=".serialize($_POST)."&";


	$result99="SELECT distinct pr.id_unico, pr.pras, pr.id_entefis, pr.ejecutora, pr.id_presuntores, pr.id_organo, pr.id_estatus, ";
	$result99.=" ct1.concepto as concepto1, ";
#	$result99.=" ct2.concepto as concepto2, ";
#	$result99.=" ct3.concepto as concepto3, ";
	$result99.=" ct4.concepto as concepto4, ";
	$result99.=" ct5.concepto as concepto5, ";
	$result99.=" ct6.concepto as concepto6 ";
	$result99.=" FROM ctra1_pras pr ";
	$result99.=" LEFT JOIN ctra1_catalogos ct1 ON ct1.id_unico=pr.id_entefis ";
#	$result99.=" LEFT JOIN ctra1_catalogos ct2 ON ct2.id_unico=pr.id_dependencia ";
#	$result99.=" LEFT JOIN ctra1_catalogos ct3 ON ct3.id_unico=pr.id_mpio ";
	$result99.=" LEFT JOIN ctra1_catalogos ct4 ON ct4.id_unico=pr.id_presuntores ";
	$result99.=" LEFT JOIN ctra1_catalogos ct5 ON ct5.id_unico=pr.id_organo ";
	$result99.=" LEFT JOIN ctra1_catalogos ct6 ON ct6.id_unico=pr.id_estatus ";
	$result99.=" LEFT JOIN ctra1_cat_selecc ct0 ON ct0.id_pras=pr.id_unico ";
	$result99.=" WHERE pr.eliminado=0 $donde1 $donde2 $donde3 $donde4 $donde5 $donde7 $donde8 $donde9 $donde10 $donde11 $donde12 $donde14 $donde15 $donde16 $donde17 $donde18 $donde19 $filtroxsecre ";
	$result99.=" ORDER BY pr.id_unico LIMIT {$startpoint} , {$limit} ";
	$result1=$link->query($result99);
	$row_count1=$result1->rowCount();

	$result4="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as ejecutoras ";
	$result4.=" FROM ctra1_cat_selecc cs ";
	$result4.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
	$result4.=" WHERE cs.id_pras=? and (cs.id_campo=2 or cs.id_campo=3) ";
	$result4.=" ORDER BY cs.id_campo ";
	$result4=$link->prepare($result4);
	$result4->execute(array($row['id_unico']));
	$row4=$result4->fetchAll(PDO::FETCH_ASSOC);
	$row_count4=$result4->rowCount();


	$exportar_sql="SELECT distinct pr.id_unico, pr.pras, pr.ejecutora, pr.id_presuntores, ";
	$exportar_sql.=" pr.id_unico as auditoria_ejercicio, pr.id_entefis as EnteFiscalizador, concat_ws('*', pr.fondoprog, pr.id_fondo, pr.id_prog) as Fondo_o_Programa, pr.id_unico as EjecutoraDependencias, pr.id_unico as EjecutoraMpios, pr.no_auditoria, pr.no_resultado, pr.descrip_observa, date_format(pr.solicitud_fecha,'%d-%m-%Y') as solicitud_inicio_fecha, pr.no_proced, pr.id_unico as dependencia_presunto_resp, pr.nombre_presuntores, pr.monto_observado, pr.id_organo as organo_control_interno, date_format(pr.fecha,'%d-%m-%Y') as fecha, pr.resultado_final, pr.id_estatus, ";
	$exportar_sql.=" ct1.concepto as concepto1, ";
	$exportar_sql.=" ct4.concepto as concepto4, ";
	$exportar_sql.=" ct5.concepto as concepto5, ";
	$exportar_sql.=" ct6.concepto as concepto6 ";
	$exportar_sql.=" FROM ctra1_pras pr ";
	$exportar_sql.=" LEFT JOIN ctra1_catalogos ct1 ON ct1.id_unico=pr.id_entefis ";
	$exportar_sql.=" LEFT JOIN ctra1_catalogos ct4 ON ct4.id_unico=pr.id_presuntores ";
	$exportar_sql.=" LEFT JOIN ctra1_catalogos ct5 ON ct5.id_unico=pr.id_organo ";
	$exportar_sql.=" LEFT JOIN ctra1_catalogos ct6 ON ct6.id_unico=pr.id_estatus ";
	$exportar_sql.=" LEFT JOIN ctra1_cat_selecc ct0 ON ct0.id_pras=pr.id_unico ";
	$exportar_sql.=" WHERE pr.eliminado=0 $donde1 $donde2 $donde3 $donde4 $donde5 $donde7 $donde8 $donde9 $donde10 $donde11 $donde12 $donde14 $donde15 $donde16 $donde17 $donde18 $donde19 $filtroxsecre ";
	$exportar_sql.=" ORDER BY pr.id_unico ";

/*	$exportar_sql="SELECT pr.id_unico, pr.pras, pr.no_auditoria, pr.no_resultado, date_format(pr.solicitud_fecha,'%d-%m-%Y') as solicitud_fecha, pr.no_proced as no_procedimiento, pr.monto_observado, date_format(pr.fecha,'%d-%m-%Y') as fecha ";
	$exportar_sql.=" FROM ctra1_pras pr ";
#	$exportar_sql.=" LEFT JOIN ctra1_cat_selecc ct0 ON ct0.id_pras=pr.id_unico ";
	$exportar_sql.=" WHERE pr.eliminado=0 $donde1 $donde2 $donde3 $donde4 $donde5 $donde7 $donde8 $donde9 $donde10 $donde11 $donde12 $donde14 $donde15 $donde16 $donde17 $donde18 $donde19 ";
	$exportar_sql.=" ORDER BY pr.id_unico ";*/

	// $exportar_sql="SELECT pr.id_unico, pr.pras, pr.no_auditoria, pr.no_resultado, date_format(pr.solicitud_fecha,'%d-%m-%Y') as solicitud_fecha, pr.no_proced as no_procedimiento, pr.monto_observado, date_format(pr.fecha,'%d-%m-%Y') as fecha, ";
	// $exportar_sql.=" ct1.concepto as EnteFiscalizador, ";
	// $exportar_sql.=" ct2.concepto as EjecutoraDependencia, ";
	// $exportar_sql.=" ct3.concepto as EjecutoraMunicipio, ";
	// $exportar_sql.=" ct4.concepto as PresuntoResponsable, ";
	// $exportar_sql.=" ct5.concepto as OrganoControlInterno, ";
	// $exportar_sql.=" ct6.concepto as Estatus, ";
	// $exportar_sql.=" ct7.concepto as AuditoriaEjercicio, ";
	// $exportar_sql.=" ct8.concepto as Fondo, ";
	// $exportar_sql.=" ct9.concepto as Programa ";
	// $exportar_sql.=" FROM ctra1_pras pr ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct1 ON ct1.id_unico=pr.id_entefis ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct2 ON ct2.id_unico=pr.id_dependencia ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct3 ON ct3.id_unico=pr.id_mpio ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct4 ON ct4.id_unico=pr.id_presuntores ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct5 ON ct5.id_unico=pr.id_organo ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct6 ON ct6.id_unico=pr.id_estatus ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct7 ON ct7.id_unico=pr.id_auditoria ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct8 ON ct8.id_unico=pr.id_fondo ";
	// $exportar_sql.=" LEFT JOIN ctra1_catalogos ct9 ON ct9.id_unico=pr.id_prog ";
	// $exportar_sql.=" WHERE pr.eliminado=0 $donde1 $donde2 $donde3 $donde4 $donde5 $donde7 $donde8 $donde9 $donde10 $donde11 $donde12 $donde14 $donde15 $donde16 $donde17 $donde18 $donde19 ";
	// $exportar_sql.=" ORDER BY pr.id_unico ";


#------------------------ todos
	$result2=$link->query("SELECT COUNT(id_unico) as todos FROM ctra1_pras WHERE eliminado=0 $filtroxsecre_sin ");
	$row_count2=$result2->rowCount();
	if ($row_count2>0){
		$objrs1=$result2->fetchObject();
		$total_general=$objrs1->todos;
	}else{
		$total_general=0;
	}
#------------------------ todos


	$total_reg=0;
	$paso=pagination($statement,$limit,$page,$url);

	if ($paso==''){
		$total_reg=$row_count1;
	}else{
		$re1='.*?';
		$re2='(paginacion)';
		$re3='(-)';
		$re4='(\\d+)';
		preg_match_all ("/".$re1.$re2.$re3.$re4."/is", $paso, $matches);
		$total_reg=$matches[3][0];
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('in_entrehead.php') ?>

<!-- paginacion -->
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href="jquery/paginator2/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="jquery/paginator2/css/B_black.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.records {
		width: 510px;
		margin: 5px;
		padding:2px 5px;
		border:1px solid #B6B6B6;
	}

	.record {
		color: #474747;
		margin: 5px 0;
		padding: 3px 5px;
		background:#E6E6E6;
		border: 1px solid #B6B6B6;
		cursor: pointer;
		letter-spacing: 2px;
	}
	.record:hover {
		background:#D3D2D2;
	}

	.round {
		-moz-border-radius:8px;
		-khtml-border-radius: 8px;
		-webkit-border-radius: 8px;
		border-radius:8px;
	}

	p.createdBy{
		padding:5px;
		width: 510px;
		font-size:15px;
		text-align:center;
	}
	p.createdBy a {color: #666666;text-decoration: none;}
</style>


<!-- botones agrupados -->
<style type="text/css">
.btn-toolbar {
    margin-bottom: 1px;
    margin-top: 1px;
}
</style>


<!-- fancybox -->
<script type="text/javascript" src="jquery/fancybox214/source/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="jquery/fancybox214/source/jquery.fancybox.css?v=2.1.4" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$(".ventana_doc").fancybox({
		fitToView	: false,
		width		: '75%',
		height		: '90%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});

	$('.fancybox').fancybox({
		maxWidth	: '90%',
		maxHeight	: '90%',
		fitToView	: false,
		width	: '90%',
		height	: '90%',
		autoSize	: false,
	});
});</script>

<!-- chosen -->
<link rel="stylesheet" href="jquery/chosen/chosen/chosen.css" />
<script src="jquery/chosen/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$(".chzn-select").chosen({no_results_text: "Sin coincidencias"});
});
</script>

<!-- calendario4 -->
<script src="jquery/calendario4/mootools-core.js" type="text/javascript"></script>
<script src="jquery/calendario4/mootools-more.js" type="text/javascript"></script>
<script src="jquery/calendario4/Source/Locale.en-US.DatePicker.js" type="text/javascript"></script>
<script src="jquery/calendario4/Source/Picker.js" type="text/javascript"></script>
<script src="jquery/calendario4/Source/Picker.Attach.js" type="text/javascript"></script>
<script src="jquery/calendario4/Source/Picker.Date.js" type="text/javascript"></script>
<link href="jquery/calendario4/Source/datepicker_vista/datepicker_vista.css" rel="stylesheet">
<script>
window.addEvent('domready', function(){
	new Picker.Date('fecha1', {
		positionOffset: {x: 5, y: 0},
		pickerClass: 'datepicker_vista'
	});

	new Picker.Date('fecha2', {
		positionOffset: {x: 5, y: 0},
		pickerClass: 'datepicker_vista'
	});
});
</script>


<!-- confirma -->
<script language="javascript">
function confirma(url){
direccion = url;
	if (confirm("¿en realidad desea borrar este registro?")){
		self.location = direccion
		return true
	}
}
</script>

</head>
<body data-spy="scroll" data-target=".subnav" data-offset="50">

<?php include('in_header.php') ?>

<div class="row-fluid">

<?php include('in_sidebar.php') ?>

<div id="sidebar" class="span10">


<?php if (isset($_POST['enviar'])){ ?>
<h3>Relación General de Compromisos <?php
echo $donde1_texto.$donde2_texto.$donde3_texto.$donde4_texto.$donde5_texto.$donde7_texto.$donde8_texto.$donde9_texto.$donde10_texto.$donde11_texto.$donde12_texto.$donde14_texto.$donde15_texto.$donde16_texto.$donde17_texto.$donde18_texto.$donde19_texto;?>&nbsp;&nbsp;&nbsp;<i class="icon-asterisk"></i><?php echo $total_reg.' de '.$total_general; ?> registro(s)</h3>
<?php } ?>

<?php
// echo $donde1."<br>";
// echo $donde20."<br>";
// echo $result99;


 	// echo $donde1.'<br>';
 	// echo $donde1_pag.'<br><br>';
 	// echo $donde2.'<br>';
 	// echo $donde2_pag.'<br><br>';
 	// echo $donde3.'<br>';
 	// echo $donde3_pag.'<br><br>';
 	// echo $donde4.'<br>';
 	// echo $donde4_pag.'<br><br>';

 	// echo $donde5.'<br>';
 	// echo $donde5_pag.'<br><br>';
 	// echo $donde7.'<br>';
 	// echo $donde7_pag.'<br><br>';
 	// echo $donde8.'<br>';
 	// echo $donde8_pag.'<br><br>';
 	// echo $donde9.'<br>';
 	// echo $donde9_pag.'<br><br>';
 	// echo $donde10.'<br>';
 	// echo $donde10_pag.'<br><br>';

 	// echo $donde11.'<br>';
 	// echo $donde11_pag.'<br><br>';

 	// echo $donde12.'<br>';
 	// echo $donde12_pag.'<br><br>';
 	// echo $donde14.'<br>';
 	// echo $donde14_pag.'<br><br>';
 	// echo $donde15.'<br>';
 	// echo $donde15_pag.'<br><br>';
 	// echo $donde16.'<br>';
 	// echo $donde16_pag.'<br><br>';
 	// echo $donde17.'<br>';
 	// echo $donde17_pag.'<br><br>';
 	// echo $donde18.'<br>';
 	// echo $donde18_pag.'<br><br>';
 	// echo $donde19.'<br>';
 	// echo $donde19_pag.'<br><br>';


// echo '<pre>';
// print_r($_POST['Beneficiarios']);
// print_r($_POST['TipoInstruccion']);
// print_r($_POST['Dependencia']);
// echo '</pre>';
?>

	<div class="accordion" id="accordion1">
	<div class="accordion-group">
	  <div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne"><i class="icon-search"></i>&nbsp;&nbsp;<strong>Criterios de Búsqueda:</strong></a>
	  </div>
	  <div id="collapseOne" class="accordion-body <?php if (isset($_POST['enviar'])){ echo 'collapse'; }?>">
		<div class="accordion-inner">

<form class="form-inline" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_rep_per.php">
<div class="row-fluid">
<div class="span6">
	<fieldset>
	  <div class="control-group">
		<label class="control-label"><strong>Clave</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="pras" id="pras" value="<?php echo $_POST['pras']; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Auditoría Ejercicio</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Auditoría..." multiple="multiple" style="width:450px;" id="auditoria" name="auditoria[]">
			<?php
				$chek='';
				$paso2=$_POST['auditoria'];
				foreach ($row3 as $row1) {
					if($row1['tp']==7){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Ente fiscalizador</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Ente..." multiple="multiple" style="width:450px;" id="ente" name="ente[]">
			<?php
				$chek='';
				$paso2=$_POST['ente'];
				foreach ($row3 as $row1) {
					if($row1['tp']==1){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Fondo</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Fondo..." multiple="multiple" style="width:450px;" id="fondoprog1" name="fondoprog1[]">
			<?php
				$chek='';
				$paso2=$_POST['fondoprog1'];
				foreach ($row3 as $row1) {
					if($row1['tp']==2){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Programa</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Programa..." multiple="multiple" style="width:450px;" id="fondoprog2" name="fondoprog2[]">
			<?php
				$chek='';
				$paso2=$_POST['fondoprog2'];
				foreach ($row3 as $row1) {
					if($row1['tp']==3){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Ejecutora Dependencia o Municipio</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Ejecutora..." multiple="multiple" style="width:450px;" id="ejecutora1" name="ejecutora1[]">
			<?php
				$chek='';
				$paso2=$_POST['ejecutora1'];
				foreach ($row3 as $row1) {
					if($row1['tp']==4 || $row1['tp']==5){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>No. de Auditoría</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="noaudito" id="noaudito" value="<?php echo $_POST['noaudito']; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>No. de Resultado</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="noresultado" id="noresultado" value="<?php echo $_POST['noresultado']; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Descripción de la Observación</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="descrip_observa" id="descrip_observa" value="<?php echo $_POST['descrip_observa']; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Solicitud de inicio de PRAS</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="fecha1" id="fecha1" value="<?php echo $_POST['fecha1']; ?>" readonly>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>No. de Procedimiento</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="noprocede" id="noprocede" value="<?php echo $_POST['noprocede']; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Dependencia, presunto Resp.</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Dependencia..." multiple="multiple" style="width:450px;" id="depe_presunto" name="depe_presunto[]">
			<?php
				$chek='';
				$paso2=$_POST['depe_presunto'];
				foreach ($row3 as $row1) {
					if($row1['tp']==4 || $row1['tp']==5){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Nombre, presunto Resp.</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="nombre_presunto" id="nombre_presunto" value="<?php echo $_POST['nombre_presunto']; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Monto Observado</strong></label>
		<div class="controls">
		  <div class="row-fluid input-prepend">
			<span class="add-on">$</span><input class="span11" type="text" name="monto_observa" id="monto_observa" value="<?php echo $_POST['monto_observa']; ?>" placeholder="No utilice signos de $ o separadores de coma, use punto si requiere decimales">
		  </div>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Órgano de Control Interno</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Órgano..." multiple="multiple" style="width:450px;" id="organo" name="organo[]">
			<?php
				$chek='';
				$paso2=$_POST['organo'];
				foreach ($row3 as $row1) {
					if($row1['tp']==4){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Fecha</strong></label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="fecha2" id="fecha2" value="<?php echo $_POST['fecha2']; ?>" readonly>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><strong>Estatus</strong></label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Estatus..." multiple="multiple" style="width:450px;" id="status" name="status[]" tabindex="20">
			<?php
				$chek='';
				$paso2=$_POST['status'];
				foreach ($row3 as $row1) {
					if($row1['tp']==6){
						foreach($paso2 as $val2){
							if ($val2==$row1['id_unico']){
								$chek=true;
								break;
							}else{
								$chek=false;
							}
						}

						$seleccionado="";
						if ($chek){
							$seleccionado=" selected=selected";
						}
						echo "<option value=".$row1['id_unico']." $seleccionado>".$row1['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	</fieldset>
</div><!-- /span6 -->



</div><!-- /row-fluid -->

	  <div class="form-actions">
		<div class="pull-right">
			<input type="hidden" name="pag" id="pag" value="1"/>
			<input type="hidden" name="enviar" id="enviar" value="1"/>
			<button type="submit" class="btn btn-primary" tabindex="23">F I L T R A R</button>
		</div>
	  </div>

<br><br><br><br>
</form>

		</div>
	  </div>
	</div>
	</div>

<?php
if (isset($_POST['enviar'])){
	if ($row_count1>0){

		echo "<div class='row-fluid'>";
			echo "<div class='span4'>
				<div id='btn_exportar' class='btn-group pull-left'>
					<button value='excel' class='btn'><i class='icon-table'></i> Exportar a Excel</button>
				</div>&nbsp;";
				if (isset($_POST['enviar'])){
					echo "<div id='btn_generar' class='btn-group pull-left'>
						<a href='#myModal' role='button' class='btn' data-toggle='modal'><i class='icon-save'></i> Guardar Reporte</a>
					</div>";
				}
				echo "<input type='hidden' value='".urlencode($exportar_sql)."' name='sql'>
			</div>";
			echo "<div class='span8'>";
				echo pagination($statement,$limit,$page,$url);
			echo "</div>";
		echo "</div>";

		echo "<table class='table table-bordered table-hover' id='tabla_com'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th width='8%'>PRAS</th>";
		echo "<th width='14%'>Ente fiscalizador</th>";
		echo "<th width='15%'>Ejecutora</th>";
		echo "<th width='15%'>Presunto responsable</th>";
		echo "<th width='14%'>Órgano de control</th>";
		echo "<th width='8%'>Estatus</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";

		while($row=$result1->fetch(PDO::FETCH_ASSOC)) {
			$result7=$link->prepare("SELECT * FROM ctra1_comentarios WHERE idpras=? ");
			$result7->execute(array($row['id_unico']));
			$row_count7=$result7->rowCount();

			$result5=$link->prepare("SELECT * FROM ctra1_comentarios_arch WHERE idpras=? ");
			$result5->execute(array($row['id_unico']));
			$row_count5=$result5->rowCount();

			if ($row_count5>0){
				$existe_archivo=" btn-success";
			}else{
				$existe_archivo="";
			}


			$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as ejecutoras ";
			$result8.=" FROM ctra1_cat_selecc cs ";
			$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
			$result8.=" WHERE cs.id_pras=? and (cs.id_campo=2 or cs.id_campo=3) ";
			$result8.=" ORDER BY cs.id_campo ";
			$result8=$link->prepare($result8);
			$result8->execute(array($row['id_unico']));
			$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
			$row_count8=$result8->rowCount();

			$ejecutora="";
			if ($row_count8>0){
				foreach ($row8 as $row8c) {
					$ejecutora.=$row8c['ejecutoras'];
				}
			}


			$result9="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as ejecutoras ";
			$result9.=" FROM ctra1_cat_selecc cs ";
			$result9.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
			$result9.=" WHERE cs.id_pras=? and cs.id_campo=4 ";
			$result9.=" ORDER BY cs.id_campo ";
			$result9=$link->prepare($result9);
			$result9->execute(array($row['id_unico']));
			$row9=$result9->fetchAll(PDO::FETCH_ASSOC);
			$row_count9=$result9->rowCount();

			$presuntores="";
			if ($row_count9>0){
				foreach ($row9 as $row9c) {
					$presuntores.=$row9c['ejecutoras'];
				}
			}

			// switch ($row['ejecutora']) {
			// case '0':
			// 	$ejecutora='-';
			// 	break;
			// case '1':
			// 	$ejecutora=$row['concepto2'];
			// 	break;
			// case '2':
			// 	$ejecutora=$row['concepto3'];
			// 	break;
			// }

			echo "<tr valign='top'><a name='".$row['id_unico']."'></a>";
			echo "<td><a class='fancybox fancybox.iframe' href='cta1_cedula.php?id_a=".$row['id_unico']."' alt='Comentarios' title='Comentarios'>".$row['pras']."</a></td>";
			echo "<td>".$conceptos[$row['id_entefis']].'-'.$row['id_entefis']."</td>";
			echo "<td>".$ejecutora."</td>";
			echo "<td>".$presuntores."</td>";
			echo "<td>".$row['concepto5']."</td>";
			echo "<td style='text-align: center' id='botones'>";
				if ($_GET['page']==''){
					$mipage=1;
				}else{
					$mipage=$_GET['page'];
				}

				switch ($row['id_estatus']){
				case '79':
					$col_boton="btn-info";
					$col_boton2="label-info";
					break;
				case '80':
					$col_boton="btn";
					$col_boton2="";
					break;
				case '81':
					$col_boton="btn-warning";
					$col_boton2="label-warning";
					break;
				case '82':
					$col_boton="btn-success";
					$col_boton2="label-success";
					break;
				default:
					$col_boton="";
					$col_boton2="";
				}

				if ($row['id_estatus']!=82){
					$eltitulo='';
					if (strlen($row['concepto6'])>20){
						$eltitulo=$row['concepto6'];
					}

					echo "<div class='btn-toolbar'>";
					if ($_SESSION['MM_UserGroupID']==1){
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-mini $col_boton dropdown-toggle' data-toggle='dropdown' title='".$eltitulo."'>".substr($row['concepto6'],0,20)." <span class='caret'></span></button>";
						echo "<ul class='dropdown-menu pull-right'>";
						foreach ($row3 as $row3b) {
							if($row3b['tp']==6){
								if ($row3b['id_unico']!=$row['id_estatus']){
									echo "<li><a href='cta1_cambia_status_boton.php?idu=".$row['id_unico']."&est=".$row3b['id_unico']."&page=".$mipage."&pag=2'>".$row3b['concepto']."</a></li>";
								}
							}
						}
						echo "</ul>";
						echo "</div>";
					}else{
						echo "<span class='label $col_boton2'>".substr($row['concepto6'],0,20)."</span>";
					}
					echo "<br />";

					echo "<div class='btn-group' id='acciones'>";

					if ($_SESSION['MM_UserGroupID']!=4){
						echo "<a class='btn ventana_doc fancybox.iframe' href='cta1_comentarios.php?idu=".$row['id_unico']."' title='Comentarios'><i class='icon-comment'></i></a>";
					}


					if ($row_count7>0){
						echo "<a class='btn $existe_archivo' href='cta1_linea.php?idu=".$row['id_unico']."&pag=2' title='Cronología de Comentarios'><i class='icon-paper-clip'></i></a>";
#&params=serialize($_POST)
					}

				if ($_SESSION['MM_UserGroupID']==1){
					echo "<a class='btn' id='editar' href='cta1_edita_pras.php?idu=".$row['id_unico']."&pag=2' title='Editar PRAS'><i class='icon-pencil'></i></a>";
						if ($row['id_estatus']!=82){
							echo "<a class='btn btn-danger' href=\"javascript:confirma('cta1_borra_pras.php?idu=".$row['id_unico']."&page=".$mipage."&est=1&pag=2')\" title='Borrar PRAS'><i class='icon-remove'></i></a>";
						}
				}

/*
					echo "<a class='btn' href='#' alt='Comentarios' title='Comentarios' id='ventana_doc'><i class='icon-comment'></i></a>";
				if ($_SESSION['MM_UserGroupID']==1){
					echo "<a class='btn' id='editar' href='#' alt='Editar PRAS' title='Editar PRAS'><i class='icon-pencil'></i></a>";
					if ($row['id_estatus']!=82){
						echo "<a class='btn btn-danger' href='#' alt='Borrar PRAS' title='Borrar PRAS'><i class='icon-remove'></i></a>";
					}
				}
*/
					echo "</div>";
					echo "</div><!-- toolbar -->";
				}else{
					echo "<span class='label label-success'>Finiquitado</span>";

					echo "<br />";
					echo "<div class='btn-toolbar'>";
					echo "<div class='btn-group' id='acciones'>";
					if ($_SESSION['MM_UserGroupID']!=4){
						echo "<a class='btn ventana_doc fancybox.iframe' href='cta1_comentarios.php?idu=".$row['id_unico']."' title='Comentarios'><i class='icon-comment'></i></a>";
					}

					if ($_SESSION['MM_UserGroupID']==1){
						echo "<a class='btn' id='editar' href='cta1_edita_pras.php?idu=".$row['id_unico']."&pag=2' title='Editar PRAS'><i class='icon-pencil'></i></a>";
					}
					echo "</div>";
					echo "</div><!-- toolbar -->";

				}

			echo "</td></tr>";
		}
		echo "</tbody></table>";

	echo pagination($statement,$limit,$page,$url);
	echo "<br /><br /><br /><br />";
	}else{
		echo "<blockquote><h2>No hay registros para la consulta solicitada</h2></blockquote>";
	}

} //if enviar
?>


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style='font-size: 20px;'><i class='icon-remove'></i></div></button>
		<h3 id="myModalLabel">Guardar Reporte</h3>
	</div>
	<div class="modal-body">

		<div class="row-fluid">
			<div class="control-group span12">
				<label class="control-label" for="inputPassword">Nombre del Reporte</label>
				<div class="controls">
					<textarea class="span12" rows="3" name="nombre" id="nombre"><?php
echo strip_tags($donde1_texto.$donde2_texto.$donde3_texto.$donde4_texto.$donde5_texto.$donde7_texto.$donde8_texto.$donde9_texto.$donde10_texto.$donde11_texto.$donde12_texto.$donde14_texto.$donde15_texto.$donde16_texto.$donde17_texto.$donde18_texto.$donde19_texto);?></textarea>
				</div>
			</div>
		</div>

		<input type='hidden' value='<?php echo urlencode(serialize($_POST));?>' name='params' id='params'>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
		<button class="btn btn-primary" id="grabar">Guardar</button>
	</div>
</div>

</div><!-- /span10 -->

</div>

<?php include('in_footer.php') ?>

<script type="text/javascript">
	$("#btn_exportar button").click(function(event){
		var tipo = $(event.currentTarget).val();
		var sql = $("input[name='sql']").val();
		window.location.href = "export.php?tipo="+tipo+"&sql="+sql;
	});
</script>

<script language="javascript">
$("#grabar").click(function(event){
	event.preventDefault();
	var nombre=$("#nombre").val();
	var params=$("#params").val();
	$.ajax({
		url:"cta1_agrega_reporte.php",
		type:"POST",
		data:{params:params,nombre:nombre},
		dataType:"json"
	}).done(function(){
//			console.log("si");
			$('#myModal').modal('hide');
		});
})
</script>

</body>
</html>
<?php
	$status_texto=array();
	$link=null;
?>