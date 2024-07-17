<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/delete_productos_carrito.php');


delete_productos::delete_productos();
?>
