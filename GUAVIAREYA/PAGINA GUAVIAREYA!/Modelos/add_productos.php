<?php
class add_productos {
    static function add_productos() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "bd_guaviareya";

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
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Verificar que la imagen se ha subido correctamente
            if ($_FILES['img_P']['error'] !== UPLOAD_ERR_OK) {
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error en la subida de la imagen");
                exit;
            }

            // Directorio donde se guardarán las imágenes subidas
            $upload_dir = '../media_productos/';

            // Crear el directorio si no existe
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Mover el archivo de imagen al directorio deseado
            $target_file = $upload_dir . basename($_FILES['img_P']['name']);
            if (!move_uploaded_file($_FILES['img_P']['tmp_name'], $target_file)) {
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error al guardar la imagen");
                exit;
            }

            // Preparar la consulta SQL para insertar los datos en la tabla Productos
            $sql = $conn->prepare("INSERT INTO Productos (ID_Producto, ID_Restaurante, Nombre_P, Descripcion, Valor_P, img_P) VALUES (?, ?, ?, ?, ?, ?)");
            $sql->bind_param("iissis", $id_producto, $id_restaurante, $nombre_P, $descripcion, $valor_P, $img_P);

            // Ejecutar la consulta
            if ($sql->execute()) {
                // Redirigir después de registrar los datos
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit;
            } else {
                header("location: controlador.php?seccion=ADMI_Agregar_P&error=Error al insertar en la base de datos");
                exit;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            // Redirigir si faltan datos
            header("location: controlador.php?seccion=ADMI_Agregar_P&error=Faltan campos obligatorios");
            exit;
        }
    }
}
?>
