$(document).ready(function() {
    $('.cantidad').on('change', function() {
        var idProducto = $(this).data('id');
        var cantidad = $(this).val();

        $.ajax({
            url: '../Controladores/controlador_actualizar_carrito.php',
            type: 'POST',
            data: { id_producto: idProducto, cantidad: cantidad },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    console.error('Error en el servidor:', response.error);
                } else {
                    $('#subtotal').text('COP ' + new Intl.NumberFormat().format(response.subtotal));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el carrito:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText); // Muestra la respuesta completa para depuración
            }
        });
    });
});
