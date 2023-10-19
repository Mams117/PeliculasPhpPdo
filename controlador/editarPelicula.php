<?php
session_start();
$idPeli = $_POST['id'];
// Se hace el llamado del modelo de conexión y consultas
if (isset($_POST['nombrePelicula']) && !empty($_POST['nombrePelicula']) && isset($_POST['descripcionPelicula']) && !empty($_POST['nombrePelicula'])) {
    $nombrePelicula = $_POST['nombrePelicula'];
    $descripcionPeliculas = $_POST['descripcionPelicula'];
    // Se instancia la clase PDO para la conexión a la base de datos
    //$sql2 = new MySQL();
    //$pdo = $sql2->conectar();
    // Se instancia la clase PDO para la conexión a la base de datos
    include("../modelo/MySQL.php");
    $conexion = new MySQL();
    $pdo = $conexion->conectar();
        // Consulta preparada para evitar inyección de SQL
        $sql = "UPDATE peliculas SET nombre=:nombrePeli, descripcion=:descripcionPeli WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombrePeli', $nombrePelicula, PDO::PARAM_STR);
        $stmt->bindParam(':descripcionPeli', $descripcionPeliculas, PDO::PARAM_STR);
        $stmt->bindParam(':id', $idPeli, PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION['mensaje'] = "La Pelicula Fue Editada Correctamente";
        $_SESSION['mensajeTitu'] = "Pelicula Editada";
        header("Location:../vista/peliculas.php");
} else {
    $_SESSION['mensaje'] = "No deje Campos Vacios";
    $_SESSION['mensajeTitu'] = "Error al Editar";
    header("Location:../vista/editarPeliculas.php?id=" . $idPeli);
}
//require_once '../modelo/MySQL.php';
