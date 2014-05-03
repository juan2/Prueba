<?php include('../validar.php') ?>
<?php include('../utiles.php') ?>
<?php
$strCharSet='UTF-8';
function array_to_json($array){
	#$var1=strpos($array,"[");
	#$array=substr($array,$var1);

    if( !is_array($array) ){
        return false;
    }
    $associative=count( array_diff( array_keys($array), array_keys(array_keys($array)) ));

    if($associative){
        $construct=array();
        foreach($array as $key=>$value ){
            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.
            // Format the key:
            if(is_numeric($key)){
                $key="key_$key";
            }
            $key="\"".addslashes($key)."\"";
            // Format the value:
            if(is_array($value)){
                $value=array_to_json($value);
            } else if(!is_numeric($value) || is_string($value) ){
                $value="\"".addslashes($value)."\"";
            }
            // Add to staging array:
            $construct[]="$key: $value";
        }
        // Then we collapse the staging array into the JSON form:
        $result_auto="{".implode( ", ",$construct)."}";
    } else { // If the array is a vector (not associative):
        $construct=array();
        foreach($array as $value){
            // Format the value:
            if(is_array($value)){
                $value=array_to_json($value);
            } else if(!is_numeric($value) || is_string($value) ){
                $value="'".addslashes($value)."'";
            }
            // Add to staging array:
            $construct[]=$value;
        }
        // Then we collapse the staging array into the JSON form:
        $result_auto="[ ". implode( ", ", $construct ) . " ]";
    }
	return $result_auto;
}


$q = strtolower($_GET['term']);
if (!$q) return;

$q=mysql_escape_string($q);
$q_fix=str_replace(" ", "%", $q);
$campo=$_GET['campo'];

if(strlen($q) >0) {
/*
	switch ($_GET['campo']) {
	case 2:
		$result99="SELECT TOP 15 idesc, clave AS clave FROM escuelacat WHERE (clave LIKE N'%" .$q_fix ."%') order by clave ";
		break;
	case 3:
		$result99="SELECT TOP 15 idesc, escuela AS clave FROM escuelacat WHERE (escuela LIKE N'%" .$q_fix ."%') order by escuela ";
		break;
	case 5:
		$result99="SELECT TOP 15 obra AS clave FROM obracat WHERE (obra LIKE N'%" .$q_fix ."%') order by obra ";
	case 6:
		$result99="SELECT TOP 15 idcont, nombre + ' ' + apaterno + ' ' + amaterno clave FROM contracat WHERE (nombre + ' ' + apaterno + ' ' + amaterno LIKE N'%" .$q_fix ."%') order by clave ";
		break;
	}
*/

	$link=Conectarse();
	$result=mysql_query("SELECT distinct $campo as campo_elegido FROM cyn_ac_acuerdos WHERE $campo LIKE N'%" .$q_fix ."%' ORDER BY $campo LIMIT 15 ",$link);
	$row = mysql_fetch_assoc($result);

	$items=array();

	do {
#		$cCadena=utf8_encode($row["campo_elegido"]);
		$cCadena=$row["campo_elegido"];
		$items[]=array("id"=>"$cCadena","label"=>"$cCadena","value"=>"$cCadena");
	} while ($row = mysql_fetch_assoc($result));

	echo array_to_json($items);
}
?>
