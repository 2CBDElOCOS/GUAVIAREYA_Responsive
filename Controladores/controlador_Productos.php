<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/add_productos.php');

add_productos::add_productos();     