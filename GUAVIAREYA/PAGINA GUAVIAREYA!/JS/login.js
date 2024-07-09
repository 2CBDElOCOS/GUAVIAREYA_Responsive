document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('loginForm');
    var btn = document.getElementById('loginButton');

    // Función para deshabilitar el botón durante unos segundos
    function disableButton(seconds) {
        btn.disabled = true;

        var countdown = seconds;
        var interval = setInterval(function() {
            btn.innerText = 'Ingresar (' + countdown + ')';
            countdown--;

            if (countdown < 0) {
                clearInterval(interval);
                btn.disabled = false;
                btn.innerText = 'Ingresar';
            }
        }, 1000);
    }

    // Agregar evento submit al formulario
    form.addEventListener('submit', function(event) {
        // Verificar intentos fallidos aquí (manejar esto en tu controlador PHP y almacenar en $_SESSION)
        if (intentos >= 3) {
            event.preventDefault(); // Evitar el envío del formulario si hay demasiados intentos fallidos
            disableButton(30); // Deshabilitar el botón durante 30 segundos
        }
    });
});
