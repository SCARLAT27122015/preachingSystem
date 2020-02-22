<?php 
	include '../../include/connection.php';
	$USERS_NOMBRE = $_POST['USERS_NOMBRE'];
	$USERS_CONGREGACION = $_POST['USERS_CONGREGACION'];
	$USERS_GRUPO = $_POST['USERS_GRUPO'];
	$USERS_PRIVILEGIO = $_POST['USERS_PRIVILEGIO'];
	$USERS_TELEFONO = $_POST['USERS_TELEFONO'];
	$USERS_CORREO = $_POST['USERS_CORREO'];
	$USERS_USUARIO = $_POST['USERS_USUARIO'];
	$USERS_CONTRASENA = $_POST['USERS_CONTRASENA'];
	$encUSERS_CONTRASENA = md5(md5($USERS_CONTRASENA));


	if($_FILES['USERS_FOTO']['name']!="") {        
	        if ($_FILES['USERS_FOTO']['type'] == "image/jpeg")
	        {
	            $fileName = $_FILES["USERS_FOTO"]["name"];
	            $fileType = $_FILES["USERS_FOTO"]["type"];
	            $fileSize = $_FILES["USERS_FOTO"]["size"];
	            if ($fileSize < 5000000) {	            
		            $urlid2 = rand(10000000000000000,900000000000000000);
		            $target = "../../images/USERS/";
		            $ext = substr($_FILES['USERS_FOTO']['name'], strrpos($_FILES['USERS_FOTO']['name'],'.'));  
		            $name_file="territorioUser_".$urlid2. $ext;  
		            move_uploaded_file($_FILES["USERS_FOTO"]["tmp_name"], $target. $name_file);
	            }else{
	            	echo "El archivo excede el tamaño permitido. <a href='javascript:history.back(1)'>regresar</a>";
	            	exit();	
	            }
	        } else {
	            echo "El archivo no esta permitido, solo puedes subir .JPEG <a href='javascript:history.back(1)'>regresar</a>";
	            exit();
	        }
	    } else {
	        $name_file="";
	}



	if ($USERS_CONGREGACION == 0) {
		$sql_DupCongregacion = "SELECT * 
					   	          FROM TERRITORIOS_CONGREGACION 
					  			 WHERE CONGREGACION_NOMBRE = '".$_POST['USERS_NUEVA_CONGREGACION']."'";
		$qry_DupCongregacion = mysqli_query($conn, $sql_DupCongregacion);
		$rows_DupCongregacion = mysqli_num_rows($qry_DupCongregacion);
		if ($rows_DupCongregacion != 0) {
			$rs_DupCongregacion = mysqli_fetch_array($qry_DupCongregacion, MYSQLI_ASSOC);
			$USERS_CONGREGACION = $rs_DupCongregacion['CONGREGACION_ID'];
		} else{
			$sql_insCongregacion = "INSERT INTO TERRITORIOS_CONGREGACION (CONGREGACION_NOMBRE) 
																  VALUES ('".$_POST['USERS_NUEVA_CONGREGACION']."')";
			mysqli_query($conn, $sql_insCongregacion);
			$USERS_CONGREGACION = mysqli_insert_id($conn);
		}
	}
	
	$sql_dupUsuario = "SELECT 
						    USERS_CORREO, 
						    USERS_USUARIO 
					   FROM TERRITORIOS_USERS 
					  WHERE USERS_CORREO = '$USERS_CORREO' 
					     AND USERS_USUARIO = '$USERS_USUARIO'";

	$qry_dupUsuario = mysqli_query($conn, $sql_dupUsuario);
	$rows_dupUsuario = mysqli_num_rows($qry_dupUsuario);
	
	if ($rows_dupUsuario == 0) {
		$sql_User = "INSERT INTO TERRITORIOS_USERS (USERS_NOMBRE, 
													USERS_CONGREGACION,
													USERS_GRUPO,
													USERS_PRIVILEGIO,
													USERS_TELEFONO,
													USERS_CORREO,
												    USERS_USUARIO,
													USERS_CONTRASENA,
													USERS_NIVEL,
													USERS_FOTO) 
											VALUES ('$USERS_NOMBRE',
													'$USERS_CONGREGACION',
													'$USERS_GRUPO',
													'$USERS_PRIVILEGIO',
													'$USERS_TELEFONO',
													'$USERS_CORREO',
													'$USERS_USUARIO',
													'$encUSERS_CONTRASENA',
													1,
													'$name_file')";
		mysqli_query($conn, $sql_User);
		header('location: ../../index.php?ST=SUCCESS');
	}else{
		header('location: ../../register.php?ST=DUPLICATED');
	}

	mysqli_close($conn);
 ?>