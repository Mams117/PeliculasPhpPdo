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
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color


      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("Peliculas creadas"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(18, 10, utf8_decode('Id°'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Pelicula'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('Descripcion'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Fecha'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Estado'), 1, 0, 'C', 1);
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


$i = $i + 1;
$id = $_POST['idUsuario'];

$pdo = new PDO("mysql:host=localhost;dbname=peliculapdo", "root", "");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT DISTINCT usuarios.idUsuario, usuarios.user,peliculas.id AS id, peliculas.nombre AS nombre, peliculas.descripcion AS descripcion, peliculas.estado AS estado, peliculas.fecha AS fecha
FROM usuarios
INNER JOIN peliculas ON peliculas.idUsuario = usuarios.idUsuario 
WHERE usuarios.idUsuario=:id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
//traigo las peliculas
//consulta para traer los idiomas 
//se desconecta de la base de datos para librerar memoria


/* TABLA */
foreach ($row2 as $datos) {
   $pdf->Cell(18, 10, utf8_decode($datos['id']), 1, 0, 'C', 0);
   $pdf->Cell(20, 10, utf8_decode($datos['nombre']), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, utf8_decode($datos['descripcion']), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, utf8_decode($datos['fecha']), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, utf8_decode($datos['estado']), 1, 0, 'C', 0);
   $pdf->Ln(10);
   // $pdf->Cell(25, 10, utf8_decode($row['nombre_Genero']), 1, 1, 'C', 0);
}
//consulta para traer los idiomas 







$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
