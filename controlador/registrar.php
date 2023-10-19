<?php
session_start();
if (isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $encriptar = function ($valor) {
        $clave = 'JotaRoncon21';
        //Metodo de encriptaciÃ³n
        $method = 'aes-256-cbc';
        // Puedes generar una diferente usando la funcion $getIV()
        $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
        return openssl_encrypt(base64_encode($valor), $method, $clave, false, $iv);
    };
    /*
     Desencripta el texto recibido
     */
    $desencriptar = function ($valor) {
        $clave = 'JotaRoncon21';
        //Metodo de encriptaciÃ³n
        $method = 'aes-256-cbc';
        // Puedes generar una diferente usando la funcion $getIV()
        $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
        return base64_decode(openssl_decrypt($valor, $method, $clave, false, $iv));
    };

    include("../modelo/MySQL.php");

    $conexion = new MySQL();
    $pdo = $conexion->conectar();
    $sql = "SELECT * FROM usuarios WHERE user=:user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $_SESSION['mensajeErr'] = "Ya hay un usuario con el nombre Ingresado en la Base de Datos";
        $_SESSION['mensaje2Err'] = "Error";
        header("Location: ../vista/registrar.php");
    } else {
        $passEncrip = $encriptar($pass);
        $sql2 = "INSERT INTO usuarios (user,pass) VALUES (:user, :pass)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt2->bindParam(':pass', $passEncrip, PDO::PARAM_STR);
        $stmt2->execute();
        $_SESSION['mensaje'] = "Usuario Agregado Correctamente";
        $_SESSION['mensaje2'] = "Felicitaciones";
        header("Location: ../index.php");
    }
}
