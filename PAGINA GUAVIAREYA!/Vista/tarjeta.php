<!DOCTYPE html>
<html lang="en">

<head>
    <title>GuaviareYa!</title>
</head>

<body>
    <div class="container">
        <div class="col-md-12 ico-footer1">
            <a href="controlador.php?seccion=carrito"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="subcontainer4">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="text-align: center;">Agregar método de pago</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <center><img src="../media/tarjeta.png" alt="tarjeta" width="400px"></center>
                </div>
            </div>

            <form action="controlador_tarjeta.php" method="post">
                <div class="row">
                    <div class="col-md-12 di-na">
                        <label for="tarjeta">Número de la tarjeta</label>
                         <input type="text" name="tarjeta" id="tarjeta" placeholder="Número de tarjeta" required
                               maxlength="19" oninput="formatCardNumber(this)">
                    </div>

                    <div class="col-md-6 di-na">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                    </div>

                    <div class="col-md-6 di-na">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
                    </div>
                    
                    <div class="col-md-6 di-na">
                        <label for="expiracion">Fecha de expiración</label>
                        <input type="text" name="expiracion" id="expiracion" placeholder="mm/aa" required
                               maxlength="7" oninput="formatExpiration(this)">
                    </div>
                    
                    <div class="col-md-6 di-na">
                        <label for="cvv">CVV</label>
                        <input type="text" name="cvv" id="cvv" placeholder="CVV" required maxlength="3"
                               oninput="formatCVV(this)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="hacer-pedido">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../JS/formato_tarjeta.js"></script>
</body>

</html>
