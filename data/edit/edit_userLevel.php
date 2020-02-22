<?php 
	include '../../include/connection.php';
	$sql_edicionTerritorio = "UPDATE TERRITORIOS_USERS 
								 SET USERS_NIVEL = '" . $_POST['EDIT_USERS_NIVEL'] . "'
							   WHERE USERS_ID = '". $_POST['EDIT_NUMERO_ID']."'";

	mysqli_query($conn, $sql_edicionTerritorio);
	header('location: ../../users.php?ST=LEVEL_EDITED');
	mysqli_close($conn);
?> 