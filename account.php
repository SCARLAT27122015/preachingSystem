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
                           USERS_NOMBRE,
                           USERS_FOTO,
                           USERS_GRUPO,
                           USERS_TELEFONO,
                           USERS_CORREO,
                           USERS_USUARIO
                      FROM TERRITORIOS_USERS
                INNER JOIN TERRITORIOS_CONGREGACION 
                        ON CONGREGACION_ID = USERS_CONGREGACION
                     WHERE USERS_ID = '". $_SESSION['USUARIO_ID'] ."'";
    $qryGetData = mysqli_query($conn, $sql_getData);
    $rs_getData = mysqli_fetch_array($qryGetData, MYSQLI_ASSOC);

    
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
    <link rel="stylesheet" href="css/mainCSS.css">
    <link rel="stylesheet" href="css/CSSAccount.css">
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
                                    <div class="card-header">
                                        <strong class="card-title">Información sobre mi cuenta</strong>
                                    </div>
                                    <?php 
                                        if(isset($_GET['ST'])){
                                            if ($_GET['ST'] == 'DUPLICATED') { ?>
                                                <div class="alert alert-warning text-center">
                                                  El usuario ya existe.
                                                </div>
                                            <?php } elseif ($_GET['ST'] == 'EDITED') { ?>
                                                <div class="alert alert-success text-center" id="planBorrado">
                                                    La cuenta ha sido editada exitosamente.
                                                </div>
                                            <?php }
                                        }
                                     ?>
                                    <div class="card-body">
                                        <div class="col-4 float-left text-center" id="foto">
                                            <?php 
                                                $imagen = $rs_getData['USERS_FOTO'];
                                                if ($imagen == NULL) {
                                                    $imagen = 'unknown.png';
                                                }
                                             ?>
                                            <img src="images/USERS/<?php echo $imagen; ?>" alt="<?php echo $rs_getData['USERS_NOMBRE']; ?>">
                                        </div>
                                        <div class="col-8 float-right text-left">
                                            <div class="col-12 data">
                                                <p><b>Nombre: </b><span id="USERS_NOMBRE"><?php echo $rs_getData['USERS_NOMBRE']; ?></span></p>
                                            </div>
                                            <div class="col-12 data">
                                                <p><b>Grupo: </b><span id="USERS_GRUPO"><?php echo $rs_getData['USERS_GRUPO']; ?></span></p>
                                            </div>
                                            <div class="col-12 data">
                                                <p>
                                                    <b>
                                                        Teléfono: 
                                                    </b>
                                                    <span id="USERS_TELEFONO">
                                                        <?php
                                                            $telefono = $rs_getData['USERS_TELEFONO'];
                                                            if (empty($telefono)) {
                                                                 $telefono = 'No registrado';
                                                            }

                                                            echo $telefono; 
                                                        ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-12 data">
                                                <p>
                                                    <b>
                                                        Correo electrónico: 
                                                    </b>
                                                    <span id="USERS_CORREO">
                                                        <?php 
                                                            $correo = $rs_getData['USERS_CORREO'];
                                                            if (empty($correo)) {
                                                                $correo = 'No registrado';
                                                            }

                                                            echo $correo;
                                                         ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-12 data">
                                                <p><b>Usuario: </b><span id="USERS_USUARIO"><?php echo $rs_getData['USERS_USUARIO']; ?></span></p>
                                            </div>
                                            <div class="col-12 data">
                                                <p>
                                                    <b>Nivel: </b>
                                                    <span id="USERS_NIVEL">
                                                        <?php 
                                                            $nivel = $rs_getData['USERS_USUARIO'];
                                                            if ($nivel == 1) {
                                                                $nivel = 'General';
                                                            }elseif ($nivel == 2) {
                                                                $nivel = 'Capitán';
                                                            }else{
                                                                $nivel = 'Administrador';
                                                            }

                                                            echo $nivel;
                                                         ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-12 data">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#ediciondeUsuarios" id="editingwholeaccount">Editar mi cuenta</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        
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
    
    <div class="modal fade" id="ediciondeUsuarios" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Modificar mi cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="data/edit/edit_user.php" method="post" id="levelEdition" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="" alt="" id="usersPhoto">
                            </div>
                           
                            <ul class="list-group-flush col-sm-6" id="listaPerfil">
                              <li class="list-group-item">
                                <div class="form-group">
                                    <label for="EDIT_USERS_NOMBRE"><b>Nombre</b></label>
                                    <input type="text" class="form-control" placeholder="Ingrese su nombre completo" id="EDIT_USERS_NOMBRE" name="EDIT_USERS_NOMBRE">  
                                </div>
                                <div class="invalid" id="#INVALID_EDIT_USERS_NOMBRE">Debe ingresar su nombre completo</div>
                              </li>
                              <li class="list-group-item">
                                <div class="form-group">
                                    <label for="EDIT_USERS_GRUPO"><b>Grupo</b></label>
                                    <select name="EDIT_USERS_GRUPO" id="EDIT_USERS_GRUPO" class="form-control">
                                        <option value="0">Seleccione su grupo</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <div class="invalid" id="#INVALID_EDIT_USERS_GRUPO">Debe ingresar su número de grupo</div>  
                                </div>
                              </li>
                              <li class="list-group-item">
                                <div class="form-group">
                                    <label for="EDIT_USERS_PRIVILEGIO"><b>Privilegio</b></label>
                                    <select id="EDIT_USERS_PRIVILEGIO" class="form-control mandatorio" name="EDIT_USERS_PRIVILEGIO">
                                        <option value="0" selected="">Seleccione su privilegio de servicio</option>
                                        <option value="1">Publicador</option>
                                        <option value="2">Precursor Auxiliar</option>
                                        <option value="3">Precursor Regular</option>
                                    </select>  
                                </div>
                              </li>
                              <li class="list-group-item">
                                <div class="form-group">
                                    <label for="EDIT_USERS_TELEFONO"><b>Teléfono</b></label>
                                    <input type="tel" name="EDIT_USERS_TELEFONO" id="EDIT_USERS_TELEFONO" class="form-control" placeholder="Ingrese su número telefónico">
                                    <div class="invalid" id="#INVALID_EDIT_USERS_TELEFONO">Debe ingresar su número telefónico a 10 dígitos</div>  
                                </div>
                              </li>
                              <li class="list-group-item">
                                <div class="form-group">
                                    <label for="EDIT_USERS_CORREO"><b>Correo electrónico</b></label>
                                    <input type="email" name="EDIT_USERS_CORREO" id="EDIT_USERS_CORREO" class="form-control" placeholder="Ingrese su correo electrónico">
                                    <div class="invalid" id="#INVALID_EDIT_USERS_CORREO">Debe ingresar un correo electrónico válido</div>  
                                </div>
                              </li>

                              <li class="list-group-item">
                                <div class="form-group">
                                    <label for="EDIT_USERS_USUARIO"><b>Usuario</b></label>
                                    <input type="text" name="EDIT_USERS_USUARIO" id="EDIT_USERS_USUARIO" class="form-control" placeholder="Ingrese su usuario">
                                    <div class="invalid" id="#INVALID_EDIT_USERS_USUARIO">Debe ingresar su nombre de usuario</div>  
                                </div>
                              </li>

                              <li class="list-group-item">
                                    <div class="form-group">
                                        <label for="EDIT_USERS_FOTO" class=" form-control-label">Foto de perfil</label>
                                        <input type="file" id="EDIT_USERS_FOTO" name="EDIT_USERS_FOTO" class="form-control-file">
                                    </div>
                              </li>
                                <li class="list-group-item">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="password_edit">Modificar contraseña</button>
                                    </div>
                                </li>
                                <li class="list-group-item contrasena">
                                    <div class="form-group">
                                        <label for="EDIT_USERS_CONTRASENA"><b>Contraseña</b></label>
                                        <input type="password" name="EDIT_USERS_CONTRASENA" id="EDIT_USERS_CONTRASENA" class="form-control" placeholder="Ingrese su contraseña actual">  
                                    </div>
                                </li>
                                <li class="list-group-item contrasena">
                                    <div class="form-group">
                                        <label for="EDIT_USERS_NEW_CONTRASENA"><b>Contraseña</b></label>
                                        <input type="password" name="EDIT_USERS_NEW_CONTRASENA" id="EDIT_USERS_NEW_CONTRASENA" class="form-control" placeholder="Ingrese su nueva contraseña">  
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <input type="hidden" value="<?php echo $_SESSION['USUARIO_ID']; ?>" name="EDIT_USER_ID" id="EDIT_USER_ID">
                        <input type="hidden" value="1" name="editmyUser">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Modificar cuenta</button>
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
    <script src="js/JSaccount.js"></script>
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
