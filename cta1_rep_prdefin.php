<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$result5=$link->query("SELECT rep.*, us.nombre as usuario FROM ctra1_fav_reportes rep LEFT JOIN ctra1_ct_usuarios us ON us.idusuario=rep.id_us WHERE rep.id_us=".$_SESSION['MM_IdUsuario']." ORDER BY rep.fecha_completa ");
	$row_count5=$result5->rowCount();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('in_entrehead.php') ?>

<style type="text/css">
.sombra {
	text-shadow: 1px 1px RGBA(0,0,0,0.5);
}

a {
	color: #FF6600;
	text-decoration: none;
//	text-shadow: 1px 1px RGBA(0,0,0,0.5);
}

a:hover {
	color: #E25700;
	text-decoration: none;
}

p {
//	font-family:'Lucida Grande', Helvetica, Arial, sans-serif;
//	font-size:14pt;
}


.well{
	min-height:135px;
	cursor:pointer;
}
</style>

<!-- confirma -->
<script language="javascript">
function confirma(url){
direccion = url;
	if (confirm("¿En realidad desea borrar este Reporte Predefinido?")){
		self.location = direccion
		return true
	}
}
</script>

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

<?php include('in_header.php') ?>

<?php if ($_SESSION['MM_modulo_ac']==0){ ?>
	<div class="row-fluid">
		<h2>Elija Módulo</h2>
	</div>

	<div class="row-fluid">

<?php if ($_SESSION['MM_modulo1']){ ?>
	<div class="span2">
	  <div class="well well-large" onclick="window.location='modulos.php?tp=1&pg=<?php echo $myurl_mod; ?>';">
	  <center>
	      <div style="font-size: 50px;"><a href="modulos.php?tp=1&pg=<?php echo $myurl_mod; ?>" class="sombra"><i class="icon-lightbulb"></i></a></div>
	      <h4>PRAS<br /> creacion de</h4>
	  </center>
	  </div>
	</div>
<?php 
}
if ($_SESSION['MM_modulo2']){ ?>
	<div class="span2">
	  <div class="well well-large" onclick="window.location='modulos.php?tp=2&pg=<?php echo $myurl_mod; ?>';">
	  <center>
	      <div style="font-size: 50px;"><a href="modulos.php?tp=2&pg=<?php echo $myurl_mod; ?>" class="sombra"><i class="icon-lightbulb"></i></a></div>
	      <h4>MODULO 2<br /> creacion de</h4>
	  </center>
	  </div>
	</div>
<?php 
}
if ($_SESSION['MM_modulo3']){ ?>
	<div class="span2">
	  <div class="well well-large" onclick="window.location='modulos.php?tp=3&pg=<?php echo $myurl_mod; ?>';">
	  <center>
	      <div style="font-size: 50px;"><a href="modulos.php?tp=3&pg=<?php echo $myurl_mod; ?>" class="sombra"><i class="icon-lightbulb"></i></a></div>
	      <h4>MODULO 3<br /> creacion de</h4>
	  </center>
	  </div>
	</div>
<?php 
}
?>
	</div>

<?php }else{ ?>


	<div class="row-fluid">

	<?php include('in_sidebar.php') ?>

	<div id="sidebar" class="span10">
		<div class="row-fluid">
			<h2>Eliminar Reportes Predefinidos</h2>
		</div>

	<?php
	if ($row_count5>0){
		echo "<div class='row-fluid'>";

			while($row=$result5->fetch(PDO::FETCH_ASSOC)) {
				echo "<div class='span2'>
				  <div class='well well-large';>
				  <center>
				      <div style='font-size: 50px;'><a href=\"javascript:confirma('cta1_borra_reporte.php?id_r=".$row['id_rep']."')\" class='sombra'><i class='icon-trash'></i></a></div>
				      <h4>".$row['usuario']."<br />
				      ".$row['nombre']."</h4>
				  </center>
				  </div>
				</div>";
				}
		echo "</div><!-- /row-fluid -->";
	}
	} ?>
	</div>

	</div>

<?php include('in_footer.php') ?>

</body>
</html>
<?php
	$link=null;
?>