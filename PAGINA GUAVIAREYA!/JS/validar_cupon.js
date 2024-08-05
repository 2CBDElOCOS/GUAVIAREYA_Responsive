function validarCupon() {
    const codigoCupon = document.getElementById('codigo_cupon').value;
    const mensajeCupon = document.getElementById('mensaje_cupon'); // Definir el elemento
    console.log('Código de cupón enviado:', codigoCupon); // Para depurar

    fetch('../Controladores/Controlador_validar_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'codigo_cupon': codigoCupon
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data); // Para depurar
        if (data.valido) {
            mensajeCupon.textContent = 'Cupón válido.';
        } else {
            mensajeCupon.textContent = data.mensaje || 'Cupón inválido o expirado.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mensajeCupon.textContent = 'Error al validar el cupón.';
    });
}
