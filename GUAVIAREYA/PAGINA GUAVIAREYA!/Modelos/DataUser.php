<?php
include 'Conexion.php';

Class DataUser{

    public static function getUserByEmail($email)
    {

        // Crear conexión
        $conn = Conexion();

        // Inicializar la variable $user
        $user = null;

        // Preparar y ejecutar la consulta SQL para obtener el usuario por correo electrónico
        $stmt = $conn->prepare("SELECT Correo, Apodo, Nombre, Apellido, Telefono,img_U FROM Usuarios WHERE Correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se obtuvo un resultado
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Obtener el resultado como un array asociativo
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        return $user;
    }
    public static function updateUser($email,  $nombre, $apellido, $telefono) {
        // Crear conexión
        $conn = Conexion();

        // Preparar y ejecutar la consulta SQL para actualizar el usuario por correo electrónico
        $stmt = $conn->prepare("UPDATE Usuarios SET  Nombre = ?, Apellido = ?, Telefono = ? WHERE Correo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . $conn->error);
        }

        $stmt->bind_param("ssss", $nombre, $apellido, $telefono, $email);
        $success = $stmt->execute();

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

        return $success;
    }

        function validar_clave($clave,&$error_clave){
    if(strlen($clave) < 6){
        $error_clave = "La clave debe tener al menos 6 caracteres";
        return false;
    }
    if(strlen($clave) > 16){
        $error_clave = "La clave no puede tener más de 16 caracteres";
        return false;
    }
    if (!preg_match('`[a-z]`',$clave)){
        $error_clave = "La clave debe tener al menos una letra minúscula";
        return false;
    }
    if (!preg_match('`[A-Z]`',$clave)){
        $error_clave = "La clave debe tener al menos una letra mayúscula";
        return false;
    }
    if (!preg_match('`[0-9]`',$clave)){
        $error_clave = "La clave debe tener al menos un caracter numérico";
        return false;
    }
    $error_clave = "";
    return true;
    }
public function subirFotoPerfil($userEmail, $file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Error al subir el archivo.';
        }

        if ($file['size'] > 5242880) {
            return 'El archivo es demasiado grande. El tamaño máximo permitido es de 5MB.';
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return 'Tipo de archivo no permitido. Solo se permiten archivos JPG, PNG y GIF.';
        }

        $uploadDir = '../media/Foto_Perfil/';
        $fileName = basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return 'Error al mover el archivo subido.';
        }

        $sql = "UPDATE Usuarios SET img_U = ? WHERE Correo = ?";
        $stmt = $this->conn->prepare($sql); // Aquí se usa $this->conn para acceder a la conexión

        if ($stmt === false) {
            return 'Error al preparar la consulta: ' . $this->conn->error;
        }

        $stmt->bind_param('ss', $uploadFilePath, $userEmail);
        $success = $stmt->execute();

        $stmt->close();

        return $success ? true : 'Error al actualizar la base de datos.';
    }
}


