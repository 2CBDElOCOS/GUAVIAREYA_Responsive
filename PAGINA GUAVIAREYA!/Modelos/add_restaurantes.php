<?php
include '../config/Conexion.php';

/**
 * Clase para agregar restaurantes.
 */
class add_restaurantes
{
    /**
     * Método estático para agregar restaurantes.
     *
     * Este método verifica si se han enviado los datos del formulario y el archivo de imagen,
     * valida si el nombre del restaurante ya existe, mueve el archivo de imagen al directorio deseado
     * y luego inserta los datos en la base de datos.
     *
     * @return mixed Retorna el ID del restaurante si la inserción es exitosa, de lo contrario, un mensaje de error.
     */
    static function add_restaurantes()
    {
        // Verificar si se han enviado los datos del formulario y el archivo de imagen
        if (isset($_POST['Nombre_R'], $_POST['Direccion'], $_POST['Telefono'], $_FILES['img_R'])) {

            // Obtener los datos del formulario
            $nombre_R = $_POST['Nombre_R'];    // Nombre del restaurante
            $direccion = $_POST['Direccion'];  // Dirección del restaurante
            $telefono = $_POST['Telefono'];    // Teléfono del restaurante

            // Obtener los detalles del archivo de imagen
            $img_R = $_FILES['img_R']['name'];     // Nombre del archivo de imagen
            $img_temp = $_FILES['img_R']['tmp_name']; // Nombre temporal del archivo en el servidor

            // Crear conexión a la base de datos
            $conn = Conexion::conectar();

            // Verificar conexión
            if ($conn->connect_error) {
                return "Error de conexión: " . $conn->connect_error;
            }

            // Verificar si el nombre del restaurante ya existe en la base de datos
            $check_sql = $conn->prepare("SELECT COUNT(*) FROM Restaurantes WHERE Nombre_R = ?");
            $check_sql->bind_param("s", $nombre_R);
            $check_sql->execute();
            $check_sql->bind_result($count);
            $check_sql->fetch();
            $check_sql->close();

            if ($count > 0) {
                return "El nombre del restaurante ya existe."; // Retornar mensaje si el restaurante ya existe
            }

            // Mover el archivo de imagen al directorio deseado
            $img_dest = "../media_restaurantes/" . basename($img_R);
            if (move_uploaded_file($img_temp, $img_dest)) {
                // Preparar la consulta SQL para insertar los datos en la tabla Restaurantes
                $sql = $conn->prepare("INSERT INTO Restaurantes (Nombre_R, Direccion, Telefono, img_R) VALUES (?, ?, ?, ?)");
                
                // Verificar si la preparación de la consulta fue exitosa
                if ($sql === false) {
                    return "Error preparando la consulta: " . $conn->error;
                }

                // Vincular los parámetros a la consulta preparada
                $sql->bind_param("ssss", $nombre_R, $direccion, $telefono, $img_dest);

                // Ejecutar la consulta
                if ($sql->execute()) {
                    $restaurante_id = $conn->insert_id; // Obtener el ID del restaurante recién insertado
                    $sql->close();
                    $conn->close();
                    return $restaurante_id; // Retornar el ID para usarlo en el controlador
                } else {
                    return "Error al insertar en la base de datos: " . $sql->error;
                }
            } else {
                return "Error al mover la imagen."; // Retornar mensaje si no se puede mover la imagen
            }
        } else {
            return "Faltan campos obligatorios."; // Retornar mensaje si faltan campos obligatorios
        }
    }
}
?>
