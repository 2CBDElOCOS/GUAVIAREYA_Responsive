<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GuaviareYa!</title>
    <!-- link css-->
    <link rel="stylesheet" href="../css/styles.css" />
    <!-- box icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <!-- link bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook"
        viewBox="0 0 16 16"></svg>

<body>
    
    <div class="container">
        <div class="col-md-12 ico-footer1">
            <a href="Perfil.html"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="subcontainer4">
            
            <div class="row">
                <div class="col-md-12 ">
                    <h3 style="text-align: center;">Agregar método de pago</h3>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-12">
                   <center> <img src="../media/tarjeta.png" alt="tarjeta" width="400px" ></center>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 di-na">
                    <label>Número de la tarjeta</label>
                    <input type="text" name="tarjeta" id="tarjeta" placeholder="Número de tarjeta">
                </div>

                <div class="col-md-6 di-na">
                    <label >Nombre</label>
                    <input type="text" name="apellido" id="tarjeta" placeholder="Nombre">
                </div>

                <div class="col-md-6 di-na">
                    <label >Apellido</label>
                    <input type="text" name="apellido" id="apellido" placeholder="Apellido"> 
                </div>
                
                <div class="col-md-6 di-na">
                    <label>Fecha de expiración</label>
                    <input type="text" name="expiracion" id="expiracion" placeholder="mm/aa">
                </div>
                <div class="col-md-6 di-na">
                    <label>CVV</label>
                    <input type="text" name="cvv" id="cvv" placeholder="CVV">
                </div>

            </div>

            <a href="facturacion.html" style="text-decoration: none; color: #fff;"><button class="hacer-pedido"> Aceptar</button></a>
        </div>
    </div>








        <!-- Scripts de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

        <!-- Scripts de fontawesome -->
        <script src="https://kit.fontawesome.com/c8b5889ad4.js" crossorigin="anonymous"></script>
</body>

</html>