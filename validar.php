<?php header('Content-Type: text/html;charset=utf-8'); ?>
<?php
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, 'es_MX');
if (!isset($_SESSION))
	session_start();

	ini_set('display_errors','0');

if ($_SESSION['aut_ctral13']!=1) {
	Session_destroy();
	header('Location: index.php?cod=2');
}else{
    $fechaGuardada=$_SESSION['ultimoAcceso'];
    $ahora=date('Y-n-j H:i:s');
	$tiempo_transcurrido=(strtotime($ahora)-strtotime($fechaGuardada));

	if($tiempo_transcurrido >= 10800) {
		session_destroy();
		header('Location: index.php?cod=3');
    }else{
	    $_SESSION['ultimoAcceso']=$ahora;
   }
}
?>