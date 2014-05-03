<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

/*	$result99="SELECT us.IdUsuario, concat_ws(' ', us.Nombre, us.Paterno, us.Materno) as nombre_completo, us.Usuario, us.EnUso, DATE_FORMAT(us.Ultimo_Acceso,'%d-%m-%Y %H:%i') as ultimo_acceso, us.depomun, us.tipous, ";
	$result99.="sec.NombreSecreataria, ";
	$result99.="mpio.Municipio ";
	$result99.="FROM Usuarios us ";
	$result99.="LEFT JOIN cyn_ac_ct_secretarias sec ON sec.IdSecretaria=us.IdDependencia ";
	$result99.="LEFT JOIN cyn_ac_ct_mpios mpio ON mpio.IdMpio=us.IdDependencia ";
	$result99.="WHERE us.Modulo=2 and us.id_us=".$_SESSION['MM_IdUsuario']." and us.IdUsuario<>23 ";
	$result99.="ORDER BY us.Usuario ";
	$rsCatalogos=mysql_query($result99,$link);*/



	$query1="SELECT idusuario, concat_ws(' ', nombre, paterno, materno) as nombre_completo, usuario, enuso, DATE_FORMAT(ultimo_acceso,'%d-%m-%Y %H:%i') as ultimo_acceso, idprivilegio ";
	$query1.="FROM ctra1_ct_usuarios ";
	$query1.="WHERE idusuario<>24 ";
	$query1.="ORDER BY usuario ";
	$result1=$link->query($query1);
	$row_count1=$result1->rowCount();

	$result2=$link->query("SELECT * FROM ctra1_catalogos WHERE enuso=1 and tp=4 ORDER BY concepto ");
	$row1=$result2->fetchAll(PDO::FETCH_ASSOC);

	$tipous[2] = "Coordinador Órgano de Control Interno";
	$tipous[3] = "Órgano de Control Interno";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('in_entrehead.php') ?>

<!-- botones agrupados -->
<style type="text/css">
.btn-toolbar {
    margin-bottom: 1px;
    margin-top: 1px;
}


.table tbody tr td {
	font-size: 17px;
}
</style>

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
<body data-spy="scroll" data-target=".bs-docs-sidebar" OnLoad="document.frmCaptura.campo1.focus();">

<?php include('in_header.php') ?>

<div class="row-fluid">
<div class="span12">
<h3>Catálogo Usuarios &nbsp;&nbsp;&nbsp;<i class="icon-asterisk"></i><?php echo $row_count1; ?> registro(s)</h3>

