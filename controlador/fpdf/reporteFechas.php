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
    isset($_POST['fechaInicia']) && !empty($_POST['fechaInicia']) &&
    isset($_POST['fechaFinal']) && !empty($_POST['fechaFinal'])

) {
    $fechaIni = $_POST['fechaInicia'];
    $fechaIni2 = strtotime($fechaIni);
    $fechaIniFormateada = date("Y-m-d", $fechaIni2);

    $fechaFin = $_POST['fechaFinal'];
    $fechaFin2 = strtotime($fechaFin);
    $fehcaFinFormateada = date("Y-m-d", $fechaFin2);
    //////////////////////////////////////////////////////////////////////////
    //se hace llamado del modelo de conexion y consultas 
    require_once '../../modelo/MySQL.php';
    //se capturan las variables que vienen desde el formulario
    $fechaInicia = ($_POST['fechaInicia']);
    $fechaFinal = $_POST['fechaFinal'];
    // se instancia la clasem, es decir, se llama para poder usar los metodos
    $conn = new MySQL();
    //se hace uso del metodo para conectarse a la base de datos 
    $conn->conectar();
    //triago el nombre
    $consulta = $conn->efectuarConsulta("SELECT peliculas.peliculas.idPelicula, peliculas.peliculas.nombre_Pelicula, peliculas.peliculas.descripcion_Pelicula, peliculas.peliculas.estado, peliculas.peliculas.Fecha_publi, peliculas.generos.nombre_Genero, peliculas.usuarios.user, peliculas.usuarios.idUsuario, peliculas.idiomas.nombre_Idioma FROM peliculas.peliculas INNER JOIN peliculas.generos_has_peliculas ON peliculas.peliculas.idPelicula = peliculas.generos_has_peliculas.Peliculas_idPelicula INNER JOIN peliculas.generos ON peliculas.generos.idGenero = peliculas.generos_has_peliculas.Generos_idGenero INNER JOIN peliculas.usuarios on peliculas.usuarios.idUsuario = peliculas.peliculas.Usuarios_idUsuario INNER JOIN peliculas.peliculas_has_idiomas on peliculas.peliculas_has_idiomas.Peliculas_idPelicula = peliculas.peliculas.idPelicula INNER JOIN peliculas.idiomas on peliculas.idiomas.idIdioma = peliculas.peliculas_has_idiomas.Idiomas_idIdioma WHERE peliculas.Fecha_publi BETWEEN ' $fechaIniFormateada ' AND '$fechaFinal' ;");
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
