<?php 
	include '../../include/connection.php';
	if (isset($_POST['fetch1'])) {
		$sql_Plan = "SELECT SALIDAS_ID,
	                       USERS_NOMBRE,
	                       USERS_FOTO,
	                       USERS_TELEFONO,
	                       SALIDAS_USUARIO_GRUPO, 
	                       SECCION_NOMBRE,
	                       NUMERO_SECCION,
	                       SALIDAS_SEGMENTO_FIN,
	                       SALIDAS_SUBSEGMENTO_FIN,
	                       SALIDAS_FORIGEN,
	                       SALIDAS_FFIN,
	                       SALIDAS_ALLPERMISSIONS,
	                       SALIDAS_COMENTARIO
	                  FROM TERRITORIOS_SALIDAS
	            INNER JOIN TERRITORIOS_SECCION ON SALIDAS_SEGMENTO = SECCION_ID
	            INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = SALIDAS_SUBSEGMENTO
	            INNER JOIN TERRITORIOS_USERS ON USERS_ID = SALIDAS_USUARIO_ORIGEN
	                 WHERE SALIDAS_ID = '". $_POST['SALIDAS_ID']."'";

	    $qry_plan = mysqli_query($conn, $sql_Plan);
	    $rs_plan = mysqli_fetch_array($qry_plan, MYSQLI_ASSOC);
	    echo json_encode($rs_plan);
	}

	if (isset($_POST['fetch2'])) {
		$sql_segmentoFinal = "SELECT 
                                SECCION_NOMBRE 
                              FROM
                                TERRITORIOS_SALIDAS
                              INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = '". $_POST['segmentoFin']."'";
        $qry_segmentoFinal = mysqli_query($conn, $sql_segmentoFinal);
        $rs_segmentoFinal = mysqli_fetch_array($qry_segmentoFinal, MYSQLI_ASSOC);
        echo json_encode($rs_segmentoFinal);
	}

	if (isset($_POST['fetch3'])) {
		$sql_subsegmentoFinal = "SELECT 
                                    NUMERO_SECCION 
                                 FROM
                                    TERRITORIOS_SALIDAS
                                 INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = '". $_POST['subsegmentoFin']."'";
        $qry_subsegmentoFinal = mysqli_query($conn, $sql_subsegmentoFinal);
        $rs_subsegmentoFinal = mysqli_fetch_array($qry_subsegmentoFinal, MYSQLI_ASSOC);
        echo json_encode($rs_subsegmentoFinal);
	}
	
    mysqli_close($conn);	
 ?>