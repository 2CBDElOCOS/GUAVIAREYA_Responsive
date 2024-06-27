<?php
include 'Conexion.php';

// Clase para agregar productos
class add_productos {
    static function add_productos() {
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['ID_Producto'], $_POST['ID_Restaurante'], $_POST['Nombre_P'], $_POST['descripcion'], $_POST['Valor_P'], $_FILES['img_P'])) {

            // Obtener los datos del formulario
            $id_producto = $_POST['ID_Producto'];
            $id_restaurante = $_POST['ID_Restaurante'];
            $nombre_P = $_POST['Nombre_P'];
            $descripcion = $_POST['descripcion'];
            $valor_P = $_POST['Valor_P'];

            // Nombre del archivo de imagen
            $img_P = $_FILES['img_P']['name'];

            // Crear conexión
            $conn = Conexion();

            // Verificar conexión
            if ($conn->connect_error) {
                // En caso de error, terminar la ejecución y mostrar el mensaje de error
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Verificar que la imagen se ha subido correctamente
            if ($_FILES['img_P']['error'] !== UPLOAD_ERR_OK) {
                // Redirigir a la página de error si la imagen no se subió correctamente
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error en la subida de la imagen");
                exit;
            }

            // Directorio donde se guardarán las imágenes subidas
            $upload_dir = '../media_productos/';

            // Crear el directorio si no existe
            if (!file_exists($upload_dir)) {
                // Crear el directorio con permisos 0777 si no existe
                mkdir($upload_dir, 0777, true);
            }

            // Mover el archivo de imagen al directorio deseado
            $target_file = $upload_dir . basename($_FILES['img_P']['name']);
            if (!move_uploaded_file($_FILES['img_P']['tmp_name'], $target_file)) {
                // Redirigir a la página de error si la imagen no se pudo mover al directorio
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error al guardar la imagen");
                exit;
            }

            // Preparar la consulta SQL para insertar los datos en la tabla Productos
            $sql = $conn->prepare("INSERT INTO Productos (ID_Producto, ID_Restaurante, Nombre_P, Descripcion, Valor_P, img_P) VALUES (?, ?, ?, ?, ?, ?)");
            if ($sql === false) {
                // Redirigir a la página de error si hubo un error al preparar la consulta SQL
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error preparando la consulta: " . $conn->error);
                exit;
            }

            // Vincular los parámetros a la consulta preparada
            $sql->bind_param("iissis", $id_producto, $id_restaurante, $nombre_P, $descripcion, $valor_P, $img_P);

            // Ejecutar la consulta
            if ($sql->execute()) {
                // Cerrar la conexión y redirigir a la página de éxito si la inserción fue exitosa
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit;
            } else {
                // Redirigir a la página de error si hubo un error al ejecutar la consulta
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error al insertar en la base de datos");
                exit;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            // Redirigir a la página de error si faltan datos obligatorios
            header("location: controlador.php?seccion=ADMI_Agregar_P&error=Faltan campos obligatorios");
            exit;
        }
    }
}
?>
