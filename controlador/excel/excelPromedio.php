<?php

include("../../modelo/MySQL.php");
$conexion = new MySQL();
$pdo = $conexion->conectar();
// Consulta preparada para evitar inyección de SQL
$sql = "SELECT COUNT(Id) AS cantidad FROM peliculas WHERE estado=1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$cantidadPeliculas = $res['cantidad'];

require './vendor/autoload.php'; // Incluye el autoload de Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crea una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator("andres")->setTitle("Reporte Cantidad Peliculas");
$spreadsheet->setActiveSheetIndex(0);
// Crea una hoja de trabajo
$sheet = $spreadsheet->getActiveSheet();
$styleArray = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '00000'], // Color de fuente rojo
    ],
    'fill' => [
        'fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00b96a'], // Color de fondo amarillo
    ],
];

$sheet->getStyle('C3')->applyFromArray($styleArray);
$sheet->getStyle('D3')->applyFromArray($styleArray);
$sheet->getStyle('E3')->applyFromArray($styleArray);
$sheet->getStyle('C4')->applyFromArray($styleArray);
$sheet->getStyle('D4')->applyFromArray($styleArray);
// Agrega datos a la hoja de trabajo
$i = 6;
$sheet->setCellValue('C3', 'Reporte Promedio de Peliculas');
$sheet->setCellValue('C4', 'Por Usuario');
$sql2 = "SELECT * FROM usuarios";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();

while ($res2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('C' . $i, $res2['user'] . " :");

    $sql3 = "SELECT COUNT(Id) AS cantidad FROM peliculas";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute();
    while ($res3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $resultado = 0;
        $cantUser = $res3['cantidad'];
        if ($cantidadPeliculas == 0 || $cantUser == 0) {
            $resultado = 0;
        } else {
            $resultado =  $cantUser / $cantidadPeliculas;
        }
        $sheet->setCellValue('D' . $i, $resultado);
    }
    $i = $i + 1;
}
// Crea un objeto Writer para guardar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reportePelicula.xlsx"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');


// Nombre del archivo Excel
$filename = 'reportePromedio2.xlsx';
