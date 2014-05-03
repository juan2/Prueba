<!-- menu -->
<?php
	$myurl = $_SERVER['SCRIPT_NAME'];
	$breakurl = Explode('/', $myurl);
	$myurldep = $breakurl[count($breakurl) - 1]; 
	$menu='';


switch ($_SESSION['MM_UserGroupID']) {
case '1':
	$privilegio='Administrador';
	break;
case '2':
	$privilegio='Captura';
	break;
case '3':
	$privilegio='Reportes';
	break;
}


switch ($_SESSION['MM_modulo_ac']) {
case '1':
	switch(TRUE) {
	case (strstr($myurldep, "cta1_cat_usuarios")):
		$claseurl1="class='active'";
		break;

	case (strstr($myurldep, "cta1_catalogos")):
		switch(TRUE) {
		case (strstr($_SERVER['QUERY_STRING'], "tp=7")):
			$claseurl2h="class='active'";
			break;
		case (strstr($_SERVER['QUERY_STRING'], "tp=6")):
			$claseurl2g="class='active'";
			break;
		case (strstr($_SERVER['QUERY_STRING'], "tp=5")):
			$claseurl2f="class='active'";
			break;
		case (strstr($_SERVER['QUERY_STRING'], "tp=4")):
			$claseurl2e="class='active'";
			break;
		case (strstr($_SERVER['QUERY_STRING'], "tp=3")):
			$claseurl2d="class='active'";
			break;
		case (strstr($_SERVER['QUERY_STRING'], "tp=2")):
			$claseurl2c="class='active'";
			break;
		case (strstr($_SERVER['QUERY_STRING'], "tp=1")):
			$claseurl2b="class='active'";
			break;
		}

		$claseurl2a="active";
		break;
	}
/*
		<li class='divider-vertical'></li>
		<li $claseurl1><a href='cyn_alta_acuerdos.php'><i class='icon-plus'></i> Nuevo PRASS</a></li>
		<li class='divider-vertical'></li>
		<li $claseurl2><a href='cyn_aprobacion.php'>Estatus Compromisos</a></li>

		<li class='divider-vertical'></li>
		<li class='dropdown'>
		  <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Reportes<b class='caret'></b></a>
		  <ul class='dropdown-menu'>
			<li $claseurl8><a href='cyn_rep_en_acuerdo.php'><i class='icon-tasks'></i> Personalizado</a></li>
			<li $claseurl8b><a href='cyn_rep_cerrados.php'><i class='icon-tasks'></i> Estatus 'TERMINADO'</a></li>
			<li class='divider'></li>
			<li $claseurl2b><a href='cyn_aprobacion_errores.php'><i class='icon-warning-sign'></i> Errores de Importación</a></li>
		  </ul>
		</li>
*/
#cta1_cat_usuarios
	if ($_SESSION['MM_UserGroupID']==1){
		$menu_use="<li class='divider-vertical'></li><li $claseurl1><a href='cta1_cat_usuarios.php'><i class='icon-user'></i> Usuarios</a></li>";
	}

	if ($_SESSION['MM_UserGroupID']==1){
		$menu_cat="<li class='divider-vertical'></li>
			<li class='dropdown $claseurl2a'>
			  <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='icon-folder-open'></i>Cat&aacute;lagos<b class='caret'></b></a>
			  <ul class='dropdown-menu'>
				<li $claseurl2b><a href='cta1_catalogos.php?tp=1'>Entes fiscalizadores</a></li>
				<li $claseurl2c><a href='cta1_catalogos.php?tp=2'>Fondo</a></li>
				<li $claseurl2d><a href='cta1_catalogos.php?tp=3'>Programa</a></li>
				<li $claseurl2e><a href='cta1_catalogos.php?tp=4'>Dependencia</a></li>
				<li $claseurl2f><a href='cta1_catalogos.php?tp=5'>Municipio</a></li>
				<li $claseurl2g><a href='cta1_catalogos.php?tp=6'>Estatus</a></li>
				<li $claseurl2h><a href='cta1_catalogos.php?tp=7'>Auditoria Ejercicio</a></li>
			  </ul>
			</li>";
	}
	break;

case '2':

	break;

case '3':

	break;
}

