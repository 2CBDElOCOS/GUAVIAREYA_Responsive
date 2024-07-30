$(document).ready(function() {
    console.log('JavaScript cargado'); // Para verificar que el JS se carga

    // Manejar el cambio en la cantidad usando el campo de entrada
    $('.cantidad').on('change', function() {
        actualizarCantidad($(this));
    });

    // Función para actualizar la cantidad en el carrito
    function actualizarCantidad($input) {
        var cantidad = $input.val();
        var id_producto = $input.data('id');
        var $row = $input.closest('.row');

        $.ajax({
            url: 'controlador_actualizar_carrito.php',
            type: 'POST',
            data: {
                id_producto: id_producto,
                cantidad: cantidad
            },
            success: function(response) {
                console.log('Respuesta recibida:', response); // Para depurar la respuesta del PHP
                var data = JSON.parse(response);
                if (data.success) {
                    // Actualizar el precio unitario y el subtotal
                    $row.find('.precio-unitario').text('COP ' + number_format(data.precio_unitario, 0, ',', '.'));
                    $('#subtotal').text('COP ' + number_format(data.subtotal, 0, ',', '.'));
                } else {
                    alert('Error al actualizar el carrito.');
                }
            }
        });
    }

    // Función para formatear el número en formato COP
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
});
