<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$result9=$link->prepare("SELECT id_unico, pras, id_auditoria, id_entefis, fondoprog, id_fondo, id_prog, ejecutora, id_dependencia, id_mpio, no_auditoria, no_resultado, descrip_observa, date_format(solicitud_fecha,'%d-%m-%Y') as solicitud_fecha, no_proced, id_presuntores, nombre_presuntores, monto_observado, id_organo, date_format(fecha,'%d-%m-%Y') as fecha, resultado_final, id_estatus, eliminado, fecha_completa, id_us FROM ctra1_pras WHERE id_unico=? ");
	$result9->execute(array($_GET['idu']));
	$objrs9=$result9->fetchObject();

	$result2=$link->prepare("SELECT id_refcat, id_campo FROM ctra1_cat_selecc WHERE id_pras=? ORDER BY id_campo, id_refcat ");
	$result2->execute(array($_GET['idu']));
	$row2=$result2->fetchAll(PDO::FETCH_ASSOC);

	$result1=$link->query("SELECT * FROM ctra1_catalogos WHERE enuso=1 ORDER BY tp, concepto ");
	$result1->execute();
	$row1=$result1->fetchAll(PDO::FETCH_ASSOC);
#	$result1->setFetchMode(PDO::FETCH_ASSOC);
#	$row1=$result1->fetchAll();

	// $result2=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=1 and enuso=1 ORDER BY concepto ");
	// $result2->setFetchMode(PDO::FETCH_ASSOC);
	// $result2->execute();
	// $row2=$result2->fetchAll();

	// $result3=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=2 and enuso=1 ORDER BY concepto ");
	// $result3->setFetchMode(PDO::FETCH_ASSOC);
	// $result3->execute();
	// $row3=$result3->fetchAll();

	// $result4=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=3 and enuso=1 ORDER BY concepto ");
	// $result4->setFetchMode(PDO::FETCH_ASSOC);
	// $result4->execute();
	// $row4=$result4->fetchAll();

	// $result5=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=4 and enuso=1 ORDER BY concepto ");
	// $result5->setFetchMode(PDO::FETCH_ASSOC);
	// $result5->execute();
	// $row5=$result5->fetchAll();

	// $result6=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=5 and enuso=1 ORDER BY concepto ");
	// $result6->setFetchMode(PDO::FETCH_ASSOC);
	// $result6->execute();
	// $row6=$result6->fetchAll();

	// $result7=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=4 or tp=5 and enuso=1 ORDER BY tp, concepto ");
	// $result7->setFetchMode(PDO::FETCH_ASSOC);
	// $result7->execute();
	// $row7=$result7->fetchAll();

	// $result8=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=6 and enuso=1 ORDER BY concepto ");
	// $result8->setFetchMode(PDO::FETCH_ASSOC);
	// $result8->execute();
	// $row8=$result8->fetchAll();

	switch ($_GET['pag']) {
	case '1':
		$pag_redirecciona="cta1_rep_basico.php";
		break;
	case '2':
		$pag_redirecciona="cta1_rep_per.php";
		break;
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('in_entrehead.php') ?>

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
//		timePicker: true,
		positionOffset: {x: 5, y: 0},
		pickerClass: 'datepicker_vista'
//		useFadeInOut: !Browser.ie
//date('d-m-Y H:i:00')
	});

	new Picker.Date('fecha2', {
		pickerClass: 'datepicker_vista',
		inputOutputFormat: 'Y-m-d'
	});
});
</script>


<!-- chosen -->
<link rel="stylesheet" href="jquery/chosen/chosen/chosen.css" />
<script src="jquery/chosen/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$(".chzn-select").chosen({no_results_text: "Sin coincidencias"});
});
</script>

<!-- no enter en formularios -->
<script type="text/javascript">
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
</script>

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

<?php include('in_header.php') ?>

<div class="row-fluid">

<?php include('in_sidebar.php') ?>

<div id="sidebar" class="span10">
<h3>Nuevo PRAS</h3>

<?php if($_GET['cod']==1) {
		echo "<div class='alert fade in'>";
		echo "<button class='close' data-dismiss='alert'>&times;</button>";
		echo "<strong>Actualización exitosa!</strong> <br><br><a class='btn' data-dismiss='alert'>CERRAR MENSAJE</a>&nbsp;&nbsp;<a class='btn btn-primary' href='cta1_rep_basico.php'>REPORTE PRAS</a>";
		echo "</div>";
}
?>

<form class="form-horizontal" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_agrega_prass.php">
<div class="span8">
	<fieldset>

	  <div class="control-group">
		<label class="control-label" for="campo1">PRAS</label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="campo1" id="campo1" value="<?php echo $objrs9->pras; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo2">Auditoría Ejercicio</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" data-placeholder="Selecciona Auditoria(s)..." multiple="multiple" id="campo2" name="campo2[]">
			<?php
				$campo1arr=array();
				foreach ($row2 as $row) {
					if($row['id_campo']==1){
						$campo1arr[]=$row['id_refcat'];
					}
				}

