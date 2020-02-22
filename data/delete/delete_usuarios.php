<?php 
	include '../../include/connection.php';
	$sql_delUsuario = "DELETE FROM TERRITORIOS_USERS 
						  WHERE USERS_ID = '". $_POST['NUMERO_ID']."'";
	mysqli_query($conn, $sql_delUsuario);
 ?>