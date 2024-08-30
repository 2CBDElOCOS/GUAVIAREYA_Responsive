<?php
class CarritoModelo {
    public static function calcularSubtotal($carrito) {
        $subtotal = 0;
        foreach ($carrito as $restaurante) {
            foreach ($restaurante['productos'] as $producto) {
                $subtotal += $producto['Valor_P'] * $producto['cantidad'];
            }
        }
        return $subtotal;
    }
}
?>
