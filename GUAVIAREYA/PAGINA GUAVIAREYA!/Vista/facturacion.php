<!DOCTYPE html>
<html lang="en">

<head>

    <title>GuaviareYa!</title>

</head>

<body>
    <div class="container">
        <div class="subcontainer3">
            <div class="row">
                <div class="col-md-12 diren">
                    <h6>Dirección de entrega</h6>
                    <a href="controlador.php?seccion=perfil">Cambiar</a>
                </div>

                <div class="col-md-12 datos">
                    <h6 class="direccion">Cl. 17 #103A-45</h6>
                    <p class="instru_entrega">Instrucciones de entrega (opcional)</p>
                    <input class="detalles" type="text" placeholder="Detalles adicioanles..">
                </div>
            </div>
        </div>

        <div class="subcontainer4">
            <div class="row">
                <div class="col-md-12">

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">

                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Nombre Restaurante
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <img src="../media/pizza/pi2.png" alt="" width="110px">
                                    <p> 1 pizza de piña</p>
                                    <p>$12.000 COP</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 estimada">
                    <h6 class="esti">Entrega estimada:</h6>
                    <b>
                        <p class="esti-tiempo">30-45 minutos</p>
                    </b>
                </div>
                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Prioritaria">
                    <div class="label-container">
                        <b><label for="Prioritaria">Prioritaria 🚀</label></b>
                        <h6>envio directo</h6>
                    </div>
                    <div class="precio">
                        <h6>+$5000</h6>
                    </div>
                </div>

                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Básica">
                    <div class="label-container">
                        <b><label for="Básica">Básica 🍔</label></b>
                        <h6>Entrega habitual</h6>
                    </div>
                    <div class="precio">
                        <h6>+$0</h6>
                    </div>
                </div>

                <div class="col-md-12 flex-container">
                    <input type="radio" name="envio" id="Economica">
                    <div class="label-container">
                        <b><label for="Economica">Economica 💹</label></b>
                        <h6>Espera y ahorra</h6>
                    </div>
                    <div class="precio">
                        <h6>-$5000</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="subcontainer4">
            <div class="row ">
                <div class="col-md-12 metodo">
                    <b>
                        <h6>✅ Metodo de pago</h6>
                    </b>
                </div>
                <div class="col-md-6 tipos_metodo">
                    <label class=" add_metodo">Agregar método de pago:</label>
                </div>
                <div class="col-md-3 tipos_metodos">
                    <input class="add_metodos" type="radio"> <img src="../media/tarjeta.png" alt="" width="80px">
                </div>
                <div class="col-md-3 tipos_metodo">
                    <a href="controlador.php?seccion=tarjeta"><button style="border-radius: 30px; margin-top:15px">ir</button></a>
                </div>



            </div>
        </div>

        <div class="subcontainer4">
            <div class="col-md-12">

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">

                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Resumen
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-12 resumen_total">
                                        <div class="resumen">
                                            <h6>Costo de productos</h6>
                                            <i>
                                                <p>$12.000</p>
                                            </i>
                                        </div>
                                        <div class="resumen">
                                            <h6>Costo de envío</h6>
                                            <i>
                                                <p>$3.000</p>
                                            </i>
                                        </div>
                                        <div class="resumen">
                                            <h6>Impuestos y Tarifas</h6>
                                            <i>
                                                <p>$2.000</p>
                                            </i>
                                        </div>
                                        <div class="resumen">
                                            <h6>Total</h6>
                                            <i>
                                                <p>$17.000</p>
                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <a href="controlador.php?seccion=confirmacion"><button style="border-radius: 15px; margin-top:30px;">Hacer Pedido</button></a>
        </div>

    </div>

    </div>

</body>

</html>