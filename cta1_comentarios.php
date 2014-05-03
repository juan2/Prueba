<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$result1=$link->prepare("SELECT * FROM ctra1_pras WHERE id_unico=? ");
	$result1->execute(array($_GET['idu']));
	$objrs1=$result1->fetchObject();


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
	$result4->execute(array($_GET['idu']));
	$row_count4=$result4->rowCount();


	$result9="SELECT id_refcat ";
	$result9.=" FROM ctra1_cat_selecc ";
	$result9.=" WHERE id_pras=? and id_campo=4 ";
	$result9.=" LIMIT 1 ";
	$result9=$link->prepare($result9);
	$result9->execute(array($_GET['idu']));
	$row9=$result9->fetchAll(PDO::FETCH_ASSOC);
	$row_count8=$result9->rowCount();

	$presuntores="";
	if ($row_count8>0){
		foreach ($row9 as $row9c) {
			$presuntores=$row9c['id_refcat'];
		}
	}


	$result2=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=6 and enuso=1 ORDER BY concepto ");

	$result3=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=4 or tp=5 and enuso=1 ORDER BY tp, concepto ");


	$actual=$link->prepare("UPDATE ctra1_notifica set leido=1 WHERE idapoyo=? and idusuario=? and leido=0 ");
	$actual->execute(array($_GET['idu'], $_SESSION['MM_IdUsuario']));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('in_entrehead.php') ?>

<!-- chosen -->
<link rel="stylesheet" href="jquery/chosen/chosen/chosen.css" />
<script src="jquery/chosen/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$(".chzn-select").chosen({no_results_text: "Sin coincidencias"});
});
</script>

<style>
body{
	padding-top: 5px;
	padding-bottom: 40px;
}

/* Fine Uploader
-------------------------------------------------- */
.qq-upload-list {
	text-align: left;
}

/* For the bootstrapped demos */
li.alert-success {
	background-color: #DFF0D8;
}

li.alert-error {
	background-color: #F2DEDE;
}

.alert-error .qq-upload-failed-text {
	display: inline;
}
</style>


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
<body>

<?php include('in_header_ventana.php') ?>

<div class="span12">
<br /><h3>Comentarios al PRAS: <br /><?php echo $objrs1->pras;?></h3><br />
<form class="form-horizontal" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_agrega_comentarios.php">
	<fieldset>
	  <div class="control-group">
		<label class="control-label" for="campo1">Estatus</label>
		<div class="controls docs-input-sizes">
		  <select class="span8" name="campo1" id="campo1" tabindex="20" <?php if ($_SESSION['MM_UserGroupID']!=1){ ?> disabled <?php }?>>
			<?php
				while($row2=$result2->fetch(PDO::FETCH_ASSOC)) {
					$seleccionado="";
					if ($row2['id_unico']==$objrs1->id_estatus){
						$seleccionado="selected=selected";
					}
					echo "<option value=".$row2['id_unico']." $seleccionado>".$row2['concepto']."</option>";
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo2">Dependencia, presunto Resp.</label>
		<div class="controls docs-input-sizes">
		  <select class="span8 chzn-select" data-placeholder="Selecciona Presunto Responsable..." id="campo2" name="campo2" tabindex="16">
			<?php
				while($row3=$result3->fetch(PDO::FETCH_ASSOC)) {
					$seleccionado="";
					if ($row3['id_unico']==$presuntores){
						$seleccionado="selected=selected";
					}
					echo "<option value=".$row3['id_unico']." $seleccionado>".$row3['concepto']."</option>";
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label" for="campo3">Comentario</label>
		<div class="controls docs-input-sizes">
		  <textarea class="span8" rows="3" name="campo3" id="campo3"></textarea>
		</div>
	  </div>

	  <div class="control-group">
		<label class="control-label">Archivos</label>
		<div class="controls docs-input-sizes">
		  <div id="bootstrapped-fine-uploader"></div>
		</div>
	  </div>

	  <div class="form-actions">
		<div class="pull-right">
			<input type="hidden" name="idu" id="idu" value="<?php echo $_GET['idu']?>"/>
			<input type="hidden" name="estatus_original" id="estatus_original" value="<?php echo $objrs1->id_estatus; ?>"/>
			<button type="submit" class="btn btn-primary" id="guarda" name="guarda">R E G I S T R A R</button>
	  	</div>
	  </div>
	</fieldset>
  </form>

<?php
	if ($row_count4>0){
		echo "<div class='alert alert-info'><strong>Número de Comentarios: ".$row_count4."&nbsp;&nbsp;&nbsp;<a class='btn btn-inverse' href='cta1_comentarios.php?idu=".$_GET['idu']."'><i class='icon-refresh'></i> Recargar Comentarios</a></strong></div>";

		echo "<table class='table table-bordered'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th width='5%'>Adjuntos</th>";#1
		echo "<th width='35%'>Comentario</th>";#1
		echo "<th width='20%'>Estatus</th>";#8
		echo "<th width='20%'>Presunto responsable</th>";#8
		echo "<th width='15%'>Fecha alta</th>";#8
		echo "<th width='5%'>Opciones</th>";#9
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
			echo "<td style='text-align: center'>";
				echo "<div class='btn-toolbar'>";
				echo "<div class='btn-group'>";
					echo "<a class='btn btn-danger' href='cta1_borra_comentarios.php?idc=".$row4['idcomenta']."&idu=".$_GET['idu']."' title='Borrar comentario'><i class='icon-remove'></i></a>";
				echo "</div>";
				echo "</div><!-- toolbar -->";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
	}
?>
</div>

<?php include('in_footer_ventana.php') ?>

<script type="text/javascript" src="jquery/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
	mode : "exact",
	elements : "campo3",
	theme : "simple",
	editor_selector :"mceEditor"
	});
