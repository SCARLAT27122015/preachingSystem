<?php 
	include '../../include/connection.php';
	$sql_delTerritorio = "DELETE FROM TERRITORIOS_NUMERO 
						  WHERE NUMERO_ID = '". $_POST['NUMERO_ID']."'";
	mysqli_query($conn, $sql_delTerritorio);
 ?>