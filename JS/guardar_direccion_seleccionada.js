$(document).ready(function() {
    $('#direccionForm').on('submit', function(e) {
        e.preventDefault();
        var direccionSeleccionada = $('input[name="direccion_seleccionada"]:checked').val();
        if (direccionSeleccionada) {
            $.ajax({
                type: 'POST',
                url: '../Controladores/Controlador_guardar_direccion.php',
                data: { direccion: direccionSeleccionada },
                success: function(response) {
                    alert('Dirección seleccionada correctamente. Ahora puedes proceder a hacer tu pedido.');
                    // Aquí puedes actualizar la interfaz o realizar otras acciones
                },
                error: function() {
                    alert('Error al guardar la dirección.');
                }
            });
        } else {
            alert('Por favor selecciona una dirección');
        }
    });
});
