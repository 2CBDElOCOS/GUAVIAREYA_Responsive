<?php

class add_productos{
    static function add_productos(){
        $servername = "127.0.0.1";
        $username = "root";   
        $password = "";
        $dbname = "bd_guaviareya";
        
        // Verificar si se han enviado los datos del formulario
        if (isset($_POST['ID_Producto']) && isset($_POST['ID_Restaurante']) && isset($_POST['descripcion']) && isset($_POST['Nombre_P']) && isset($_POST['Valor_P']) && isset($_POST['img_P'])) {

            // Obtener los datos del formulario
            $id_producto = $_POST['ID_Producto'];
            $id_restaurante = $_POST['ID_Restaurante'];
            $descripcion = $_POST['descripcion'];
            $Nombre_P = $_POST['Nombre_P'];
            $Valor_P = $_POST['Valor_P'];
            $img_P = $_POST['img_P'];

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            
            // Preparar la consulta SQL para insertar los datos en la tabla tb_productos
            $sql = "INSERT INTO Usuarios (ID_Producto, ID_Restaurante, descripcion, Nombre_P,Valor_P,img_P) VALUES ('$id_producto', '$id_restaurante', '$descripcion', '$Nombre_P','$Valor_P','$img_P')";

            // Ejecutar la consulta
            if ($conn->query($sql) === TRUE) {
                // Redirigir a otra página después de registrar los datos
                $conn->close();
                header("location: ../Vista/ADMI_Productos_A.php");
                exit(); // Salir del script después de redirigir
            } else {
                echo "Error al ingresar productos: " . $conn->error;
            }

            // Cerrar la conexión
            
        } else {
            echo "No se recibieron los datos del formulario de agregar productos";
        }
    }
}