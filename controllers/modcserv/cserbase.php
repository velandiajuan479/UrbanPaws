<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

date_default_timezone_set('America/Bogota');

require_once __DIR__ . '/../../models/conexion.php';

function servUserId()
{
    return isset($_SESSION['iduser']) ? (int) $_SESSION['iduser'] : 0;
}

function servRequireLogin()
{
    $iduser = servUserId();
    if ($iduser <= 0) {
        header('Location: index.php');
        exit;
    }
    return $iduser;
}

function servIsPost()
{
    return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST';
}

function servCsrfToken()
{
    if (empty($_SESSION['csrf_serv'])) {
        $_SESSION['csrf_serv'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_serv'];
}

function servCsrfValid()
{
    return isset($_SESSION['csrf_serv'], $_POST['csrf_token'])
        && is_string($_POST['csrf_token'])
        && hash_equals($_SESSION['csrf_serv'], $_POST['csrf_token']);
}

function servCsrfField()
{
    return '<input type="hidden" name="csrf_token" value="' . servH(servCsrfToken()) . '">';
}

function servFlash($tipo, $mensaje)
{
    if (empty($_SESSION['serv_flash'])) {
        $_SESSION['serv_flash'] = [];
    }
    $_SESSION['serv_flash'][] = ['tipo' => $tipo, 'mensaje' => $mensaje];
}

function servTakeFlash()
{
    $flash = isset($_SESSION['serv_flash']) && is_array($_SESSION['serv_flash'])
        ? $_SESSION['serv_flash']
        : [];
    unset($_SESSION['serv_flash']);
    return $flash;
}

function servRenderFlash($flash)
{
    if (!is_array($flash) || !$flash) {
        return;
    }

    foreach ($flash as $item) {
        $tipo = isset($item['tipo']) ? $item['tipo'] : 'info';
        if (!in_array($tipo, ['success', 'danger', 'warning', 'info'], true)) {
            $tipo = 'info';
        }
        echo '<div class="alert alert-' . $tipo . '">' . servH(isset($item['mensaje']) ? $item['mensaje'] : '') . '</div>';
    }
}

function servRedirect($pg, $params = [], $fragmento = '')
{
    $url = 'home.php?pg=' . (int) $pg;
    foreach ($params as $clave => $valor) {
        if ($valor !== null && $valor !== '') {
            $url .= '&' . rawurlencode((string) $clave) . '=' . rawurlencode((string) $valor);
        }
    }
    if ($fragmento !== '') {
        $url .= '#' . rawurlencode((string) $fragmento);
    }
    header('Location: ' . $url);
    exit;
}

function servRoles($iduser)
{
    static $cache = [];

    $iduser = (int) $iduser;
    if ($iduser <= 0) {
        return [];
    }
    if (array_key_exists($iduser, $cache)) {
        return $cache[$iduser];
    }

    try {
        $sql = "SELECT GROUP_CONCAT(DISTINCT p.nomperf SEPARATOR ',') AS roles
                FROM userxper ux
                INNER JOIN perfil p ON ux.idperf = p.idperf
                WHERE ux.iduser = :iduser";
        $conexion = (new Conexion())->get_conexion();
        $result = $conexion->prepare($sql);
        $result->bindValue(":iduser", $iduser, PDO::PARAM_INT);
        $result->execute();
        $roles = (string) $result->fetchColumn();
        $cache[$iduser] = $roles !== ''
            ? array_values(array_filter(array_map('trim', explode(',', $roles))))
            : [];
        return $cache[$iduser];
    } catch (Exception $e) {
        error_log("Error al consultar roles: " . $e->getMessage());
        $cache[$iduser] = [];
        return [];
    }
}

function servHasRole($iduser, $rol)
{
    return in_array($rol, servRoles($iduser), true);
}

function servIsAdmin($iduser)
{
    return servHasRole($iduser, 'Admin');
}

function servIsPaseador($iduser)
{
    return servHasRole($iduser, 'Paseador');
}

function servIsCliente($iduser)
{
    return servHasRole($iduser, 'Cliente');
}

function servCanManageRoutes($iduser)
{
    return servIsAdmin($iduser) || servIsPaseador($iduser);
}

function servH($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function servPrice($valor)
{
    return '$' . number_format((float) $valor, 0, ',', '.');
}

function servFecha($valor)
{
    if (!$valor) {
        return '—';
    }
    $ts = strtotime($valor);
    return $ts ? date('d/m/Y H:i', $ts) : '—';
}

function servHora($valor)
{
    if (!$valor) {
        return '—';
    }
    if (preg_match('/^\d{2}:\d{2}/', (string) $valor)) {
        return substr((string) $valor, 0, 5);
    }
    $ts = strtotime($valor);
    return $ts ? date('H:i', $ts) : '—';
}

function servMinutos($hora)
{
    if (!preg_match('/^(\d{2}):(\d{2})$/', (string) $hora, $partes)) {
        return -1;
    }
    $hh = (int) $partes[1];
    $mm = (int) $partes[2];
    if ($hh > 23 || $mm > 59) {
        return -1;
    }
    return ($hh * 60) + $mm;
}

function servHoraValida($hora)
{
    return servMinutos($hora) >= 0;
}

function servBadge($estado)
{
    $clases = [
        'Solicitado' => 'warning text-dark',
        'Aceptado' => 'success',
        'Rechazado' => 'danger',
        'Cancelado' => 'secondary',
        'Terminado' => 'primary',
        'Pendiente' => 'warning text-dark',
        'Aplicada' => 'danger',
        'Pagada' => 'success',
        'Anulada' => 'secondary',
    ];
    $estado = (string) $estado;
    $clase = isset($clases[$estado]) ? $clases[$estado] : 'secondary';
    return '<span class="badge bg-' . $clase . '">' . servH($estado !== '' ? $estado : 'Sin estado') . '</span>';
}
?>
