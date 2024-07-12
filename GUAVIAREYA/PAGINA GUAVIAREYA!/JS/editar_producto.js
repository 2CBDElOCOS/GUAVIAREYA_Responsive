// Script para actualizar el título del formulario y el texto del botón si se está editando un producto
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const idProducto = urlParams.get('id');
    if (idProducto) {
        document.getElementById("form-title").innerText = "Editar Producto";
        document.getElementById("form-button").innerText = "Guardar Cambios";

        // Cargar los datos del producto usando AJAX (requiere un endpoint para obtener los detalles del producto)
        fetch(`../Controladores/controlador_obtener_producto.php?id=${idProducto}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("ID_Producto").value = data.ID_Producto;
                document.getElementById("Nombre_P").value = data.Nombre_P;
                document.getElementById("descripcion").value = data.Descripcion || ''; // Asegurar que la descripción no sea undefined
                document.getElementById("Valor_P").value = data.Valor_P;
                // Manejar la vista previa de la imagen si es necesario
            })
            .catch(error => console.error('Error al cargar los datos del producto:', error));
    }
});
