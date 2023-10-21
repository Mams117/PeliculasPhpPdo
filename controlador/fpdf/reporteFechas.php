<?php

require('./fpdf.php');

class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {
        //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

        //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
        //$dato_info = $consulta_info->fetch_object();

        $this->SetFont('Arial', 'B', 15); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(30); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); //color
        //creamos una celda o fila
        $this->Cell(110, 15, utf8_decode('Peliculas'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(10); // Salto de línea
        $this->SetTextColor(103); //color


        /* TITULO DE LA TABLA */
        //color
        $this->SetTextColor(228, 100, 0);
        $this->Cell(50); // mover a la derecha
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100, 10, utf8_decode("Peliculas creadas"), 0, 1, 'C', 0);
        $this->Ln(10);

        /* CAMPOS DE LA TABLA */
        //color
        $this->SetFillColor(228, 100, 0); //colorFondo
        $this->SetTextColor(255, 255, 255); //colorTexto
        $this->SetDrawColor(163, 163, 163); //colorBorde
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(20, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(25, 10, utf8_decode('descripcion'), 1, 0, 'C', 1);
        $this->Cell(25, 10, utf8_decode('estado'), 1, 0, 'C', 1);
        $this->Cell(25, 10, utf8_decode('fecha'), 1, 0, 'C', 1);
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
        $hoy = date('d/m/Y');
        $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
    }
}

session_start();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde



$fechaIni = $_POST['fechaInicia'];
$fechaini2 = strtotime($fechaIni);
$fechaIniformateada = date("Y-m-d", $fechaini2);


$fechaFin = $_POST['fechaFinal'];
$fechafin2 = strtotime($fechaFin);
$fechaFinFormateada = date("Y-m-d", $fechafin2);
require_once '../../modelo/MySQL.php';
$pdo = new PDO("mysql:host=localhost;dbname=peliculapdo", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$consulta = "SELECT * FROM peliculas where fecha between :fechaIni and :fechaFin";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(":fechaIni", $fechaIniformateada, PDO::PARAM_STR);
$stmt->bindParam(":fechaFin", $fechaFinFormateada, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($row as $datos) {

    $pdf->Cell(20, 10, utf8_decode($datos['nombre']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($datos['descripcion']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, utf8_decode($datos['estado']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, utf8_decode($datos['fecha']), 1, 0, 'C', 0);
    $pdf->Ln(10);
}


$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)