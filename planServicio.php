<?php 
    session_start();
    if (!isset($_SESSION['USUARIO_ID'])) {
        header('location: index.php?ST=UNAUTHORIZED');
    }

    include 'include/connection.php';
    include 'phpFunctions/convertDate.php';
    $sql_getData = "SELECT * 
                      FROM TERRITORIOS_USERS
                INNER JOIN TERRITORIOS_CONGREGACION 
                        ON CONGREGACION_ID = USERS_CONGREGACION
                     WHERE USERS_ID = '". $_SESSION['USUARIO_ID'] ."'";
    $qryGetData = mysqli_query($conn, $sql_getData);
    $rs_getData = mysqli_fetch_array($qryGetData, MYSQLI_ASSOC);

    $segmento = $rs_getData['CONGREGACION_SEGMENTO'];
    $subsegmento = $rs_getData['CONGREGACION_SUBSEGMENTO'];

    $sql_Usuarios = "SELECT * 
                           FROM TERRITORIOS_USERS 
                          WHERE USERS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'";
    $qry_Usuarios = mysqli_query($conn, $sql_Usuarios);
    $row_Usuarios = mysqli_num_rows($qry_Usuarios);

    $sql_Secciones = "SELECT * 
                        FROM TERRITORIOS_SECCION 
                       WHERE SECCION_CONGREGACION = '" .$_SESSION['USUARIO_CONGREGACION']. "'
                       ORDER BY SECCION_NOMBRE ASC";
    $qry_Secciones = mysqli_query($conn, $sql_Secciones);
    $row_Secciones = mysqli_num_rows($qry_Secciones);
    $qry_SeccionesFin = mysqli_query($conn, $sql_Secciones);
    $row_SeccionesFin = mysqli_num_rows($qry_SeccionesFin);

    /*Esta consulta va a evaluar si hay un plan de servicio previo a nivel congregación que el usuario quiera insertar un nuevo plan*/
    $sql_PlanGeneral = "SELECT 
                            SALIDAS_ID,
                            USERS_NOMBRE,
                            SALIDAS_USUARIO_GRUPO, 
                            SECCION_NOMBRE,
                            NUMERO_SECCION,
                            SALIDAS_SEGMENTO_FIN,
                            SALIDAS_SUBSEGMENTO_FIN,
                            SALIDAS_ALLPERMISSIONS
                        FROM
                            TERRITORIOS_SALIDAS
                        INNER JOIN TERRITORIOS_SECCION ON SALIDAS_SEGMENTO = SECCION_ID
                        INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = SALIDAS_SUBSEGMENTO
                        LEFT JOIN TERRITORIOS_USERS ON USERS_ID = SALIDAS_USUARIO_ORIGEN
                        INNER JOIN TERRITORIOS_CONGREGACION ON CONGREGACION_ID = SALIDAS_CONGREGACION  
                        WHERE 
                            SALIDAS_CONGREGACION = '". $_SESSION['USUARIO_CONGREGACION']."'
                            AND SALIDAS_ALLPERMISSIONS = 0 
                            AND SALIDAS_COMPLETADO IS NULL";
    $qry_planGeneral = mysqli_query($conn, $sql_PlanGeneral);
    $rows_planGeneral = mysqli_num_rows($qry_planGeneral);

    /*Esta consulta va a evaluar si hay un plan de servicio previo a nivel grupo que el usuario quiera insertar un nuevo plan*/
    $sql_PlanGrupo = "SELECT 
                            SALIDAS_ID
                        FROM
                            TERRITORIOS_SALIDAS 
                        WHERE 
                            SALIDAS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'
                            AND SALIDAS_ALLPERMISSIONS = 1
                            AND SALIDAS_USUARIO_GRUPO = '". $_SESSION['GRUPO'] ."'
                            AND SALIDAS_COMPLETADO IS NULL";
    $qry_planGrupo = mysqli_query($conn, $sql_PlanGrupo);
    $rows_planGrupo = mysqli_num_rows($qry_planGrupo);

    $sql_PlanotrosGrupos = "SELECT 
                                SALIDAS_ID,
                                USERS_NOMBRE,
                                SALIDAS_USUARIO_GRUPO, 
                                SECCION_NOMBRE,
                                NUMERO_SECCION,
                                SALIDAS_SEGMENTO_FIN,
                                SALIDAS_SUBSEGMENTO_FIN,
                                SALIDAS_ALLPERMISSIONS
                            FROM
                                TERRITORIOS_SALIDAS
                            INNER JOIN TERRITORIOS_SECCION ON SALIDAS_SEGMENTO = SECCION_ID
                            INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = SALIDAS_SUBSEGMENTO
                            LEFT JOIN TERRITORIOS_USERS ON USERS_ID = SALIDAS_USUARIO_ORIGEN
                            INNER JOIN TERRITORIOS_CONGREGACION ON CONGREGACION_ID = SALIDAS_CONGREGACION
                            WHERE 
                                SALIDAS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'
                                AND SALIDAS_ALLPERMISSIONS = 1
                                AND SALIDAS_COMPLETADO IS NULL";

    $sql_planesCerrados = "SELECT
                                SALIDAS_ID,
                                USERS_NOMBRE,
                                SALIDAS_USUARIO_GRUPO, 
                                SECCION_NOMBRE,
                                NUMERO_SECCION,
                                SALIDAS_SEGMENTO_FIN,
                                SALIDAS_SUBSEGMENTO_FIN,
                                SALIDAS_ALLPERMISSIONS,
                                SALIDAS_USUARIO_FIN,
                                SALIDAS_CLOSE_DATE
                            FROM
                                TERRITORIOS_SALIDAS
                            INNER JOIN TERRITORIOS_SECCION ON SALIDAS_SEGMENTO = SECCION_ID
                            INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = SALIDAS_SUBSEGMENTO
                            LEFT JOIN TERRITORIOS_USERS ON USERS_ID = SALIDAS_USUARIO_ORIGEN
                            INNER JOIN TERRITORIOS_CONGREGACION ON CONGREGACION_ID = SALIDAS_CONGREGACION
                            WHERE 
                                SALIDAS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'
                                AND SALIDAS_COMPLETADO = 1
                            ORDER BY SALIDAS_CLOSE_DATE DESC, SALIDAS_ID DESC
                            LIMIT 10";

    $qry_planesCerrados = mysqli_query($conn, $sql_planesCerrados);
    $rows_planescerrados = mysqli_num_rows($qry_planesCerrados);
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Salidas al servicio <?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/mainCSS.css">
    <link rel="stylesheet" href="css/CSSSalidas.css">
