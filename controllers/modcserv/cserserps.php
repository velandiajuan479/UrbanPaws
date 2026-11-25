<?php

require_once __DIR__ . '/cserbase.php';
require_once __DIR__ . '/../../models/modmserv/mserpas.php';

$iduser = servRequireLogin();
$esAdmin = servIsAdmin($iduser);
$esPaseador = servIsPaseador($iduser);
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : null;
$idpas = isset($_POST['idpas']) ? (int) $_POST['idpas'] : 0;
$errorSolicitud = null;
$datAll = [];

if (!$esAdmin && !$esPaseador) {
    servFlash('danger', 'Tu usuario no tiene perfil Paseador ni Admin para ver solicitudes.');
    servRedirect(11);
}

$mserpas = new mServPas();

if ($ope === 'aceptar' || $ope === 'rechazar') {
    if (!servIsPost() || !servCsrfValid()) {
        $errorSolicitud = 'No se pudo validar la acción. Recarga la página e inténtalo de nuevo.';
    } elseif ($idpas <= 0) {
        $errorSolicitud = 'La solicitud indicada no es válida.';
    } else {
        $mserpas->setIdpas($idpas);
        $paseo = $mserpas->getOne();

        if (!$paseo) {
            $errorSolicitud = 'La solicitud no existe.';
        } elseif (!$esAdmin && (int) $paseo['idpaseador_real'] !== $iduser) {
            $errorSolicitud = 'No tienes permiso para responder esta solicitud.';
        } elseif ($paseo['estapas'] !== 'Solicitado') {
            $errorSolicitud = 'Solo se pueden responder solicitudes en estado Solicitado.';
        } elseif ($ope === 'aceptar' && $mserpas->hayCruce((int) $paseo['idpaseador_real'], $paseo['inicio_programado'], $paseo['fin_programado'], $idpas)) {
            $errorSolicitud = 'No se puede aceptar: el paseador ya tiene otro paseo en ese horario.';
        } else {
            $mserpas->setIdpas($idpas);
            $mserpas->setEstapas($ope === 'aceptar' ? 'Aceptado' : 'Rechazado');

            if ($mserpas->updEstado()) {
                servFlash('success', $ope === 'aceptar' ? 'Solicitud aceptada.' : 'Solicitud rechazada.');
                servRedirect(14);
            }

            $errorSolicitud = 'No se pudo actualizar la solicitud.';
        }
    }
}

if ($esAdmin) {
    $datAll = $mserpas->getAll();
} else {
    $mserpas->setIduser($iduser);
    $datAll = $mserpas->getByPaseador();
}

$flash = servTakeFlash();
?>
