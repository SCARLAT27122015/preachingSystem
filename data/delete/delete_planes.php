<?php
	include '../../include/connection.php'; 
	$SALIDAS_ID = $_POST['id'];
	$sql_borradoPlan = "DELETE FROM TERRITORIOS_SALIDAS WHERE SALIDAS_ID = $SALIDAS_ID";
	mysqli_query($conn, $sql_borradoPlan);
	mysqli_close($conn);
 ?>