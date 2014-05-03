<?php
	$rutatwb='twbotstrap/ver231';
	$rutafaw='twbotstrap/font_awes302';

	$myurl_mod = $_SERVER['REQUEST_URI'];
	$breakurl_mod = Explode('/', $myurl_mod);
	$myurl_mod = $breakurl_mod[count($breakurl_mod) - 1];

	echo "<title>Gobierno del Estado de Tamaulipas</title> \n";

# twitter bootstrap
	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'> \n";
	echo "<meta name='description' content=''> \n";
	echo "<meta name='author' content=''> \n";

# Le styles
	echo "<script src='$rutatwb/js/jquery.js'></script> \n";
	echo "<link href='$rutatwb/css/bootstrap.css' rel='stylesheet'> \n";

	echo "<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements --> \n";
	echo "<!--[if lt IE 9]> \n";
	echo "  <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script> \n";
	echo "<![endif]--> \n";

# JS mios
	echo "<link href='$rutafaw/font-awesome.css' rel='stylesheet'> \n";
	echo "<link href='twbotstrap/mis_mods_twb.css' rel='stylesheet'> \n";

	echo "<link rel='stylesheet' media='screen,projection' href='jquery/gotop/css/ui.totop.css' /> \n";
	echo "<script src='jquery/gotop/js/easing.js' type='text/javascript'></script> \n";
	echo "<script src='jquery/gotop/js/jquery.ui.totop.js' type='text/javascript'></script> \n";
	echo "<script type='text/javascript'>
	$(document).ready(function() {
		/*
		var defaults = {
			containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear'
		};
		*/
		$().UItoTop({ easingType: 'easeOutQuart' });

	});
</script> \n";
?>