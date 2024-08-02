document.getElementById('mostrarContrasena').addEventListener('change', function() {
    var contrasenaInput = document.getElementById('Contrasena');
    if (this.checked) {
        contrasenaInput.type = 'text';
    } else {
        contrasenaInput.type = 'password';
    }
});