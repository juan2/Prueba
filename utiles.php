<?php
function Conectarse() {
	try {
		$link=new PDO('mysql:host=localhost; dbname=sist_contral2; charset=utf8', 'contral', 'on4te0fa');
		$link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	} catch(PDOException $ex) {
		echo "Error conectando a la base de datos ";
		echo $ex->getMessage();
	}
#	mysql_query("SET NAMES 'utf8'");
	return $link;
}

function actual_date ($date)
{
	$date = explode('-',$date);
	$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$year_now = $date[0];
	$month_now = number_format($date[1]);
	$day_now = $date[2];
	$week_day_now = date ('w');
	$date = $day_now . " de " . $months[$month_now] . " de " . $year_now;
	return $date;
}

function add_date($givendate,$day=0,$mth=0,$yr=0) {
	$cd = strtotime($givendate);
	$newdate = date('Y-m-d', mktime(date('h',$cd),
    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
    date('d',$cd)+$day, date('Y',$cd)+$yr));
	return $newdate;
}

function cambiaDMA($givendate) {
	$cd = strtotime($givendate);
	$newdate = date('d-m-Y', mktime(date('h',$cd),
    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
    date('d',$cd)+$day, date('Y',$cd)+$yr));
	return $newdate;
}

function CalculaEdad($fecha) {
	list($Y,$m,$d) = explode("-",$fecha);
	return( date('md') < $m.$d ? date('Y')-$Y-1 : date('Y')-$Y );
}

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
/*
$interval can be:
yyyy - Number of full years
q - Number of full quarters
m - Number of full months
y - Difference between day numbers
(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
d - Number of full days
w - Number of full weekdays
ww - Number of full weeks
h - Number of full hours
n - Number of full minutes
s - Number of full seconds (default)
*/
if (!$using_timestamps) {
	$datefrom = strtotime($datefrom, 0);
	$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds

switch($interval) {
	case 'yyyy': // Number of full years
		$years_difference = floor($difference / 31536000);
		if (mktime(date('H', $datefrom), date('i', $datefrom), date('s', $datefrom), date('n', $datefrom), date('j', $datefrom), date('Y', $datefrom)+$years_difference) > $dateto) {
			$years_difference--;
		}
		if (mktime(date('H', $dateto), date('i', $dateto), date('s', $dateto), date('n', $dateto), date('j', $dateto), date('Y', $dateto)-($years_difference+1)) > $datefrom) {
			$years_difference++;
		}
		$datediff = $years_difference;
	break;
	case 'q': // Number of full quarters
		$quarters_difference = floor($difference / 8035200);
		while (mktime(date('H', $datefrom), date('i', $datefrom), date('s', $datefrom), date('n', $datefrom)+($quarters_difference*3), date('j', $dateto), date('Y', $datefrom)) < $dateto) {
			$months_difference++;
		}
		$quarters_difference--;
		$datediff = $quarters_difference;
	break;
	case 'm': // Number of full months
		$months_difference = floor($difference / 2678400);
		while (mktime(date('H', $datefrom), date('i', $datefrom), date('s', $datefrom), date('n', $datefrom)+($months_difference), date('j', $dateto), date('Y', $datefrom)) < $dateto) {
			$months_difference++;
		}
		$months_difference--;
		$datediff = $months_difference;
	break;
	case 'y': // Difference between day numbers
		$datediff = date('z', $dateto) - date('z', $datefrom);
	break;
	case 'd': // Number of full days
		$datediff = floor($difference / 86400);
	break;
	case 'w': // Number of full weekdays
		$days_difference = floor($difference / 86400);
		$weeks_difference = floor($days_difference / 7); // Complete weeks
		$first_day = date('w', $datefrom);
		$days_remainder = floor($days_difference % 7);
		$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
		if ($odd_days > 7) { // Sunday
			$days_remainder--;
		}
		if ($odd_days > 6) { // Saturday
			$days_remainder--;
		}
		$datediff = ($weeks_difference * 5) + $days_remainder;
	break;
	case 'ww': // Number of full weeks
		$datediff = floor($difference / 604800);
	break;
	case 'h': // Number of full hours
		$datediff = floor($difference / 3600);
	break;
	case 'n': // Number of full minutes
		$datediff = floor($difference / 60);
	break;
	default: // Number of full seconds (default)
		$datediff = $difference;
	break;
}
return $datediff;
}

function Capitalizar($nombre)
{
	$low = array(chr(193) => chr(225), //á
	chr(201) => chr(233), //é
	chr(205) => chr(237), //í*
	chr(211) => chr(243), //ó
	chr(218) => chr(250), //ú
	chr(220) => chr(252), //ü
	chr(209) => chr(241)  //ñ
	);

	$outputString = utf8_decode($nombre);
	//$outputString = strtolower($outputString);//strtolower(strtr($str,$low));
	$outputString = strtolower($outputString);
	$nombre = utf8_encode(strtr($outputString,$low));

	$cap_articulos[] = 'a';
	$cap_articulos[] = 'de';
	$cap_articulos[] = 'del';
	$cap_articulos[] = 'la';
	$cap_articulos[] = 'los';
	$cap_articulos[] = 'las';
	$cap_articulos[] = 'y';

	$cap_palabras = explode(' ', $nombre);
	$nuevoNombre = '';
	foreach($cap_palabras as $elemento)
	{
		//if(in_array(trim(strtolower($elemento)), $cap_articulos))
		if(in_array(trim($elemento), $cap_articulos)) {
			$nuevoNombre .= $elemento." ";
		}else{
			$nuevoNombre .= ucfirst($elemento)." ";
		}
	}
	return trim($nuevoNombre);
}
/*
function Capitalizar($nombre)
{
	$articulos = array(
	'0' => 'a',
	'1' => 'de',
	'2' => 'del',
	'3' => 'la',
	'4' => 'los',
	'5' => 'las',
	);

	$palabras = explode(' ', $nombre);
	$nuevoNombre = '';

	foreach($palabras as $elemento)
	{
		if(in_array(trim(strtolower($elemento)), $articulos))
		{
			$nuevoNombre .= strtolower($elemento)." ";
		}else{
			$nuevoNombre .= ucfirst(strtolower($elemento))." ";
		}
	}
	return trim($nuevoNombre);
}
*/

function QuitarGuion($texto)
{
	$nuevotexto = str_replace('-','',$texto);
	return trim($nuevotexto);
}

function zerofill($numero, $zerocant)
{
	$nuevonum = str_pad($numero, $zerocant, 0, STR_PAD_LEFT);
	return $nuevonum;
}

function funcion_java ($funcion) {
	echo '<script type="text/javascript">';
	echo $funcion;
	echo '</script>';
	return false;
}
?>
