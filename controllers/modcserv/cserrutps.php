<?php

require_once __DIR__ . '/cserbase.php';
require_once __DIR__ . '/../../models/modmserv/mserrut.php';
require_once __DIR__ . '/../../models/musuubi.php';

$iduser = servRequireLogin();
$esAdmin = servIsAdmin($iduser);
$esPaseador = servIsPaseador($iduser);
$puedeGestionar = $esAdmin || $esPaseador;

$mserrut = new mServRut();
$musuubi = new mUsuUbi();
$datUbi = $musuubi->getAll();
$dtOn = null;
$datAll = [];
$errorRuta = null;
$errores = [];
$form = [];

$csrfToken = servCsrfToken();
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : null;
$idrut = isset($_REQUEST['idrut']) ? (int) $_REQUEST['idrut'] : 0;

if (!$puedeGestionar) {
    servFlash('danger', 'Tu usuario no tiene perfil Paseador ni Admin para gestionar rutas.');
    servRedirect(11);
}

if ($puedeGestionar && $ope === 'save') {
    if (!servIsPost() || !servCsrfValid()) {
        $errorRuta = 'No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.';
    } else {
        $form = $_POST;
        $nomrut = trim((string) ($_POST['nomrut'] ?? ''));
        $direccion_rut = trim((string) ($_POST['direccion_rut'] ?? ''));
        $referencia_rut = trim((string) ($_POST['referencia_rut'] ?? ''));
        $distrut = trim((string) ($_POST['distrut'] ?? ''));
        $idubi = (int) ($_POST['idubi'] ?? 0);
        $precioini = trim((string) ($_POST['precioini'] ?? ''));
        $horaini = trim((string) ($_POST['horaini'] ?? ''));
        $horafin = trim((string) ($_POST['horafin'] ?? ''));
        $estarut = (int) ($_POST['estarut'] ?? 1);

        if ($nomrut === '') {
            $errores[] = 'El nombre de la ruta es obligatorio.';
        }
        if ($direccion_rut === '') {
            $errores[] = 'La dirección escrita es obligatoria.';
        }
        if ($precioini === '' || !is_numeric($precioini) || (float) $precioini < 0) {
            $errores[] = 'El precio debe ser un número mayor o igual a cero.';
        }
        if ($distrut !== '' && (!is_numeric($distrut) || (float) $distrut < 0)) {
            $errores[] = 'La distancia debe ser un número mayor o igual a cero.';
        }
        if (!servHoraValida($horaini) || !servHoraValida($horafin)) {
            $errores[] = 'Las horas deben tener formato HH:MM.';
        } else {
            $minIni = servMinutos($horaini);
            $minFin = servMinutos($horafin);
            if ($minIni % 30 !== 0 || $minFin % 30 !== 0) {
                $errores[] = 'Las horas deben estar en bloques de 30 minutos.';
            }
            if ($minFin <= $minIni) {
                $errores[] = 'La hora fin debe ser mayor que la hora inicio.';
            }
        }
        if (!in_array($estarut, [1, 2], true)) {
            $errores[] = 'El estado de la ruta no es válido.';
        }

        if ($idrut > 0) {
            $mserrut->setIdrut($idrut);
            $rutaActual = $mserrut->getOne();
            if (!$rutaActual) {
                $errores[] = 'La ruta que intentas editar no existe.';
            } elseif (!$esAdmin && (int) $rutaActual['iduser'] !== $iduser) {
                $errores[] = 'No tienes permiso para editar esta ruta.';
            }
        }

        if (!$errores) {
            $mserrut->setIdrut($idrut > 0 ? $idrut : null);
            $mserrut->setNomrut($nomrut);
            $mserrut->setDistrut($distrut !== '' ? $distrut : null);
            $mserrut->setIduser($iduser);
            $mserrut->setIdubi($idubi > 0 ? $idubi : null);
            $mserrut->setEstarut($estarut);
            $mserrut->setHoraini($horaini . ':00');
            $mserrut->setHorafin($horafin . ':00');
            $mserrut->setPrecioini($precioini);
            $mserrut->setDireccionRut($direccion_rut);
            $mserrut->setReferenciaRut($referencia_rut);

            $guardado = $idrut > 0 ? $mserrut->upd() : $mserrut->save();

            if ($guardado) {
                servFlash('success', $idrut > 0 ? 'Ruta actualizada correctamente.' : 'Ruta creada correctamente.');
                servRedirect(12);
            }

            $errorRuta = 'No se pudo guardar la ruta.';
        }
    }
}

if ($puedeGestionar && $ope === 'eli' && $idrut > 0) {
    if (!servIsPost() || !servCsrfValid()) {
        $errorRuta = 'No se pudo validar la eliminación. Recarga la página e inténtalo de nuevo.';
    } else {
        $mserrut->setIdrut($idrut);
        $rutaActual = $mserrut->getOne();

        if (!$rutaActual) {
            $errorRuta = 'La ruta que intentas eliminar no existe.';
        } elseif (!$esAdmin && (int) $rutaActual['iduser'] !== $iduser) {
            $errorRuta = 'No tienes permiso para eliminar esta ruta.';
        } elseif ($mserrut->tienePaseos()) {
            $errorRuta = 'No puedes eliminar una ruta con paseos asociados. Desactívala en su lugar.';
        } elseif ($mserrut->del()) {
            servFlash('success', 'Ruta eliminada correctamente.');
            servRedirect(12);
        } else {
            $errorRuta = 'No se pudo eliminar la ruta.';
        }
    }
}

if ($puedeGestionar && $ope === 'edi' && $idrut > 0) {
    $mserrut->setIdrut($idrut);
    $rutaActual = $mserrut->getOne();
    if (!$rutaActual) {
        $errorRuta = 'La ruta que intentas editar no existe.';
    } elseif (!$esAdmin && (int) $rutaActual['iduser'] !== $iduser) {
        $errorRuta = 'No tienes permiso para editar esta ruta.';
    } else {
        $dtOn = $rutaActual;
    }
}

if ($puedeGestionar) {
    if ($esAdmin) {
        $datAll = $mserrut->getAll();
    } else {
        $mserrut->setIduser($iduser);
        $datAll = $mserrut->getByUser();
    }
}

$flash = servTakeFlash();
?>
