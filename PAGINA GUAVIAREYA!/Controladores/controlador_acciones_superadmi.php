<?php
// controlador_acciones_superadmi.php
require_once '../Modelos/DataSuperAdmi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ID_Restaurante'])) {
    DataSuperAdmi::borrar_restaurante();
}
