<?php
session_start();
if ($_SESSION['session'] == true) {
    $idPeli = $_GET['id'];
    include("../modelo/MySQL.php");
    $conexion = new MySQL();
    $pdo = $conexion->conectar();
    // Consulta preparada para evitar inyección de SQL
    $sql = "SELECT * FROM peliculas WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $idPeli, PDO::PARAM_STR);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombrePelicula = $fila['nombre'];
    $descripcionPelicula = $fila['descripcion'];
?>

    <!doctype html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
    <!--[if gt IE 8]><!-->
    <html class="no-js" lang="en">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ADMIN PELISOFT</title>
        <meta name="description" content="Sufee Admin - HTML5 Admin Template">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-icon.png">
        <link rel="shortcut icon" href="favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/vendors/themify-icons/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="../assets/vendors/selectFX/css/cs-skin-elastic.css">
        <link rel="stylesheet" href="../assets/vendors/jqvmap/dist/jquery.vmap.min.js">


        <link rel="stylesheet" href="../assets/css2/style.css">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>


        <!-- Left Panel -->

        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default">

                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand">
                        <h1><i class="fa fa-ticket"></i></h1>
                    </a>
                    <a class="navbar-brand hidden" href="./peliculas.php"><i class="fa fa-ticket"></i></a>
                </div>

                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <h3 class="menu-title">PELICULAS</h3><!-- /.menu-title -->
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-film"></i>Peliculas</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-film"></i><a href="../vista/peliculas.php">Administrar Peliculas</a>
                                </li>
                                <li><i class="fa fa-video-camera"></i><a href="./agregarPeliculas.php">Agregar Peliculas</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Reportes</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-bar-chart"></i><a href="./reportes.php">Ver Reportes</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </aside><!-- /#left-panel -->

        <!-- Left Panel -->

        <!-- Right Panel -->

        <div id="right-panel" class="right-panel">

            <!-- Header-->
            <header id="header" class="header">

                <div class="header-menu">

                    <div class="col-sm-7">
                        <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                        <div class="header-left">
                            <button class="search-trigger"><i class="fa fa-search"></i></button>
                            <div class="form-inline">
                                <form class="search-form">
                                    <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                    <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="user-area dropdown float-right">
                            <label for="" style="margin-top: 9.5px; margin-right: 10px; font-weight:bold; ">
                            </label>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="user-avatar rounded-circle" src="./assets/images/UsersinFondo.png" alt="User Avatar">
                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i class="fa fa-user"></i> Mi Perfil</a>
                                <a class="nav-link" href="../controlador/cerrar.php"><i class="fa fa-power-off"></i> Salir
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </header>
            <!-- Header-->

            <div class="content mt-3">
                <?php
                if (isset($_SESSION['mensaje'])) {
                ?>
                    <script>
                        let msj = '<?php echo $_SESSION['mensaje'] ?>'
                        let titulo = '<?php echo $_SESSION['mensajeTitu'] ?>'
                        Swal.fire({
                            icon: 'error',
                            title: titulo,
                            text: msj,
                        })
                    </script>
                <?php
                    unset($_SESSION['mensaje']);
                }
                ?>
                <h1 style="text-align:center; font-size: 500%; font-weight: bold;">Editar Peliculas</h1>
                <div class="col-2"></div>
                <div class="col-8 mt-5">
                    <form method="post" action="../controlador/editarPelicula.php">
                        <input type="hidden" class="form-control" id="id" name="id" aria-describedby="emailHelp" value="<?php echo $idPeli ?>">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre de la Pelicula</label>
                            <input type="text" class="form-control" id="nombrePelicula" name="nombrePelicula" aria-describedby="emailHelp" value="<?php echo $nombrePelicula ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Descripcion de la Pelicula</label>
                            <textarea class="form-control" placeholder="" id="floatingTextarea2" style="height: 100px" name="descripcionPelicula"> <?php echo $descripcionPelicula ?> </textarea>
                        </div>
                        <h1 style="text-align: center;"><button type="submit" class="btn btn-primary">Agregar</button></h1>
                        <br>
                        <br>
                    </form>
                </div>
                <div class="col-2"></div>


            </div>
        </div>

        <!-- Right Panel -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="../assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="../assets/vendors/popper.js/dist/umd/popper.min.js"></script>
        <script src="../assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../assets/js2/main.js"></script>


        <script src="../assets/vendors/chart.js/dist/Chart.bundle.min.js"></script>
        <script src="../assets/js2/dashboard.js"></script>
        <script src="../assets/js2/widgets.js"></script>
        <script src="../assets/vendors/jqvmap/dist/jquery.vmap.min.js"></script>
        <script src="../assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <script src="../assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script>
            (function($) {
                "use strict";

                jQuery('#vmap').vectorMap({
                    map: 'world_en',
                    backgroundColor: null,
                    color: '#ffffff',
                    hoverOpacity: 0.7,
                    selectedColor: '#1de9b6',
                    enableZoom: true,
                    showTooltip: true,
                    values: sample_data,
                    scaleColors: ['#1de9b6', '#03a9f5'],
                    normalizeFunction: 'polynomial'
                });
            })(jQuery);
        </script>

    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>