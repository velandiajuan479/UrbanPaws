<?php

require_once __DIR__ . '/cserbase.php';
require_once __DIR__ . '/../../models/modmserv/mserrut.php';
require_once __DIR__ . '/../../models/modmserv/mserpas.php';
require_once __DIR__ . '/../../models/mcofval.php';

$iduser = servRequireLogin();
$idrut = isset($_REQUEST['idrut']) ? (int) $_REQUEST['idrut'] : 0;
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : null;

$mserrut = new mServRut();
$mserpas = new mServPas();
$dtRut = null;
$errores = [];
$form = [];
$flash = servTakeFlash();

if ($idrut > 0) {
    $mserrut->setIdrut($idrut);
    $dtRut = $mserrut->getOne();
}

$mcofval = new mCofVal();
$mcofval->setIddom(5);
$datServ = $mcofval->getByDom();

if ($ope === 'save') {
    $form = $_POST;

    if (!servIsPost() || !servCsrfValid()) {
        $errores[] = 'No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.';
    } elseif (!$dtRut) {
        $errores[] = 'La ruta seleccionada no existe.';
    } elseif ((int) $dtRut['estarut'] !== 1) {
        $errores[] = 'La ruta seleccionada no está activa.';
    } else {
        $fecha = trim((string) ($_POST['fecha'] ?? ''));
        $horaInicio = trim((string) ($_POST['hora_inicio'] ?? ''));
        $horaFin = trim((string) ($_POST['hora_fin'] ?? ''));
        $idmasc = (int) ($_POST['idmasc'] ?? 0);
        $servtipo = trim((string) ($_POST['servtipo'] ?? 'Individual'));
        $descserv = trim((string) ($_POST['descserv'] ?? ''));

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            $errores[] = 'La fecha no es válida.';
        } else {
            [$anio, $mes, $dia] = array_map('intval', explode('-', $fecha));
            if (!checkdate($mes, $dia, $anio)) {
                $errores[] = 'La fecha no es válida.';
            }
        }

        $servtiposValidos = [];
        foreach ((array) $datServ as $serv) {
            if (isset($serv['codval'])) {
                $servtiposValidos[] = $serv['codval'];
            }
        }
        if ($servtiposValidos && !in_array($servtipo, $servtiposValidos, true)) {
            $errores[] = 'El tipo de servicio no es válido.';
        }

        if (!servHoraValida($horaInicio) || !servHoraValida($horaFin)) {
            $errores[] = 'Las horas deben tener formato HH:MM.';
        } else {
            $minIni = servMinutos($horaInicio);
            $minFin = servMinutos($horaFin);
            if ($minIni % 30 !== 0 || $minFin % 30 !== 0) {
                $errores[] = 'Las horas deben estar en bloques de 30 minutos.';
            }
            if ($minFin - $minIni < 30) {
                $errores[] = 'El paseo debe durar al menos 30 minutos.';
            }

            $minRutaIni = servMinutos($dtRut['horaini_fmt']);
            $minRutaFin = servMinutos($dtRut['horafin_fmt']);
            if ($minRutaIni >= 0 && $minIni < $minRutaIni) {
                $errores[] = 'La hora de inicio está fuera del horario de la ruta.';
            }
            if ($minRutaFin >= 0 && $minFin > $minRutaFin) {
                $errores[] = 'La hora de fin está fuera del horario de la ruta.';
            }
        }

        $inicio = $fecha !== '' && servHoraValida($horaInicio) ? $fecha . ' ' . $horaInicio . ':00' : null;
        $fin = $fecha !== '' && servHoraValida($horaFin) ? $fecha . ' ' . $horaFin . ':00' : null;

        if ($inicio && strtotime($inicio) < time() + 86400) {
            $errores[] = 'El paseo debe agendarse con al menos 24 horas de antelación.';
        }

        if ($idmasc <= 0) {
            $errores[] = 'Selecciona una mascota.';
        } elseif (!$mserpas->mascotaPertenece($idmasc, $iduser)) {
            $errores[] = 'La mascota seleccionada no pertenece a tu cuenta.';
        }

        if ($inicio && $fin && (int) $dtRut['iduser'] > 0 && $mserpas->hayCruce((int) $dtRut['iduser'], $inicio, $fin)) {
            $errores[] = 'El paseador ya tiene un paseo en ese horario.';
        }

        if (!$errores) {
            $mserpas->setEstapas('Solicitado');
            $mserpas->setServtipo($servtipo !== '' ? $servtipo : 'Individual');
            $mserpas->setInicioProgramado($inicio);
            $mserpas->setFinProgramado($fin);
            $mserpas->setIdmasc($idmasc);
            $mserpas->setIdrut($idrut);
            $mserpas->setIduser($iduser);
            $mserpas->setDescserv($descserv);
            $mserpas->setIdpaseador((int) $dtRut['iduser']);
            $mserpas->setPrecioPactado($dtRut['precioini']);
            $mserpas->setDireccionPactada($dtRut['direccion_rut']);
            $mserpas->setReferenciaPactada($dtRut['referencia_rut']);

            $idpas = $mserpas->save();

            if ($idpas) {
                servFlash('success', 'Paseo solicitado correctamente. El paseador debe aceptarlo.');
                servRedirect(15);
            }

            $errores[] = 'No se pudo guardar la solicitud de paseo.';
        }
    }
}

if (!$form) {
    $form = [
        'fecha' => date('Y-m-d', strtotime('+1 day')),
        'hora_inicio' => $dtRut ? $dtRut['horaini_fmt'] : '',
        'hora_fin' => $dtRut ? $dtRut['horafin_fmt'] : '',
        'idmasc' => '',
        'servtipo' => 'Individual',
        'descserv' => '',
    ];
}

$mserpas->setIduser($iduser);
$datMas = $mserpas->getMascotasByUser();
?>
