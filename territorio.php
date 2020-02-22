<?php 
    session_start();
    if (!isset($_SESSION['USUARIO_ID'])) {
        header('location: index.php?ST=UNAUTHORIZED');
    }

    include 'include/connection.php';
    $sql_getData = "SELECT CONGREGACION_NOMBRE,
                           CONGREGACION_SEGMENTO,
                           CONGREGACION_SUBSEGMENTO,
                           USERS_FOTO 
                      FROM TERRITORIOS_USERS
                INNER JOIN TERRITORIOS_CONGREGACION 
                        ON CONGREGACION_ID = USERS_CONGREGACION
                     WHERE USERS_ID = '". $_SESSION['USUARIO_ID'] ."'";
    $qryGetData = mysqli_query($conn, $sql_getData);
    $rs_getData = mysqli_fetch_array($qryGetData, MYSQLI_ASSOC);

    $sql_Territorios = "SELECT * 
                           FROM TERRITORIOS_SECCION 
                          WHERE SECCION_CONGREGACION = '" .$_SESSION['USUARIO_CONGREGACION']. "'";
    $qry_Territorios = mysqli_query($conn, $sql_Territorios);
    $row_Territorios = mysqli_num_rows($qry_Territorios);

    $sql_Secciones = "SELECT * FROM TERRITORIOS_SECCION WHERE SECCION_CONGREGACION = '" .$_SESSION['USUARIO_CONGREGACION']. "'";
    $qry_Secciones = mysqli_query($conn, $sql_Secciones);
    $row_Secciones = mysqli_num_rows($qry_Secciones);

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
    <title>Territorio <?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></title>

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
    <link rel="stylesheet" href="css/CSSTerritorios.css">
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
                                            <img src="images/USERS/<?php echo $rs_getData['USERS_FOTO']; ?>" alt="<?php echo $_SESSION['USUARIO_NOMBRE']; ?>" />
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
                                                        <img src="images/USERS/<?php echo $rs_getData['USERS_FOTO']; ?>" alt="<?php echo $_SESSION['USUARIO_NOMBRE']; ?>" />
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
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-settings"></i>Ajustes de mi cuenta</a>
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
                                    <strong class="card-title">Territorio congregación <span id="CONGREGACION"><?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></span></strong>
                                  </div>
                                    <div class="alert alert-success text-center" role="alert" id="division-success">
                                        La división de su territorio ha sido ingresada exitosamente.
                                    </div>
                                    <div class="alert alert-warning text-center" role="alert" id="territorioBorrado">
                                      El territorio se ha borrado exitosamente.
                                    </div> 
                                    <?php 
                                        if (isset($_GET['ST'])) {
                                            if ($_GET['ST'] == 'SUCCESS') { ?>
                                                <div class="alert alert-success text-center" role="alert">
                                                  El territorio se ha añadido exitosamente.
                                                </div>            
                                            <?php } elseif ($_GET['ST'] == 'EDITED') { ?>
                                                <div class="alert alert-success text-center" role="alert">
                                                  El territorio se ha editado exitosamente.
                                                </div> 
                                            <?php }
                                        } ?> 
                                    
                                    
                                  <div class="card-body">
                                    <div class="col-md-12">
                                        <h3 class="title-4 m-b-35">Distribución del territorio</h3>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#listaTerritorios" id="addTerritorio">Agregar Territorio</button>
                                        <?php 
                                            if ($row_Secciones != 0 ) { ?>
                                                <div class="form-group col-sm-12">
                                                    <input type="text" class="form-control au-input au-input--xl" placeholder="Buscar territorio" id="buscarTerritorio">
                                                </div>
                                        <?php } ?>
                                        <!-- DATA TABLE -->
                                            <div class="table-responsive table-responsive-data2 col-md-12" id="insercionRegistros"></div>
                                        <!-- END DATA TABLE -->
                                    </div>
                                    <?php      
                                        if ($rs_getData['CONGREGACION_SEGMENTO'] == NULL) { ?>
                                                </br><hr>
                                                <div class="col-md-12" id="segmentacionPrimeraVez">
                                                    <h4 class="title-8 m-b-35">Configuración inicial de distribución de territorios</h4>
                                            
                                                    <p>Parece que es la primera vez que ingresa al sistema. Por favor ingrese la forma en que el territorio se encuentra dividido y subdividido:</p></br>
                                                    <div class="row">
                                                        <div class="form-group col-sm-12 col-lg-6">
                                                            <label>División</label>
                                                            <input class="au-input au-input--full texto" type="text" name="CONGREGACION_SEGMENTO" id="CONGREGACION_SEGMENTO" placeholder="Ingrese la división de su territorio">
                                                            <div class="invalid" id="INVALID_CONGREGACION_SEGMENTO">Es necesario ingresar la división del territorio</div>
                                                        </div>

                                                        <div class="form-group col-sm-12 col-lg-6">
                                                            <label>SubDivisión</label>
                                                            <input class="au-input au-input--full texto" type="text" name="CONGREGACION_SUBSEGMENTO" id="CONGREGACION_SUBSEGMENTO" placeholder="Ingrese la subdivisión de su territorio">
                                                            <div class="invalid" id="INVALID_CONGREGACION_SUBSEGMENTO">Es necesario ingresar la subdivisión del territorio</div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <button class="btn btn-primary col-md-4 d-md-inline" type="submit" id="ingresar_division">Ingresar división</button>
                                                    </div>    
                                                </div>    
                                                
                                  <?php } else { ?>
                                                <div class="col-md-12" id="segmentacionEdicion">
                                                    </br>
                                                    <p>¿Deseas modificar tu división y subdivisión de territorios? Da click <button class="btn-link" id="displayerSegments">Aquí</button>.</p></br>
                                                    <div class="segmentos">
                                                        <form action="data/edit/edit_segmentos.php" method="post" enctype="multipart/form-data" id="editandoSegmentosFormulario">
                                                            <div class="form-group float-lg-left col-lg-6">
                                                                <label>División</label>
                                                                <input class="au-input au-input--full texto" type="text" name="EDITAR_CONGREGACION_SEGMENTO" id="EDITAR_CONGREGACION_SEGMENTO" placeholder="Ingrese la división de su territorio">
                                                                <div class="invalid" id="INVALID_EDITAR_CONGREGACION_SEGMENTO">Es necesario ingresar la división del territorio</div>
                                                            </div>

                                                            <div class="form-group float-lg-right col-lg-6">
                                                                <label>SubDivisión</label>
                                                                <input class="au-input au-input--full texto" type="text" name="EDITAR_CONGREGACION_SUBSEGMENTO" id="EDITAR_CONGREGACION_SUBSEGMENTO" placeholder="Ingrese la subdivisión de su territorio">
                                                                <div class="invalid" id="INVALID_EDITAR_CONGREGACION_SUBSEGMENTO">Es necesario ingresar la subdivisión del territorio</div>
                                                            </div>
                                                            <input type="hidden" name="EDITAR_CONG" id="EDITAR_CONG">
                                                            <button class="btn btn-primary segmentos" type="submit" id="modificar-division">Modificar división</button>
                                                        </form>
                                                    </div>
                                                    <div class="clearfix"></div>    
                                                </div>
                                  <?php } ?>  
                                                </br></br><hr>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
            <!-- modal insertar Territorio -->
            <div class="modal fade" id="listaTerritorios" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Ingresar nuevo territorio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="agregarNuevoTerritorio" action="data/insert/insert_territorios.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></label>
                                            <select id="EXISTENTE_NUMERO_TERRITORIO" class="form-control mandatorio" name="EXISTENTE_NUMERO_TERRITORIO">
                                                <?php 
                                                    if ($row_Territorios == 0) { ?>
                                                        <option value="0">No hay <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> por mostrar</option>
                                                    <?php } else { ?>
                                                        <option value="0" selected>Seleccione <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></option>
                                                        <?php while ($rs_Territorios = mysqli_fetch_array($qry_Territorios, MYSQLI_ASSOC)) { ?>
                                                            <option value="<?php echo $rs_Territorios['SECCION_ID']; ?>"><?php echo $rs_Territorios['SECCION_NOMBRE']; ?></option>
                                                        <?php }         
                                                } ?>
                                            </select>
                                            <div class="invalid" id="INVALID_EXISTENTE_NUMERO_TERRITORIO">Es necesario seleccionar su <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6" id="nonExistentTerritorioDiv">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <label for="nonExistentTerritorio" class="form-check-label">
                                                        <input type="checkbox" id="nonExistentTerritorio" name="nonExistentTerritorio" value="option1" class="form-check-input">Mi <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?> no se encuentra en la lista.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="newTerrAdd">
                                        <div class="form-group">
                                            <label for="NUMERO_TERRITORIO" class="control-label mb-1"><span id="etiquetaDiv">Nuevo/a <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></span></label>
                                            <input id="NUMERO_TERRITORIO" name="NUMERO_TERRITORIO" type="text" class="form-control" placeholder="Ingrese el/la nuevo <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?>">
                                            <div class="invalid" id="INVALID_NUMERO_TERRITORIO">Este campo es mandatorio</div>
                                        </div>
                                    </div>        
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="NUMERO_SECCION" class="control-label mb-1"><span id="etiquetaSub"><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?></span></label>
                                            <input id="NUMERO_SECCION" name="NUMERO_SECCION" type="text" class="form-control" placeholder="Ingrese el/la <?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?>">
                                            <div class="invalid" id="INVALID_NUMERO_SECCION">Este campo es mandatorio</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="NUMERO_CALLES" class="control-label mb-1">Calles</label>
                                            <textarea name="NUMERO_CALLES" id="NUMERO_CALLES" rows="4" placeholder="Ingrese las calles del territorio a agregar" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="NUMERO_COMENTARIOS" class="control-label mb-1">Comentarios</label>
                                            <textarea name="NUMERO_COMENTARIOS" id="NUMERO_COMENTARIOS" rows="4" placeholder="Ingrese comentarios del territorio a agregar (por ejemplo: casas marcadas, zonas de negocios, etc" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" value="<?php echo $_SESSION['USUARIO_CONGREGACION']; ?>" name="NUMERO_CONGREGACION" id="NUMERO_CONGREGACION">    
                            <input type="hidden" value="1" name="insNewTerritorio">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar territorio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal insertar Territorio -->

            <!-- modal editar Territorio -->
            <div class="modal fade" id="ediciondeTerritorios" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Editar territorio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editarelTerritorio" action="data/edit/edit_territorios.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="EDIT_NUMERO_TERRITORIO" class="control-label mb-1"><span id="etiquetaDiv"><?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?></span></label>
                                            <input id="EDIT_NUMERO_TERRITORIO" name="EDIT_NUMERO_TERRITORIO" type="text" class="form-control" placeholder="Ingrese el/la <?php echo $rs_getData['CONGREGACION_SEGMENTO']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="EDIT_NUMERO_SECCION" class="control-label mb-1"><span id="etiquetaSub"><?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?></span></label>
                                            <input id="EDIT_NUMERO_SECCION" name="EDIT_NUMERO_SECCION" type="text" class="form-control" placeholder="Ingrese el/la <?php echo $rs_getData['CONGREGACION_SUBSEGMENTO']; ?>" disabled>
                                        </div>
                                    </div>        
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="EDIT_NUMERO_CALLES" class="control-label mb-1">Calles</label>
                                            <textarea name="EDIT_NUMERO_CALLES" id="EDIT_NUMERO_CALLES" rows="4" placeholder="Ingrese las calles del territorio a agregar" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="EDIT_NUMERO_COMENTARIOS" class="control-label mb-1">Comentarios</label>
                                            <textarea name="EDIT_NUMERO_COMENTARIOS" id="EDIT_NUMERO_COMENTARIOS" rows="4" placeholder="Ingrese comentarios del territorio a agregar (por ejemplo: casas marcadas, zonas de negocios, etc" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" value="" name="EDIT_NUMERO_ID" id="EDIT_NUMERO_ID">    
                            <input type="hidden" value="1" name="editNewTerritorio">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Editar territorio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal editar Territorio -->

            <!-- modal static -->
            <div class="modal fade" id="borraTerritorio" tabindex="-1" role="dialog" aria-labelledby="borraTerritorioLabel" aria-hidden="true"
             data-backdrop="static">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="borraTerritorioLabel">Borrar territorio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id2remove">
                            <p>
                                ¿Realmente deseas borrar el territorio de la lista?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="confirmacion_borrado">Borrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal static -->

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
    <script src="js/JSterritorio.js"></script>
    <?php if ($rs_getData['CONGREGACION_SEGMENTO'] != NULL){ ?><script>hideAddTerritorio();</script><?php } ?>
    <?php 
        if (isset($_GET['ST'])){ ?>
            <script>showMessage();</script>
    <?php } ?>
</body>

</html>
<!-- end document-->
