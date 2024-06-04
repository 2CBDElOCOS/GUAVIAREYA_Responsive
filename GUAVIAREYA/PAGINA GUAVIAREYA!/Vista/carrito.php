<!DOCTYPE html>
<html lang="en">

<head>

  <title>GuaviareYa!</title>

</head>

<body>
    <div class="container">
        <div class="col-md-12 ico-carro">
            <a href="?seccion=productos"><i class="fa-solid fa-circle-arrow-left"></i></a>
        </div>
        <div class="subcontainer3">
            <div class="row">
                <div class="col-md-12 carrito">
                    <h3 class="name-ca">Tu Carrito</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="name-car">#RESTAURANTE</h3>
                </div>
            </div>
            <div class="row carrito">
                <div class="col-md-3">
                    <img src="../media/pizza/pi1.png" alt="" width="100px">
                </div>
                <div class="col-md-3">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Omnis, in!</p>
                </div>
                <div class="col-md-3">
                    <input type="number" name="cantidad" min="0" max="20" value="1" class="cantidad">
                </div>
                <div class="col-md-3 precio ">
                    <p>COP 21.000</p>
                   <a href=""><i class="fa-solid fa-trash" style="color: orange; font-size: 25px;"></i></a> 
                </div>
            </div>


            <div class="row ">
                <div class="col-md-12">
                    <h3 class="name-car">#lOCAL</h3>
                </div>
            </div>
            <div class="row carrito">
                <div class="col-md-3">
                    <img src="../media/gaseosa.jpg" alt="" width="100px">
                </div>
                <div class="col-md-3">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Omnis, in!</p>
                </div>
                <div class="col-md-3 ">
                    <input type="number" name="cantidad" min="0" max="20" value="1" class="cantidad ">
                </div>
                <div class="col-md-3 precio">
                    <p>COP 3.000</p>
                   <a href=""><i class="fa-solid fa-trash" style="color: orange; font-size: 25px;"></i></a> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 subtotal">
                    <h3 class="name-car">SUBTOTAL</h3>
                    <p class="valor" style="font-weight: bold;">COP 24.000</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="controlador?seccion=tarjeta"><button class="btn-pagar">Pagar</button></a>
                </div>
            </div>
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