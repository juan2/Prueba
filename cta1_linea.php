<?php include('utiles.php') ?>
<?php include('validar.php') ?>
<?php
/*
	if(trim($_GET['params'])!=''){
		$_POST=unserialize($_GET['params']);
	}
*/

	switch ($_GET['pag']) {
	case '1':
		$pag_redirecciona="cta1_rep_basico.php";
		break;
	case '2':
		$pag_redirecciona="cta1_rep_per.php";
		break;
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='twbotstrap/ver231/js/jquery.js'></script> 
<link href="twbotstrap/ver231/css/bootstrap.css" rel="stylesheet">
	<meta charset="utf-8">
	<meta name="description" content="TimelineJS example">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<!-- Style-->
<style>
	html, body {
		height:100%;
		padding: 0px;
		margin: 0px;
	}
</style>
<!-- HTML5 shim, for IE6-8 support of HTML elements--><!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>
<!-- BEGIN Timeline Embed -->
<div id="timeline-embed"></div>


<script type="text/javascript" src="jquery/timeline2/compiled/js/storyjs-embed.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		$.getJSON("cta1_linea2.php",{idu:<?php echo $_GET['idu']; ?>},function(json){
			createStoryJS({
				width: "100%",
				height: "80%",
				lang:"es",
				source: json
			});
		});


	});

</script>

<!-- END Timeline Embed-->
<div class="row-fluid">
	<div class="span4"></div>
	<div class="span4" style="text-align:center">
		<br><p><a class="btn btn-primary" href="<?php echo $pag_redirecciona; ?>">REGRESAR</a></p>
	</div>
	<div class="span4"></div>
</div>

</body>
</html>