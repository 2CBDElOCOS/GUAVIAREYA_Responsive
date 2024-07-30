<?php

// Definir rutas permitidas
$routes = [
    '' => 'home',
    'productos' => 'productos',
    'restaurantes' => 'restaurantes',
    'terminos' => 'terminos',
    'tarjeta' => 'tarjeta',
    'shop' => 'shop',
    'registro' => 'registro',
    'politicas' => 'politicas',
    'perfil' => 'perfil',
    'login' => 'login',
    'contactanos' => 'contactanos',
    'comida' => 'comida',
    'carrito' => 'carrito',
    'ADMI_Agregar_P' => 'ADMI_Agregar_P',
    'ADMI_CambiarPass' => 'ADMI_CambiarPass',
    'ADMI_Comida_A' => 'ADMI_Comida_A',
    'ADMI_Editar_A' => 'ADMI_Editar_A',
    'ADMI_editar_Producto' => 'ADMI_editar_Producto',
    'ADMI_Horario2' => 'ADMI_Horario2',
    'ADMI_Horarios' => 'ADMI_Horarios',
    'ADMI_login_A' => 'ADMI_login_A',
    'ADMI_Ordenes' => 'ADMI_Ordenes',
    'ADMI_Perfil_A' => 'ADMI_Perfil_A',
    'ADMI_Productos_A' => 'ADMI_Productos_A',
    'ADMI_Shop_A' => 'ADMI_Shop_A',
    'Cambiar_clave' => 'Cambiar_clave',
    'confirmacion' => 'confirmacion',
    'facturacion' => 'facturacion',
    'home' => 'home',
    'Olvidaste' => 'Olvidaste',
    'Olvidaste2' => 'Olvidaste2',
    'pago' => 'pago',
    'pedidos_per' => 'pedidos_per',
    'Perfil_Direcciones' => 'Perfil_Direcciones',
    'Perfil_E' => 'Perfil_E',
    'Perfil_P' => 'Perfil_P',
    'SUPER_add_administrador' => 'SUPER_add_administrador',
    'SUPER_add' => 'SUPER_add',
    'SuperAdmin_Panel' => 'SuperAdmin_Panel',
    // Agrega más rutas según sea necesario
];

// Obtener la ruta solicitada
$request = trim($_SERVER['REQUEST_URI'], '/');

// Quitar el prefijo de la carpeta si es necesario
$request = str_replace('guaviare/pagina_guaviare/', '', $request);

// Verificar si la ruta existe en las rutas definidas
if (array_key_exists($request, $routes)) {
    $seccion = $routes[$request];
} else {
    // Mostrar error 404 si la ruta no existe
    header("HTTP/1.0 404 Not Found");
    $seccion = '404';
}

header("Location: controladores/controlador.php?seccion=$seccion");
exit();
