$(document).ready(function() {
    $('.cantidad').on('change', function() {
        var cantidad = $(this).val();
        var id_producto = $(this).data('id');
        var $row = $(this).closest('.row');
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
    });
});