</head>

<body class="animsition">
    <input type="hidden" id="miGrupo" value="<?php echo $_SESSION['GRUPO'];?>">
    <div class="page-wrapper">
        
        <?php
            if ($_SESSION['NIVEL'] == 1) {
                include 'include/menu_general.php';
             }else if ($_SESSION['NIVEL'] == 2){
                include 'include/menu_capitan.php';
             }else{
                include 'include/menu_admin.php';
             }  
         ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop d-sm-none d-lg-block">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="header-button">
                                <div class="account-wrap" style="position: absolute !important; right: 3% !important;">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image
                                        ">
                                            <?php 
                                                $picture = $rs_getData['USERS_FOTO'];
                                                if ($picture == NULL) {
                                                    $picture = 'unknown.png';
                                                }
                                             ?>
                                            <img src="images/USERS/<?php echo $picture; ?>" alt="<?php echo $_SESSION['USUARIO_NOMBRE']; ?>" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#" id="nombre_usuario">Hola <?php 
                                                $usuario = $_SESSION['USUARIO_NOMBRE'];
                                                $posEspacio = strpos($usuario, ' ');
                                                 $iparr = split (" ", $usuario);
                                                 echo $iparr[0] . ' ' . $iparr[1];
                                             ?></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="images/USERS/<?php echo $picture; ?>" alt="<?php echo $_SESSION['USUARIO_NOMBRE']; ?>" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#"><?php echo $usuario; ?></a>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="account.php">
                                                        <i class="zmdi zmdi-account"></i>Mi cuenta</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="data/logout.php">
                                                    <i class="zmdi zmdi-power"></i>Salir del sistema</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card">
                                  <div class="card-header">
                                    <div class="clearfix"></div>
                                    <strong class="card-title">Salidas al servicio - <span id="CONGREGACION"><?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></span></strong>
                                    <input type="hidden" id="congregacionID" value="<?php echo $_SESSION['USUARIO_CONGREGACION'];?>">
                                  </div> 
                                    <?php 
                                        if (isset($_GET['ST'])) {
                                            if ($_GET['ST'] == 'PREV_PLAN') { ?>
                                                <div class="alert alert-danger">
                                                  No es posible ingresar un plan de predicación a nivel congregación habiendo planes abiertos a nivel grupal.
                                                </div>    
                                            <?php }elseif ($_GET['ST'] == 'COMPLETE') { ?>
                                                <div class="alert alert-success text-center">
                                                    El plan de predicación ha sido cerrado exitosamente.
                                                </div>
                                            <?php }

                                        } ?> 
                                                <div class="alert alert-success text-center" id="planBorrado">
                                                    El plan de predicación ha sido borrado exitosamente.
                                                </div>
                                    
                                  <div class="card-body">
                                    <div class="col-md-12">
                                        <h3 class="title-4 m-b-35">Mis planes de predicación</h3>
                                        <?php if ($rows_planGeneral !=0) { ?>
                                                <p class="forbidden">
                                                    Hay un plan de predicación abierto a nivel congregación.
                                                </p>    
                                        <?php }else{ 
                                                if ($rows_planGrupo != 0) { ?>
                                                    <p class="forbidden">
                                                        Hay un plan de predicación abierto a nivel grupo.
                                                    </p>
                                                <?php } else { ?>
                                                        <button class="btn btn-primary" data-toggle="modal" data-target="#insertarSalida" id="addSalida">Agregar plan de predicación</button>
                                                <?php }
                                            }?>
                                            <div id="agregando"></div>

                                            <div id="planesPredicacionCongregacion">
                                        <?php 
                                            if ($rows_planGeneral != 0 ) { ?>
                                                <hr>
                                                <h6 class="title-5 m-b-35">Planes de predicación abiertos</h5>
                                                <div class="table-responsive table-responsive-data2 col-md-12" id="insercionSalidas">
                                                    <table class="table table-data2 table-hover">
                                                        <thead class="thead-dark">
                                                            <tr class="text-center">
                                                                <th class="encabezado_tabla">Usuario</th>
                                                                <th class="encabezado_tabla">Grupo</th>
                                                                <th class="encabezado_tabla">Punto de origen</th>
                                                                <th class="encabezado_tabla">Punto Cierre</th>
                                                                <th class="encabezado_tabla">Nivel de plan</th>
                                                                <th class="text-center encabezado_tabla">Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                while ($rs_planGeneral = mysqli_fetch_array($qry_planGeneral)) { ?>
                                                                     <tr id="plan_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>" class="tr-shadow text-left">
                                                                        <td id="nombre_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>"><?php echo $rs_planGeneral['USERS_NOMBRE']; ?></td>
                                                                        <td id="grupo_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>"><?php echo $rs_planGeneral['SALIDAS_USUARIO_GRUPO']; ?></td>
                                                                        <td id="origen_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>"><?php echo $segmento. ': '. $rs_planGeneral['SECCION_NOMBRE']. ' - '. $subsegmento. ': ' . $rs_planGeneral['NUMERO_SECCION']; ?>
                                                                        </td>
                                                                        <td id="cierre_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>"><?php
                                                                                $segmento_final = $rs_planGeneral['SALIDAS_SEGMENTO_FIN'];
                                                                                $sql_segmentoFinal = "SELECT 
                                                                                                        SECCION_NOMBRE 
                                                                                                      FROM
                                                                                                        TERRITORIOS_SALIDAS
                                                                                                      INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = $segmento_final";
                                                                                $qry_segmentoFinal = mysqli_query($conn, $sql_segmentoFinal);
                                                                                $rs_segmentoFinal = mysqli_fetch_array($qry_segmentoFinal, MYSQLI_ASSOC);

                                                                                $subsegmento_final = $rs_planGeneral['SALIDAS_SUBSEGMENTO_FIN'];
                                                                                $sql_subsegmentoFinal = "SELECT 
                                                                                                            NUMERO_SECCION 
                                                                                                         FROM
                                                                                                            TERRITORIOS_SALIDAS
                                                                                                         INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = $subsegmento_final";
                                                                                $qry_subsegmentoFinal = mysqli_query($conn, $sql_subsegmentoFinal);
                                                                                $rs_subsegmentoFinal = mysqli_fetch_array($qry_subsegmentoFinal, MYSQLI_ASSOC);

                                                                                echo $segmento. ': '. $rs_segmentoFinal['SECCION_NOMBRE']. ' - '. $subsegmento. ': '. $rs_subsegmentoFinal['NUMERO_SECCION']; ?></td>
                                                                        <td id="nivel_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>"><?php
                                                                                $tipo_salida = $rs_planGeneral['SALIDAS_ALLPERMISSIONS'];
                                                                                if ($tipo_salida == 0) {
                                                                                    $tipo_salida = 'Congregación';
                                                                                }else{
                                                                                    $tipo_salida = 'Grupal';
                                                                                }
                                                                                echo $tipo_salida;
                                                                            ?></td>
                                                                        <td>
                                                                            <div class="table-data-feature">
                                                                                <button class="item cerradoPlan" data-toggle="modal" data-target="#cerrarPlan" title="Cerrar plan" id="cerrado_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>">
                                                                                    <i class="fa fa-check-circle"></i>
                                                                                </button>
                                                                                <button class="item editadoPlan" data-toggle="modal" data-target="#editarSalida" title="Editar fechas" id="editado_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>">
                                                                                    <i class="zmdi zmdi-edit a"></i>
                                                                                </button>
                                                                                <button class="item borradoPlan" data-toggle="modal" data-target="#borraPlan" id="borrado_<?php echo $rs_planGeneral['SALIDAS_ID']; ?>" title="Borrar plan">
                                                                                    <i class="zmdi zmdi-delete"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                        <?php 
                                            } else{
                                                $qry_planotrosGrupos = mysqli_query($conn, $sql_PlanotrosGrupos);
                                                $row_planotrosGrupos = mysqli_num_rows($qry_planotrosGrupos);
                                                if ($row_planotrosGrupos == 0) { ?>
                                                    
                                            <?php }else { ?>
                                                <hr>
                                                <h6 class="title-5 m-b-35">Planes de predicación abiertos</h5>
                                                <div class="table-responsive table-responsive-data2 col-md-12" id="insercionSalidas">
                                                    <table class="table table-data2 table-hover">
                                                        <thead class="thead-dark">
                                                            <tr class="text-center">
                                                                <tr class="text-center">
                                                                <th class="encabezado_tabla">Usuario</th>
                                                                <th class="encabezado_tabla">Grupo</th>
                                                                <th class="encabezado_tabla">Punto de Origen</th>
                                                                <th class="encabezado_tabla">Punto de Cierre</th>
                                                                <th class="encabezado_tabla">Nivel de plan</th>
                                                                <th class="text-center encabezado_tabla">Opciones</th>
                                                            </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                while ($rs_PlanotrosGrupos = mysqli_fetch_array($qry_planotrosGrupos)) { ?>
                                                                     <tr id="plan_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>" class="tr-shadow text-left">
                                                                        <td id="nombre_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>"><?php echo $rs_PlanotrosGrupos['USERS_NOMBRE']; ?></td>
                                                                        <td id="grupo_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>"><?php echo $rs_PlanotrosGrupos['SALIDAS_USUARIO_GRUPO']; ?></td>
                                                                        <td id="origen_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>"><?php echo $segmento. ': '. $rs_PlanotrosGrupos['SECCION_NOMBRE']. ' - '. $subsegmento. ': ' . $rs_PlanotrosGrupos['NUMERO_SECCION']; ?>
                                                                        </td>
                                                                        <td id="cierre_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>"><?php
                                                                                $segmento_final = $rs_PlanotrosGrupos['SALIDAS_SEGMENTO_FIN'];
                                                                                $sql_segmentoFinal = "SELECT 
                                                                                                        SECCION_NOMBRE 
                                                                                                      FROM
                                                                                                        TERRITORIOS_SALIDAS
                                                                                                      INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = $segmento_final";
                                                                                $qry_segmentoFinal = mysqli_query($conn, $sql_segmentoFinal);
                                                                                $rs_segmentoFinal = mysqli_fetch_array($qry_segmentoFinal, MYSQLI_ASSOC);

                                                                                $subsegmento_final = $rs_PlanotrosGrupos['SALIDAS_SUBSEGMENTO_FIN'];
                                                                                $sql_subsegmentoFinal = "SELECT 
                                                                                                            NUMERO_SECCION 
                                                                                                         FROM
                                                                                                            TERRITORIOS_SALIDAS
                                                                                                         INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = $subsegmento_final";
                                                                                $qry_subsegmentoFinal = mysqli_query($conn, $sql_subsegmentoFinal);
                                                                                $rs_subsegmentoFinal = mysqli_fetch_array($qry_subsegmentoFinal, MYSQLI_ASSOC);

                                                                                echo $segmento. ': '. $rs_segmentoFinal['SECCION_NOMBRE']. ' - '. $subsegmento. ': '. $rs_subsegmentoFinal['NUMERO_SECCION']; ?></td>
                                                                        <td id="nivel_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>"><?php
                                                                                $tipo_salida = $rs_PlanotrosGrupos['SALIDAS_ALLPERMISSIONS'];
                                                                                if ($tipo_salida == 0) {
                                                                                    $tipo_salida = 'Congregación';
                                                                                }else{
                                                                                    $tipo_salida = 'Grupal';
                                                                                }
                                                                                echo $tipo_salida;
                                                                            ?></td>
                                                                        <td>
                                                                            <div class="table-data-feature">
                                                                                <button class="item cerradoPlan" data-toggle="modal" data-target="#cerrarPlan" title="Cerrar plan" id="cerrado_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>">
                                                                                    <i class="fa fa-check-circle"></i>
                                                                                </button>
                                                                                <button class="item editadoPlan" data-toggle="modal" data-target="#editarSalida" title="Editar fechas" id="editado_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>">
                                                                                    <i class="zmdi zmdi-edit a"></i>
                                                                                </button>
                                                                                <button class="item borradoPlan" data-toggle="modal" data-target="#borraPlan" id="borrado_<?php echo $rs_PlanotrosGrupos['SALIDAS_ID']; ?>" title="Borrar plan">
                                                                                    <i class="zmdi zmdi-delete"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                            <?php } ?> <!--Cierre de loop para plan de otros grupos-->
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <?php } //Cierre del else del plan para otros grupos
                                            } ?>
                                            </div>
                                            <?php

                                                if ($rows_planescerrados != 0) { ?>
                                                    <div id="opener">
                                                        <button class="btn btn-primary seccion">Mostrar planes cerrados</button>
                                                    </div>
                                                    <div id="planescerrados" class="seccion">
                                                        <h6 class="title-5 m-b-35">Planes de predicación Cerrados</h5>
                                                        <div class="table-responsive table-responsive-data2 col-md-12" id="insercionSalidas">
                                                            <table class="table table-data2 table-hover">
                                                                <thead class="thead-dark">
                                                                    <tr class="text-center">
                                                                        <tr class="text-center">
                                                                        <th class="encabezado_tabla">Quién abre el plan</th>
                                                                        <th class="encabezado_tabla">Grupo</th>
                                                                        <th class="encabezado_tabla">Punto de Origen</th>
                                                                        <th class="encabezado_tabla">Punto de Cierre</th>
                                                                        <th class="encabezado_tabla">Nivel de plan</th>
                                                                        <th class="text-center encabezado_tabla">Quién cierra el plan</th>
                                                                        <th class="encabezado_tabla">Fecha de cierre</th>
                                                                        </tr>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="contenidoPlanesCerrados">
                                                                    <?php 
                                                                        while ($rs_planescerrados = mysqli_fetch_array($qry_planesCerrados, MYSQLI_ASSOC)) { ?>
                                                                            <tr id="planCerrado_<?php echo $rs_planescerrados['SALIDAS_ID']; ?>">
                                                                                <td><?php $usuarioAbre = $rs_planescerrados['USERS_NOMBRE'];
                                                                                if (empty($usuarioAbre)) {
                                                                                    $usuarioAbre = 'Usuario desactivado';
                                                                                }
                                                                                echo $usuarioAbre;?></td>
                                                                                <td><?php echo $rs_planescerrados['SALIDAS_USUARIO_GRUPO']; ?></td>
                                                                                <td>
                                                                                    <?php echo $segmento. ': '. $rs_planescerrados['SECCION_NOMBRE']. ' - '. $subsegmento. ': ' . $rs_planescerrados['NUMERO_SECCION']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $segmento_final = $rs_planescerrados['SALIDAS_SEGMENTO_FIN'];
                                                                                        $sql_segmentoFinal = "SELECT 
                                                                                                                SECCION_NOMBRE 
                                                                                                              FROM
                                                                                                                TERRITORIOS_SALIDAS
                                                                                                              INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = $segmento_final";
                                                                                        $qry_segmentoFinal = mysqli_query($conn, $sql_segmentoFinal);
                                                                                        $rs_segmentoFinal = mysqli_fetch_array($qry_segmentoFinal, MYSQLI_ASSOC);

                                                                                        $subsegmento_final = $rs_planescerrados['SALIDAS_SUBSEGMENTO_FIN'];
                                                                                        $sql_subsegmentoFinal = "SELECT 
                                                                                                                    NUMERO_SECCION 
                                                                                                                 FROM
                                                                                                                    TERRITORIOS_SALIDAS
                                                                                                                 INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = $subsegmento_final";
                                                                                        $qry_subsegmentoFinal = mysqli_query($conn, $sql_subsegmentoFinal);
                                                                                        $rs_subsegmentoFinal = mysqli_fetch_array($qry_subsegmentoFinal, MYSQLI_ASSOC);

                                                                                        echo $segmento. ': '. $rs_segmentoFinal['SECCION_NOMBRE']. ' - '. $subsegmento. ': '. $rs_subsegmentoFinal['NUMERO_SECCION']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $tipo_salida = $rs_planescerrados['SALIDAS_ALLPERMISSIONS'];
                                                                                        if ($tipo_salida == 0) {
                                                                                            $tipo_salida = 'Congregación';
                                                                                        }else{
                                                                                            $tipo_salida = 'Grupal';
                                                                                        }
                                                                                        echo $tipo_salida;
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $quienCierra = $rs_planescerrados['SALIDAS_USUARIO_FIN'];
                                                                                        if (!empty($quienCierra)) {
                                                                                            $sql_quienCierra = "SELECT USERS_NOMBRE FROM TERRITORIOS_USERS WHERE USERS_ID = $quienCierra";
                                                                                            $qry_quienCierra = mysqli_query($conn, $sql_quienCierra);
                                                                                            $rs_quienCierra = mysqli_fetch_array($qry_quienCierra, MYSQLI_ASSOC);
                                                                                            $usuarioCierra = $rs_quienCierra['USERS_NOMBRE'];
                                                                                            if (empty($usuarioCierra)) {
                                                                                                $usuarioCierra = 'Usuario desactivado';
                                                                                            }
                                                                                            echo $usuarioCierra;
                                                                                        }
                                                                                    ?>  
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $fecha = $rs_planescerrados['SALIDAS_CLOSE_DATE'];
                                                                                        $newFecha = convertDate($fecha);
                                                                                        echo $newFecha;
                                                                                    ?>  
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?> <!--Final del loop para planes cerrados--> 
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                            <?php } ?> <!--End if de planes cerrados-->

                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
            
            <!-- modal insertar Salida -->
            <div class="modal fade" id="insertarSalida" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Ingresar plan de predicación - <?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="agregarNuevoPlan" action="data/insert/insert_plan.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row title">
                                    <div class="col-12">
                                        <h5>Punto de partida</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="SALIDAS_SEGMENTO" class="control-label mb-1"><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></label>
                                            <select name="SALIDAS_SEGMENTO" id="SALIDAS_SEGMENTO" class="form-control">
                                                <?php 
                                                    if ($row_Secciones == 0) { ?>
                                                        <option value="0">No hay <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> por mostrar.</option>
                                                <?php } else { ?>
                                                        <option value="0"><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> a seleccionar</option>
                                                    <?php while ($rs_Secciones = mysqli_fetch_array($qry_Secciones, MYSQLI_ASSOC)) {?>
                                                        <option value="<?php echo $rs_Secciones['SECCION_ID'];?>"><?php echo $rs_Secciones['SECCION_NOMBRE'];?></option>
                                                    <?php }
                                                } ?>
                                                
                                            </select>
                                            <div class="invalid" id="INVALID_SALIDAS_SEGMENTO">El/la <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> es mandatorio</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="SALIDAS_SUBSEGMENTO" class="control-label mb-1"><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?></label>
                                            <select name="SALIDAS_SUBSEGMENTO" id="SALIDAS_SUBSEGMENTO" class="form-control">
                                                
                                            </select>
                                            <div class="invalid" id="INVALID_SALIDAS_SUBSEGMENTO">El/la <?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?> es mandatorio</div>
                                        </div>
                                    </div>        
                                </div>
                                <hr>
                                <div class="row title">
                                    <div class="col-12">
                                        <h5>Punto de Cierre</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="SALIDAS_SEGMENTO_FIN" class="control-label mb-1"><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></label>
                                            <select name="SALIDAS_SEGMENTO_FIN" id="SALIDAS_SEGMENTO_FIN" class="form-control">
                                                <?php 
                                                    if ($row_SeccionesFin == 0) { ?>
                                                        <option value="0">No hay <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> por mostrar.</option>
                                                <?php } else { ?>
                                                        <option value="0"><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> a seleccionar</option>
                                                    <?php while ($rs_SeccionesFin = mysqli_fetch_array($qry_SeccionesFin, MYSQLI_ASSOC)) {?>
                                                        <option value="<?php echo $rs_SeccionesFin['SECCION_ID'];?>"><?php echo $rs_SeccionesFin['SECCION_NOMBRE'];?></option>
                                                    <?php }
                                                } ?>
                                                
                                            </select>
                                            <div class="invalid" id="INVALID_SALIDAS_SEGMENTO_FIN">El/la <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> es mandatorio</div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="SALIDAS_SUBSEGMENTO_FIN" class="control-label mb-1"><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?></label>
                                            <select name="SALIDAS_SUBSEGMENTO_FIN" id="SALIDAS_SUBSEGMENTO_FIN" class="form-control">
                                                
                                            </select>
                                            <div class="invalid" id="INVALID_SALIDAS_SUBSEGMENTO_FIN">El/la <?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?> es mandatorio</div>
                                        </div>
                                    </div>        
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="SALIDAS_FORIGEN" class="control-label mb-1">Fecha de inicio</label>
                                            <input type="date" id="SALIDAS_FORIGEN" name="SALIDAS_FORIGEN" class="form-control">
                                            <div class="invalid" id="INVALID_SALIDAS_FORIGEN">Seleccione una fecha de inicio</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="SALIDAS_FFIN" class="control-label mb-1">Fecha de término</label>
                                            <input type="date" id="SALIDAS_FFIN" name="SALIDAS_FFIN" class="form-control">
                                            <div class="invalid" id="INVALID_SALIDAS_FFIN">Seleccione una fecha de término</div>
                                        </div>
                                    </div>        
                                </div>
                                <div class="row invalid" id="INVALID_INCONGRUENCIA_FECHAS">
                                    No hay coherencia en las fechas seleccionadas
                                </div>
                                <hr>
                                <div class="row">
                                    <label for="SALIDAS_COMENTARIO" class="col-12">Comentarios</label>
                                    <textarea name="SALIDAS_COMENTARIO" id="SALIDAS_COMENTARIO" rows="4" placeholder="Ingrese algún comentario sobre este plan de predicación" class="col-12"></textarea>
                                </div>
                                    
                                <hr>
                                <div class="row">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <label for="SALIDAS_ALLPERMISSIONS" class="form-check-label">
                                                <input type="checkbox" id="SALIDAS_ALLPERMISSIONS" name="SALIDAS_ALLPERMISSIONS" value="1" class="form-check-input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deseo que solo mi grupo vea este plan de salida al servicio.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <div class="modal-footer">
                            <input type="hidden" value="<?php echo $_SESSION['USUARIO_CONGREGACION']; ?>" name="NUMERO_CONGREGACION" id="NUMERO_CONGREGACION">    
                            <input type="hidden" value="1" name="insNewServicio">
                            <input type="hidden" value="<?php echo $_SESSION['USUARIO_ID']; ?>" name="SALIDAS_USUARIO_ORIGEN" id="SALIDAS_USUARIO_ORIGEN">
                            <input type="hidden" name="SALIDAS_USUARIO_GRUPO" id="SALIDAS_USUARIO_GRUPO" value="<?php echo $rs_getData['USERS_GRUPO']; ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar plan de predicación</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal insertar Salida -->
            
        </div>

    </div>
    <!-- modal static -->
    <div class="modal fade" id="borraPlan" tabindex="-1" role="dialog" aria-labelledby="borraPlanLabel" aria-hidden="true"
     data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="borraPlanLabel">Borrar plan de predicación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="planID" name="planID">
                    <p>
                        ¿Realmente deseas borrar el plan de predicación de la lista?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmacion_borrado">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal para cerrar plan-->
    <div class="modal fade" id="cerrarPlan" tabindex="-1" role="dialog" aria-labelledby="cierraPlanLabel" aria-hidden="true"
     data-backdrop="static">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="borraPlanLabel">Cerrar plan de predicación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="cerradodePlan" method="POST" action="data/edit/edit_plan.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p>
                            ¿Realmente deseas cerrar este plan de predicación de la lista?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="salida_id" name="salida_id">
                        <input type="hidden" id="closeSalida" name="closeSalida" value="1">
                        <input type="hidden" name="SALIDAS_USUARIO_FIN" id="SALIDAS_USUARIO_FIN" value="<?php echo $_SESSION['USUARIO_ID']; ?>">
                        <input type="hidden" name="redirect" value="1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="confirmacion_cierre">Cerrar plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Fin de modal de cierre de plan-->

    <!-- modal editar Salida -->
            <div class="modal fade" id="editarSalida" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Editar plan de predicación - <?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editandoPlan" action="data/edit/edit_plan.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div id="EDIT_PLAN_FOTO" class="col-6 float-left">
                                            <img src="" alt="">
                                        </div>
                                        <div class="datos col-6 float-left">
                                            <p><b>Asignado por: </b><span id="EDIT_USERS_NOMBRE"></span></p>
                                            <p><b>Grupo: </b><span id="EDIT_SALIDAS_USUARIO_GRUPO"></span></p>
                                            <p><b>Número de contacto: </b><span id="EDIT_USERS_TELEFONO"></span></p>
                                            <hr>
                                            <h5 class="pb-2 display-5">Punto de Partida</h5>
                                            <p><b><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?>: </b><span id="EDIT_SECCION_NOMBRE"></span></p>
                                            <p><b><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?>: </b><span id="EDIT_NUMERO_SECCION"></span></p>
                                            <hr>
                                            
                                            <h5 class="pb-2 display-5">Punto de Cierre</h5>
                                            <p><b><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?>: </b><span id="EDIT_SALIDAS_SEGMENTO_FIN"></span>
                                            </p>
                                            <p><b><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?>:</b>
                                                <span id="EDIT_SALIDAS_SUBSEGMENTO_FIN"></span>
                                            </p>
                                            <hr>
                                            <h5 class="pb-2 display-5">Comentarios sobre el territorio:</h5>
                                            <div class="row">
                                                <textarea name="EDIT_SALIDAS_COMENTARIO" id="EDIT_SALIDAS_COMENTARIO" rows="4" placeholder="Ingrese algún comentario sobre este plan de predicación" class="col-12"></textarea>
                                            </div>
                                            <hr>
                                            <h5 class="pb-2 display-5">Fecha estimada de trabajo:</h5>
                                            <p><b>Fecha de inicio: </b></p>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input type="date" name="EDIT_SALIDAS_FORIGEN" id="EDIT_SALIDAS_FORIGEN" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <p><b>Fecha Final:</b></p>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input type="date" name="EDIT_SALIDAS_FFIN" id="EDIT_SALIDAS_FFIN" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="clearfix"></div>
                                
                            <div class="modal-footer">
                                <input type="hidden" name="editFechas" value="1">
                                <input type="hidden" name="EDIT_SALIDAS_ID" id="EDIT_SALIDAS_ID">
                                <input type="hidden" name="EDIT_USER_ID" value="<?php echo $_SESSION['USUARIO_ID']; ?>">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Editar plan de predicación</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/JSplanPredicacion.js"></script>    
    
    <?php if (isset($_GET['ST'])) { ?><script>showMessage();</script><?php } ?>    
    <?php mysqli_close($conn); ?>
</body>

</html>
<!-- end document-->
