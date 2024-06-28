<?php
include 'Conexion.php';

class Registrar {
    static function registrarUsuario() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Apodo'], $_POST['Nombre'], $_POST['Apellido'], $_POST['Correo'], $_POST['Contrasena'], $_POST['Telefono'])) {

            // Obtener los datos del formulario
            $apodo = $_POST['Apodo'];
            $nombre = $_POST['Nombre'];
            $apellido = $_POST['Apellido'];
            $correo = $_POST['Correo'];
            $contrasena = $_POST['Contrasena'];
            $telefono = $_POST['Telefono'];

            // Validar la contraseña
            $error_clave = "";
            if (!self::validar_clave($contrasena, $error_clave)) {
                echo "Error: $error_clave";
                return;
            }

            // Crear conexión usando la función Conexion
            $conn = Conexion();

            // Preparar la consulta SQL para insertar los datos en la tabla Usuarios
            $sql = "INSERT INTO Usuarios (Apodo, Nombre, Apellido, Correo, Contrasena, Telefono) VALUES ('$apodo', '$nombre', '$apellido', '$correo', '$contrasena', '$telefono')";

            // Ejecutar la consulta
            if ($conn->query($sql) === TRUE) {
                // Guardar el apodo y correo en la sesión después de registrar los datos
                $_SESSION['Apodo'] = $apodo;
                $_SESSION['correo'] = $correo;

                // Redirigir a la tienda después de registrar los datos
                $conn->close();
                header("location: ../Controladores/controlador.php?seccion=login");
                exit(); // Salir del script después de redirigir
            } else {
                echo "Error al registrar los datos: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "No se recibieron todos los datos del formulario";
        }
    }

    // Función para validar la contraseña
    static function validar_clave($clave, &$error_clave) {
        if (strlen($clave) < 6) {
            $error_clave = "La clave debe tener al menos 6 caracteres";
            return false;
        }
        if (strlen($clave) > 16) {
            $error_clave = "La clave no puede tener más de 16 caracteres";
            return false;
        }
        if (!preg_match('`[a-z]`', $clave)) {
            $error_clave = "La clave debe tener al menos una letra minúscula";
            return false;
        }
        if (!preg_match('`[A-Z]`', $clave)) {
            $error_clave = "La clave debe tener al menos una letra mayúscula";
            return false;
        }
        if (!preg_match('`[0-9]`', $clave)) {
            $error_clave = "La clave debe tener al menos un caracter numérico";
            return false;
        }
        $error_clave = "";
        return true;
    }
}
?>