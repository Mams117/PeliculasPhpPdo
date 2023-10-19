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
    $contraEncry = $encriptar($pass);

    include("../modelo/MySQL.php");
    $conexion = new MySQL();
    $pdo = $conexion->conectar();
    $sql = "SELECT * FROM usuarios WHERE user=:user AND pass=:pass";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $contraEncry, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['usuario'] = $fila['user'];
        $_SESSION['idUsuario'] = $fila['idUsuario'];
        $_SESSION['session'] = true;
        header("Location:../vista/peliculas.php");
    } else {
        $_SESSION['error'] = "Usuario o Contraseña Incorrecta Intente Nuevamente";
        $_SESSION['error2'] = "Error";
        header("Location: ../index.php");
    }
}
