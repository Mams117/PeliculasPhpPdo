<?php
session_start();
$id = $_GET['id'];
include("../modelo/MySQL.php");
$conexion = new MySQL();
$pdo = $conexion->conectar();
// Consulta preparada para evitar inyección de SQL
$sql = "UPDATE peliculas SET estado=0 WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$_SESSION['mensaje'] = "La Pelicula Fue Eliminada Correctamente";
$_SESSION['mensajeTitu'] = "Pelicula Eliminada";
header("Location:../vista/peliculas.php");
