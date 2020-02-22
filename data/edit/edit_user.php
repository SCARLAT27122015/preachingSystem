<?php 
	include '../../include/connection.php';

	$sql_dupUser = "SELECT 
						USERS_USUARIO 
					FROM 
						TERRITORIOS_USERS 
					WHERE 
						USERS_ID <> '". $_POST['EDIT_USER_ID']."' AND
						USERS_USUARIO = '". $_POST['EDIT_USERS_USUARIO']."'";

	$qry_dupUser = mysqli_query($conn, $sql_dupUser);
	$row_dupUser = mysqli_num_rows($qry_dupUser);
	if ($row_dupUser > 0) {
		header('location: ../../account.php?ST=DUPLICATED');
	}else{
		if($_FILES['EDIT_USERS_FOTO']['name'] != '') {        //Si no viene vacío el input de imagen
			if ($_FILES['EDIT_USERS_FOTO']['type'] == "image/jpeg" || $_FILES['EDIT_USERS_FOTO']['type'] == "image/jpg")
				  {
				      $fileName = $_FILES["EDIT_USERS_FOTO"]["name"];
				      $fileType = $_FILES["EDIT_USERS_FOTO"]["type"];
				      $fileSize = $_FILES["EDIT_USERS_FOTO"]["size"];
				      $urlid2 = rand(10000000000000000,900000000000000000);
				      $target = "../../images/USERS/";
				      $ext = substr($_FILES['EDIT_USERS_FOTO']['name'], strrpos($_FILES['EDIT_USERS_FOTO']['name'],'.'));  
				      $name_file="territorioUser_".$urlid2. $ext;  //Nuevo archivo de imagen
				      move_uploaded_file($_FILES["EDIT_USERS_FOTO"]["tmp_name"], $target. $name_file);
				  } else {
					  echo "El archivo no esta permitido, solo puedes subir .JPEG <a href='javascript:history.back(1)'>regresar</a>";
					  exit();
				  }
		} else { //Si viene vacío el input de imagen hacemos consulta a la BD y sacamos el nombre de la imagen actual para que al actualizar ese valor se quede igual
			$rsConsulta= mysqli_query($conn,"SELECT USERS_FOTO FROM TERRITORIOS_USERS WHERE USERS_ID = '". $_POST['EDIT_USER_ID']."'") or die(mysqli_error());
			$row_rsConsulta = mysqli_fetch_array($rsConsulta, MYSQLI_ASSOC);
			if ($row_rsConsulta['USERS_FOTO'] == '') {
			    $name_file= ""; //Si viene vacío el input de imagen y aparte no subió una imagen el usuario
			} else {
			    $name_file= $row_rsConsulta['USERS_FOTO'];  //Si viene vacío el input de imagen pero si existe un valor en la tabla anterior dejamos el mismo nombre
			}
		}

		$upd_contrasena = $_POST['EDIT_USERS_NEW_CONTRASENA'];

		if (empty($upd_contrasena)){
			$sql_edicionTerritorio = "UPDATE TERRITORIOS_USERS 
										 SET 
										 	USERS_NOMBRE = '" . $_POST['EDIT_USERS_NOMBRE'] . "',
										 	USERS_FOTO = '$name_file',
										 	USERS_GRUPO = '". $_POST['EDIT_USERS_GRUPO']."',
										 	USERS_TELEFONO = '". $_POST['EDIT_USERS_TELEFONO']."',
										 	USERS_CORREO = '". $_POST['EDIT_USERS_CORREO']."',
										 	USERS_USUARIO = '".$_POST['EDIT_USERS_USUARIO']."'
									   WHERE USERS_ID = '". $_POST['EDIT_USER_ID']."'";
		}else{
			$enc_contrasena = md5(md5($upd_contrasena));
			$sql_edicionTerritorio = "UPDATE TERRITORIOS_USERS 
										 SET 
										 	USERS_NOMBRE = '" . $_POST['EDIT_USERS_NOMBRE'] . "',
										 	USERS_FOTO = '$name_file',
										 	USERS_GRUPO = '". $_POST['EDIT_USERS_GRUPO']."',
										 	USERS_TELEFONO = '". $_POST['EDIT_USERS_TELEFONO']."',
										 	USERS_CORREO = '". $_POST['EDIT_USERS_CORREO']."',
										 	USERS_USUARIO = '".$_POST['EDIT_USERS_USUARIO']."',
										 	USERS_CONTRASENA = '$enc_contrasena'
									   WHERE USERS_ID = '". $_POST['EDIT_USER_ID']."'";
		}

		mysqli_query($conn, $sql_edicionTerritorio);
		header('location: ../../account.php?ST=EDITED');

	}


	mysqli_close($conn);
?> 