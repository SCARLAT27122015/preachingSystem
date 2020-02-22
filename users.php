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

    $sql_Usuarios = "SELECT * 
                           FROM TERRITORIOS_USERS 
                          WHERE USERS_CONGREGACION = '".$_SESSION['USUARIO_CONGREGACION']."'";
    $qry_Usuarios = mysqli_query($conn, $sql_Usuarios);
    $row_Usuarios = mysqli_num_rows($qry_Usuarios);
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
    <title>Usuarios <?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></title>

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
                                        <div class="clearfix"></div>
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
                                                    <a href="#">
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
                                    <strong class="card-title">Usuarios Congregación <span id="CONGREGACION"><?php echo $rs_getData['CONGREGACION_NOMBRE']; ?></span></strong>
                                    <input type="hidden" id="congregacionID" value="<?php echo $_SESSION['USUARIO_CONGREGACION'];?>">
                                  </div>
                                    
                                    <div class="alert alert-warning text-center" role="alert" id="usuarioBorrado">
                                      El usuario se ha borrado exitosamente.
                                    </div> 
                                    <?php 
                                        if (isset($_GET['ST'])) {
                                            if ($_GET['ST'] == 'LEVEL_EDITED') { ?>
                                                <div class="alert alert-success text-center" role="alert">
                                                  El usuario se ha editado exitosamente.
                                                </div>            
                                            <?php }
                                        } ?> 
                                    
                                    
                                  <div class="card-body">
                                    <div class="col-md-12">
                                        <h3 class="title-4 m-b-35">Lista de usuarios</h3>
                                        
                                        <?php 
                                            if ($row_Usuarios != 0 ) { ?>
                                                <div class="form-group col-sm-12">
                                                    <input type="text" class="form-control au-input au-input--xl buscador" placeholder="Buscar usuario" id="buscarUsuario">
                                                </div>
                                        <?php } ?>
                                        <!-- DATA TABLE -->
                                            <div class="table-responsive table-responsive-data2 col-md-12" id="insercionUsuarios"></div>
                                        <!-- END DATA TABLE -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
            <!-- modal editar nivel de Usuario -->
            <div class="modal fade" id="ediciondeUsuarios" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Modificar nivel de Usuario - <span class="nombreCompleto"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img src="images/USERS/territorioUser_1258778925.jpg" alt="" id="usersPhoto">
                                    </div>
                                   
                                    <ul class="list-group-flush col-sm-6" id="listaPerfil">
                                      <li class="list-group-item">
                                        <div class="form-group">
                                            <label for="usuarioNombre"><b>Nombre</b></label>
                                            <p id="usuarioNombre" class="nombreCompleto"></p>  
                                        </div>
                                      </li>
                                      <li class="list-group-item">
                                        <div class="form-group">
                                            <label for="usuarioGrupo"><b>Grupo</b></label>
                                            <p id="usuarioGrupo"></p>  
                                        </div>
                                      </li>
                                      <li class="list-group-item">
                                        <div class="form-group">
                                            <label for="usuarioPrivilegio"><b>Privilegio</b></label>
                                            <p id="usuarioPrivilegio"></p>  
                                        </div>
                                      </li>
                                      <li class="list-group-item">
                                        <div class="form-group">
                                            <label for="usuarioTelefono"><b>Teléfono</b></label>
                                            <p id="usuarioTelefono"></p>  
                                        </div>
                                      </li>
                                      <li class="list-group-item">
                                        <div class="form-group">
                                            <label for="usuarioCorreo"><b>Correo electrónico</b></label>
                                            <p id="usuarioCorreo"></p>  
                                        </div>
                                      </li>

                                      <li class="list-group-item">
                                          <div class="form-group">
                                                <label for="EDICION_USERS_NIVEL"><b style="color:  #0000ff";>Nivel de Usuario</b></label>
                                              <select id="EDICION_USERS_NIVEL" class="form-control mandatorio" name="EDICION_USERS_NIVEL">
                                                  <option value="0">Seleccione un nivel de usuario</option>
                                                  <option value="1">General</option>
                                                  <option value="2">Capitán</option>
                                                  <option value="3">Administrador</option>
                                              </select>
                                              <div class="invalid" id="INVALID_EDIT_USERS_NIVEL">Debe seleccionar un perfil</div>
                                          </div>
                                      </li>
                                    </ul> 
                                </div>
                            </div>
                        
                            <div class="modal-footer">
                                <form action="data/edit/edit_userLevel.php" method="post" id="levelEdition" enctype="multipart/form-data">
                                    <input type="hidden" value="" id="EDIT_USERS_NIVEL" name="EDIT_USERS_NIVEL">    
                                    <input type="hidden" value="" name="EDIT_NUMERO_ID" id="EDIT_NUMERO_ID">
                                    <input type="hidden" value="1" name="editUser">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Modificar nivel</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <!-- end modal insertar Territorio -->

            

            <!-- modal static -->
            <div class="modal fade" id="borraUsuario" tabindex="-1" role="dialog" aria-labelledby="borraUsuarioLabel" aria-hidden="true"
             data-backdrop="static">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="borraUsuarioLabel">Borrar Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id2remove">
                            <p>
                                ¿Realmente deseas borrar el usuario de la lista?
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

    <div class="modal fade bd-example-modal-lg show" id="imageModal" role="dialog">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="dynamic-content">
                    <img id="largeProfilePic" src="" class="img-fluid" alt=""/>
                </div>
                <div class="modal-footer" id="nombreProfile">
                        
                </div>
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
    <script src="js/JSusuario.js"></script>    
    
    <?php 
        if (isset($_GET['ST'])){ ?>
            <script>showMessage();</script>
    <?php } ?>
</body>

</html>
<!-- end document-->
