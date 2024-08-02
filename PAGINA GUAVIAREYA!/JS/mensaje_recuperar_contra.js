$(document).ready(function() {
    $('#recoveryForm').on('submit', function(event) {
        event.preventDefault(); // Evita el envío normal del formulario

        $.ajax({
            url: '../enviar_correo.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                var messageDiv = $('#message');
                messageDiv.removeClass('success error'); // Limpiar clases anteriores
                messageDiv.addClass(response.status === 'success' ? 'success' : 'error');
                messageDiv.text(response.message);
                messageDiv.show();
            },
            error: function() {
                var messageDiv = $('#message');
                messageDiv.removeClass('success').addClass('error');
                messageDiv.text('Error al procesar la solicitud. Inténtalo de nuevo más tarde.');
                messageDiv.show();
            }
        });
    });
});