<?php 
	include '../../include/connection.php';
	$sql_fetchUsuario = "SELECT  * FROM TERRITORIOS_USERS WHERE USERS_ID = '" . $_POST['NUMERO_ID'] ."'";
	$qry_fetchUsuario = mysqli_query($conn, $sql_fetchUsuario);
	$rs_fetchUsuario = mysqli_fetch_array($qry_fetchUsuario, MYSQLI_ASSOC);
	echo json_encode($rs_fetchUsuario);
	mysqli_close($conn);
 ?>