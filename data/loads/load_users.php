<?php
	include '../../include/connection.php';

	$busqueda = $_POST['busqueda'];
	$congregacion = $_POST['NUMERO_CONGREGACION'];

	if (isset($busqueda)) {
		if ($busqueda == '') {
			$sql_Usuarios = "SELECT USERS_ID,
                              USERS_NOMBRE, 
                              USERS_GRUPO, 
                              USERS_PRIVILEGIO, 
                              USERS_TELEFONO, 
                              USERS_NIVEL, 
                              USERS_FOTO 
                         FROM TERRITORIOS_USERS 
                        WHERE USERS_CONGREGACION = $congregacion";
		}else{
			$sql_Usuarios = "SELECT USERS_ID,
                              USERS_NOMBRE, 
                              USERS_GRUPO, 
                              USERS_PRIVILEGIO, 
                              USERS_TELEFONO, 
                              USERS_NIVEL, 
                              USERS_FOTO 
                         FROM TERRITORIOS_USERS 
                    	  WHERE ((USERS_NOMBRE LIKE '%$busqueda%') OR (USERS_GRUPO LIKE '%$busqueda%') OR (USERS_TELEFONO LIKE '%$busqueda%'))
                        AND (USERS_CONGREGACION = $congregacion)";	
		}
	}else{
		$sql_Usuarios = "SELECT   USERS_ID,
                              USERS_NOMBRE, 
                              USERS_GRUPO, 
                              USERS_PRIVILEGIO, 
                              USERS_TELEFONO, 
                              USERS_NIVEL, 
                              USERS_FOTO 
                         FROM TERRITORIOS_USERS 
                        WHERE USERS_CONGREGACION = $congregacion";
	}

	
	
  $qry_Usuarios = mysqli_query($conn, $sql_Usuarios);
	$row_Usuarios = mysqli_num_rows($qry_Usuarios);
	if ($row_Usuarios != 0) { ?>
		<table class="table table-data2 table-hover">
        <thead class="thead-dark">
            <tr class="text-center">
                <th class="encabezado_tabla">Nombre</th>
                <th class="encabezado_tabla">Grupo</th>
                <th class="encabezado_tabla">Privilegio de servicio</th>
                <th class="encabezado_tabla">Teléfono</th>
                <th class="encabezado_tabla">Nivel</th>
                <th class="encabezado_tabla" id="fotografia">Foto</th>
                <th class="text-center encabezado_tabla">Opciones</th>
            </tr>
        </thead>
        <tbody>
 	<?php while ($rs_Usuarios = mysqli_fetch_array($qry_Usuarios, MYSQLI_ASSOC)) { ?>
            <tr class="tr-shadow text-justify" id="fila_<?php echo $rs_Usuarios['USERS_ID']; ?>">
                <td><?php echo $rs_Usuarios['USERS_NOMBRE']; ?></td>
                <td><?php echo $rs_Usuarios['USERS_GRUPO']; ?></td>
                
                <td>
                    <?php
                        $privilegio = $rs_Usuarios['USERS_PRIVILEGIO'];
                        if ($privilegio == 1) {
                          $privilegio = 'Publicador';
                        }elseif ($privilegio == 2) {
                          $privilegio = 'Precursor Auxiliar';
                        }else{
                          $privilegio = 'Precursor Regular';
                        }

                        echo $privilegio; 
                    ?>
                </td>
                
                <td>
                  <?php 
                    $telefono = $rs_Usuarios['USERS_TELEFONO'];
                    if ($telefono == '') {
                      $telefono = 'Ninguno';  
                    }
                    echo $telefono;
                  ?>
                </td>
                
                <td>
                    <?php
                        $nivel = $rs_Usuarios['USERS_NIVEL'];
                        if ($nivel == 1) {
                          $nivel = 'General';
                        }elseif ($nivel == 2) {
                          $nivel = 'Capitán';
                        }else{
                          $nivel = 'Administrador';
                        }
                        echo $nivel;
                    ?>  
                </td>

                <td>
                  <?php 
                    $foto = $rs_Usuarios['USERS_FOTO'];
                    if ($foto == '') {
                      $foto = 'Ninguna';
                      echo $foto;
                    }else{ ?>
                      <a href="#imageModal" role="button" class="addModal" data-toggle="modal">
                        <img class="profileImage" src="images/USERS/<?php echo $foto;?>" alt="<?php echo $rs_Usuarios['USERS_NOMBRE']; ?>">
                      </a>
                    <?php } ?>
                </td>
                
                <td>
                    <div class="table-data-feature">
                        <button class="item editadoUsuarios" data-toggle="tooltip" data-placement="top" title="Editar nivel de usuario" id="editado_<?php echo $rs_Usuarios['USERS_ID']; ?>">
                            <i class="zmdi zmdi-edit a"></i>
                        </button>
                        <button class="item borradoUsuarios" data-toggle="modal" data-target="#borraUsuario" id="borrado_<?php echo $rs_Usuarios['USERS_ID']; ?>" title="Borrar usuario">
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
	<div id="sin-usuarios">No hay usuarios listados.</div>
<?php } mysqli_close($conn) ?>    	