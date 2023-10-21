<?php
require './vendor/autoload.php';
require '../../modelo/MySQL.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Iniciar la sesión
session_start();
$id = $_POST['idUsuario'];


// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

//CONECTO A LA BASE DE DATOS
try {
    // Create a PDO connection to the database.
    $pdo = new PDO("mysql:host=localhost;dbname=peliculapdo", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $idUsuario = $_SESSION["idUsuario"];

    $consulta = $pdo->prepare("SELECT DISTINCT usuarios.idUsuario, usuarios.user,peliculas.id AS id, peliculas.nombre AS nombre, peliculas.descripcion AS descripcion, peliculas.estado AS estado, peliculas.fecha AS fecha
    FROM usuarios
    INNER JOIN peliculas ON peliculas.idUsuario = usuarios.idUsuario 
    WHERE usuarios.idUsuario=:id");
    $consulta->bindParam(':id', $id, PDO::PARAM_INT);

    $consulta->execute();
    $rowNumber = 2; // Empezamos en la segunda fila (después de los encabezados)
    if ($consulta->rowCount() > 0) {
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
            // Agregar datos a la hoja de cálculo
            $activeWorksheet->setCellValue('A' . $rowNumber, $row['idUsuario']);
            $activeWorksheet->setCellValue('B' . $rowNumber, $row['nombre']);
            // $activeWorksheet->setCellValue('C' . $rowNumber, $row['peliculas']);
            $activeWorksheet->setCellValue('D' . $rowNumber, $row['descripcion']);
            $activeWorksheet->setCellValue('E' . $rowNumber, $row['estado']);
            $activeWorksheet->setCellValue('F' . $rowNumber, $row['fecha']);
            $rowNumber++;
        }
    }

    // Definir encabezados
    $activeWorksheet->setCellValue('A1', 'ID');
    $activeWorksheet->setCellValue('B1', 'nombre');
    // $activeWorksheet->setCellValue('C1', 'peliculas');
    $activeWorksheet->setCellValue('D1', 'descripcion');
    $activeWorksheet->setCellValue('E1', 'estado');
    $activeWorksheet->setCellValue('F1', 'fecha');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reportePelicula.xlsx"');
    header('Cache-Control: max-age=0');

    // Guardar el archivo Excel en la salida
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
} catch (PDOException $e) {
    // Handle errors in case of an exception.
    echo "Error: " . $e->getMessage();
}
