<?php include('validar.php') ?>
<?php include('validar_md1.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

switch ($_GET['tp']) {
case '1':
	$titulo="Entes fiscalizadores";
	$forma="Ente";
	$tabla="Entes";
	break;
case '2':
	$titulo="Fondo";
	$forma="Fondo";
	$tabla="Fondos";
	break;
case '3':
	$titulo="Programa";
	$forma="Programa";
	$tabla="Programas";
	break;
case '4':
	$titulo="Dependencia";
	$forma="Dependencia";
	$tabla="Dependencias";
	break;
case '5':
	$titulo="Municipio";
	$forma="Municipio";
	$tabla="Municipios";
	break;
case '6':
	$titulo="Estatus";
	$forma="Estatus";
	$tabla="Estatus";
	break;
case '7':
	$titulo="Auditoria Ejercicio";
	$forma="Auditoria Ejercicio";
	$tabla="Auditoria Ejercicio";
	break;
}

	$query1="SELECT * ";
	$query1.="FROM ctra1_catalogos ";
	$query1.="WHERE tp=? ";
	$query1.="ORDER BY concepto ";
	$result1=$link->prepare($query1);
	$result1->execute(array($_GET['tp']));
	$row_count1=$result1->rowCount();
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
<h3>Catálogo <?php echo $titulo;?> &nbsp;&nbsp;&nbsp;<i class="icon-asterisk"></i><?php echo $row_count1; ?> registro(s)</h3>

<?php if ($_GET['id_ct']==""){ ?>
	<form class="well form-inline" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_agrega.php">
		<label class="checkbox">Nuevo <?php echo $forma;?></label>
		<input type="text" class="input-xxlarge" name="campo1" id="campo1">
		<input type="hidden" name="tp" id="tp" value="<?php echo $_GET['tp'];?>"/>
		<button type="submit" class="btn btn-primary">REGISTRAR</button>
	</form>
<?php }else{
	$result2=$link->prepare("SELECT concepto FROM ctra1_catalogos WHERE id_unico=? AND tp=? ");
	$result2->execute(array($_GET['id_ct'], $_GET['tp']));
	$row2=$result2->fetch(PDO::FETCH_ASSOC)
?>
	<form class="well form-inline" id="frmCaptura" name="frmCaptura" method="POST" action="cta1_editar.php">
		<label class="checkbox">Editando <?php echo $forma;?></label>
		<input type="text" class="input-xxlarge" name="campo1" id="campo1" value="<?php echo $row2['concepto'];?>">
		<input type="hidden" name="tp" id="tp" value="<?php echo $_GET['tp'];?>"/>
		<input type="hidden" name="id_ct" id="id_ct" value="<?php echo $_GET['id_ct']?>"/>
		<button type="submit" class="btn btn-primary">ACTUALIZAR</button>
		<a class="btn" href="<?php echo $_SERVER['SCRIPT_NAME']."?tp=".$_GET['tp']; ?>">CANCELAR</a>
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
		echo "<th width='85%'>$tabla</th>";
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
			if($_GET['ex']==$row['id_unico']){
				$clase_color="class='info'";
			}

			echo "<tr valign='top' $colort $clase_color>";
			echo "<td><a name='".$row['id_unico']."'></a>".$row['concepto']."</td>";
			echo "<td style='text-align: center'>";

				echo "<div class='btn-toolbar'>";
				echo "<div class='btn-group'>";
				echo "<a class='btn' href='".$_SERVER['SCRIPT_NAME']."?tp=".$_GET['tp']."&id_ct=".$row['id_unico']."' title='Editar $forma'><i class='icon-pencil'></i></a>";
				if($row['enuso']==0){
					echo "<a class='btn' href='cta1_enuso.php?id_ct=".$row['id_unico']."&est=".$row['enuso']."&tp=".$_GET['tp']."' title='Habilitar $forma'><i class='icon-refresh'></i></a>";
				}else{
					echo "<a class='btn btn-danger' href='cta1_enuso.php?id_ct=".$row['id_unico']."&est=".$row['enuso']."&tp=".$_GET['tp']."' title='Borrar $forma'><i class='icon-remove'></i></a>";
				}
				echo "</div>";
				echo "</div><!-- toolbar -->";

			echo "</td></tr>";
		}
		echo "</tbody></table>";
	}
?>
</div>
</div>

<?php include('in_footer.php') ?>

<script type="text/javascript">
	var elemento0 = document.getElementById("frmCaptura");
	elemento0.setAttribute("autocomplete", "off");
</script>

</body>
</html>
<?php
	$link=null;
?>