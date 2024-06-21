<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR PERFIL</title>
</head>

<body>
    <div class="container">
        <div class="col-md-12 ico-footer1">
            <a href="controlador.php?seccion=perfil"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="main-body">
            <br>
            <div>
                <h4>EDITAR PERFIL</h4>
            </div>

            <!-- Formulario de edición de perfil -->
            <form action="controlador_editar_datos.php" method="POST">

                <div class="row gutters-sm">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <br>
                                        <h6 class="mb-0">Nombre</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <br>
                                        <input type="text" name="nombre" class="form-control form-control-lg bg-light fs-6" placeholder="Nombre">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <br>
                                        <h6 class="mb-0">Apellido</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <br>
                                        <input type="text" name="apellido" class="form-control form-control-lg bg-light fs-6" placeholder="Apellido">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Teléfono</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="tel" name="telefono" class="form-control form-control-lg bg-light fs-6" placeholder="Teléfono">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Dirección</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="direccion" class="form-control form-control-lg bg-light fs-6" placeholder="Dirección">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-info">Guardar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</body>

</html>