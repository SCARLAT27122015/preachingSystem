<?php 
	include '../include/connection.php';
	$USERS_CORREO = $_POST['USERS_CORREO'];
	$USERS_CONTRASENA = $_POST['USERS_CONTRASENA'];
	$encUSERS_CONTRASENA = md5(md5($USERS_CONTRASENA));

	$sqlAcceso = "SELECT * 
					FROM TERRITORIOS_USERS 
				   WHERE USERS_USUARIO = '$USERS_CORREO' 
				     AND USERS_CONTRASENA = '$encUSERS_CONTRASENA'";

	$qry_Acceso = mysqli_query($conn, $sqlAcceso);
	$rows_Acceso = mysqli_num_rows($qry_Acceso);
	if ($rows_Acceso == 0) {
		header('location: ../index.php?ST=DENIED');
	}else{
		$rs_Acceso = mysqli_fetch_array($qry_Acceso, MYSQLI_ASSOC);
		session_start();
		$_SESSION['USUARIO_ID'] = $rs_Acceso['USERS_ID'];
		$_SESSION['USUARIO_CONGREGACION'] = $rs_Acceso['USERS_CONGREGACION'];
		$_SESSION['USUARIO_NOMBRE'] = $rs_Acceso['USERS_NOMBRE'];
		$_SESSION['USUARIO'] = $rs_Acceso['USERS_USUARIO'];
		$_SESSION['NIVEL'] = $rs_Acceso['USERS_NIVEL'];
		$_SESSION['GRUPO'] = $rs_Acceso['USERS_GRUPO'];
		header('location: ../dashboard.php?ST=USER_SUCCESS');
	}

	mysqli_close($conn);
 ?>
