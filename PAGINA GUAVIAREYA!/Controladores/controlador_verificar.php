<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/add_verificacion.php');

add_foto::add_foto();
