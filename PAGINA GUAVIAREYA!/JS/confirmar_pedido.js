function verificarDireccion() {
    // Verificar si se ha seleccionado una dirección
    var direccionSeleccionada = document.querySelector('input[name="direccion_seleccionada"]:checked');
    if (!direccionSeleccionada) {
        alert('Por favor selecciona una dirección antes de confirmar el pedido.');
        return false; // Evita que se envíe el formulario
    }
    return true; // Permite que el formulario se envíe
}

document.getElementById('confirmarPedidoBtn').addEventListener('click', function(event) {
    if (!verificarDireccion()) {
        event.preventDefault(); // Evita el envío del formulario si la dirección no está seleccionada
    }
});
