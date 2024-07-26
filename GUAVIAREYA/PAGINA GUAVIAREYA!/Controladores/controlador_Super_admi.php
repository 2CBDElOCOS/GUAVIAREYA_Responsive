<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/add_administrador.php');

add_administrador::add_administrador();

?>
