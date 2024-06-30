document.getElementById('Contrasena').addEventListener('input', function() {
    var password = this.value;
    var strengthText = document.getElementById('password-strength');
    var messages = [];

    if (password.length < 8) {
        messages.push('La contraseña debe tener al menos 8 caracteres.');
    }
    if (!/[A-Z]/.test(password)) {
        messages.push('La contraseña debe tener al menos una letra mayúscula.');
    }
    if (!/[a-z]/.test(password)) {
        messages.push('La contraseña debe tener al menos una letra minúscula.');
    }
    if (!/[0-9]/.test(password)) {
        messages.push('La contraseña debe tener al menos un número.');
    }
    if (!/[!@#\$%\^&\*]/.test(password)) {
        messages.push('La contraseña debe tener al menos un carácter especial.');
    }

    if (messages.length > 0) {
        strengthText.style.display = 'block';
        strengthText.textContent = messages.join(' ');
        strengthText.classList.remove('strong-password');
        strengthText.classList.add('weak-password');
        strengthText.dataset.valid = 'false';
    } else {
        strengthText.style.display = 'block';
        strengthText.textContent = 'La contraseña es fuerte';
        strengthText.classList.remove('weak-password');
        strengthText.classList.add('strong-password');
        strengthText.dataset.valid = 'true';
    }
});

document.getElementById('registerForm').addEventListener('submit', function(event) {
    var strengthText = document.getElementById('password-strength');
    if (strengthText.dataset.valid === 'false' || strengthText.style.display === 'none') {
        event.preventDefault();
        alert('Por favor, ingrese una contraseña válida.');
    }
});