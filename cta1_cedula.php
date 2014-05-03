<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

/* ---------------------------------------------------- */

	if (isset($_GET["valor"]))
		$valor=$_GET["valor"];
	else
		$valor=0;

/* ---------------------------------------------------- */

	$query9="SELECT pr.id_unico, pr.pras, pr.id_auditoria, pr.fondoprog, pr.ejecutora, pr.id_dependencia, pr.id_mpio, pr.no_auditoria, pr.no_resultado, pr.descrip_observa, date_format(pr.solicitud_fecha,'%d-%m-%Y') as solicitud_fecha, pr.no_proced, pr.id_presuntores, pr.nombre_presuntores, pr.monto_observado, date_format(pr.fecha,'%d-%m-%Y') as fecha, pr.resultado_final, pr.fecha_completa, pr.id_us, ";
	$query9.="cat1.concepto as concepto1, ";
	$query9.="cat2.concepto as concepto2, ";
	$query9.="cat3.concepto as concepto3, ";
	$query9.="cat4.concepto as concepto4, ";
	$query9.="cat5.concepto as concepto5 ";

	$query9.="FROM ctra1_pras pr ";
	$query9.="LEFT JOIN ctra1_catalogos cat1 ON cat1.id_unico=pr.id_entefis ";
	$query9.="LEFT JOIN ctra1_catalogos cat2 ON cat2.id_unico=pr.id_fondo ";
	$query9.="LEFT JOIN ctra1_catalogos cat3 ON cat3.id_unico=pr.id_prog ";
	$query9.="LEFT JOIN ctra1_catalogos cat4 ON cat4.id_unico=pr.id_organo ";
	$query9.="LEFT JOIN ctra1_catalogos cat5 ON cat5.id_unico=pr.id_estatus ";

	$query9.="WHERE pr.id_unico=? ";
	$result9=$link->prepare($query9);
	$result9->execute(array($_GET['id_a']));
	$objrs9=$result9->fetchObject();



	$result8="SELECT id_campo, GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as datos ";
	$result8.=" FROM ctra1_cat_selecc cs ";
	$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
	$result8.=" WHERE cs.id_pras=? ";
	$result8.=" GROUP BY cs.id_campo ";
	$result8.=" ORDER BY cs.id_campo ";
	$result8=$link->prepare($result8);
	$result8->execute(array($objrs9->id_unico));
	$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
	$row_count8=$result8->rowCount();

	$arr_catalogos = array();
	if ($row_count8>0){
		foreach ($row8 as $row8c) {
			$arr_catalogos[$row8c['id_campo']]=$row8c['datos'];
		}
	}

	$query4="SELECT co.idcomenta, co.idpras, co.id_estatus, co.id_presuntores, co.comentario, date_format(co.fechaalta,'%d-%m-%Y') as fechaalta,  ";
	$query4.="us.nombre, ";
	$query4.="ct1.concepto as concepto1, ";
	$query4.="ct2.concepto as concepto2 ";
	$query4.="FROM ctra1_comentarios co ";
	$query4.="LEFT JOIN ctra1_ct_usuarios us ON us.idusuario=co.id_us ";
	$query4.="LEFT JOIN ctra1_catalogos ct1 ON ct1.id_unico=co.id_estatus ";
	$query4.="LEFT JOIN ctra1_catalogos ct2 ON ct2.id_unico=co.id_presuntores ";
	$query4.="WHERE co.idpras=? ";
	$query4.="ORDER BY co.idcomenta desc ";
	$result4=$link->prepare($query4);
	$result4->execute(array($_GET['id_a']));
	$row_count4=$result4->rowCount();


