<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
	session_start();
	session_unset(); 
	session_destroy();
	header('Location: index.php?cod=1');
?>
