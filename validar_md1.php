<?php
if ($_SESSION['MM_modulo_ac']!=1) {
	$_SESSION['MM_modulo_ac']=null;
	header('Location: inicio.php');
}
?>