/* ---------------------------------------------------- */
	// Encabezado
	$header  ="<table id='table' width='90%'>";
	$header .="<tr style='background: #004D31; height: 60px;'>";
	$header .="<td style='font-size: 16px; width: 80%; color: #fff;'>&nbsp;&nbsp;PRAS</td>";
	$header .="<td style='width: 20%; text-align: right;' ><img src='http://compromisos.tamaulipas.gob.mx/twbotstrap/logo60.png' width='24' height='24'></td>";
	$header .="<td style='width: 2%;'>&nbsp;</td>";
	$header .="</tr>";
	$header .="</table>";
	$header .="<br />";

	// Pie de pagina
	$footer  ="<table id='table' width='100%'>";
	$footer .="<tr>";
	$footer .="<tr style='background:none;' height='80'>";
	$footer .="<td style='width: 20%'><img src='http://compromisos.tamaulipas.gob.mx/twbotstrap/gobEstado.jpg' width='150' height='40'></td>";


	$footer1  = "<td style='text-align: center; width: 60%'>Página 1</td>";
	$footer2  = "<td style='width: 20%; float: right;'><img src='http://compromisos.tamaulipas.gob.mx/twbotstrap/estadoFuerte.jpg' width='150' height='40'></td>";
	$footer2 .= "</tr>";
	$footer2 .="</table>";


	$tamFuente=9;
	if ($valor==2)	{	// PDF
		$tamFuente	=9;

		include 'librerias/MPDF54/mpdf.php';
		//				   charset formato  font-size, font-name, left, right, top, bottom, header, footer
		$mpdf	=new mPDF('utf-8', 'LETTER-L', 0, "", 10, 10, 30, 24, 10, 10);

		$mpdf->useOddEven = 1;
		$mpdf->mirrorMargins = true;

		$mpdf->SetHTMLHeader($header, 'O');
		$mpdf->SetHTMLHeader($header, 'E');

		$mpdf->SetHTMLFooter($footer ."<td style='text-align: center; width: 60%'>Página {PAGENO}</td>" .$footer2, 'O');
		$mpdf->SetHTMLFooter($footer ."<td style='text-align: center; width: 60%'>Página {PAGENO}</td>" .$footer2, 'E');

		$mpdf->SetDisplayMode('fullpage','two');

		ob_start();				// Inicia buffer para la captura de html
	}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if ($valor==0) {
	include('in_entrehead.php');
}
?>

<style>
body{
	padding-top: 5px;
	padding-bottom: 40px;
}
</style>

</head>
<body>
<?php
if ($valor==0) {
	include('in_header_ventana.php');
}
?>

<div class="span12">
<h3>Cédula PRAS: <?php echo $objrs9->pras;?></h3><br />
<?php
if ($valor==0) {
	echo "<div class='row-fluid'>";
		echo "<div class='span6'>";
		echo "<button onclick=\"window.location='cta1_cedula.php?id_a=".$_GET['id_a']."&valor=2'\" class='btn'><i class='icon-file-alt'></i> Exportar a PDF</button>";
		echo "</div>";
	echo "</div>";
}
?>

<div class="row-fluid">

