<?php
// Utilidades compartidas por las vistas y controladores del módulo Usuarios.
if (!function_exists('up_e')) {
    function up_e($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('up_csrf')) {
    function up_csrf() {
        if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
        if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
        return $_SESSION['csrf'];
    }
}
if (!function_exists('up_csrf_field')) {
    function up_csrf_field() { return '<input type="hidden" name="csrf" value="' . up_e(up_csrf()) . '">'; }
}
if (!function_exists('up_controller_guard')) {
    // Para controladores: exige sesión iniciada, método POST y token CSRF válido.
    function up_controller_guard($destino) {
        if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
        if (empty($_SESSION['iduser'])) { header('Location: ../index.php'); exit(); }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . $destino); exit(); }
        $token = (string) ($_POST['csrf'] ?? '');
        if (!hash_equals((string) ($_SESSION['csrf'] ?? ''), $token)) {
            http_response_code(403);
            exit('Solicitud no válida. Recarga la página e inténtalo de nuevo.');
        }
    }
}
