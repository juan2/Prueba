<?php include('utiles.php') ?>
<?php
	ini_set('display_errors','0');
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, 'es_MX');

	session_start();
	session_unset();
	session_destroy();
	session_start();

	if (isset($_POST['rememberme']))
		$rememberme=$_POST['rememberme'];
	else
		$rememberme=0;

	if (isset($_POST ['user_login']))
		$user_login=$_POST['user_login'];
	else
		$user_login="";

	if (isset($_POST ['user_pass']))
		$user_pass=hash('sha256', $_POST ['user_pass']);
#		$user_pass=md5($_POST ['user_pass']);
	else
		$user_pass="";

	$noexisteusuario=0;

	// proporcionar usuario y password
	if ((!empty($user_login) && !empty($user_pass))) {
		$link=Conectarse();

		$query1="SELECT u.idusuario, concat_ws(' ', u.nombre, u.paterno) as nombre_completo, u.modulo1, u.modulo2, u.modulo3, u.iddependencia, u.idprivilegio ";
		$query1.="FROM ctra1_ct_usuarios u ";
		$query1.="WHERE u.usuario=? AND u.password=? ";
		$result1=$link->prepare($query1);
		$result1->execute(array($user_login, $user_pass));
		$row_count=$result1->rowCount();

		if ($row_count>0){
/*			$result8="SELECT GROUP_CONCAT(cc.concepto ORDER BY cc.tp, cc.concepto SEPARATOR ', ') as ejecutoras ";
			$result8.=" FROM ctra1_cat_selecc cs ";
			$result8.=" LEFT JOIN ctra1_catalogos cc ON cc.id_unico=cs.id_refcat ";
			$result8.=" WHERE cs.id_pras=? and cs.id_campo=5 ";
			$result8.=" ORDER BY cs.id_campo ";
			$result8=$link->prepare($result8);
			$result8->execute(array($objrs->idusuario));
			$row8=$result8->fetchAll(PDO::FETCH_ASSOC);
			$row_count8=$result8->rowCount();

			$ejecutora="";
			if ($row_count8>0){
				foreach ($row8 as $row8c) {
					$ejecutora.=$row8c['ejecutoras'];
				}
			}*/

			$objrs=$result1->fetchObject();

			$_SESSION['MM_IdUsuario']=$objrs->idusuario;
			$_SESSION['MM_Username']=QuitarGuion($objrs->nombre_completo);
			$_SESSION['MM_modulo1']=$objrs->modulo1;
			$_SESSION['MM_modulo2']=$objrs->modulo2;
			$_SESSION['MM_modulo3']=$objrs->modulo3;
			$_SESSION['MM_UserGroupID']=$objrs->idprivilegio;
			$_SESSION['MM_IdDependencia']=$objrs->iddependencia;
			$_SESSION['aut_ctral13']=true;
			$_SESSION['ultimoAcceso']= date('Y-n-j H:i:s');
			if (($_SESSION['MM_modulo1']+$_SESSION['MM_modulo2']+$_SESSION['MM_modulo3'])==1){
				switch(TRUE) {
				case ($_SESSION['MM_modulo1']==1):
					$_SESSION['MM_modulo_ac']=1;
					break;
				case ($_SESSION['MM_modulo2']==1):
					$_SESSION['MM_modulo_ac']=2;
					break;
				case ($_SESSION['MM_modulo3']==1):
					$_SESSION['MM_modulo_ac']=3;
					break;
				}
			}else{
				$_SESSION['MM_modulo_ac']=0;
			}

			// ultima visita
			$fecha_completa=date('Y-n-j H:i:s');
			$actualiza1=$link->prepare("UPDATE ctra1_ct_usuarios SET ultimo_acceso=:fecha_completa WHERE idusuario=:idusuario ");
			$actualiza1->execute(array(":fecha_completa"=>$fecha_completa, ":idusuario"=>$objrs->idusuario));

			$link=null;

			header('Location: inicio.php');
			$noexisteusuario=1;
		}

		$link=null;
		$noexisteusuario=2;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Gobierno del Estado de Tamaulipas</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="images/ios.png" />

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

</head>

<body OnLoad="document.loginform.user_login.focus();">

<div id="wraplogin">
  <h1></h1>
  <div id="login_error" class="loginerror" style="display:none" >
  <strong>ERROR:</strong> parece que el usuario no existe, vuelva a intentarlo o comuníquese con el Administrador del Sitio</div>

  <div id="login_cod1" class="loginerror" style="display:none" >
  <strong>Aviso:</strong> la Sesión ha finalizado</div>

  <div id="login_cod2" class="loginerror" style="display:none" >
  <strong>Aviso:</strong> no ha iniciado Sesión, por favor proporcione los siguientes datos</div>

  <div id="login_cod3" class="loginerror" style="display:none" >
  <strong>Aviso:</strong> la Sesión ha finalizado debido a inactividad</div>

  <form name="loginform" id="loginform" action="index.php" method="POST">
	  <p><label for="user_login">Nombre de usuario<br>
      <input type="text" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10"></label></p>
	  <p><label for="user_pass">Contraseña<br>
      <input type="password" name="user_pass" id="user_pass" class="input" value="" size="20" tabindex="20"></label></p>
	  <p class="recordarpass">&nbsp;</p>
      <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Acceder" tabindex="100"></p>
    </form>
</div>
</body>

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<?php
	if ($noexisteusuario==2)
		funcion_java ('$("#login_error").show();');

	if ($_GET['cod']==1)
		funcion_java ('$("#login_cod1").show();');

	if ($_GET['cod']==2)
		funcion_java ('$("#login_cod2").show();');

	if ($_GET['cod']==3)
		funcion_java ('$("#login_cod3").show();');

#echo md5('contraloria')."<br>";
#echo hash('sha256', 'contraloria')
?>
</html>