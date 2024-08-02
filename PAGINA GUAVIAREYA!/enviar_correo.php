<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

// Incluir el archivo de configuración
include('../config/config_dire_correo.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../Vista/olvidaste.php?error=1");
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.mailersend.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'MS_nb05PB@trial-351ndgw8w3rgzqx8.mlsender.net';
        $mail->Password   = 'TcB1lD9bJwDdCVHo';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('MS_nb05PB@trial-351ndgw8w3rgzqx8.mlsender.net', 'GUAVIAREYA');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de Contraseña - GuaviareYA';
        $mail->Body    = "<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: 0 auto; padding: 20px; }
        h1 { color: #333; }
        p { line-height: 1.6; }
        .button { display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #666; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Recuperación de Contraseña</h1>
        <p>Estimado/a,</p>
        <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en GuaviareYA.</p>
        <p>Para proceder con el restablecimiento, haz clic en el siguiente enlace:</p>
        <p><a href='" . APP_URL . "/Controladores/controlador.php?seccion=Olvidaste2&correo=" . urlencode($correo) . "' class='button'>Restablecer mi contraseña</a></p>
        <p>Si no has solicitado este cambio, por favor ignora este correo.</p>
        <p>Para cualquier duda o asistencia adicional, no dudes en contactarnos a través de nuestro soporte en <b>Guaviareya@gmail.com</b></p>
        <p>Gracias por tu atención.</p>
        <p>Atentamente,</p>
        <p>El equipo de GuaviareYA</p>
        <div class='footer'>
            <p>&copy; " . date("Y") . " GuaviareYA. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>";

        $mail->send();
        header("Location: ../Controladores/controlador.php?seccion=olvidaste&success=1");
    } catch (Exception $e) {
        header("Location: ../Controladores/controlador.php?seccion=olvidaste&error=2");
    }
} else {
    header("Location: ../Controladores/controlador.php?seccion=olvidaste&error=3");
}
?>
