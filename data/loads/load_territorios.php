<?php
	include '../../include/connection.php';

	$busqueda = $_POST['busqueda'];
	$congregacion = $_POST['NUMERO_CONGREGACION'];

	if (isset($busqueda)) {
		if ($busqueda == '') {
			$sql_Territorios = "SELECT * 
                                  FROM TERRITORIOS_NUMERO
                            INNER JOIN TERRITORIOS_SECCION
                                    ON NUMERO_MAIN_SECCION = SECCION_ID  
                                 WHERE SECCION_CONGREGACION = $congregacion";
		}else{
			$sql_Territorios = "SELECT * 
                                   FROM TERRITORIOS_NUMERO
                             INNER JOIN TERRITORIOS_SECCION
                                     ON NUMERO_MAIN_SECCION = SECCION_ID 
                              	  WHERE ((SECCION_NOMBRE LIKE '%$busqueda%') 
                              	  	 OR (NUMERO_SECCION LIKE '%$busqueda%')
                              	  	 OR (NUMERO_CALLES LIKE '%$busqueda%')
                              	  	 OR (NUMERO_COMENTARIOS LIKE '%$busqueda%')) 
                                   AND (SECCION_CONGREGACION = $congregacion)";	
		}
	}else{
		$sql_Territorios = "SELECT * 
                                  FROM TERRITORIOS_NUMERO
                            INNER JOIN TERRITORIOS_SECCION
                                    ON NUMERO_MAIN_SECCION = SECCION_ID  
                                 WHERE SECCION_CONGREGACION = $congregacion";
	}

  	
	
  $qry_Territorios = mysqli_query($conn, $sql_Territorios);
	$row_Territorios = mysqli_num_rows($qry_Territorios);
	if ($row_Territorios != 0) { 
		$sql_getData = "SELECT CONGREGACION_SEGMENTO,
		                       CONGREGACION_SUBSEGMENTO 
		                  FROM TERRITORIOS_CONGREGACION
		                 WHERE CONGREGACION_ID = $congregacion";
		$qryGetData = mysqli_query($conn, $sql_getData);
		$rs_getData = mysqli_fetch_array($qryGetData, MYSQLI_ASSOC);
    ?>
		<table class="table table-data2 table-hover">
        <thead class="thead-dark">
            <tr class="text-center">
                <th class="encabezado_tabla"><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></th>
                <th class="encabezado_tabla"><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?></th>
                <th class="encabezado_tabla">Calles</th>
                <th class="encabezado_tabla">Comentarios adicionales</th>
                <th class="text-center encabezado_tabla">Opciones</th>
            </tr>
        </thead>
        <tbody>
 	<?php while ($rs_Territorios = mysqli_fetch_array($qry_Territorios, MYSQLI_ASSOC)) { ?>
            <tr class="tr-shadow text-justify" id="fila_<?php echo $rs_Territorios['NUMERO_ID']; ?>">
                <td><?php echo $rs_Territorios['SECCION_NOMBRE']; ?></td>
                <td><?php echo $rs_Territorios['NUMERO_SECCION']; ?></td>
                <td>
                    <?php
                        $calles = $rs_Territorios['NUMERO_CALLES'];
                        if ($calles == '') {
                             $calles = 'No especificadas';
                        }

                        echo $calles; 
                    ?>
                </td>
                <td>
                    <?php
                        $comentarios = $rs_Territorios['NUMERO_COMENTARIOS'];
                        if ($comentarios == '') {
                             $comentarios = 'Ninguno';
                        }
                        echo $comentarios;
                    ?>  
                </td>
                <td>
                    <div class="table-data-feature">
                        <button class="item editadoTerritorios" data-toggle="tooltip" data-placement="top" title="Editar territorio" id="editado_<?php echo $rs_Territorios['NUMERO_ID']; ?>">
                            <i class="zmdi zmdi-edit a"></i>
                        </button>
                        <button class="item borradoTerritorios" data-toggle="modal" data-target="#borraTerritorio" id="borrado_<?php echo $rs_Territorios['NUMERO_ID']; ?>" title="Borrar territorio">
                            <i class="zmdi zmdi-delete"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="spacer"></tr>
<?php   } ?>
        </tbody>
    </table> 
<?php   } else { ?>
	<div id="sin-territorios">No hay territorios listados.</div>
<?php } mysqli_close($conn) ?>    	