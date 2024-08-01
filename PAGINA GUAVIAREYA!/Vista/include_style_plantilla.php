<?php
// Define las fechas del evento
$eventoInicio = new DateTime('2024-07-31');
$eventoFin = new DateTime('2024-08-01'); // Ajusta según la duración del evento
$fechaActual = new DateTime();

$eventoEnCurso = ($fechaActual >= $eventoInicio && $fechaActual <= $eventoFin);

// Define la sección actual (esto debería ser dinámico en función del archivo o URL)
$seccion = isset($seccion) ? $seccion : 'home';

// Determina el archivo CSS a incluir basado en si el evento está en curso o no
$cssFile = $eventoEnCurso ? '../css/evento.css' : '../css/styles.css';
?>
<head>
    <?php
    if (in_array($seccion, ['home', 'shop', 'comida', 'bebidas', 'productos', 'carrito', 'tarjeta', 'pago', 'facturacion', 'confirmacion', 'ADMI_Shop_A', 'ADMI_Productos_A', 'ADMI_Bebidas_A', 'ADMI_Bebida_A', 'ADMI_Comida_A', 'SuperAdmin_Panel', 'SUPER_add', 'SUPER_add_administrador', 'Perfil_Restaurantes'])) {
    ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>" />
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c8b5889ad4.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    } else if (in_array($seccion, ['perfil', 'Perfil_P', 'perfil_E', 'ADMI_Perfil_A', 'Cambiar_clave', 'pedidos_per', 'ADMI_Editar_A', 'ADMI_CambiarPass', 'Perfil_Direcciones', 'Perfil_SuperAdmi', 'CambiarClave_SuperAdmi'])) {
    ?>
        <link rel="stylesheet" href="../css/style3.css" />
        <link rel="stylesheet" href="<?php echo $cssFile; ?>" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js'></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css'>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/c8b5889ad4.js" crossorigin="anonymous"></script>
    <?php
    } else if (in_array($seccion, ['registro', 'Olvidaste', 'Olvidaste2', 'login', 'ADMI_login_A'])) {
    ?>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        <link rel="stylesheet" href="../css/style3.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
    } elseif (in_array($seccion, ['ADMI_Agregar_P', 'ADMI_editar_Producto'])) {
    ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>" />
    <?php
    } elseif (in_array($seccion, ['ADMI_Ordenes', 'ADMI_Horario2', 'ADMI_Horarios'])) {
    ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>" />
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/c8b5889ad4.js" crossorigin="anonymous"></script>
    <?php
    } elseif (in_array($seccion, ['ADMI_Editar_A'])) {
    ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
    } elseif (in_array($seccion, ['ADMI_Productos_A', 'ADMI_Bebidas_A', 'ADMI_Shop_A', 'bebidas', 'comida', 'productos', 'Perfil_Restaurantes'])) {
    ?>
        <link rel="stylesheet" href="../css/style2.css">
    <?php
    }
    ?>
</head>