</script>

<script src="jquery/upload2/jquery.fineuploader-3.0.js"></script>
<script>
var uploader;

function createUploader() {
	uploader = new qq.FineUploader({
		element: document.getElementById('bootstrapped-fine-uploader'),
		autoUpload:false,
		request: {
			endpoint: "cta1_subir.php",
			inputName: "upload",
			forceMultipart: true
		},
		text: {
			uploadButton: '<i class="icon-upload icon-white"></i> Subir Archivo(s)'
		},
			template: '<div class="qq-uploader span8">' +
			'<pre class="qq-upload-drop-area span8"><span>{dragZoneText}</span></pre>' +
			'<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' +
			'<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
			'</div>',
		classes: {
			success: 'alert alert-success',
			fail: 'alert alert-error'
		},
		callbacks:{
			onError: function (id, fileName, obj) {
            	console.log (obj);
            	alert(obj);
        	}
		}
	});
}

function get_datos(){
	var datos={};
	datos.campo2=$("#campo2").val();
	datos.campo1=$("#campo1").val();
	datos.campo3=tinyMCE.get("campo3").getContent();
	datos.idu=$("#idu").val();
	datos.estatus_original=$("#estatus_original").val();
	return datos;
}

function onLoad(){
	createUploader();
	$("#guarda").click(function (e) {
		e.preventDefault();
		console.log(get_datos());

		var datos=get_datos();
		var textarea = tinyMCE.get('campo3').getContent();
		if ( (textarea=="") || (textarea==null) || (datos.campo2=="") || (datos.campo2==null) ) {
			alert("El campo de Comentarios es obligatorio");
			return false;
		}else{
			$.ajax({
				url: "cta1_agrega_comentarios.php",
				dataType: "json",
				data: datos,
				type: "POST"
			}).success(function (data,text,xhr){
				$("#frmCaptura").get(0).reset();
				uploader.setParams({'idc': data.idc, 'idu': data.idu});
				uploader.uploadStoredFiles();
			});
		}

	})
}

window.onload = onLoad;
</script>

<style type="text/css">
.chzn-container {
  width: 75% !important;
}
.chzn-drop {
  width: 99.6% !important;
}
.chzn-search input {
  width: 92% !important;
}
.mceLayout {
  width: 75% !important;
}
</style>

</body>
</html>

<?php
	$link=null;
?>