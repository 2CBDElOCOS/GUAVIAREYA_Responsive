document.getElementById('search-icon').addEventListener('click', function() {
    document.getElementById('search-box').style.display = 'flex';
  });

  document.getElementById('search-close').addEventListener('click', function() {
    document.getElementById('search-box').style.display = 'none';
  });




  document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.form-agregar');

    forms.forEach(form => {
      form.addEventListener('submit', function(event) {
        const useAjax = !form.classList.contains('no-ajax'); // Clase para distinguir el método

        if (useAjax) {
          event.preventDefault();

          const formData = new FormData(form);

          fetch('controlador_carrito.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Actualiza el contador del carrito
                const cartCounter = document.querySelector('.bx-cart span');
                if (cartCounter) {
                  cartCounter.textContent = data.contador;
                } else {
                  // Si no existe el span, lo crea y lo añade
                  const newCounter = document.createElement('span');
                  newCounter.textContent = data.contador;
                  document.querySelector('.bx-cart').appendChild(newCounter);
                }
              }
            })
            .catch(error => console.error('Error:', error));
        }
      });
    });
  });