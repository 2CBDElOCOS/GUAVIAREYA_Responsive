<?php
include '../config/Conexion.php';

/**
 * Clase para agregar administradores
 */
class add_administrador {

    /**
     * Método estático para agregar administradores
     *
     * Este método verifica si se han enviado los datos del formulario, 
     * obtiene los datos y luego inserta los datos en la tabla Administradores.
     *
     * @return void
     */
    static function add_administrador() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Correo'], $_POST['Apodo'], $_POST['Contrasena'], $_POST['ID_Restaurante'])) {

            // Obtener los datos del formulario
            $correo = $_POST['Correo'];                // Correo del administrador
            $apodo = $_POST['Apodo'];                  // Apodo del administrador
            $contrasena = md5($_POST['Contrasena']);   // Encriptar la contraseña con md5
            $rol = 'administrador';                   // Rol asignado automáticamente
            $restaurante_id = $_POST['ID_Restaurante']; // ID del restaurante asociado

            // Crear conexión con la base de datos
            $conn = Conexion::conectar();

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Preparar la consulta SQL para insertar los datos en la tabla Administradores
            $sql = $conn->prepare("INSERT INTO Administradores (correo, apodo, contrasena, rol, ID_Restaurante) VALUES (?, ?, ?, ?, ?)");
            
            // Verificar si la preparación de la consulta fue exitosa
            if ($sql === false) {
                header("Location: SUPER_add_administrador.php?error=Error preparando la consulta: " . $conn->error);
                exit;
            }

            // Vincular los parámetros a la consulta preparada
            $sql->bind_param("sssss", $correo, $apodo, $contrasena, $rol, $restaurante_id);

            // Ejecutar la consulta
            if ($sql->execute()) {
                $admin_id = $sql->insert_id; // Obtener el ID del administrador insertado
                $conn->close(); // Cerrar la conexión
                header("Location: ../Controladores/controlador.php?seccion=SuperAdmin_Panel&admin_id=$admin_id");
                exit;
            } else {
                // Manejar el error si la inserción falla
                header("Location: SUPER_add_administrador.php?error=Error al insertar en la base de datos: " . $sql->error);
                exit;
            }
        } else {
            // Manejar el caso donde faltan campos obligatorios
            header("Location: SUPER_add_administrador.php?error=Faltan campos obligatorios");
            exit;
        }
    }
}
?>
