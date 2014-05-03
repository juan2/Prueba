<?php
switch ($_SESSION['MM_modulo_ac']) {
case '1':
	switch(TRUE) {
	case (strstr($myurldep, "cta1_alta")):
		$clase_sdurl1="active";
		break;
	case (strstr($myurldep, "cta1_rep_basico")):
		$clase_sdurl2="active";
		break;
	case (strstr($myurldep, "cta1_rep_per")):
		$clase_sdurl3="active";
		break;
	}

	echo "
		<!-- SIDEBAR -->
		<div id='sidebar' class='span2'>
			<ul id='deskton_nav' class='nav nav-list hidden-phone hidden-tablet hidden-ipad'>";
				if ($_SESSION['MM_UserGroupID']==1){
					echo "<li class='btn-modulo $clase_sdurl1'><a href='cta1_alta.php'><i class='icon-file-alt'></i><h4 class='label-modulo'>Nuevo PRAS</h4><small class='label-modulo'>agregar nuevo registro</small></a>
					</li>";
				}

				echo "<li class='btn-modulo $clase_sdurl2'><a href='cta1_rep_basico.php'><i class='icon-bar-chart'></i><h4 class='label-modulo'>Reporte</h4><small class='label-modulo'>basico</small></a>
				</li>

				<li class='btn-modulo $clase_sdurl3'><a href='cta1_rep_per.php'><i class='icon-bar-chart'></i><h4 class='label-modulo'>Reporte</h4><small class='label-modulo'>personalizado</small></a>
				</li>

			</ul>
		</div>
		<!-- /SIDEBAR -->
	";
	break;

case '2':

	break;

case '3':

	break;
}
?>