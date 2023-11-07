<?php
session_start();

if ($_SESSION['session'] == true) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=peliculapdo", "root", "");
    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
    $idUser = $_SESSION['idUsuario'];
    include("../modelo/MySQL.php");
    $conexion = new MySQL();
    $pdo = $conexion->conectar();
    // Consulta preparada para evitar inyección de SQL
    $sql = "SELECT id,nombre,descripcion,estado,fecha FROM peliculas WHERE estado=1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //hago las consultas del log 
    $url = $_SERVER['REQUEST_URI'];
    $tiempo = date('Y-m-d');

    $logger = "INSERT INTO logger (url,tiempo,IdUsuario) VALUES (:url, :tiempo, :idUser)";
    $stmt = $pdo->prepare($logger);
    $stmt->bindParam(':url', $url, PDO::PARAM_STR);
    $stmt->bindParam(':tiempo', $tiempo, PDO::PARAM_INT);
    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $stmt->execute();
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
                        <h1><img src="../assets/images/pelicula icono.png" alt="" srcset=""></h1>
                    </a>
                    <a class="navbar-brand hidden" href="./peliculas.php"><img src="../assets/images/pelicula icono.png" alt="" srcset=""></a>
                </div>

                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <h3 class="menu-title">PELICULAS</h3><!-- /.menu-title -->
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-film"></i>Peliculas</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-film"></i><a href="./peliculas.php">Administrar Peliculas</a>
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
                                <img class="user-avatar rounded-circle" src="./assets/images/UsersinFondo.png" alt="Mi perfil">
                            </a>

                            <div class="user-menu dropdown-menu">


                                <a class="nav-link" href="../controlador/cerrar.php"><i class="fa fa-power-off"></i> Salir </a>
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
                        Swal.fire(
                            titulo,
                            msj,
                            'success'
                        )
                    </script>
                <?php
                    unset($_SESSION['mensaje']);
                }
                ?>
                <h1 style="text-align:center; font-size: 500%; font-weight: bold;">Peliculas</h1>
                <div class="container-fluid">
                    <div class="row">

                        <?php
                        foreach ($fila as $datos) {
                        ?>
                            <div class="col-3">
                                <div class="card text-bg-dark border-dark text-center rounded-3" style="width: 18rem;">
                                    <img src="https://i.pinimg.com/1200x/34/0c/a8/340ca86e649dc419441b6b43cf811eb1.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $datos['nombre']; ?></h5>
                                        <p class="card-text"><?php echo $datos['descripcion']; ?></p>
                                        <p class="card-text"><?php echo $datos['fecha']; ?></p>

                                    </div>
                                    <div class="card-footer text-bg-dark mt-0">
                                        <a href="../controlador/eliminarPelicula.php?id=<?php echo $datos['id'] ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                        <a href="../vista/editarPeliculas.php?id=<?php echo $datos['id'] ?>" class="btn btn-success"><i class="fa  fa-pencil"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
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