<?php if ($_GET['id_ct']==""){ ?>
	<div class="accordion" id="accordion2">
	<div class="accordion-group">
	  <div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"><i class="icon-th-list"></i>&nbsp;&nbsp;<strong>Nuevo Usuario:</strong></a>
	  </div>
	  <div id="collapseOne" class="accordion-body collapse">
		<div class="accordion-inner">
<form class="form-horizontal" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_agrega_usr.php">
	<fieldset>

<div class="control-group" id="gral1">
	  <div class="control-group" id="tipos3">
		<label class="control-label" for="tipo1"><em>Tipo de Usuario</em></label>
		<div class="controls docs-input-sizes">
			<div class="btn-group" data-toggle-name="tipo1" data-toggle="buttons-radio" >
			  <button type="button" value="1" class="btn active" data-toggle="button" id="seleccion1_1">Coordinador Órgano de Control Interno</button>
			  <button type="button" value="2" class="btn" data-toggle="button" id="seleccion1_2">Órgano de Control Interno</button>
			</div>
			<input type="hidden" name="tipo1" id="tipo1" value="2" />
		</div>
	  </div>

	  <div class="control-group" id="tipos1">
		<label class="control-label" for="Campo1">Órgano(s) de Control Interno</label>
		<div class="controls docs-input-sizes">
		  <select class="span5 chzn-select" data-placeholder="Selecciona Órgano(s) de Control Interno..." multiple="multiple" id="Campo1" name="Campo1[]">
			<?php
				foreach ($row1 as $row) {
					echo "<option value=".$row['id_unico'].">".$row['concepto']."</option>";
				}
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group" id="tipos2">
		<label class="control-label" for="Campo8">Órgano de Control Interno</label>
		<div class="controls docs-input-sizes">
		  <select class="span5" name="Campo8" id="Campo8">
			<?php
				foreach ($row1 as $row) {
					echo "<option value=".$row['id_unico'].">".$row['concepto']."</option>";
				}
			?>
		  </select>
		</div>
	  </div>
</div>

	  <div class="control-group">
		<label class="control-label" for="Campo2">Nombre</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo2" id="Campo2">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo3">Apellido Paterno</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo3" id="Campo3">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo4">Apellido Materno</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo4" id="Campo4">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo5">Usuario</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo5" id="Campo5">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo7">Contraseña</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="password" name="Campo7" id="Campo7">
		</div>
	  </div>

	  <div class="form-actions">
		<input type="hidden" name="pag" id="pag" value="10"/>
		<button type="submit" class="btn btn-primary">R E G I S T R A R</button>
	  </div>
	</fieldset>
</form>
		</div>
	  </div>
	</div>
	</div>
<?php }else{
	$result9=$link->prepare("SELECT * FROM ctra1_ct_usuarios WHERE idusuario=? and idusuario<>24 ");
	$result9->execute(array($_GET['id_ct']));
	$row2=$result9->fetch(PDO::FETCH_ASSOC);

	$result8=$link->prepare("SELECT id_refcat, id_campo FROM ctra1_cat_selecc WHERE id_pras=? and id_campo=5 ORDER BY id_campo, id_refcat ");
	$result8->execute(array($row2['idusuario']));
	$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
?>
<form class="form-horizontal" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_editar_usr.php">
	<fieldset>

<div class="control-group" id="gral1">
	  <div class="control-group" id="tipos3">
		<label class="control-label" for="tipo1"><em>Tipo de Usuario</em></label>
		<div class="controls docs-input-sizes">
			<div class="btn-group" data-toggle-name="tipo1" data-toggle="buttons-radio" >
			  <button type="button" value="1" class="btn <?php if($row2['idprivilegio']==2) echo 'active'; ?>" data-toggle="button" id="seleccion1_1">Coordinador Órgano de Control Interno</button>
			  <button type="button" value="2" class="btn <?php if($row2['idprivilegio']==3) echo 'active'; ?>" data-toggle="button" id="seleccion1_2">Órgano de Control Interno</button>
			</div>
			<input type="hidden" name="tipo1" id="tipo1" value="<?php echo $row2['idprivilegio']; ?>" />
		</div>
	  </div>

	  <div class="control-group" id="tipos1">
		<label class="control-label" for="Campo1">Órgano(s) de Control Interno</label>
		<div class="controls docs-input-sizes">
		  <select class="span5 chzn-select" data-placeholder="Selecciona Órgano(s) de Control Interno..." multiple="multiple" id="Campo1" name="Campo1[]">
			<?php
				$campo1arr=array();
				foreach ($row8 as $row) {
					$campo1arr[]=$row['id_refcat'];
				}

				foreach ($row1 as $row) {
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
			?>
		  </select>
		</div>
	  </div>

	  <div class="control-group" id="tipos2">
		<label class="control-label" for="Campo8">Órgano de Control Interno</label>
		<div class="controls docs-input-sizes">
		  <select class="span5" name="Campo8" id="Campo8">
			<?php
				$campo1arr=array();
				foreach ($row8 as $row) {
					$campo1arr[]=$row['id_refcat'];
				}

				foreach ($row1 as $row) {
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
			?>
		  </select>
		</div>
	  </div>
</div>


	  <div class="control-group">
		<label class="control-label" for="Campo2">Nombre</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo2" id="Campo2" value="<?php echo $row2['nombre'];?>">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo3">Apellido Paterno</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo3" id="Campo3" value="<?php echo $row2['paterno'];?>">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo4">Apellido Materno</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo4" id="Campo4" value="<?php echo $row2['materno'];?>">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo5">Usuario</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="text" name="Campo5" id="Campo5" value="<?php echo $row2['usuario'];?>">
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="Campo7">Contraseña</label>
		<div class="controls docs-input-sizes">
		  <input class="span5" type="password" name="Campo7" id="Campo7">
              <span class="help-inline">dejar en blanco el campo indica que no desea cambiar la contraseña</span>
		</div>
	  </div>

	  <div class="form-actions">
		<input type="hidden" name="pag" id="pag" value="10"/>
		<input type="hidden" name="id_ct" id="id_ct" value="<?php echo $_GET['id_ct']?>"/>
		<a class="btn" href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">CANCELAR</a>
		<button type="submit" class="btn btn-primary">ACTUALIZAR</button>
	  </div>
	</fieldset>
</form>
<?php
	}

if($_GET['cod']==1) {
	echo "<div class='alert alert-success'>";
	echo "<button class='close' data-dismiss='alert'>&times;</button>";
	echo "<strong>Registro exitoso!</strong> si lo desea puede continuar Capturando o Editando registros. <br><br><a class='btn' data-dismiss='alert'>CERRAR MENSAJE</a>";
	echo "</div>";
}

if($_GET['cod']==2) {
	echo "<div class='alert alert-error'>";
	echo "<button class='close' data-dismiss='alert'>&times;</button>";
	echo "<strong>¡Error!</strong> hubo un error mientras intentaba registrar o actualizar, quizas dejo uno o varios campos vacios, verifique por favor. <br><br><a class='btn' data-dismiss='alert'>CERRAR MENSAJE</a>";
	echo "</div>";
}

	if ($row_count1>0){
		echo "<table class='table table-bordered table-hover'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th width='25%'>Nombre</th>";
		echo "<th width='10%'>Usuario</th>";
		echo "<th width='15%'>Tipo</th>";
		echo "<th width='25%'>Órgano(s) de Control Interno</th>";
		echo "<th width='10%'>Ultimo Acceso</th>";
		echo "<th width='15%'>Opciones</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";

		while($row=$result1->fetch(PDO::FETCH_ASSOC)) {
			$colort="";
			if($row['enuso']==0){
				$colort="style='background-color:#e7e7e7; text-decoration:line-through;'";
			}

			$clase_color="";
			if($_GET['ex']==$row['idusuario']){
				$clase_color="class='info'";
			}

			$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as ejecutoras ";
			$result8.=" FROM ctra1_cat_selecc cs ";
			$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
			$result8.=" WHERE cs.id_pras=? and cs.id_campo=5 ";
			$result8.=" ORDER BY cs.id_campo ";
			$result8=$link->prepare($result8);
			$result8->execute(array($row['idusuario']));
			$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
			$row_count8=$result8->rowCount();

			$ejecutora="";
			if ($row_count8>0){
				foreach ($row8 as $row8c) {
					$ejecutora.=$row8c['ejecutoras'];
				}
			}

			echo "<tr valign='top' $colort $clase_color>";
			echo "<td><a name='".$row['idusuario']."'></a>".QuitarGuion($row['nombre_completo'])."</td>";
			echo "<td>".$row['usuario']."</td>";
			echo "<td>".$tipous[$row['idprivilegio']]."</td>";
			echo "<td>".$ejecutora."</td>";
			echo "<td>".$row['ultimo_acceso']."</td>";
			echo "<td style='text-align: center'>";

				echo "<div class='btn-toolbar'>";
				echo "<div class='btn-group'>";
				echo "<a class='btn' href='".$_SERVER['SCRIPT_NAME']."?id_ct=".$row['idusuario']."' alt='Editar Usuario' title='Editar Usuario'><i class='icon-pencil'></i></a>";
				if($row['enuso']==0){
					echo "<a class='btn' href='cta1_enuso_usr.php?id_ct=".$row['idusuario']."&est=".$row['enuso']."' alt='Habilitar Usuario' title='Habilitar Usuario'><i class='icon-refresh'></i></a>";
				}else{
					echo "<a class='btn btn-danger' href='cta1_enuso_usr.php?id_ct=".$row['idusuario']."&est=".$row['enuso']."' alt='Borrar Usuario' title='Borrar Usuario'><i class='icon-remove'></i></a>";
				}
				echo "</div>";
				echo "</div><!-- toolbar -->";

			echo "</td></tr>";
		}
		echo "</tbody></table>";
	}else{
		echo "<blockquote><h2>Sin registros aún</h2></blockquote>";
	}
?>
</div>
</div>

<?php include('in_footer.php') ?>

<script>
<?php if ($_GET['id_ct']==""){ ?>
	$("#tipos2").hide();
<?php }else{
	if($row2['idprivilegio']==2){ ?>
		$("#tipos2").hide();
	<?php }else{ ?>
		$("#tipos1").hide();
<?php }
} ?>

$("#seleccion1_2").click(function () {
	$("#tipos1").hide("fast", function () { });
	$("#tipos2").show("fast", function () {	});
	$("#tipo1").val("3");
});

$("#seleccion1_1").click(function () {
	$("#tipos1").show("fast", function () {	});
	$("#tipos2").hide("fast", function () { });
	$("#tipo1").val("2");
});
</script>

<script type="text/javascript">
	var elemento0 = document.getElementById("frmCaptura");
	elemento0.setAttribute("autocomplete", "off");
</script>

</body>
</html>
<?php
	$link=null;
?>