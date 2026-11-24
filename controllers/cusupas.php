<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../models/musupas.php';
require_once __DIR__ . '/../models/musuperm.php';

$pasId = (int) $_SESSION['iduser'];
$pasNombre = trim((string) ($_SESSION['prinom'] ?? $_SESSION['nomusr'] ?? 'Paseador'));
$pasNombre = $pasNombre !== '' ? $pasNombre : 'Paseador';
$pasRol = trim((string) ($_SESSION['nomperf'] ?? ''));
if ($pasRol === '') {
    $pasRol = up_permisos()->getNombreRol();
}
$pasRol = $pasRol !== '' ? $pasRol : 'Paseador UrbanPaws';

$pasModelo = new mUsuPas();
$pasModelo->setIduser($pasId);
$resumenPas = $pasModelo->getResumen();
$solicitudesPas = $pasModelo->getSolicitudes(6);
$rutasPas = $pasModelo->getRutas(6);
$errorPas = $pasModelo->getError();

if (!function_exists('pas_clase_estado')) {
    function pas_clase_estado($estado)
    {
        switch (strtoupper(trim((string) $estado))) {
            case 'SOLICITADO':
            case 'PENDIENTE':
                return 'bg-warning text-dark';
            case 'ACEPTADO':
            case 'APROBADO':
                return 'bg-primary';
            case 'TERMINADO':
            case 'FINALIZADO':
            case 'COMPLETADO':
                return 'bg-success';
            case 'RECHAZADO':
            case 'CANCELADO':
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }
}

if (!function_exists('pas_texto_estado')) {
    function pas_texto_estado($estado)
    {
        $estado = strtoupper(trim((string) $estado));
        $etiquetas = array(
            'SOLICITADO' => 'Solicitado',
            'PENDIENTE' => 'Pendiente',
            'ACEPTADO' => 'Aceptado',
            'APROBADO' => 'Aceptado',
            'TERMINADO' => 'Terminado',
            'FINALIZADO' => 'Terminado',
            'COMPLETADO' => 'Terminado',
            'RECHAZADO' => 'Rechazado',
            'CANCELADO' => 'Cancelado',
        );
        return isset($etiquetas[$estado]) ? $etiquetas[$estado] : ($estado !== '' ? ucfirst(strtolower($estado)) : 'Sin estado');
    }
}

if (!function_exists('pas_fecha')) {
    function pas_fecha($valor)
    {
        if (empty($valor)) {
            return 'Sin fecha';
        }
        $marca = strtotime((string) $valor);
        return $marca !== false ? date('d/m/Y H:i', $marca) : 'Sin fecha';
    }
}
?>
