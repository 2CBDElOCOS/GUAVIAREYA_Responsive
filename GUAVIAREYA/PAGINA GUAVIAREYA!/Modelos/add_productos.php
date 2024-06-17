<?php

class add_productos {
    static function add_productos() {
        $servername = "127.0.0.1";
        $username = "root";   
        $password = "";
        $dbname = "bd_guaviareya";
        
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['ID_Producto']) && isset($_POST['ID_Restaurante']) && isset($_POST['Nombre_P']) && isset($_POST['descripcion']) && isset($_POST['Valor_P']) && isset($_FILES['img_P'])) {

            // Obtener los datos del formulario
            $id_producto = $_POST['ID_Producto'];
            $id_restaurante = $_POST['ID_Restaurante'];
            $nombre_P = $_POST['Nombre_P'];
            $descripcion = $_POST['descripcion'];
            $valor_P = $_POST['Valor_P'];

            // Manejo de la imagen
            $img_P = file_get_contents($_FILES['img_P']['tmp_name']);

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            
            // Preparar la consulta SQL para insertar los datos en la tabla Productos
            $sql = $conn->prepare("INSERT INTO Productos (ID_Producto, ID_Restaurante, Nombre_P, Descripcion, Valor_P, img_P) VALUES (?, ?, ?, ?, ?, ?)");
            $sql->bind_param("iissis", $id_producto, $id_restaurante, $nombre_P, $descripcion, $valor_P, $img_P);

            // Ejecutar la consulta
            if ($sql->execute() === TRUE) {
                // Redirigir a otra página después de registrar los datos
                $conn->close();
                header("location: controlador.php?seccion=ADMI_Productos_A");
                exit(); // Salir del script después de redirigir
            } else {
                echo "Error al ingresar productos: " . $conn->error;
            }

            // Cerrar la conexión
            $conn->close();
        } else {
            echo "No se recibieron los datos del formulario de agregar productos";
        }
    }
}

