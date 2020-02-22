<?php 
	include '../../include/connection.php';
	$sql_fetchSegmentos = "SELECT * 
							  FROM TERRITORIOS_CONGREGACION 
							 WHERE CONGREGACION_ID = '". $_POST['NUMERO_CONGREGACION'] ."'";

	$qry_fetchSegmentos = mysqli_query($conn, $sql_fetchSegmentos);
	$rs_fetchSegmentos = mysqli_fetch_array($qry_fetchSegmentos, MYSQLI_ASSOC);

	echo json_encode($rs_fetchSegmentos);
	mysqli_close($conn);
 ?>