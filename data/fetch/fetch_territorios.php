<?php 
	include '../../include/connection.php';
	$sql_fetchTerritorio = "SELECT  * FROM TERRITORIOS_NUMERO
								INNER JOIN TERRITORIOS_SECCION
										ON SECCION_ID = NUMERO_MAIN_SECCION 
									 WHERE NUMERO_ID = '" . $_POST['NUMERO_ID'] ."'";

	$qry_fetchTerritorio = mysqli_query($conn, $sql_fetchTerritorio);
	$rs_fetchTerritorio = mysqli_fetch_array($qry_fetchTerritorio, MYSQLI_ASSOC);
	echo json_encode($rs_fetchTerritorio);
	mysqli_close($conn);
 ?>