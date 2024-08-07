

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR DATOS ADMI</title>
</head>
<body>
    <div class="container">
        <div class="ico-footer1">
            <a href="controlador.php?seccion=ADMI_Perfil_A"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
        </div>
        <div class="main-body">
            <h4 class="mb-4">EDITAR DATOS</h4>

            <!-- Formulario de edición de perfil -->
            <form action="Controlador_AdmiP.php" method="POST">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-12 col-md-3 col-form-label">Nombre</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" name="Nombre_R" class="form-control form-control-lg bg-light" placeholder="Nombre">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label class="col-sm-12 col-md-3 col-form-label">Telefono</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" name="Telefono" class="form-control form-control-lg bg-light" placeholder="Telefono">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label class="col-sm-12 col-md-3 col-form-label">Direccion</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="tel" name="Direccion" class="form-control form-control-lg bg-light" placeholder="Direccion">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info w-100">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
