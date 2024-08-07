<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/Registrar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captchaResponse = $_POST['cf-turnstile-response'];
    $secretKey = '0x4AAAAAAAgDs52B4mxcqN8Dogf2JgT5KTg';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $secretKey,
        'response' => $captchaResponse
    ]));
    $response = curl_exec($ch);
    curl_close($ch);

    $verification = json_decode($response);

    if ($verification->success) {
        $result = Registrar::registrarUsuario();
        
        if ($result === true) {
            header("location: ../Controladores/controlador.php?seccion=login");
            exit();
        } else {
            $error = ($result === "Usuario ya existente") ? 1 : 3; // 3 = Error general
            header("location: controlador.php?seccion=registro&error=$error");
            exit();
        }
    } else {
        header("location: controlador.php?seccion=registro&error=2");
        exit();
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=registro");
    exit();
}

