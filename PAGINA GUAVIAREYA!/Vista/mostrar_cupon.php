<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Cupón</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>

    <!-- Scripts de Bootstrap y SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    <script>
        function mostrarCupon(codigoCupon) {
            Swal.fire({
                title: '¡Felicidades!',
                html: `Tienes un 10% de descuento en tu primera compra. Usa el código de cupón que encontraras en tu perfil.`,
                icon: 'info',
                width: 600,
                padding: '3em',
                color: '#716add',
                background: '#fff url(https://sweetalert2.github.io/images/trees.png)',
                backdrop: `
                    rgba(0,0,123,0.4)
                    url("https://media.tenor.com/uYAFdAfKa7sAAAAi/shopbackshopfest-shopback.gif")
                    left top
                    no-repeat
                `,
                confirmButtonText: 'Continuar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Marcar el cupón como usado
                    fetch('../Controladores/controlador.php?seccion=marcar_cupon_usado&codigo=' + encodeURIComponent(codigoCupon))
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            // Redirigir a la página "shop"
                            window.location.href = '../Controladores/controlador.php?seccion=shop';
                        });
                }
            });
        }

        window.onload = function () {
            const cuponCodigo = '<?php echo $_SESSION["cupon_codigo"]; ?>';
            mostrarCupon(cuponCodigo);
        };
    </script>
</body>

</html>
