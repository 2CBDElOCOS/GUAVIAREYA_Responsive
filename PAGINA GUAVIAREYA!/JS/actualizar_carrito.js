$(document).ready(function() {
    // Manejar el cambio en la cantidad usando el campo de entrada
    $('.cantidad').on('change', function() {
        actualizarCantidad($(this));
    });

    // Manejar clic en el botón de incrementar
    $('.btn-incrementar').on('click', function() {
        var $input = $(this).closest('.input-group').find('.cantidad');
        $input.val(parseInt($input.val()) + 1).trigger('change');
    });

    // Manejar clic en el botón de decrementar
    $('.btn-decrementar').on('click', function() {
        var $input = $(this).closest('.input-group').find('.cantidad');
        if ($input.val() > 1) {
            $input.val(parseInt($input.val()) - 1).trigger('change');
        }
    });

    // Función para actualizar la cantidad en el carrito
    function actualizarCantidad($input) {
        var cantidad = $input.val();
        var id_producto = $input.data('id');
        var $row = $input.closest('.row');
        var precioUnitario = $row.find('.precio-unitario').data('precio');

        $.ajax({
            url: 'controlador_actualizar_carrito.php',
            type: 'POST',
            data: {
                id_producto: id_producto,
                cantidad: cantidad
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $row.find('.precio-unitario').text('COP ' + data.precio_unitario);
                    $('#subtotal').text('COP ' + data.subtotal);
                } else {
                    alert(data.message);
                }
            }
        });
    }
});
