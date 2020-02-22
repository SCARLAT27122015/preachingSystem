<?php 
	include '../../include/connection.php';
	$sql_edicionTerritorio = "UPDATE TERRITORIOS_NUMERO 
								 SET NUMERO_CALLES = '" . $_POST['EDIT_NUMERO_CALLES'] . "',
								     NUMERO_COMENTARIOS = '". $_POST['EDIT_NUMERO_COMENTARIOS']."'
							   WHERE NUMERO_ID = '". $_POST['EDIT_NUMERO_ID']."'";

	mysqli_query($conn, $sql_edicionTerritorio);
	header('location: ../../territorio.php?ST=EDITED');
	mysqli_close($conn);
?> 