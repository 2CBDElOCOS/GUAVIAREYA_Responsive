$(document).ready(function() {
    // Función para manejar el clic en el botón Agregar
    $('.btn-agregar').click(function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        var form = $(this).closest('form'); // Obtener el formulario más cercano
        var url = form.attr('action'); // Obtener la URL del formulario

        // Enviar datos del formulario usando AJAX
        $.post(url, form.serialize(), function(response) {
            // Parsear la respuesta JSON
            var data = JSON.parse(response);

            // Verificar si la respuesta fue exitosa
            if (data.success) {
                // Actualizar el contador del carrito
                $('#contador-carrito').text(data.contador);

                // Opcional: Puedes mostrar un mensaje de éxito o una notificación al usuario
            } else {
                // Manejar el caso donde la respuesta no fue exitosa
                alert('Error al agregar el producto al carrito.');
            }
        });
    });
});
