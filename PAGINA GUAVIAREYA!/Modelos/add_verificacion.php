<?php
include '../config/Conexion.php';

/**
 * Clase para manejar la adición de fotos de identificación.
 */
class add_foto {
    /**
     * Función para agregar una foto de identificación.
     */
    static function add_foto() {
        // Verificar si los datos del formulario y el archivo están presentes
        if (isset($_FILES['img_P']) && isset($_POST['correo']) && isset($_POST['tipo_documento'])) {
            // Obtener los datos del formulario y el archivo
            $correo_formulario = $_POST['correo'];
            $tipo_documento = $_POST['tipo_documento'];
            $img_P = $_FILES['img_P']['name'];
            $img_temp = $_FILES['img_P']['tmp_name'];

            // Verificar si el usuario ha iniciado sesión
            if (!isset($_SESSION['correo'])) {
                // Redirigir al usuario si no ha iniciado sesión
                header("location: controlador.php?seccion=verificacion&error=No se ha iniciado sesión");
                exit;
            }

            // Obtener el correo de la sesión
            $correo_sesion = $_SESSION['correo'];

            // Verificar si el correo del formulario coincide con el correo de la sesión
            if ($correo_formulario !== $correo_sesion) {
                header("location: controlador.php?seccion=verificacion&error=El correo no coincide con el correo de sesión");
                exit;
            }

            // Obtener la conexión a la base de datos
            $conn = Conexion::conectar();

            // Verificar si hubo un error en la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Verificar si el correo existe en la tabla Usuarios
            $sql_verificar = $conn->prepare("SELECT * FROM Usuarios WHERE Correo = ?");
            $sql_verificar->bind_param("s", $correo_formulario);
            $sql_verificar->execute();
            $resultado = $sql_verificar->get_result();

            // Redirigir si el correo no está registrado en la base de datos
            if ($resultado->num_rows == 0) {
                header("location: controlador.php?seccion=verificacion&error=El correo no está registrado en la base de datos");
                exit;
            }

            // Ruta para guardar la imagen en el servidor
            $img_dest = "../media_documentos/" . basename($img_P);
            
            // Mover el archivo cargado a la ruta de destino
            if (move_uploaded_file($img_temp, $img_dest)) {
                // Preparar la declaración SQL para insertar la información en la base de datos
                $sql = $conn->prepare("INSERT INTO Documentos_Identificacion (Correo, Tipo_Documento, Foto_Documento) VALUES (?, ?, ?)");
                if ($sql === false) {
                    // Redirigir si hay un error al preparar la consulta
                    header("location: controlador.php?seccion=verificacionP&error=Error preparando la consulta: " . $conn->error);
                    exit;
                }

                // Vincular los parámetros a la declaración SQL
                $sql->bind_param("sss", $correo_formulario, $tipo_documento, $img_P);

                // Ejecutar la declaración SQL
                if ($sql->execute()) {
                    // Cerrar la conexión y redirigir en caso de éxito
                    $conn->close();
                    header("location: controlador.php?seccion=confirmacion");
                    exit;
                } else {
                    // Redirigir si hay un error al insertar en la base de datos
                    header("location: controlador.php?seccion=verificacion&error=Error al insertar en la base de datos");
                    exit;
                }
            } else {
                // Redirigir si hay un error al mover la imagen
                header("location: controlador.php?seccion=verificacion&error=Error al mover la imagen");
                exit;
            }
        } else {
            // Redirigir si faltan campos obligatorios
            header("location: controlador.php?seccion=verificacion&error=Faltan campos obligatorios");
            exit;
        }
    }
}
?>
