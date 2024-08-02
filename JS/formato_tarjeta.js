// Función para formatear el número de tarjeta
function formatCardNumber(input) {
    let value = input.value.replace(/\s+/g, ''); // Quitar espacios existentes
    value = value.replace(/[^0-9]/g, ''); // Eliminar caracteres no numéricos
    if (value.length > 16) {
        value = value.slice(0, 16); // Limitar a 16 dígitos
    }
    input.value = value.replace(/(.{4})/g, '$1 ').trim(); // Añadir espacios cada 4 dígitos
}

// Función para formatear la fecha de expiración
function formatExpiration(input) {
    let value = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
    if (value.length > 4) {
        value = value.slice(0, 4); // Limitar a 4 dígitos
    }
    if (value.length >= 3) {
        value = value.slice(0, 2) + '/' + value.slice(2); // Insertar espacio
    }
    input.value = value;
}

// Función para formatear el CVV
function formatCVV(input) {
    let value = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
    if (value.length > 3) {
        value = value.slice(0, 3); // Limitar a 3 dígitos
    }
    input.value = value;
}