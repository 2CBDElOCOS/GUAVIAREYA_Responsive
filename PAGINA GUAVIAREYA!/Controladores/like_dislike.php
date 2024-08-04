<?php
// Controladores/like_dislike.php
session_start();

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado."]);
    exit();
}

include '../Modelos/like_dislike.php';

$correo = $_SESSION['correo'];
$id_restaurante = $_POST['id_restaurante'];
$tipo = $_POST['tipo'];

$likeDislike = new LikeDislike();
$result = $likeDislike->insertarLikeDislike($correo, $id_restaurante, $tipo);

if ($result === "Success") {
    $likes = $likeDislike->obtenerConteoLikes($id_restaurante);
    $dislikes = $likeDislike->obtenerConteoDislikes($id_restaurante);
    echo json_encode([
        "status" => "success",
        "likes" => $likes,
        "dislikes" => $dislikes
    ]);
} else {
    echo json_encode(["status" => "error", "message" => $result]);
}
?>