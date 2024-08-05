<?php
include '../config/Conexion.php';

/**
 * Clase para agregar productos
 */
class add_productos {
    /**
     * Método estático para agregar productos
     *
     * Este método verifica si se han enviado los datos del formulario, obtiene los datos, 
     * mueve el archivo de imagen al directorio deseado y luego inserta los datos en la tabla Productos.
     *
     * @return void
     */
    static function add_productos() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['Nombre_P'], $_POST['descripcion'], $_POST['Valor_P'], $_FILES['img_P'])) {

            // Obtener los datos del formulario
            $nombre_P = $_POST['Nombre_P'];
            $descripcion = $_POST['descripcion'];
            $valor_P = $_POST['Valor_P'];

            // Nombre del archivo de imagen
            $img_P = $_FILES['img_P']['name'];
            $img_temp = $_FILES['img_P']['tmp_name'];

            // Verificar si el ID_Restaurante está almacenado en la sesión
            if (isset($_SESSION['id_restaurante'])) {
                $id_restaurante = $_SESSION['id_restaurante'];

                // Crear conexión
                $conn = Conexion::conectar();

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Mover el archivo de imagen al directorio deseado
                $img_dest = "../media_productos/" . basename($img_P);
                if (move_uploaded_file($img_temp, $img_dest)) {
                    // Preparar la consulta SQL para insertar los datos en la tabla Productos
                    $sql = $conn->prepare("INSERT INTO Productos (Nombre_P, Descripcion, Valor_P, img_P, ID_Restaurante) VALUES (?, ?, ?, ?, ?)");
                    if ($sql === false) {
                        header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error preparando la consulta: " . $conn->error);
                        exit;
                    }

                    // Vincular los parámetros a la consulta preparada
                    $sql->bind_param("ssisd", $nombre_P, $descripcion, $valor_P, $img_P, $id_restaurante);

                    // Ejecutar la consulta
                    if ($sql->execute()) {
                        $conn->close();
                        header("location: controlador.php?seccion=ADMI_Productos_A");
                        exit;
                    } else {
                        header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error al insertar en la base de datos");
                        exit;
                    }
                } else {
                    header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error al mover la imagen");
                    exit;
                }
                
            } else {
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=ID de restaurante no especificado");
                exit;
            }
        } else {
            header("location: controlador.php?seccion=ADMI_Agregar_P&error=Faltan campos obligatorios");
            exit;
        }
    }
}

?>