<?php
    include 'include/connection.php';
    $sql_populaCongregaciones = "SELECT * FROM TERRITORIOS_CONGREGACION";
    $qry_populaCongregaciones = mysqli_query($conn, $sql_populaCongregaciones);
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
    <title>Registro</title>

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
    <link rel="stylesheet" href="css/registration.css">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/mainCSS.css">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <?php 
                            if (isset($_GET['ST'])) {
                                if ($_GET['ST'] == 'DUPLICATED') { ?>
                                    <div class="alert alert-danger" role="alert">
                                      El usuario y correo ya se encuentran registrados.
                                    </div>
                          <?php }
                            }
                        ?>
                        <div class="login-logo">
                            <a href="register.php">
                                <img src="images/icon/finibus_logo.png" alt="Finibus - Control de territorios" id="mainLogo">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="data/insert/insert_registration.php" method="post" id="registration" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nombre completo</label>
                                    <input class="au-input au-input--full texto mandatorio" type="text" id="USERS_NOMBRE" name="USERS_NOMBRE" placeholder="Nombre completo">
                                    <div class="invalid" id="INVALID_USERS_NOMBRE">Es necesario ingresar su nombre completo</div>
                                </div>
                                <div class="form-group">
                                    <label>Congregación</label>
                                    <select id="USERS_CONGREGACION" class="form-control mandatorio" name="USERS_CONGREGACION">
                                        <?php 
                                            $rows_populaCongregaciones = mysqli_num_rows($qry_populaCongregaciones);
                                            if ($rows_populaCongregaciones == 0) { ?>
                                                <option value="0" selected>No hay congregaciones registradas</option>
                                            <?php } else{ ?>
                                                <option value="0" selected>Seleccione su congregación</option>
                                                <?php
                                                    while ($rs_populaCongregaciones = mysqli_fetch_array($qry_populaCongregaciones, MYSQLI_ASSOC)) { ?>
                                                          <option value="<?php echo $rs_populaCongregaciones['CONGREGACION_ID']; ?>"><?php echo $rs_populaCongregaciones['CONGREGACION_NOMBRE']; ?></option>
                                              <?php }
                                            } ?>
                                    </select>
                                    <div class="invalid" id="INVALID_USERS_CONGREGACION">Es necesario seleccionar su congregación</div>
                                </div>

                                <div class="form-group noCongregation">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <label for="checkbox1" class="form-check-label">
                                                <input type="checkbox" id="CHECK_ADD_CONGREGATION" name="CHECK_ADD_CONGREGATION" value="option1" class="form-check-input">Mi congregación no aparece listada
                                            </label>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="form-group" id="ADD_CONGREGACION">
                                    <label>Nombre de la congregación</label>
                                    <input class="au-input au-input--full texto" type="text" name="USERS_NUEVA_CONGREGACION" id="USERS_NUEVA_CONGREGACION" placeholder="Ingrese el nombre de la nueva congregación">
                                    <div class="invalid" id="INVALID_USERS_NUEVA_CONGREGACION">Es necesario ingresar su congregación</div>
                                </div>

                                <div class="form-group">
                                    <label>Grupo</label>
                                    <select id="USERS_GRUPO" class="form-control mandatorio" name="USERS_GRUPO">
                                        <option value="0">Seleccione su número de grupo</option>
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
                                    <div class="invalid" id="INVALID_USERS_GRUPO">Es necesario seleccionar su número de grupo</div>
                                </div>

                                <div class="form-group">
                                    <label>Privilegio de servicio</label>
                                    <select id="USERS_PRIVILEGIO" class="form-control mandatorio" name="USERS_PRIVILEGIO">
                                        <option value="0" selected>Seleccione su privilegio de servicio</option>
                                        <option value="1">Publicador</option>
                                        <option value="2">Precursor Auxiliar</option>
                                        <option value="3">Precursor Regular</option>
                                    </select>
                                    <div class="invalid" id="INVALID_USERS_PRIVILEGIO">Es necesario seleccionar su privilegio de servicio</div>
                                </div>

                                <div class="form-group">
                                    <label>Número celular (opcional)</label>
                                    <input class="au-input au-input--full numerico " type="tel" name="USERS_TELEFONO" placeholder="Ingrese el número celular" id="USERS_TELEFONO">
                                    <div class="invalid" id="INVALID_USERS_TELEFONO">Es necesario ingresar un teléfono válido a 10 dígito</div>
                                </div>

                                <div class="form-group">
                                    <label>Correo electrónico (opcional)</label>
                                    <input class="au-input au-input--full minuscula" type="email" name="USERS_CORREO" placeholder="Ingrese el correo electrónico" id="USERS_CORREO">
                                    <div class="invalid" id="INVALID_USERS_CORREO">Es necesario ingresar un correo electrónico válido</div>
                                </div>
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input class="au-input au-input--full mandatorio" type="text" name="USERS_USUARIO" placeholder="Ingrese un usuario" id="USERS_USUARIO">
                                    <div class="invalid" id="INVALID_USERS_USUARIO">Es necesario ingresar su usuario</div>
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input class="au-input au-input--full mandatorio" type="password" name="USERS_CONTRASENA" placeholder="Ingrese una contraseña" id="USERS_CONTRASENA">
                                    <div class="invalid" id="INVALID_USERS_CONTRASENA">Es necesario ingresar su contraseña</div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-sm-12">
                                        <label for="USERS_FOTO" class=" form-control-label">Foto de perfil</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="USERS_FOTO" name="USERS_FOTO" class="form-control-file">
                                    </div>
                                </div>
                                <button class="au-btn au-btn--block au-btn--blue m-b-20" type="submit">Registrarse</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    ¿Ya tiene una cuenta?
                                    <a href="index.php" id="loginForm">Accesar al sistema</a>
                                </p>
                            </div>
                        </div>
                    </div>
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
    <script src="js/functions.js"></script>
    <script src="js/registration.js"></script>
    <?php 
        if (isset($_GET['ST'])){ ?>
            <script>showMessage();</script>
  <?php } ?>    
</body>

</html>
<!-- end document-->