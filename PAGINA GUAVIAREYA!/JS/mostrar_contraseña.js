document.getElementById('mostrarContrasena').addEventListener('change', function() {
    var passFields = [
        document.getElementById('ContrasenaAnterior'),
        document.getElementById('NuevaContrasena'),
        document.getElementById('ConfirmarContrasena'),
        document.getElementById('Contrasena')
    ];
    passFields.forEach(function(field) {
        if (field) {
            field.type = document.getElementById('mostrarContrasena').checked ? 'text' : 'password';
        }
    });
});