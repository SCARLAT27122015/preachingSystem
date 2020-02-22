<?php 
    session_start();
    if (!isset($_SESSION['USUARIO_ID'])) {
        header('location: index.php?ST=UNAUTHORIZED');
    }

    include 'include/connection.php';
    include 'phpFunctions/convertDate.php';
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");

    $sql_getData = "SELECT CONGREGACION_NOMBRE,
                           USERS_FOTO 
                      FROM TERRITORIOS_USERS
                INNER JOIN TERRITORIOS_CONGREGACION 
                        ON CONGREGACION_ID = USERS_CONGREGACION
                     WHERE USERS_ID = '". $_SESSION['USUARIO_ID'] ."'";
    $qryGetData = mysqli_query($conn, $sql_getData);
    $rs_getData = mysqli_fetch_array($qryGetData, MYSQLI_ASSOC);

    $sql_Salidas = "SELECT SALIDAS_ID,
                           SALIDAS_CONGREGACION,
                           USERS_NOMBRE,
                           USERS_FOTO,
                           USERS_TELEFONO,
                           USERS_NIVEL,
                           SALIDAS_USUARIO_GRUPO, 
                           SECCION_NOMBRE,
                           NUMERO_SECCION,
                           SALIDAS_SEGMENTO_FIN,
                           SALIDAS_SUBSEGMENTO_FIN,
                           SALIDAS_FORIGEN,
                           SALIDAS_FFIN,
                           SALIDAS_ALLPERMISSIONS,
                           SALIDAS_COMPLETADO,
                           CONGREGACION_SEGMENTO,
                           CONGREGACION_SUBSEGMENTO,
                           SALIDAS_COMENTARIO
                      FROM TERRITORIOS_SALIDAS
                INNER JOIN TERRITORIOS_SECCION ON SALIDAS_SEGMENTO = SECCION_ID
                INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = SALIDAS_SUBSEGMENTO
                LEFT JOIN TERRITORIOS_USERS ON USERS_ID = SALIDAS_USUARIO_ORIGEN
                INNER JOIN TERRITORIOS_CONGREGACION ON CONGREGACION_ID = SALIDAS_CONGREGACION
                     WHERE SALIDAS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'
                       AND SALIDAS_COMPLETADO IS NULL
                       AND SALIDAS_ALLPERMISSIONS = 0";
    $qry_Salidas = mysqli_query($conn, $sql_Salidas);
    $row_Salidas = mysqli_num_rows($qry_Salidas);

    $sql_Salidas_grupo = "SELECT SALIDAS_ID,
                           SALIDAS_CONGREGACION,
                           USERS_NOMBRE,
                           USERS_FOTO,
                           USERS_TELEFONO,
                           USERS_NIVEL,
                           SALIDAS_USUARIO_GRUPO, 
                           SECCION_NOMBRE,
                           NUMERO_SECCION,
                           SALIDAS_SEGMENTO_FIN,
                           SALIDAS_SUBSEGMENTO_FIN,
                           SALIDAS_FORIGEN,
                           SALIDAS_FFIN,
                           SALIDAS_ALLPERMISSIONS,
                           SALIDAS_COMPLETADO,
                           CONGREGACION_SEGMENTO,
                           CONGREGACION_SUBSEGMENTO,
                           SALIDAS_COMENTARIO
                      FROM TERRITORIOS_SALIDAS
                INNER JOIN TERRITORIOS_SECCION ON SALIDAS_SEGMENTO = SECCION_ID
                INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = SALIDAS_SUBSEGMENTO
                LEFT JOIN TERRITORIOS_USERS ON USERS_ID = SALIDAS_USUARIO_ORIGEN
                INNER JOIN TERRITORIOS_CONGREGACION ON CONGREGACION_ID = SALIDAS_CONGREGACION
                     WHERE SALIDAS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'
                       AND SALIDAS_COMPLETADO IS NULL
                       AND SALIDAS_ALLPERMISSIONS = 1
                       AND SALIDAS_USUARIO_GRUPO = '". $_SESSION['GRUPO'] ."'";
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
    <title>Panel <?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></title>

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
</head>

