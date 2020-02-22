<?php 
	include '../../include/connection.php';
	$sql_editSegmentos = "UPDATE TERRITORIOS_CONGREGACION 
							 SET CONGREGACION_SEGMENTO = '". $_POST['EDITAR_CONGREGACION_SEGMENTO'] ."', 
							     CONGREGACION_SUBSEGMENTO = '" . $_POST['EDITAR_CONGREGACION_SUBSEGMENTO']. "'
							     WHERE CONGREGACION_ID = '". $_POST['EDITAR_CONG'] . "'";
	mysqli_query($conn, $sql_editSegmentos);
	header('location: ../../territorio.php?ST=SGMT_EDITED');
	mysqli_close($conn);
 ?>