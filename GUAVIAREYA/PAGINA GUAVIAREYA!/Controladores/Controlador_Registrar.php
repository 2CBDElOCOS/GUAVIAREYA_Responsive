<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/Registrar.php");

// Verificar si se han enviado los datos del formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar el CAPTCHA de Cloudflare
    $captchaResponse = $_POST['cf-turnstile-response'];
    $secretKey = '0x4AAAAAAAgDs52B4mxcqN8Dogf2JgT5KTg'; // Reemplaza con tu clave secreta

    // Crear la solicitud para verificar el CAPTCHA
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
        // El CAPTCHA fue verificado correctamente
        $result = Registrar::registrarUsuario();
        
        if ($result === true) {
            // Registro exitoso
            header("location: ../Controladores/controlador.php?seccion=login");
            exit();
        } else {
            // Error al registrar el usuario
            $error = $result; // Captura el mensaje de error
            header("location: controlador.php?seccion=registro&error=1");
            exit();
        }
    } else {
        // El CAPTCHA falló
        header("location: controlador.php?seccion=registro&error=2");
        exit();
    }
} else {
    // Cargar la vista de registro si no se han enviado datos
    header("location: ../Controladores/controlador.php?seccion=registro");
    exit();
}
?>
