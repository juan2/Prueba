<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php
	$link=Conectarse();

	if ($_SESSION['MM_UserGroupID']!=1){
		$filtroxsecre='';
			if ($_SESSION['MM_UserGroupID']!=1){
				$filtroxsecre=" and id_organo in (select distinct id_refcat from ctra1_cat_selecc where id_campo=5 and id_pras=".$_SESSION['MM_IdUsuario'].")";
		}
	}


	$fecha_ini=add_date(date('Y-m-d'),$day=-5,$mth=0,$yr=0);
	$fecha_fin=date('Y-m-d');

	$result1=$link->query("SELECT id_unico FROM ctra1_pras WHERE (date(fecha_cambio_estatus) BETWEEN '".$fecha_ini."' and '".$fecha_fin."') and eliminado=0 $filtroxsecre ");
	$row_count1=$result1->rowCount();


	if ($row_count1>0){
		echo $row_count1;
	}else{
		echo '0';
	}
?>