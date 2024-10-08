<?php
/**
 * Clase para cerrar la sesión actual del usuario
 */
class CerrarSession {
    /**
     * Método estático para cerrar la sesión
     *
     * Este método destruye todas las variables de sesión y opcionalmente la cookie de sesión.
     *
     * @return void
     */
    public static function cerrar() {
        // Iniciar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, también se debe destruir la cookie de sesión
        // Nota: ¡Esto destruirá la sesión, no solo los datos de la sesión!
        if (ini_get("session.use_cookies")) {
            // Obtener los parámetros de la cookie de sesión
            $params = session_get_cookie_params();
            
            // Establecer una cookie con el nombre de la sesión, pero con una fecha de expiración pasada
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();
    }
}
?>
