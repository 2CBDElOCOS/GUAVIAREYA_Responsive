document.querySelectorAll('.btn-status').forEach(button => {
    button.addEventListener('click', function () {
        const pedidoId = this.getAttribute('data-pedido-id');
        document.getElementById('pedidoId').value = pedidoId;
        const estadoActual = this.getAttribute('data-estado-actual');
        document.getElementById('Estado').value = estadoActual;
    });
});
