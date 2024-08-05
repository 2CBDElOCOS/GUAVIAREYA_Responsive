<?php
// Asegúrate de que la sesión esté iniciada y que el usuario esté autenticado.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

require_once '../Modelos/mostrar_restaurantes.php';
require_once '../Modelos/like_dislike.php';

// Instanciar el modelo
$mostrarProductos = new mostrar_restaurantes();
$restaurantes = $mostrarProductos->obtenerRestaurantes();
$likeDislike = new LikeDislike();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
</head>
<body class="body">
    <section id="hero" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                <div class="d-flex justify-content-end mb-4 ico-footer1">
                <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left" style="color: #fff;"></i></a>
                 </div>

                </div>
                <h1 class="text-white text-center mb-4">RESTAURANTES</h1>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <?php
                    foreach ($restaurantes as $restaurante) {
                        $estado = $restaurante['Estado'];
                        $id_restaurante = $restaurante['ID_Restaurante'];
                        $link = $estado === 'Abierto'
                            ? 'controlador.php?seccion=productos&id_restaurante=' . $id_restaurante
                            : '#';

                        $estadoClase = $estado === 'Abierto' ? 'text-success' : 'text-danger';

                        $likes = $likeDislike->obtenerConteoLikes($id_restaurante);
                        $dislikes = $likeDislike->obtenerConteoDislikes($id_restaurante);

                        echo '
                        <div class="col">
                            <a style="text-decoration:none" href="' . $link . '" ' . ($estado !== 'Abierto' ? 'onclick="return false;"' : '') . '>
                                <div class="card h-100">
                                    <img style="object-fit: cover; width: 100%; height: 200px;" src="../media_restaurantes/' . $restaurante['img_R'] . '" class="card-img-top" alt="Imagen de ' . $restaurante['Nombre_R'] . '">
                                    <div class="card-body">
                                        <h5 class="card-title"> NOMBRE: '. $restaurante['Nombre_R'] . '</h5> 
                                        <p class="card-text"> Dirección: ' . $restaurante['Direccion'] . '</p>
                                        <p class="card-text"> Teléfono: '  . $restaurante['Telefono'] . '</p>
                                        <p class="card-text ' . $estadoClase . '"> Estado: '  . $estado . '</p>
                                        <div class="like-dislike-container d-flex justify-content-between">
                                            <button class="btn btn-outline-success like-btn" data-id="' . $id_restaurante . '">
                                                <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i> 
                                                <span class="like-count">' . $likes . '</span>
                                            </button>
                                            <button class="btn btn-outline-danger dislike-btn" data-id="' . $id_restaurante . '">
                                                <i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i>
                                                <span class="dislike-count">' . $dislikes . '</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <script src="../JS/like_dislike.js"></script> <!-- Incluye tu archivo JS -->
</body>
</html>
