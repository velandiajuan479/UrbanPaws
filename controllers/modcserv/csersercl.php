<?php

require_once __DIR__ . '/cserbase.php';
require_once __DIR__ . '/../../models/modmserv/mserpas.php';

$iduser = servRequireLogin();
$esAdmin = servIsAdmin($iduser);
$esPaseador = servIsPaseador($iduser);
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : null;
$datAll = [];
$datMul = [];
$errorServicio = null;

$mserpas = new mServPas();

if ($ope === 'cancelar') {
    $idpas = isset($_POST['idpas']) ? (int) $_POST['idpas'] : 0;

    if (!servIsPost() || !servCsrfValid()) {
        $errorServicio = 'No se pudo validar la cancelación. Recarga la página e inténtalo de nuevo.';
    } elseif ($idpas <= 0) {
        $errorServicio = 'El paseo indicado no es válido.';
    } else {
        $mserpas->setIdpas($idpas);
        $paseo = $mserpas->getOne();

        if (!$paseo) {
            $errorServicio = 'El paseo no existe.';
        } elseif (!$esAdmin && (int) $paseo['iduser'] !== $iduser) {
            $errorServicio = 'No tienes permiso para cancelar este paseo.';
        } elseif (!in_array($paseo['estapas'], ['Solicitado', 'Aceptado'], true)) {
            $errorServicio = 'Este paseo ya no se puede cancelar.';
        } else {
            $motivo = trim((string) ($_POST['motivo'] ?? ''));
            if ($motivo === '') {
                $motivo = 'Cancelado por el usuario.';
            }

            $aplicarAdvertencia = !$esAdmin && (int) $paseo['iduser'] === $iduser;
            $resultado = $mserpas->cancelar($idpas, $iduser, $motivo, $aplicarAdvertencia);

            if ($resultado !== false) {
                if ($resultado['sancion'] === 'Pendiente') {
                    servFlash('warning', 'Paseo cancelado. Se registró una multa automática pendiente de revisión por el administrador.');
                } elseif ($resultado['tardia']) {
                    servFlash('warning', 'Paseo cancelado con menos de 12 horas de antelación. Se registró una advertencia.');
                } else {
                    servFlash('success', 'Paseo cancelado correctamente.');
                }
                servRedirect(15);
            }

            $errorServicio = 'No se pudo cancelar el paseo.';
        }
    }
}

if ($ope === 'mul_save') {
    if (!$esAdmin) {
        servFlash('danger', 'No tienes permiso para administrar multas.');
        servRedirect(15);
    }

    if (!servIsPost() || !servCsrfValid()) {
        $errorServicio = 'No se pudo validar la multa. Recarga la página e inténtalo de nuevo.';
    } else {
        $iduserSancion = (int) ($_POST['iduser_sancion'] ?? 0);
        $estado = isset($_POST['sancionusr']) ? trim((string) $_POST['sancionusr']) : '';
        $multa = isset($_POST['multausr']) ? $_POST['multausr'] : 0;
        $veto = isset($_POST['vetousr']) ? 1 : 0;

        if ($iduserSancion <= 0) {
            $errorServicio = 'El usuario indicado no es válido.';
        } elseif ($mserpas->actualizarSancion($iduserSancion, $estado, $multa, $veto)) {
            servFlash('success', 'Sanción actualizada correctamente.');
            servRedirect(15, [], 'multas');
        } else {
            $errorServicio = 'No se pudo actualizar la sanción.';
        }
    }
}

if ($esAdmin) {
    $datAll = $mserpas->getAll();
    $datMul = $mserpas->getSanciones();
} elseif ($esPaseador) {
    $mserpas->setIduser($iduser);
    $datAll = $mserpas->getByPaseador();
} else {
    $mserpas->setIduser($iduser);
    $datAll = $mserpas->getByCliente();
}

$flash = servTakeFlash();
?>
