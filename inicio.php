<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	$filtroxsecre_sin='';
	if ($_SESSION['MM_UserGroupID']!=1){
		$filtroxsecre_sin=" and id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5)";
	}

	$result1=$link->query("SELECT COUNT(id_unico) as tot_terminados FROM ctra1_pras WHERE id_estatus=82 $filtroxsecre_sin ");
	$row_count1=$result1->rowCount();
	if ($row_count1>0){
		$objrs1=$result1->fetchObject();
		$tot_terminados=$objrs1->tot_terminados;
	}else{
		$tot_terminados=0;
	}

	$result2=$link->query("SELECT COUNT(id_unico) as tot_ejecc FROM ctra1_pras WHERE id_estatus=2 ");
	$row_count2=$result2->rowCount();
	if ($row_count2>0){
		$objrs2=$result2->fetchObject();
		$tot_ejecc=$objrs2->tot_ejecc;
	}else{
		$tot_ejecc=0;
	}

	$result3=$link->query("SELECT COUNT(id_unico) as tot_valora FROM ctra1_pras WHERE id_estatus=1 ");
	$row_count3=$result3->rowCount();
	if ($row_count3>0){
		$objrs3=$result3->fetchObject();
		$tot_valora=$objrs3->tot_valora;
	}else{
		$tot_valora=0;
	}

	$result4=$link->query("SELECT COUNT(id_unico) as total_invita FROM ctra1_pras WHERE Eliminado=0 ");
	$row_count4=$result4->rowCount();
	if ($row_count4>0){
		$objrs4=$result4->fetchObject();
		$total_invita=$objrs4->total_invita;
	}else{
		$total_invita=0;
	}


	// $result77="SELECT rep.*, ";
	// $result77.=" us.Nombre as usuario ";
	// $result77.=" FROM cyn_ac_reportes rep ";
	// $result77.=" LEFT JOIN Usuarios us ON us.IdUsuario=rep.id_us ";
	// if ($_SESSION['MM_UserGroupID']!=1){
	// 	$result77.=" WHERE rep.id_us=".$_SESSION['MM_IdUsuario']." ";
	// }
	// $result77.=" ORDER BY us.Nombre ";
	// $rsReportes=mysql_query($result77,$link);


	$result5=$link->query("SELECT rep.*, us.nombre as usuario FROM ctra1_fav_reportes rep LEFT JOIN ctra1_ct_usuarios us ON us.idusuario=rep.id_us ORDER BY us.nombre ");
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
<?php } ?>
	</div>

<?php }else{ ?>


	<div class="row-fluid">

	<?php include('in_sidebar.php') ?>

	<div id="sidebar" class="span10">
		<div class="row-fluid">
			<h2>Resumen de actividades</h2>
		</div>

		<div class="span2">
		  <div class="well well-large" onclick="window.location='inicio.php';">
		  <center>
		      <div style="font-size: 50px;"><a href="inicio.php" class="sombra"><i class="icon-check"></i></a></div>
		      <h4><?php echo $tot_terminados.'/'.$total_invita;?><br />
		      PRAS</h4>
		  </center>
		  </div>
		</div>
	</div>

	</div>



	<div class="row-fluid">

	<div id='sidebar' class='span2'>
	</div>

	<?php
	if ($row_count5>0){
		echo "<div class='span10'>
			<div class='accordion' id='accordion1'>
			<div class='accordion-group'>
			  <div class='accordion-heading'>
				<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion1' href='#collapseOne'><i class='icon-save'></i>&nbsp;&nbsp;<strong>Reportes Predefinidos</strong></a>
			  </div>
			  <div id='collapseOne' class='accordion-body collapse'>
				<div class='accordion-inner'>";

				echo "<div class='span2'>
				  <div class='well well-large' onclick=window.location='cta1_rep_prdefin.php';>
				  <center>
				      <div style='font-size: 50px;'><a href='cta1_rep_prdefin.php' class='sombra'><i class='icon-cog'></i></a></div>
				      <h4>Eliminar Reportes Predefinidos</h4>
				  </center>
				  </div>
				</div>";

			while($row=$result5->fetch(PDO::FETCH_ASSOC)) {
				echo "<div class='span2'>
				  <div class='well well-large' onclick=window.location='cta1_rep_per.php?params=".urldecode($row['reporte'])."';>
				  <center>
				      <div style='font-size: 50px;'><a href='cta1_rep_per.php?params=".urldecode($row['reporte'])."' class='sombra'><i class='icon-user'></i></a></div>
				      <h4>".$row['usuario']."<br />
				      ".$row['nombre']."</h4>
				  </center>
				  </div>
				</div>";
				}
		echo "</div>
		  </div>
		</div>
		</div>
	</div><!-- /span10 -->";
	}
	} ?>

	</div>



<?php include('in_footer.php') ?>

</body>
</html>
<?php
	$link=null;
?>