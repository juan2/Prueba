<?php include('validar.php') ?>
<?php include('utiles.php') ?>
<?php include('firephp.php') ?>
<?php
$fecha_alta = date('Y-m-d');

$link=Conectarse();

include ($_SERVER['DOCUMENT_ROOT']."/upload_class.php"); //classes is the map where the class file is stored (one above the root)

$max_size = 1024*250; // the max. size for uploading

$my_upload = new file_upload;

$my_upload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/archs/"; // "files" is thefolder for the uploaded files (you have to create this folder)
$my_upload->extensions = array(".png", ".zip", ".pdf", ".jpg", ".jpeg"); // specify the allowed extensions here
// $my_upload->extensions = "de"; // use this to switch the messages into an other language (translate first!!!)
$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
$my_upload->rename_file = true;

if(isset($_GET['idc'])) {
    $my_upload->the_temp_file = $_FILES['upload']['tmp_name'];
    $my_upload->the_file = $_FILES['upload']['name'];
    $my_upload->http_error = $_FILES['upload']['error'];
    $my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "n"; // because only a checked checkboxes is true
    $my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
#    $new_name = (isset($_POST['name'])) ? $_POST['name'] : "";
    $new_name = $_GET['idc'].'_'.str_replace(' ','', substr(microtime(), 2)).$my_upload->ext_string;

    if ($my_upload->upload($new_name)) { // new name is an additional filename information, use this to rename the uploaded file
        $full_path = $my_upload->upload_dir.$my_upload->file_copy;
        $info = $my_upload->get_uploaded_file_info($full_path);

#$firephp = FirePHP::getInstance(true);
#$firephp->log($my_upload);

#$firephp = FirePHP::getInstance(true);
#$firephp->log($my_upload->file_copy);
    $inserta=$link->prepare("INSERT INTO ctra1_comentarios_arch (idcomenta, idpras, nom_arch, fechaalta, id_us) values (:idcomenta, :idpras, :nom_arch, :fechaalta, :id_us) ");
    $inserta->execute(array(":idcomenta"=>$_GET['idc'], ":idpras"=>$_GET['idu'], ":nom_arch"=>$my_upload->file_copy, ":fechaalta"=>$fecha_alta, ":id_us"=>$_SESSION['MM_IdUsuario']));

#        mysql_query("insert into cyn_ac_comentarios_arch (idcomenta, idapoyo, nom_arch, fechaalta, quienalta) values (".$_GET['idc'].", ".$_GET['id_a'].", '".$my_upload->file_copy."', '".$fecha_alta."', ".$_SESSION['MM_IdUsuario'].")", $link);

		echo json_encode(array('success' => true));
    }else{
    	echo json_encode(array(
    		'success'=>false,
    		'error'=>$my_upload->show_error_string()
//    		'preventRetry'=>true
    		)
    	);
    }
    $link=null;
}
?>
