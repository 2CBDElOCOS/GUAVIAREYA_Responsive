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
        shippingCost = 0;
    }

    estimatedTimeElement.textContent = estimatedTime;
    taxFeesElement.textContent = `$${taxFees.toLocaleString()}`;
    shippingCostElement.textContent = `$${shippingCost.toLocaleString()}`;

    // Update total
    const subtotal = parseInt(document.querySelector('.subtotal').textContent.replace(/\D/g, ''));
    const total = subtotal + shippingCost + taxFees;
    totalElement.textContent = `$${total.toLocaleString()}`;
}

// Deshabilitar el botón inicialmente
const hacerPedidoBtn = document.getElementById('hacerPedidoBtn');
const errorMessage = document.getElementById('error-message');

// Función para habilitar el botón si se selecciona un método de pago
function checkPaymentMethodSelected() {
    const paymentMethods = document.querySelectorAll('input[name="metodo_pago"]');
    let isPaymentMethodSelected = false;

    paymentMethods.forEach(function (method) {
        if (method.checked) {
            isPaymentMethodSelected = true;
        }
    });

    hacerPedidoBtn.disabled = !isPaymentMethodSelected;
    errorMessage.style.display = isPaymentMethodSelected ? 'none' : 'block';
}

// Escuchar cambios en los radio buttons de método de pago
document.querySelectorAll('input[name="metodo_pago"]').forEach(function (method) {
    method.addEventListener('change', checkPaymentMethodSelected);
});

// Validar al hacer clic en el botón
hacerPedidoBtn.addEventListener('click', function (event) {
    const paymentMethods = document.querySelectorAll('input[name="metodo_pago"]');
    const isPaymentMethodSelected = Array.from(paymentMethods).some(method => method.checked);

    if (!isPaymentMethodSelected) {
        event.preventDefault(); // Prevenir la acción del botón si no hay método de pago seleccionado
        errorMessage.style.display = 'block'; // Mostrar mensaje de error
    }
});

// Actualizar tiempos y costos de envío al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    updateEstimatedTimeAndFees();
    checkPaymentMethodSelected(); // Habilitar o deshabilitar el botón al cargar la página
});

// Escuchar cambios en los radio buttons de envío
document.querySelectorAll('input[name="envio"]').forEach(function (envio) {
    envio.addEventListener('change', updateEstimatedTimeAndFees);
});
