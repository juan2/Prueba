<?php session_start(); ?>
<?php require_once("Connections/conexion.php"); ?>

<?php
setlocale(LC_CTYPE,"es_ES");
error_reporting(0);



 if(isset($_SESSION['curp']))
 {
	$curp=$_SESSION['curp']; 
 }
   
    mssql_select_db($database_connMydb, $conexion);
	$query_Persona = "Select sol.RelacionAval
						FROM TempPersonaAspirante t 
						inner join TempDomicilioAspirante td on t.IdTemp = td.IdTemp 
						inner join TempSolicitanteAspirante	 sol on t.Curp_log = sol.Curp_log
						where t.Curp_log='$curp' and t.FTipoPersona=4 and td.IdtipoDireccion=0";
	$rsPersona = mssql_query($query_Persona, $conexion) or die(mssql_error());
	$row_Persona = mssql_fetch_assoc($rsPersona);
	$total_Persona = mssql_num_rows($rsPersona);
	
	$query = "select idmadre from TempSolicitanteAspirante where Curp_log='$curp'";
	$rsQuery = mssql_query($query, $conexion) or die(mssql_error());
	$row_Query= mssql_fetch_assoc($rsQuery);
	$total_Query = mssql_num_rows($rsQuery);
	
	if($total_Query > 0)
	{
		$madre= 0;
		
	}
	else
	{
		$madre= 2;
	}
	
	$query_p = "select idPadre from TempSolicitanteAspirante  where Curp_log='$curp'";
	$rsQuery_p = mssql_query($query_p, $conexion) or die(mssql_error());
	$row_Query_p= mssql_fetch_assoc($rsQuery_p);
	$total_Query_p = mssql_num_rows($rsQuery_p);
	
	if($total_Query_p > 0)
	{
		if($row_Query_p['idPadre'] == '')
		{
			$padre= 1;
			echo $padre;
		}
	
		$padre= 0;
		
	}

	
	
	
	$query_relAval = "select idrelacion,relacion  from CatrelacionAval where idrelacion not in($padre,$madre)";
	echo "select idrelacion,relacion  from CatrelacionAval where idrelacion not in($padre,$madre)";
	exit();
	$rsrelAval = mssql_query($query_relAval, $conexion) or die(mssql_error());
	$rowrelAval= mssql_fetch_assoc($rsrelAval);
	$totalrelAval = mssql_num_rows($rsrelAval);
	
	

?>


<script language="JavaScript" type="text/JavaScript">

				
jQuery(document).ready(function(){
	
	<?php if($row_Persona['RelacionAval']<>'' || $row_Persona['RelacionAval']<> NULL) {  ?>
	
	<?php if($row_Persona['RelacionAval'] == 3 || $row_Persona['RelacionAval']== 4) {  ?>
		
		var valor = jQuery("select#relacionAcreditado").val();
		
		 if(valor == 3 || valor== 4)
		  {
				switch(valor){
					case "3":{jQuery("fieldset.aval").load("forms/aval.php");break;}
					case "4":{jQuery("fieldset.aval").load("forms/aval.php");break;}
				}
		  }
	<?php
        }
     }
	?>
	
	
	
	jQuery("select#relacionAcreditado").change(function () {
	var a = jQuery('#relacionAcreditado').val(); 
	
		  if(a == 3 || a == 4)
		  {
				switch(a){
					case "3":{jQuery("fieldset.aval").load("forms/aval.php");break;}
					case "4":{jQuery("fieldset.aval").load("forms/aval.php");break;}
				}
		  }
		  else
		  {
			  switch(a){
			  case "1":{jQuery("fieldset.aval").empty();break;}
			  case "2":{jQuery("fieldset.aval").empty();break;}
		  
		   }
		  }
   });
	  

  
	  
});

</script>


<form method="post" id="theForm" name="theForm" action="forms/insertarPersona.php?tp=4">

<!-- Begin "Información del Aval" -->
	<fieldset>
	
	<div class="wrapField mr20">
		<label>Relaci&oacute;n con el acreditado</label>
		<select name="relacionAcreditado" id="relacionAcreditado">
		<option value="0" <?php if (!(strcmp(0, $_POST['relacionAcreditado']))) {echo "selected=\"selected\"";} ?>>-- Seleccione relaci&oacute;n</option>
            <?php
            do {  
            ?>
          
            <option value="<?php echo $rowrelAval ['idrelacion']?>"<?php if (!(strcmp($rowrelAval['idrelacion'], $_POST['relacionAcreditado']))) {echo "selected=\"selected\"";} ?>><?php echo $rowrelAval['relacion']?></option>
           <?php
            } while ($rowrelAval = mssql_fetch_assoc($rsrelAval));
              $rows = mssql_num_rows($rsrelAval);
              if($rows > 0) {
                  mssql_data_seek($rsrelAval, 0);
                  $rowrelAval = mssql_fetch_assoc($rsrelAval);
              }
            ?>
		</select>
	</div>
	
	
	</fieldset> 
	
	<fieldset id="prueba" class="aval">
	</fieldset> 
	<!-- End "Información General del Estudiante" -->
	
	 
	<script>
	/* jQuery("select#relacionAcreditado").change(function () {
    	status = jQuery(this).val();
    	switch(status){

            case "1":{jQuery('fieldset.aval').empty();break;}
    		case "2":{jQuery('fieldset.aval').empty();break;}
    		case "3":{jQuery('fieldset.aval').load("forms/aval.php");break;}
    		case "4":{jQuery('fieldset.aval').load("forms/aval.php");break;}
    	}
          
    });*/
	</script>
	<!-- End "Información del Aval" -->
	
	<input type="submit" value="Enviar"></submit>
	
</form>

