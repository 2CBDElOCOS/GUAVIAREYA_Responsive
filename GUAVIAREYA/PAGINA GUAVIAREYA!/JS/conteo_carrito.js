$(document).ready(function() {
    // Función para manejar el clic en el botón Agregar
    $('.btn-agregar').click(function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        var form = $(this).closest('form'); // Obtener el formulario más cercano
        var url = form.attr('action'); // Obtener la URL del formulario

        // Enviar datos del formulario usando AJAX
        $.post(url, form.serialize(), function(response) {
            // Actualizar el contador del carrito
            var contador = parseInt($('#contador-carrito').text());
            $('#contador-carrito').text(contador + 1);

            // Opcional: Puedes mostrar un mensaje de éxito o una notificación al usuario
        });
    });
});
