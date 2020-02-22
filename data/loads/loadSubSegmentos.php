<?php 
	include '../../include/connection.php';
	$sql_SubSegmentos = "SELECT NUMERO_ID,
								NUMERO_SECCION 
						   FROM TERRITORIOS_NUMERO
						  WHERE NUMERO_MAIN_SECCION = '". $_POST['NUMERO_MAIN_SECCION']."'
						  ORDER BY NUMERO_SECCION ASC";


	if ($_POST['INICIO']==1) {
		$qry_SubSegmentos = mysqli_query($conn, $sql_SubSegmentos);
		$rows_SubSegmentos = mysqli_num_rows($qry_SubSegmentos);

		if ($rows_SubSegmentos == 0) { ?>
			<option value="0">No hay elementos por mostrar</option>
		<?php }else{ ?>
			<option value="0">Seleccione...</option>
		<?php while ($rs_SubSegmentos = mysqli_fetch_array($qry_SubSegmentos, MYSQLI_ASSOC)) { ?>
			<option value="<?php echo $rs_SubSegmentos['NUMERO_ID']; ?>"><?php echo $rs_SubSegmentos['NUMERO_SECCION']; ?></option>
			<?php }
		}		
	}

	if ($_POST['FIN']==1) {
		$qry_SubSegmentos = mysqli_query($conn, $sql_SubSegmentos);
		$rows_SubSegmentos = mysqli_num_rows($qry_SubSegmentos);

		if ($rows_SubSegmentos == 0) { ?>
			<option value="0">No hay elementos por mostrar</option>
		<?php }else{ ?>
			<option value="0">Seleccione...</option>
		<?php while ($rs_SubSegmentos = mysqli_fetch_array($qry_SubSegmentos, MYSQLI_ASSOC)) { ?>
			<option value="<?php echo $rs_SubSegmentos['NUMERO_ID']; ?>"><?php echo $rs_SubSegmentos['NUMERO_SECCION']; ?></option>
			<?php }
		}
	}
	mysqli_close($conn);
 ?>