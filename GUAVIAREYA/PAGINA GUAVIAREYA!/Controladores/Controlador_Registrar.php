<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/Registrar.php');

Registrar::Registrar();