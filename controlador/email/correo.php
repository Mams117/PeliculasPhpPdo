<?php
session_start();
// Importar las clases de PHPMailer al espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargar el autoloader de Composer
require 'vendor/autoload.php';

// Crear una instancia de PHPMailer; pasar `true` habilita las excepciones
$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    //$mail->SMTPDebug = 2; // Habilitar la salida de depuración detallada
    $mail->isSMTP(); // Enviar utilizando SMTP
    $mail->Host       = 'smtp.gmail.com'; // Establecer el servidor SMTP
    $mail->SMTPAuth   = true; // Habilitar la autenticación SMTP
    $mail->Username   = 'am17222001@gmail.com'; // Tu dirección de correo electrónico SMTP
    $mail->Password   = 'cqip gjls gckk sapn'; // Tu contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Habilitar la encriptación TLS implícita
    $mail->Port       = 465; // Puerto TCP al que conectarse (usa 587 si SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS)


    // Configuración del remitente
    $correoDestinatario = $_POST["correo"];
    $mail->setFrom($correoDestinatario, 'usuario'); // Dirección de correo y nombre del remitente


    // Configuración de destinatarios
    $mail->addAddress($correoDestinatario);

    // Verificar si los archivos existen antes de adjuntarlos
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
        $archivoTmp = $_FILES["archivo"]["tmp_name"];
        $nombreArchivo = $_FILES["archivo"]["name"];
        // Adjuntar el archivo cargado
        $mail->addAttachment($archivoTmp, $nombreArchivo);
        $_SESSION["mensajeExitoso"] = "Correo enviado exitosamente";
    } else {
        $_SESSION["mensajeError"] = "Error: No se cargó ningún archivo o hubo un problema con la carga.";
    }

    // Configuración del contenido
    $mail->isHTML(true); // Establecer el formato de correo electrónico en HTML
    $mail->Subject = 'Asunto del correo'; // Asunto del correo
    $mail->Body    = 'Contenido del correo en formato HTML'; // Contenido HTML del correo
    $mail->AltBody = 'Contenido del correo en texto sin formato HTML'; // Contenido en texto sin formato HTML
    header("Location: ../../vista/reportes.php");

    // Enviar el correo
    $mail->send();
} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Error del remitente: {$mail->ErrorInfo}";
}
