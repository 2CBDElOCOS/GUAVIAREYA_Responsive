<?php
include 'Conexion.php';

/**
 * Clase para agregar restaurantes
 */
class add_restaurantes
{
    /**
     * Método estático para agregar restaurantes
     *
     * Este método verifica si se han enviado los datos del formulario, obtiene los datos,
     * mueve el archivo de imagen al directorio deseado y luego inserta los datos en la tabla Restaurantes.
     *
     * @return void
     */
    static function add_restaurantes()
    {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Nombre_R'], $_POST['Direccion'], $_POST['Telefono'], $_FILES['img_R'])) {

            // Obtener los datos del formulario
            $nombre_R = $_POST['Nombre_R'];
            $direccion = $_POST['Direccion'];
            $telefono = $_POST['Telefono'];

            // Nombre del archivo de imagen
            $img_R = $_FILES['img_R']['name'];
            $img_temp = $_FILES['img_R']['tmp_name'];

            // Crear conexión
            $conn = Conexion();

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Mover el archivo de imagen al directorio deseado
            $img_dest = "../media_restaurantes/" . basename($img_R);
            if (move_uploaded_file($img_temp, $img_dest)) {
                // Preparar la consulta SQL para insertar los datos en la tabla Restaurantes
                $sql = $conn->prepare("INSERT INTO Restaurantes (Nombre_R, Direccion, Telefono, img_R) VALUES (?, ?, ?, ?)");
                if ($sql === false) {
                    header("location: SUPER_add.php?error=Error preparando la consulta: " . $conn->error);
                    exit;
                }

                // Vincular los parámetros a la consulta preparada
                $sql->bind_param("ssss", $nombre_R, $direccion, $telefono, $img_dest);

                // Ejecutar la consulta
                if ($sql->execute()) {
                    $restaurante_id = $sql->insert_id; // Obtener el ID del restaurante insertado
                    $conn->close();
                    header("Location: ../Controladores/controlador.php?seccion=SUPER_add_administrador&ID_Restaurante=$restaurante_id");
                    exit;
                } else {
                    header("location: SUPER_add.php?error=Error al insertar en la base de datos: " . $sql->error);
                    exit;
                }
            } else {
                header("location: SUPER_add.php?error=Error al mover la imagen");
                exit;
            }
            $conn->close();
        } else {
            header("location: SUPER_add.php?error=Faltan campos obligatorios");
            exit;
        }
    }
}
