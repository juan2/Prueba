<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	if(trim($_GET['params'])!=''){
		$_POST=unserialize($_GET['params']);
	}


	$filtroxsecre='';
	$filtroxsecre_pag='';
	if ($_SESSION['MM_UserGroupID']!=1){
		$filtroxsecre=" and pr.id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5 and id_pras=".$_SESSION['MM_IdUsuario'].")";
		$filtroxsecre_pag=" and `id_organo` in (select distinct `id_refcat` from `ctra1_cat_selecc` where `id_campo`=5 and `id_pras`=".$_SESSION['MM_IdUsuario'].")";
		$filtroxsecre_sin=" and id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5 and id_pras=".$_SESSION['MM_IdUsuario'].")";
	}
#print_r($_SESSION);
#echo '<br>'.$filtroxsecre.'<br>';


	#paginacion
    include_once ('jquery/paginator2/function.php');
	$page=(int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$limit=10;
	$startpoint=($page * $limit) - $limit;
	$statement = "ctra1_pras where eliminado=0 $filtroxsecre_pag ";


	$result99="SELECT pr.id_unico, pr.pras, pr.id_entefis, pr.ejecutora, pr.id_presuntores, pr.id_organo, pr.id_estatus, ";
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
	$result99.=" WHERE pr.eliminado=0 $filtroxsecre ";
	$result99.=" ORDER BY pr.id_unico LIMIT {$startpoint} , {$limit} ";
	$result1=$link->query($result99);
	$row_count1=$result1->rowCount();

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
	$paso=pagination($statement,$limit,$page);

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

	$result3=$link->query("SELECT * FROM ctra1_catalogos WHERE tp=6 and enuso=1 ORDER BY concepto ");
	$result3->setFetchMode(PDO::FETCH_ASSOC);
	$result3->execute();
	$row3=$result3->fetchAll();
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

<!-- countdown reloj -->
<style type="text/css">
@import "jquery/reloj/jquery.countdown.css";
#defaultCountdown { width: 240px; height: 45px; }
</style>
<!-- 
http://keith-wood.name/countdown.html
<script type="text/javascript" src="jquery/reloj/jquery.min.js"></script>-->
<script type="text/javascript" src="jquery/reloj/jquery.countdown.js"></script>
<script type="text/javascript">
$(function () {
	var austDay = new Date();
	austDay = new Date(<?php echo $fechayhora;?>);
	$('#defaultCountdown').countdown({until: austDay});
	$('#year').text(austDay.getFullYear());
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
<h3>Estatus PRAS &nbsp;&nbsp;&nbsp;<i class="icon-asterisk"></i><?php echo $total_reg.' de '.$total_general; ?> registro(s)</h3>
<?php
	if ($row_count1>0){
		echo pagination($statement,$limit,$page);

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
			$row_count8=$result9->rowCount();

			$presuntores="";
			if ($row_count8>0){
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
			echo "<td>".$row['concepto1']."</td>";
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
							if ($row3b['id_unico']!=$row['id_estatus']){
								echo "<li><a href='cta1_cambia_status_boton.php?idu=".$row['id_unico']."&est=".$row3b['id_unico']."&page=".$mipage."&pag=1'>".$row3b['concepto']."</a></li>";
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
						echo "<a class='btn $existe_archivo' href='cta1_linea.php?idu=".$row['id_unico']."&pag=1' title='Cronología de Comentarios'><i class='icon-paper-clip'></i></a>";
#&params=serialize($_POST)
					}

				if ($_SESSION['MM_UserGroupID']==1){
					echo "<a class='btn' id='editar' href='cta1_edita_pras.php?idu=".$row['id_unico']."&pag=1' title='Editar PRAS'><i class='icon-pencil'></i></a>";
						if ($row['id_estatus']!=82){
							echo "<a class='btn btn-danger' href=\"javascript:confirma('cta1_borra_pras.php?idu=".$row['id_unico']."&page=".$mipage."&est=1&pag=1')\" title='Borrar PRAS'><i class='icon-remove'></i></a>";
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
						echo "<a class='btn' id='editar' href='cta1_edita_pras.php?idu=".$row['id_unico']."&pag=1' title='Editar PRAS'><i class='icon-pencil'></i></a>";
					}
					echo "</div>";
					echo "</div><!-- toolbar -->";

				}

			echo "</td></tr>";
		}
		echo "</tbody></table>";

	echo pagination($statement,$limit,$page);
	echo "<br /><br /><br /><br />";
	}else{
		echo "<blockquote><h2>No hay registros para la consulta solicitada</h2></blockquote>";
	}
?>
</div><!-- /span10 -->

</div>

<?php include('in_footer.php') ?>

</body>
</html>
<?php
	$status_texto=array();
	$link=null;
?>