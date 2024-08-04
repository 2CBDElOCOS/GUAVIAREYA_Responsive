function updateEstimatedTimeAndFees() {
    const elementoTiempoEstimado = document.querySelector('.esti-tiempo');
    const elementoCostoEnvio = document.querySelector('.costo-envio'); // Actualiza el costo de envío
    const elementoSubtotal = document.querySelector('.subtotal'); // Actualiza esto si usas una clase diferente para el subtotal
    const elementoTotal = document.querySelector('.total'); // Elemento para el total

    const opcionPrioritaria = document.getElementById('Prioritaria');
    const opcionBasica = document.getElementById('Básica');

    let tiempoEstimado, costoEnvio;

    // Costo de envío predeterminado
    costoEnvio = 3000;
    tiempoEstimado = '35-50 minutos'; // Tiempo estimado por defecto

    if (opcionPrioritaria.checked) {
        tiempoEstimado = '20-30 minutos';
        costoEnvio += 5000; // Agrega 5000 al costo de envío si se selecciona Prioritaria
        document.getElementById('tipo_envio').value = 'Prioritaria'; // Actualiza el tipo de envío
    } else if (opcionBasica.checked) {
        document.getElementById('tipo_envio').value = 'Básica'; // Actualiza el tipo de envío
    }

    elementoTiempoEstimado.textContent = tiempoEstimado;
    elementoCostoEnvio.textContent = `+$${costoEnvio.toLocaleString()}`;

    // Actualizar el subtotal y total
    const subtotal = parseInt(document.querySelector('.subtotal').textContent.replace(/\D/g, '')) || 0;
    const impuestosTarifas = 2000; // Ajusta según lo necesario
    const total = subtotal + costoEnvio + impuestosTarifas;
    elementoTotal.textContent = `$${total.toLocaleString()}`;

    // Actualizar valores ocultos para el formulario
    document.getElementById('costo_envio').value = costoEnvio;
    document.getElementById('total').value = total;
}

// Actualizar tiempos y costos de envío al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    updateEstimatedTimeAndFees();
});

// Escuchar cambios en los radio buttons de envío
document.querySelectorAll('input[name="envio"]').forEach(function (envio) {
    envio.addEventListener('change', updateEstimatedTimeAndFees);
});
