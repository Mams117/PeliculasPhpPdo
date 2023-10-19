<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Pelisoft</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->

    <link rel="icon" type="image/png" href="../assets/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <!--===============================================================================================-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <?php
            if (isset($_SESSION['mensajeErr'])) {
            ?>
                <script>
                    let msj = '<?php echo $_SESSION['mensajeErr'] ?>'
                    let titulo = '<?php echo $_SESSION['mensaje2Err'] ?>'
                    Swal.fire({
                        icon: 'error',
                        title: titulo,
                        text: msj
                    })
                </script>
            <?php
                unset($_SESSION['mensajeErr']);
                unset($_SESSION['mensaje2Err']);
            }
            ?>
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post" action="../controlador/registrar.php">
                    <span class="login100-form-title p-b-26">
                        Registrarse
                    </span>
                    <span class="login100-form-title p-b-48">
                        <img src="../assets/images/logo.png" alt="" srcset="" width="170" height="170">
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Ingrese un usuario valido">
                        <input class="input100" type="text" name="user">
                        <span class="focus-input100" data-placeholder="Usuario"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Ingrese una contraseña">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="pass">
                        <span class="focus-input100" data-placeholder="Contraseña"></span>
                    </div>
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Registrarse
                            </button>
                        </div>
                    </div>
                    <div class="text-center p-t-115">
                        <span class="txt1">
                            ¿Ya tienes cuenta?
                        </span>

                        <a class="txt2" href="../index.php">
                            Ingresa
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../assets/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="../assets/vendor/bootstrap/js/popper.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../assets/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="../assets/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="../assets/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="../assets/js/main.js"></script>

</body>

</html>