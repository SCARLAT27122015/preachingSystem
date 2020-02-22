<?php 
	include '../../include/connection.php';
	date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
	
	if (isset($_POST['closeSalida'])) {
		$sql_conclusionPlan = "UPDATE TERRITORIOS_SALIDAS 
								  SET 
								  	SALIDAS_COMPLETADO = 1, 
								  	SALIDAS_USUARIO_FIN = '". $_POST['SALIDAS_USUARIO_FIN']."',
								  	SALIDAS_CLOSE_DATE = '". date("Y-m-d") ."'
							    WHERE 
							        SALIDAS_ID = '" .$_POST['salida_id']. "'";
		mysqli_query($conn, $sql_conclusionPlan);
		if (!isset($_POST['redirect'])) {
			header('location:../../dashboard.php?ST=COMPLETE');
		}else{
			header('location:../../planServicio.php?ST=COMPLETE');
		}
	}

	if (isset($_POST['editFechas'])) {
		$sql_edicionFechas = "UPDATE TERRITORIOS_SALIDAS
							  SET
							  	SALIDAS_COMENTARIO = '". $_POST['EDIT_SALIDAS_COMENTARIO']."',
							  	SALIDAS_USUARIO_FIN = '". $_POST['EDIT_USER_ID']."',
							  	SALIDAS_CLOSE_DATE = '". date("Y-m-d")."',
							  	SALIDAS_FORIGEN = '". $_POST['EDIT_SALIDAS_FORIGEN']."',
							  	SALIDAS_FFIN = '". $_POST['EDIT_SALIDAS_FFIN']."'
							  WHERE 
							    SALIDAS_ID = '" .$_POST['salida_id']. "'";
		mysqli_query($conn, $sql_edicionFechas);
		header('location: ../../planServicio.php?ST=EDITED');
	}

	mysqli_close($conn);
 ?>