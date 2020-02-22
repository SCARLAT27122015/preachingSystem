<?php 
	include '../../include/connection.php';
	date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    
	if (isset($_POST['insNewServicio'])) {
		$typePermission = $_POST['SALIDAS_ALLPERMISSIONS'];

		if ($typePermission == 0) {
			$sql_PlanGrupo = "SELECT 
	                            SALIDAS_ID,
	                            SALIDAS_USUARIO_GRUPO
	                        FROM
	                            TERRITORIOS_SALIDAS 
	                        WHERE 
	                            SALIDAS_CONGREGACION = '". $_POST['NUMERO_CONGREGACION']."'
	                            AND SALIDAS_ALLPERMISSIONS = 1
	                            AND SALIDAS_COMPLETADO IS NULL";
		    $qry_planGrupo = mysqli_query($conn, $sql_PlanGrupo);
		    $rows_planGrupo = mysqli_num_rows($qry_planGrupo);

		    if ($rows_planGrupo == 0) {
		    	$sql_addPlan = "INSERT INTO TERRITORIOS_SALIDAS 
										(SALIDAS_CONGREGACION, 
										 SALIDAS_USUARIO_ORIGEN,
										 SALIDAS_USUARIO_GRUPO,
										 SALIDAS_SEGMENTO,
										 SALIDAS_SUBSEGMENTO,
										 SALIDAS_SEGMENTO_FIN,
										 SALIDAS_SUBSEGMENTO_FIN,
										 SALIDAS_FORIGEN,
										 SALIDAS_FFIN,
										 SALIDAS_ALLPERMISSIONS,
										 SALIDAS_COMENTARIO) 
								 VALUES ('". $_POST['NUMERO_CONGREGACION']."',
										 '". $_POST['SALIDAS_USUARIO_ORIGEN']."',
										 '". $_POST['SALIDAS_USUARIO_GRUPO']."',
										 '". $_POST['SALIDAS_SEGMENTO']."',
										 '". $_POST['SALIDAS_SUBSEGMENTO']."',
										 '". $_POST['SALIDAS_SEGMENTO_FIN']."',
										 '". $_POST['SALIDAS_SUBSEGMENTO_FIN']."',
										 '".$_POST['SALIDAS_FORIGEN']."',
										 '". $_POST['SALIDAS_FFIN'] ."',
										 '". $_POST['SALIDAS_ALLPERMISSIONS']."',
										 '". $_POST['SALIDAS_COMENTARIO']."')";
			
			
				
				mysqli_query($conn, $sql_addPlan);
				header('location: ../../dashboard.php?ST=SUCCESS');
		    }else{
		    	header('location: ../../planServicio.php?ST=PREV_PLAN');
		    }
		}else{
			$sql_addPlan = "INSERT INTO TERRITORIOS_SALIDAS 
										(SALIDAS_CONGREGACION, 
										 SALIDAS_USUARIO_ORIGEN,
										 SALIDAS_USUARIO_GRUPO,
										 SALIDAS_SEGMENTO,
										 SALIDAS_SUBSEGMENTO,
										 SALIDAS_SEGMENTO_FIN,
										 SALIDAS_SUBSEGMENTO_FIN,
										 SALIDAS_FORIGEN,
										 SALIDAS_FFIN,
										 SALIDAS_ALLPERMISSIONS,
										 SALIDAS_COMENTARIO) 
								 VALUES ('". $_POST['NUMERO_CONGREGACION']."',
										 '". $_POST['SALIDAS_USUARIO_ORIGEN']."',
										 '". $_POST['SALIDAS_USUARIO_GRUPO']."',
										 '". $_POST['SALIDAS_SEGMENTO']."',
										 '". $_POST['SALIDAS_SUBSEGMENTO']."',
										 '". $_POST['SALIDAS_SEGMENTO_FIN']."',
										 '". $_POST['SALIDAS_SUBSEGMENTO_FIN']."',
										 '".$_POST['SALIDAS_FORIGEN']."',
										 '". $_POST['SALIDAS_FFIN'] ."',
										 '". $_POST['SALIDAS_ALLPERMISSIONS']."',
										 '". $_POST['SALIDAS_COMENTARIO']."')";
			
			
				
			mysqli_query($conn, $sql_addPlan);
			header('location: ../../dashboard.php?ST=SUCCESS');
		}
	}

	mysqli_close($conn);
 ?>