if (($_SESSION['MM_modulo1']+$_SESSION['MM_modulo2']+$_SESSION['MM_modulo3'])>1){
	$menu_sis="<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='icon-tags'></i>Módulos<b class='caret'></b></a>
		<ul class='dropdown-menu'>";
		if ($_SESSION['MM_modulo1']){
			$menu_sis.="<li><a href='modulos.php?tp=1&pg=$myurl_mod'>PRAS</a></li>";
		}
		if ($_SESSION['MM_modulo2']){
			$menu_sis.="<li><a href='modulos.php?tp=2&pg=$myurl_mod'>MODULO 2</a></li>";
		}
		if ($_SESSION['MM_modulo3']){
			$menu_sis.="<li><a href='modulos.php?tp=3&pg=$myurl_mod'>MODULO 3</a></li>";
		}
	$menu_sis.="</ul>
	</li>";
}


if (strstr($myurldep, "inicio")){
	$claseurl99="class='active'";
}

if (strstr($myurldep, "cta1_notifica.php")){
	$claseurl88="class='active'";
}

if (strstr($myurldep, "cta1_notifica3.php")){
	$claseurl77="class='active'";
}

	$menu_inicio="<li class='divider-vertical'></li><li $claseurl99><a href='inicio.php'><i class='icon-flag'></i> Inicio</a></li>";

	$menu_notifica="<li class='divider-vertical'></li><li $claseurl88><a href='cta1_notifica.php'>Cambios Bitacora <span class='badge badge-info'>
<script src='jquery/notifica_aj.js'></script>
<script type='text/javascript'>refreshdiv();</script>
<div id='timediv'></div>
</span></a></li>

<li class='divider-vertical'></li><li $claseurl77><a href='cta1_notifica3.php'>Cambios Status <span class='badge badge-info'>
<script src='jquery/notifica_aj2.js'></script>
<script type='text/javascript'>refreshdiv2();</script>
<div id='timediv2'></div>
</span></a></li>";
?>
<div class="navbar navbar-fixed-top" id="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">

            <!-- LOGOS -->
            <div class="row-fluid" id="logos">
                <div>
                    <!-- MENU USUARIO DESKTOP -->
<div class="user-desktop pull-right hidden-phone" id="user">
    <div class="profile">
        <img src="twbotstrap/no_avatar.jpg" class="img-rounded pull-left">
        <p class="pull-left"><small><?php echo $_SESSION["MM_Username"]; ?><br><strong><?php echo $privilegio; ?></strong></small></p>
    </div>
    <div class="actions btn-group">
        <button data-placement="bottom" title="" class="btn" value="" data-original-title="Notificaciones" onclick="window.location='#';"><span class="badge badge-warning">1</span><i class="icon-bell"></i></button>
        <button data-placement="bottom" title="" class="btn" value="" data-original-title="Mensajes" onclick="window.location='#';"><span class="badge badge-warning">2</span><i class="icon-envelope-alt"></i></button>
        <button data-placement="bottom" title="" class="btn" value="perfil" data-original-title="Perfil" onclick="window.location='#';"><i class="icon-cog"></i></button>
        <button data-placement="bottom" title="" class="btn" value="logout" data-original-title="Salir" onclick="window.location='salir.php';"><i class="icon-off"></i></button>
    </div>
</div>
<!-- /MENU USUARIO DESKTOP -->

                </div>
                <a class="brand hidden-phone pull-left" href="inicio.php"><img alt="" src="twbotstrap/logo_app.png"></a>
                <img src="twbotstrap/EstadoFuerte.png" class="brand-lema pull-right hidden-phone">
            </div>
            <!-- /LOGOS -->

            <!-- MENU ADMINISTRADOR -->
             <div class="row-fluid" id="menus">
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><i class="icon-reorder"></i></a>
    <div class="nav-collapse collapse">
        <ul class="nav">
			<?php echo $menu_sis;?>
			<?php echo $menu_cat;?>
			<?php echo $menu_use;?>
			<?php echo $menu_notifica;?>
			<?php echo $menu_inicio;?>
        </ul>
    </div>
</div>
            <!-- /MENU ADMINISTRADOR -->

        </div>
    </div>
</div><!-- /navbar -->

<div class="container-fluid">