<table border="0" width="100%">
	<tr valign='top'>
		<td width="50%">
			<strong>Auditoría Ejercicio</strong>
			<blockquote><p><?php echo $arr_catalogos[1]; ?></p></blockquote>


			<?php
				switch ($objrs9->fondoprog) {
				case '0':
					echo "";
					break;
				case '1':
					echo "<strong>Fondo</strong><blockquote><p>".$objrs9->concepto2."</p></blockquote>";
					break;
				case '2':
					echo "<strong>Programa</strong><blockquote><p>".$objrs9->concepto3."</p></blockquote>";
					break;
				}
			?>

			<strong>Ejecutora Municipios</strong>
			<blockquote><p><?php echo $arr_catalogos[3]; ?></p></blockquote>

			<strong>No. de Auditoría</strong>
			<blockquote><p><?php echo $objrs9->no_auditoria; ?></p></blockquote>
		</td>

		<td width="50%">
			<strong>Ente fiscalizador</strong>
			<blockquote><p><?php echo $objrs9->concepto1; ?></p></blockquote>

			<strong>Ejecutora Dependencias</strong>
			<blockquote><p><?php echo $arr_catalogos[2]; ?></p></blockquote>

			<strong>No. de Resultado</strong>
			<blockquote><p><?php echo $objrs9->no_resultado; ?></p></blockquote>
		</td>
	</tr>


	<tr valign='top'>
		<td colspan="2">
			<strong>Descripción de la Observación:</strong>
			<blockquote><p><?php echo $objrs9->descrip_observa; ?></p></blockquote>
		</td>
	</tr>

	<tr valign='top'>
		<td width="50%">
			<strong>Solicitud de inicio de PRAS</strong>
			<blockquote><p><?php echo $objrs9->solicitud_fecha; ?></p></blockquote>

			<strong>Dependencia, presunto Resp.</strong>
			<blockquote><p><?php echo $arr_catalogos[4]; ?></p></blockquote>

			<strong>Monto Observado</strong>
			<blockquote><p>$<?php echo number_format($objrs9->monto_observado,2); ?></p></blockquote>

			<strong>Fecha</strong>
			<blockquote><p><?php echo $objrs9->fecha; ?></p></blockquote>

			<strong>Estatus</strong>
			<blockquote><p><?php echo $objrs9->concepto5; ?></p></blockquote>
		</td>

		<td width="50%">
			<strong>No. de Procedimiento</strong>
			<blockquote><p><?php echo $objrs9->no_proced; ?></p></blockquote>

			<strong>Nombre, presunto Resp.</strong>
			<blockquote><p><?php echo $objrs9->nombre_presuntores; ?></p></blockquote>

			<strong>Órgano de Control Interno</strong>
			<blockquote><p><?php echo $objrs9->concepto4; ?></p></blockquote>

			<strong>Resultado Final</strong>
			<blockquote><p><?php echo $objrs9->resultado_final; ?></p></blockquote>
		</td>
	</tr>


</table>
</div><!-- /row-fluid -->




<?php
if ($valor==2) {
	echo "<br /><br /><br /><br /><br /><br /><br />";
}

	if ($row_count4>0){
		echo "<table class='table table-bordered'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th width='5%'>Adjuntos</th>";#1
		echo "<th width='40%'>Comentario</th>";#1
		echo "<th width='20%'>Estatus</th>";#8
		echo "<th width='20%'>Presunto responsable</th>";#8
		echo "<th width='15%'>Fecha alta</th>";#8
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";

		while($row4=$result4->fetch(PDO::FETCH_ASSOC)) {
			$result5=$link->prepare("SELECT * FROM ctra1_comentarios_arch WHERE idcomenta=? and idpras=? ");
			$result5->execute(array($row4['idcomenta'], $row4['idpras']));
			$row_count5=$result5->rowCount();

			if ($row_count5>0){
				$existe_archivo="<div style='font-size: 20px;'><i class='icon-paper-clip'></i></div>";
			}else{
				$existe_archivo="";
			}

			echo "<tr id='tr".$row4['idcomenta']."' valign='top'>";
			echo "<td style='text-align: center'>".$existe_archivo."</td>";
			echo "<td>".$row4['comentario']."</td>";
			echo "<td>".$row4['concepto1']."</td>";
			echo "<td>".$row4['concepto2']."</td>";
			echo "<td style='text-align: center'>".$row4['fechaalta']."&nbsp;&nbsp;<em>".$row4['nombre']."</em></td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
	}
?>
</div>

<?php
if ($valor==0) {
	include('in_footer_ventana.php');
}
?>

</body>
</html>

<?php
	mysql_free_result($rsAcuerdo);
	mysql_free_result($rsComenta);
	mysql_close($link);
?>

<?php
	if ($valor==2)	{
		$html =ob_get_contents();
		ob_end_clean();

		$html = iconv("UTF-8","UTF-8//IGNORE", $html);

		$mpdf->WriteHTML($html);

		$archivo ="cedula_pras.pdf";
		$mpdf->Output("$archivo", 'D');
	}
?>