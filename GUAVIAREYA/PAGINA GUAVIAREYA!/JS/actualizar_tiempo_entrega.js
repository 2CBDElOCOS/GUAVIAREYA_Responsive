function updateEstimatedTimeAndFees() {
    const estimatedTimeElement = document.querySelector('.esti-tiempo');
    const taxFeesElement = document.querySelector('.impuestos-tarifas');
    const shippingCostElement = document.querySelector('.costo-envio');
    const totalElement = document.querySelector('.total');
    const priorityOption = document.getElementById('Prioritaria');
    const basicOption = document.getElementById('Básica');

    let estimatedTime, taxFees, shippingCost;

    if (priorityOption.checked) {
        estimatedTime = '20-30 minutos';
        taxFees = 7000;
        shippingCost = 5000;
    } else if (basicOption.checked) {
        estimatedTime = '35-50 minutos';
        taxFees = 2000;
        shippingCost = 3000;
    }

    estimatedTimeElement.textContent = estimatedTime;
    taxFeesElement.textContent = `$${taxFees.toLocaleString()}`;
    shippingCostElement.textContent = `$${shippingCost.toLocaleString()}`;

    // Update total
    const subtotal = parseInt(document.querySelector('.subtotal').textContent.replace(/\D/g, ''));
    const total = subtotal + shippingCost + taxFees;
    totalElement.textContent = `$${total.toLocaleString()}`;
}

// Actualizar tiempos y costos de envío al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    updateEstimatedTimeAndFees();
});

// Escuchar cambios en los radio buttons de envío
document.querySelectorAll('input[name="envio"]').forEach(function (envio) {
    envio.addEventListener('change', updateEstimatedTimeAndFees);
});