<body class="animsition">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <?php if (isset($_GET['ST'])) {
                                        if ($_GET['ST'] == 'SUCCESS') { ?>
                                            <div class="alert alert-success text-center" role="alert">
                                              El plan de servicio se ha ingresado exitosamente.
                                            </div>            
                                        <?php }
                                        if ($_GET['ST'] == 'USER_SUCCESS') { ?>
                                            <div class="alert alert-success text-center" role="alert">
                                              Acceso correcto.
                                            </div>            
                                        <?php }
                                    } ?> 
                                    <div class="card-header">
                                        <div class="clearfix"></div>
                                            <strong class="card-title">Plan de Salidas al servicio - <span id="CONGREGACION"><?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></span></strong>
                                    </div>
                                    <div class="card-body">
                                        <?php 
                                            if ($row_Salidas == 0) { 
                                                $qry_Salidas_grupo = mysqli_query($conn, $sql_Salidas_grupo);
                                                $row_Salidas_grupo = mysqli_num_rows($qry_Salidas_grupo);
                                                if ($row_Salidas_grupo == 0) { ?>
                                                    <p>No hay plan de predicación asignado.</p>
                                                <?php } else { 
                                                    while ($rs_Salidas = mysqli_fetch_array($qry_Salidas_grupo, MYSQLI_ASSOC)) { ?>
                                                    <div class="body-plan">
                                                        <div id="foto" class="col-6 float-left">
                                                            <?php 
                                                                $salidas_foto = $rs_Salidas['USERS_FOTO'];
                                                                if ($salidas_foto == '') {
                                                                    $salidas_foto = 'unknown.png';
                                                                }
                                                             ?>    
                                                            <img src="images/USERS/<?php echo $salidas_foto; ?>" alt="<?php echo $rs_Salidas['USERS_NOMBRE'];?>">
                                                        </div>
                                                        <div class="datos col-6 float-left">
                                                            <p><b>Asignado por:</b> <?php echo $rs_Salidas['USERS_NOMBRE'];?></p>
                                                            <p><b>Grupo:</b> <?php echo $rs_Salidas['SALIDAS_USUARIO_GRUPO']; ?></p>
                                                            <p><b>Número de contacto:</b> 
                                                                <?php 
                                                                    $telefono = $rs_Salidas['USERS_TELEFONO'];
                                                                    if ($telefono == NULL) {
                                                                        $telefono = "Ninguno";
                                                                    }
                                                                    echo $telefono;
                                                                 ?>
                                                            </p>
                                                            <hr>
                                                            <h5 class="pb-2 display-5">Punto de Partida</h5>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SEGMENTO']; ?>:</b> <?php echo $rs_Salidas['SECCION_NOMBRE'];?></p>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SUBSEGMENTO']; ?>:</b> <?php echo $rs_Salidas['NUMERO_SECCION']; ?></p>
                                                            <hr>
                                                            
                                                            <h5 class="pb-2 display-5">Punto de Cierre</h5>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SEGMENTO']; ?>:</b>
                                                                <?php 
                                                                    $segmento_final = $rs_Salidas['SALIDAS_SEGMENTO_FIN'];
                                                                    $sql_segmentoFinal = "SELECT 
                                                                                            SECCION_NOMBRE 
                                                                                          FROM
                                                                                            TERRITORIOS_SALIDAS
                                                                                          INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = $segmento_final";
                                                                    $qry_segmentoFinal = mysqli_query($conn, $sql_segmentoFinal);
                                                                    $rs_segmentoFinal = mysqli_fetch_array($qry_segmentoFinal, MYSQLI_ASSOC);
                                                                    echo $rs_segmentoFinal['SECCION_NOMBRE'];
                                                                 ?>
                                                            </p>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SUBSEGMENTO']; ?>:</b>
                                                                <?php 
                                                                    $subsegmento_final = $rs_Salidas['SALIDAS_SUBSEGMENTO_FIN'];
                                                                    $sql_subsegmentoFinal = "SELECT 
                                                                                                NUMERO_SECCION 
                                                                                             FROM
                                                                                                TERRITORIOS_SALIDAS
                                                                                             INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = $subsegmento_final";
                                                                    $qry_subsegmentoFinal = mysqli_query($conn, $sql_subsegmentoFinal);
                                                                    $rs_subsegmentoFinal = mysqli_fetch_array($qry_subsegmentoFinal, MYSQLI_ASSOC);
                                                                    echo $rs_subsegmentoFinal['NUMERO_SECCION'];
                                                                 ?>
                                                            </p>
                                                            <hr>
                                                            <h5 class="pb-2 display-5">Comentarios sobre el territorio:</h5>
                                                            <p><?php 
                                                                $comentarios = $rs_Salidas['SALIDAS_COMENTARIO'];
                                                                if ($comentarios == NULL) {
                                                                    $comentarios = 'Ninguno';
                                                                }
                                                                echo $comentarios;
                                                            ?></p>
                                                            <hr>
                                                            <h5 class="pb-2 display-5">Fecha estimada de trabajo:</h5>
                                                            <p><b>Fecha de Inicio:</b>  
                                                                <?php 
                                                                    $fecha = $rs_Salidas['SALIDAS_FORIGEN'];
                                                                    $newFecha = convertDate($fecha);
                                                                    echo $newFecha;  
                                                                ?>
                                                            </p>
                                                            <p><b>Fecha Final:</b> 
                                                                <?php 
                                                                    $fecha = $rs_Salidas['SALIDAS_FFIN'];
                                                                    $fecha_actual = date("Y-m-d");
                                                                    $newFecha = convertDate($fecha);
                                                                    echo $newFecha;  
                                                                ?>
                                                            </p>
                                                            <p id="delay">
                                                                <?php
                                                                    if ($_SESSION['NIVEL'] == 1) {
                                                                        $mensaje = "Este plan de predicación debió de concluirse hace algunos días. Favor de notificar al capitán de servicio.";
                                                                    }else{
                                                                        $mensaje = "Este plan de predicación debió de concluirse hace algunos días. Favor de darlo por terminado.";
                                                                    }

                                                                    if ($fecha_actual > $fecha) { 
                                                                        echo $mensaje;    
                                                                    }
                                                                 ?>
                                                            </p>
                                                            <hr>
                                                            <?php 
                                                                if ($_SESSION['NIVEL'] != 1) { ?>
                                                                    <form action="data/edit/edit_plan.php" method="POST" id="finalizaSalida" enctype="multipart/form-data">
                                                                        <input type="hidden" value="1" name="closeSalida">
                                                                        <input type="hidden" value="<?php echo $rs_Salidas['SALIDAS_ID']; ?>" name="salida_id">
                                                                        <input type="hidden" value="<?php echo $_SESSION['USUARIO_ID']; ?>" id="SALIDAS_USUARIO_FIN" name="SALIDAS_USUARIO_FIN">
                                                                        <input type="submit" class="btn btn-primary" value="Dar por terminado" id="finalizar" name="finalizar">
                                                                    </form>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                <?php }
                                                    }
                                            } else { 
                                                while ($rs_Salidas = mysqli_fetch_array($qry_Salidas, MYSQLI_ASSOC)) { ?>
                                                    <div class="body-plan">
                                                        <div id="foto" class="col-6 float-left">
                                                            <?php 
                                                                $salidas_foto = $rs_Salidas['USERS_FOTO'];
                                                                if ($salidas_foto == '') {
                                                                    $salidas_foto = 'unknown.png';
                                                                }
                                                             ?>    
                                                            <img src="images/USERS/<?php echo $salidas_foto; ?>" alt="<?php echo $rs_Salidas['USERS_NOMBRE'];?>">
                                                        </div>
                                                        <div class="datos col-6 float-left">
                                                            <p><b>Asignado por:</b> <?php echo $rs_Salidas['USERS_NOMBRE'];?></p>
                                                            <p><b>Grupo:</b> <?php echo $rs_Salidas['SALIDAS_USUARIO_GRUPO']; ?></p>
                                                            <p><b>Número de contacto:</b> 
                                                                <?php 
                                                                    $telefono = $rs_Salidas['USERS_TELEFONO'];
                                                                    if ($telefono == NULL) {
                                                                        $telefono = "Ninguno";
                                                                    }
                                                                    echo $telefono;
                                                                 ?>
                                                            </p>
                                                            <hr>
                                                            <h5 class="pb-2 display-5">Punto de Partida</h5>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SEGMENTO']; ?>:</b> <?php echo $rs_Salidas['SECCION_NOMBRE'];?></p>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SUBSEGMENTO']; ?>:</b> <?php echo $rs_Salidas['NUMERO_SECCION']; ?></p>
                                                            <hr>
                                                            
                                                            <h5 class="pb-2 display-5">Punto de Cierre</h5>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SEGMENTO']; ?>:</b>
                                                                <?php 
                                                                    $segmento_final = $rs_Salidas['SALIDAS_SEGMENTO_FIN'];
                                                                    $sql_segmentoFinal = "SELECT 
                                                                                            SECCION_NOMBRE 
                                                                                          FROM
                                                                                            TERRITORIOS_SALIDAS
                                                                                          INNER JOIN TERRITORIOS_SECCION ON SECCION_ID = $segmento_final";
                                                                    $qry_segmentoFinal = mysqli_query($conn, $sql_segmentoFinal);
                                                                    $rs_segmentoFinal = mysqli_fetch_array($qry_segmentoFinal, MYSQLI_ASSOC);
                                                                    echo $rs_segmentoFinal['SECCION_NOMBRE'];
                                                                 ?>
                                                            </p>
                                                            <p><b><?php echo $rs_Salidas['CONGREGACION_SUBSEGMENTO']; ?>:</b>
                                                                <?php 
                                                                    $subsegmento_final = $rs_Salidas['SALIDAS_SUBSEGMENTO_FIN'];
                                                                    $sql_subsegmentoFinal = "SELECT 
                                                                                                NUMERO_SECCION 
                                                                                             FROM
                                                                                                TERRITORIOS_SALIDAS
                                                                                             INNER JOIN TERRITORIOS_NUMERO ON NUMERO_ID = $subsegmento_final";
                                                                    $qry_subsegmentoFinal = mysqli_query($conn, $sql_subsegmentoFinal);
                                                                    $rs_subsegmentoFinal = mysqli_fetch_array($qry_subsegmentoFinal, MYSQLI_ASSOC);
                                                                    echo $rs_subsegmentoFinal['NUMERO_SECCION'];
                                                                 ?>
                                                            </p>
                                                            <hr>
                                                            <h5 class="pb-2 display-5">Comentarios sobre el territorio:</h5>
                                                            <p><?php 
                                                                $comentarios = $rs_Salidas['SALIDAS_COMENTARIO'];
                                                                if ($comentarios == NULL) {
                                                                    $comentarios = 'Ninguno';
                                                                }
                                                                echo $comentarios;
                                                            ?></p>
                                                            <hr>
                                                            <h5 class="pb-2 display-5">Fecha estimada de trabajo:</h5>
                                                            <p><b>Fecha de Inicio:</b>  
                                                                <?php 
                                                                    $fecha = $rs_Salidas['SALIDAS_FORIGEN'];
                                                                    $newFecha = convertDate($fecha);
                                                                    echo $newFecha;  
                                                                ?>
                                                            </p>
                                                            <p><b>Fecha Final:</b> 
                                                                <?php 
                                                                    $fecha = $rs_Salidas['SALIDAS_FFIN'];
                                                                    $fecha_actual = date("Y-m-d");
                                                                    $newFecha = convertDate($fecha);
                                                                    echo $newFecha;  
                                                                ?>
                                                            </p>
                                                            <p id="delay">
                                                                <?php
                                                                    if ($_SESSION['NIVEL'] == 1) {
                                                                        $mensaje = "Este plan de predicación debió de concluirse hace algunos días. Favor de notificar al capitán de servicio.";
                                                                    }else{
                                                                        $mensaje = "Este plan de predicación debió de concluirse hace algunos días. Favor de darlo por terminado.";
                                                                    }

                                                                    if ($fecha_actual > $fecha) { 
                                                                        echo $mensaje;    
                                                                    }
                                                                 ?>
                                                            </p>
                                                            <hr>
                                                            <?php 
                                                                if ($_SESSION['NIVEL'] != 1) { ?>
                                                                    <form action="data/edit/edit_plan.php" method="POST" id="finalizaSalida" enctype="multipart/form-data">
                                                                        <input type="hidden" value="1" name="closeSalida">
                                                                        <input type="hidden" value="<?php echo $rs_Salidas['SALIDAS_ID']; ?>" name="salida_id">
                                                                        <input type="hidden" value="<?php echo $_SESSION['USUARIO_ID']; ?>" id="SALIDAS_USUARIO_FIN" name="SALIDAS_USUARIO_FIN">
                                                                        <input type="submit" class="btn btn-primary" value="Dar por terminado" id="finalizar" name="finalizar">
                                                                    </form>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                             <?php }
                                            } ?>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
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
    <?php 
        if (isset($_GET['ST'])){ ?>
            <script>showMessage();</script>
    <?php } ?>

    <?php 
        mysqli_close($conn);
     ?>
</body>
</html>
<!-- end document-->
