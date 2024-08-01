<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuaviareYa!</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS (Opcional, si usas iconos) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center ico-footer1">
                <a href="controlador.php?seccion=carrito"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
        </div>
        <div class="subcontainer4">
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="text-center">Agregar método de pago</h3>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 text-center">
                    <img src="../media/tarjeta.png" alt="tarjeta" class="img-fluid" style="max-width: 400px;">
                </div>
            </div>

            <form action="controlador_tarjeta.php" method="post">
                <div class="row">
                    <div class="col-12 col-md-6 di-na">
                        <label for="tarjeta">Número de la tarjeta</label>
                        <input type="text" name="tarjeta" id="tarjeta" placeholder="Número de tarjeta" required
                               maxlength="19" oninput="formatCardNumber(this)">
                    </div>

                    <div class="col-12 col-md-6 di-na">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                    </div>

                    <div class="col-12 col-md-6 di-na">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
                    </div>

                    <div class="col-12 col-md-6 di-na">
                        <label for="expiracion">Fecha de expiración</label>
                        <input type="text" name="expiracion" id="expiracion" placeholder="mm/aa" required
                               maxlength="7" oninput="formatExpiration(this)">
                    </div>

                    <div class="col-12 col-md-6 di-na">
                        <label for="cvv">CVV</label>
                        <input type="text" name="cvv" id="cvv" placeholder="CVV" required maxlength="3"
                               oninput="formatCVV(this)">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="hacer-pedido">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/formato_tarjeta.js"></script>
</body>

</html>
