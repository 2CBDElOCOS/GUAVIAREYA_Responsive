<?php
require_once "../Modelos/cupon.php";

class Controlador_Cupon {
    public function validarCupon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigoCupon = isset($_POST['codigo_cupon']) ? $_POST['codigo_cupon'] : '';

            if (empty($codigoCupon)) {
                echo json_encode(['valido' => false, 'mensaje' => 'El código de cupón no puede estar vacío.']);
                exit();
            }

            $resultado = Cupones::validarCupon($codigoCupon);
            echo json_encode($resultado);
            exit();
        }
    }
}

// Instanciar el controlador y llamar al método correspondiente
$controlador = new Controlador_Cupon();
$controlador->validarCupon();
?>