#				while($row1=$result1->fetch(PDO::FETCH_ASSOC)) {
				foreach ($row1 as $row) {
					if($row['tp']==7){
						$seleccionado="";
						foreach($campo1arr as $val){
							if ($val==$row['id_unico']){
								$seleccionado=" selected=selected";
								break;
							}else{
								$seleccionado="";
							}
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo3">Ente fiscalizador</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" id="campo3" name="campo3">
			<?php
				foreach ($row1 as $row) {
					if($row['tp']==1){
						$seleccionado="";
						if ($row['id_unico']==$objrs9->id_entefis){
							$seleccionado="selected=selected";
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label"><em>Fondo o programa</em></label>
		<div class="controls docs-input-sizes">
			<div class="btn-group" data-toggle-name="tipo1" data-toggle="buttons-radio" >
			  <button type="button" value="0" class="btn <?php if($objrs9->fondoprog==0) echo 'active'; ?>" data-toggle="button" id="seleccion1_0">sin selección</button>
			  <button type="button" value="1" class="btn <?php if($objrs9->fondoprog==1) echo 'active'; ?>" data-toggle="button" id="seleccion1_1">Fondo</button>
			  <button type="button" value="2" class="btn <?php if($objrs9->fondoprog==2) echo 'active'; ?>" data-toggle="button" id="seleccion1_2">Programa</button>
			</div>
			<input type="hidden" name="tipo1" id="tipo1" value="<?php echo $objrs9->fondoprog; ?>" />
		</div>
	  </div>

	  <div class="control-group" id="tipos1">
		<label class="control-label" for="campo4">Fondos</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" id="campo4" name="campo4">
			<?php
				foreach ($row1 as $row) {
					if($row['tp']==2){
						$seleccionado="";
						if ($row['id_unico']==$objrs9->id_fondo){
							$seleccionado="selected=selected";
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group" id="tipos2">
		<label class="control-label" for="campo5">Programas</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" id="campo5" name="campo5">
			<?php
				foreach ($row1 as $row) {
					if($row['tp']==3){
						$seleccionado="";
						if ($row['id_unico']==$objrs9->id_prog){
							$seleccionado="selected=selected";
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group" id="tipos3">
		<label class="control-label" for="campo7">Ejecutora Dependencias</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" data-placeholder="Selecciona Dependencia(s)..." multiple="multiple" id="campo7" name="campo7[]">
			<?php
				$campo2arr=array();
				foreach ($row2 as $row) {
					if($row['id_campo']==2){
						$campo2arr[]=$row['id_refcat'];
					}
				}

				foreach ($row1 as $row) {
					if($row['tp']==4){
						$seleccionado="";
						foreach($campo2arr as $val){
							if ($val==$row['id_unico']){
								$seleccionado=" selected=selected";
								break;
							}else{
								$seleccionado="";
							}
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group" id="tipos4">
		<label class="control-label" for="campo8">Ejecutora Municipios</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" data-placeholder="Selecciona Municipio(s)..." multiple="multiple" id="campo8" name="campo8[]">
			<?php
				$campo3arr=array();
				foreach ($row2 as $row) {
					if($row['id_campo']==3){
						$campo3arr[]=$row['id_refcat'];
					}
				}

				foreach ($row1 as $row) {
					if($row['tp']==5){
						$seleccionado="";
						foreach($campo3arr as $val){
							if ($val==$row['id_unico']){
								$seleccionado=" selected=selected";
								break;
							}else{
								$seleccionado="";
							}
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo9">No. de Auditoría</label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="campo9" id="campo9" value="<?php echo $objrs9->no_auditoria; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo10">No. de Resultado</label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="campo10" id="campo10" value="<?php echo $objrs9->no_resultado; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo17">Descripción de la Observación</label>
		<div class="controls docs-input-sizes">
		  <textarea class="span12" rows="3" name="campo17" id="campo17"><?php echo $objrs9->descrip_observa; ?></textarea>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="fecha1">Solicitud de inicio de PRAS</label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="fecha1" id="fecha1" value="<?php echo $objrs9->solicitud_fecha;?>" readonly>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo11">No. de Procedimiento</label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="campo11" id="campo11" value="<?php echo $objrs9->no_proced; ?>">
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo12">Dependencia, presunto Resp.</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" data-placeholder="Selecciona Dependencia(s) o entidad(es)..." multiple="multiple" id="campo12" name="campo12[]">
			<?php
				$campo12arr=array();
				foreach ($row2 as $row) {
					if($row['id_campo']==4){
						$campo12arr[]=$row['id_refcat'];
					}
				}

#				while($row1=$result1->fetch(PDO::FETCH_ASSOC)) {
				foreach ($row1 as $row) {
					if($row['tp']==4 || $row['tp']==5){
						$seleccionado="";
						foreach($campo12arr as $val){
							if ($val==$row['id_unico']){
								$seleccionado=" selected=selected";
								break;
							}else{
								$seleccionado="";
							}
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

<!-- 	  <div class="control-group">
		<label class="control-label" for="campo12">Dependencia, presunto Resp.</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" id="campo12" name="campo12">
			<?php
				foreach ($row1 as $row) {
					if($row['tp']==4 || $row['tp']==5){
						$seleccionado="";
						if ($row['id_unico']==$objrs9->id_presuntores){
							$seleccionado="selected=selected";
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div> -->

	  <div class="control-group">
		<label class="control-label" for="campo18">Nombre, presunto Resp.</label>
		<div class="controls docs-input-sizes">
		  <textarea class="span12" rows="3" name="campo18" id="campo18"><?php echo $objrs9->nombre_presuntores; ?></textarea>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo14">Monto Observado</label>
		<div class="controls">
		  <div class="row-fluid input-prepend">
			<span class="add-on">$</span><input class="span11" type="text" name="campo14" id="campo14" placeholder="No utilice signos de $ o separadores de coma, use punto si requiere decimales" value="<?php echo $objrs9->monto_observado; ?>">
		  </div>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo15">Órgano de Control Interno</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" id="campo15" name="campo15">
			<?php
				foreach ($row1 as $row) {
					if($row['tp']==4){
						$seleccionado="";
						if ($row['id_unico']==$objrs9->id_organo){
							$seleccionado="selected=selected";
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="fecha2">Fecha</label>
		<div class="controls docs-input-sizes">
		  <input class="span12" type="text" name="fecha2" id="fecha2" value="<?php echo $objrs9->fecha;?>" readonly>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo19">Resultado Final</label>
		<div class="controls docs-input-sizes">
		  <textarea class="span12" rows="3" name="campo19" id="campo19"><?php echo $objrs9->resultado_final; ?></textarea>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo16">Estatus</label>
		<div class="controls docs-input-sizes">
		  <select class="span12 chzn-select" id="campo16" name="campo16">
			<?php
				foreach ($row1 as $row) {
					if($row['tp']==6){
						$seleccionado="";
						if ($row['id_unico']==$objrs9->id_estatus){
							$seleccionado="selected=selected";
						}
						echo "<option value=".$row['id_unico']." $seleccionado>".$row['concepto']."</option>";
					}
				}
			?>
		  </select>
		</div>
	  </div>

	</fieldset>
</div><!-- /span8 -->

<div class="span8">
	  <div class="form-actions">
		<div class="pull-right">
			<input type="hidden" name="idu" id="idu" value="<?php echo $objrs9->id_unico; ?>"/>
			<input type="hidden" name="pag" id="pag" value="<?php echo $_GET['pag']; ?>"/>
			<input type="hidden" name="estatus_original" id="estatus_original" value="<?php echo $objrs9->id_estatus; ?>"/>
			<a class="btn" href="<?php echo $pag_redirecciona; ?>">CANCELAR</a>
			<button type="submit" class="btn btn-primary">A C T U A L I Z A R</button>
		</div>
	  </div>
</div><!-- /span8 -->

</form>
</div><!-- /span10 -->

</div><!-- /row-fluid -->

<?php include('in_footer.php') ?>

<script>
// seleccion1
$("#tipos1").hide();
$("#tipos2").hide();

$("#seleccion1_2").click(function () {
	$("#tipos1").hide("fast", function () { });
	$("#tipos2").show("fast", function () {	});
	$("#tipo1").val("2");
//	$(".chzn-select").trigger("liszt:updated");
});

$("#seleccion1_1").click(function () {
	$("#tipos1").show("fast", function () {	});
	$("#tipos2").hide("fast", function () { });
	$("#tipo1").val("1");
});

$("#seleccion1_0").click(function () {
	$("#tipos1").hide("fast", function () {	});
	$("#tipos2").hide("fast", function () { });
	$("#tipo1").val("0");
});

<?php 
switch ($objrs9->fondoprog) {
case '0':
	echo "$('#tipos1').hide('fast', function () {	});
	$('#tipos2').hide('fast', function () { });
	$('#tipo1').val('0');";
	break;
case '1':
	echo "$('#tipos1').show('fast', function () {	});
	$('#tipos2').hide('fast', function () { });
	$('#tipo1').val('1');";
	break;
case '2':
	echo "$('#tipos1').hide('fast', function () { });
	$('#tipos2').show('fast', function () {	});
	$('#tipo1').val('2');";
	break;
}
?>
</script>

<style type="text/css">
.chzn-container {
  width: 100% !important;
}
.chzn-drop {
  width: 99.6% !important;
}
.chzn-search input {
  width: 92% !important;
}
</style>

<script type="text/javascript">
	var elemento0 = document.getElementById("frmCaptura");
	elemento0.setAttribute("autocomplete", "off");
</script>

</body>
</html>
<?php
	$link=null;
?>