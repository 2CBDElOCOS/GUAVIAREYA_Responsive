<?php
include 'Conexion.php';

class add_foto {
    static function add_foto() {
        if (isset($_FILES['img_P']) && isset($_POST['correo']) && isset($_POST['tipo_documento'])) {
            $correo_formulario = $_POST['correo'];
            $tipo_documento = $_POST['tipo_documento'];
            $img_P = $_FILES['img_P']['name'];
            $img_temp = $_FILES['img_P']['tmp_name'];

            // Obtener el correo almacenado en la sesión
            if (!isset($_SESSION['correo'])) {
                header("location: controlador.php?seccion=verificacion&error=No se ha iniciado sesión");
                exit;
            }

            $correo_sesion = $_SESSION['correo'];

            // Verificar si el correo del formulario coincide con el correo de la sesión
            if ($correo_formulario !== $correo_sesion) {
                header("location: controlador.php?seccion=verificacion&error=El correo no coincide con el correo de sesión");
                exit;
            }

            $conn = Conexion();

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Verificar si el correo existe en la tabla Usuarios
            $sql_verificar = $conn->prepare("SELECT * FROM Usuarios WHERE Correo = ?");
            $sql_verificar->bind_param("s", $correo_formulario);
            $sql_verificar->execute();
            $resultado = $sql_verificar->get_result();

            if ($resultado->num_rows == 0) {
                header("location: controlador.php?seccion=verificacion&error=El correo no está registrado en la base de datos");
                exit;
            }

            $img_dest = "../media_documentos/" . basename($img_P);
            if (move_uploaded_file($img_temp, $img_dest)) {
                $sql = $conn->prepare("INSERT INTO Documentos_Identificacion (Correo, Tipo_Documento, Foto_Documento) VALUES (?, ?, ?)");
                if ($sql === false) {
                    header("location: controlador.php?seccion=verificacionP&error=Error preparando la consulta: " . $conn->error);
                    exit;
                }

                $sql->bind_param("sss", $correo_formulario, $tipo_documento, $img_P);

                if ($sql->execute()) {
                    $conn->close();
                    header("location: controlador.php?seccion=confirmacion");
                    exit;
                } else {
                    header("location: controlador.php?seccion=verificacion&error=Error al insertar en la base de datos");
                    exit;
                }
            } else {
                header("location: controlador.php?seccion=verificacion&error=Error al mover la imagen");
                exit;
            }
        } else {
            header("location: controlador.php?seccion=verificacion&error=Faltan campos obligatorios");
            exit;
        }
    }
}
?>
