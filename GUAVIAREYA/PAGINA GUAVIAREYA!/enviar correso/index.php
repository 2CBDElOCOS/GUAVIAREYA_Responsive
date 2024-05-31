<?php
// Dirección de correo del destinatario
$para = "luiszapata2051@gmail.com";

// Asunto del correo
$asunto = "Este es un asunto de prueba";

// Mensaje del correo
$mensaje = "Hola Luis, este es un mensaje de prueba enviado desde PHP.";

// Encabezados adicionales
$cabeceras = "From: tu-email@example.com\r\n" .
             "Reply-To: tu-email@example.com\r\n" .
             "X-Mailer: PHP/" . phpversion();

// Enviar el correo
if(mail($para, $asunto, $mensaje, $cabeceras)) {
    echo "Correo enviado con éxito a luiszapata2051@gmail.com.";
} else {
    echo "Error al enviar el correo.";
}
?>
