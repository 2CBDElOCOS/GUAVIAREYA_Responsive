<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/add_restaurantes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_restaurantes::add_restaurantes();
} else {
    header("location: SUPER_add.php");
    exit;
}
?>
