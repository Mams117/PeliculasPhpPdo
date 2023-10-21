<?php
session_start();
// Se hace el llamado del modelo de conexión y consultas
if (isset($_POST['nombrePelicula']) && !empty($_POST['nombrePelicula']) && isset($_POST['descripcionPelicula']) && !empty($_POST['descripcionPelicula'])) {
    $nombrePelicula = $_POST['nombrePelicula'];
    $descripcionPeliculas = $_POST['descripcionPelicula'];
    $edadPelicula = $_POST['edadPelicula'];
    $fecha = date('Y-m-d');
    $idUser = $_POST['idUsuario'];
    // Se instancia la clase PDO para la conexión a la base de datos
    //$sql2 = new MySQL();
    //$pdo = $sql2->conectar();
    // Se instancia la clase PDO para la conexión a la base de datos
    include("../modelo/MySQL.php");
    $conexion = new MySQL();
    $pdo = $conexion->conectar();
    $sql2 = "SELECT * FROM peliculas WHERE nombre=:nombrePeli AND estado=1";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':nombrePeli', $nombrePelicula, PDO::PARAM_STR);
    $stmt2->execute();
    if ($stmt2->rowCount() > 0) {
        $_SESSION['mensaje'] = "Ya existe una Pelicula igual en la Base de Datos";
        $_SESSION['mensajeTitu'] = "Error al Agregar";
        header("Location:../vista/agregarPeliculas.php");
    } else {
        // Consulta preparada para evitar inyección de SQL
        $sql = "INSERT INTO peliculas (nombre,descripcion,fecha,idUsuario,edad,audiencia) VALUES(:nombrePeli,:descripcionPeli,:fecha,:idUsuario,:edadPelicula,:audiencia)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombrePeli', $nombrePelicula, PDO::PARAM_STR);
        $stmt->bindParam(':descripcionPeli', $descripcionPeliculas, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUser, PDO::PARAM_STR);
        $stmt->bindParam(':edadPelicula', $edadPelicula, PDO::PARAM_STR);
        $stmt->bindParam(':audiencia', $audiencia, PDO::PARAM_STR);

        

        $stmt->execute();
        $_SESSION['mensaje'] = "La Pelicula Fue Agregada Correctamente";
        $_SESSION['mensajeTitu'] = "Pelicula Agregada";
        header("Location:../vista/peliculas.php");
    }
} else {
    $_SESSION['mensaje'] = "No deje Campos Vacios";
    $_SESSION['mensajeTitu'] = "Error al Agregar";
    header("Location:../vista/agregarPeliculas.php");
}
//require_once '../modelo/MySQL.php';
