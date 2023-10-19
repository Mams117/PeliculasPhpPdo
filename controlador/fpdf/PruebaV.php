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
      $this->Cell(20, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Pelicula'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('idioma'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('descripcion'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('genero'), 1, 1, 'C', 1);
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



$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;

if (
   isset($_POST['idusuario']) && !empty($_POST['idusuario'])

) {
   require_once '../../modelo/MySQL.php';
   $idusuario = $_POST['idusuario'];
   $sql = "SELECT * pelicula Where IdUsuario:user ";
   $stmt->bindParam(':IdUsuario', $idUser, PDO::PARAM_STR);
   $stmt->execute();
   //traigo las peliculas
   //consulta para traer los idiomas 
   //se desconecta de la base de datos para librerar memoria
   $conn->desconectar();

   /* TABLA */
   while ($row = mysqli_fetch_array($consulta)) {
      //consulta para traer los idiomas 


      $pdf->Cell(18, 10, utf8_decode($row['idPelicula']), 1, 0, 'C', 0);
      $pdf->Cell(20, 10, utf8_decode($row['user']), 1, 0, 'C', 0);
      $pdf->Cell(30, 10, utf8_decode($row['nombre_Pelicula']), 1, 0, 'C', 0);
      $pdf->Cell(25, 10, utf8_decode($row['nombre_Idioma']), 1, 0, 'C', 0);
      $pdf->Cell(25, 10, utf8_decode($row['descripcion_Pelicula']), 1, 0, 'C', 0);
      $pdf->Cell(25, 10, utf8_decode($row['nombre_Genero']), 1, 1, 'C', 0);
   }
}

$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
