<?php 
	include '../../include/connection.php';
	if (isset($_POST['insDivisiones'])) {
		$sql_addDivisiones = "UPDATE TERRITORIOS_CONGREGACION 
							  SET CONGREGACION_SEGMENTO = '". $_POST['division']."', 
							      CONGREGACION_SUBSEGMENTO = '". $_POST['subdivision']."'
							WHERE CONGREGACION_NOMBRE = '". $_POST['congregacion']."'";
		mysqli_query($conn, $sql_addDivisiones);
		echo "success";
	}

	if (isset($_POST['insNewTerritorio'])) {
		$NUMERO_MAIN_SECCION = '';
		$SECCION_NOMBRE = $_POST['NUMERO_TERRITORIO'];
		$SECCION_CONGREGACION = $_POST['NUMERO_CONGREGACION'];
		$EXISTENTE_NUMERO_TERRITORIO = $_POST['EXISTENTE_NUMERO_TERRITORIO'];
		$NUMERO_SECCION = $_POST['NUMERO_SECCION'];
		
		if ($EXISTENTE_NUMERO_TERRITORIO == 0) {
			$dupSECCION_NOMBRE = "SELECT SECCION_ID 
									FROM TERRITORIOS_SECCION 
								   WHERE SECCION_NOMBRE = '$SECCION_NOMBRE' 
								     AND SECCION_CONGREGACION = $SECCION_CONGREGACION";

			$qry_dupSECCION_NOMBRE = mysqli_query($conn, $dupSECCION_NOMBRE);
			$row_dupSECCION_NOMBRE = mysqli_num_rows($qry_dupSECCION_NOMBRE);
			if ($row_dupSECCION_NOMBRE == 0) {
				$sql_InsSeccion = "INSERT INTO TERRITORIOS_SECCION (SECCION_NOMBRE, SECCION_CONGREGACION) VALUES ('$SECCION_NOMBRE', $SECCION_CONGREGACION)";
				$qry_InsSeccion = mysqli_query($conn, $sql_InsSeccion);
				$NUMERO_MAIN_SECCION = mysqli_insert_id($conn);
			}
		}else{
			$NUMERO_MAIN_SECCION = $EXISTENTE_NUMERO_TERRITORIO;
		}

		$sql_dupTerritorio = "SELECT NUMERO_ID,
									 SECCION_ID 
						        FROM TERRITORIOS_NUMERO 
						  INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = NUMERO_MAIN_SECCION
						       WHERE NUMERO_SECCION = '$NUMERO_SECCION'
						       AND NUMERO_MAIN_SECCION = $NUMERO_MAIN_SECCION";
		$qry_dupTerritorio = mysqli_query($conn, $sql_dupTerritorio);
		$row_dupTerritorio = mysqli_num_rows($qry_dupTerritorio);

		if ($row_dupTerritorio == 0) {
			$sql_NewTerritorio = "INSERT INTO TERRITORIOS_NUMERO (NUMERO_SECCION,
															  NUMERO_MAIN_SECCION,
															  NUMERO_CALLES,
															  NUMERO_COMENTARIOS)
											          VALUES ('". $_POST['NUMERO_SECCION']."',
											          		  $NUMERO_MAIN_SECCION,	
											      			  '". $_POST['NUMERO_CALLES']."',
											      			  '". $_POST['NUMERO_COMENTARIOS']."')";
		}

		mysqli_query($conn, $sql_NewTerritorio);
		header('location: ../../territorio.php?ST=SUCCESS');
	}
	mysqli_close($conn);
 ?>