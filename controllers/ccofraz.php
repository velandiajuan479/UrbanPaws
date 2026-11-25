<?php
require_once __DIR__ . '/../models/mcofraz.php';
require_once __DIR__ . '/../models/mcofval.php';

if (empty($_SESSION['token_cofraz'])) {
    $_SESSION['token_cofraz'] = bin2hex(random_bytes(32));
}

$mcofraz = new mCofraz();
$mcofval = new mCofval();
$datEst = array_values(array_filter($mcofval->getAll() ?: [], static function ($valor) {
    return (int) $valor['iddom'] === 1 && in_array((int) $valor['idval'], [1, 2], true);
}));
$errorRaza = null;
$nombreRaza = '';
$idrazEditar = 0;
$estadoFormulario = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacion = isset($_POST['ope']) && is_string($_POST['ope']) ? $_POST['ope'] : '';
    $idrazEditar = filter_var($_POST['idraz'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0;
    $tokenValido = isset($_POST['csrf_token']) && is_string($_POST['csrf_token'])
        && hash_equals($_SESSION['token_cofraz'], $_POST['csrf_token']);

    if (!$tokenValido) {
        $errorRaza = 'No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.';
    } elseif ($operacion === 'toggle') {
        if ($idrazEditar && $mcofraz->toggle($idrazEditar)) {
            header('Location: home.php?pg=25&seccion=razas&resultado=estado');
            exit();
        }
        $errorRaza = 'No se pudo cambiar el estado de la raza.';
    } elseif ($operacion === 'eli') {
        if ($idrazEditar && $mcofraz->delete($idrazEditar)) {
            header('Location: home.php?pg=25&seccion=razas&resultado=eliminada');
            exit();
        }
        $errorRaza = 'No se pudo eliminar. La raza puede estar asociada a mascotas existentes.';
    } elseif ($operacion !== 'save') {
        $errorRaza = 'La operación solicitada no es válida.';
    } else {
        $nombreRaza = isset($_POST['nomraz']) && is_string($_POST['nomraz']) ? trim($_POST['nomraz']) : '';
        $estadoRaza = filter_var($_POST['actraz'] ?? null, FILTER_VALIDATE_INT);
        $estadoFormulario = $estadoRaza ?: 1;
        if ($nombreRaza === '' || (function_exists('mb_strlen') ? mb_strlen($nombreRaza, 'UTF-8') : strlen($nombreRaza)) > 255) {
            $errorRaza = 'Escribe un nombre de hasta 255 caracteres.';
        } elseif (!in_array($estadoRaza, array_map(static function ($estado) { return (int) $estado['idval']; }, $datEst), true)) {
            $errorRaza = 'Selecciona un estado válido para la raza.';
        } else {
            $actraz = $estadoRaza === 1 ? 1 : 0;
            $guardado = $idrazEditar
                ? $mcofraz->update($idrazEditar, $nombreRaza, $actraz)
                : $mcofraz->save($nombreRaza, $actraz);
            if ($guardado) {
                header('Location: home.php?pg=25&seccion=razas&resultado=' . ($idrazEditar ? 'actualizada' : 'guardada'));
                exit();
            }
            $errorRaza = 'No se pudo guardar la raza. Comprueba que no esté registrada y vuelve a intentarlo.';
        }
    }
} elseif (isset($_GET['ope'], $_GET['idraz']) && $_GET['ope'] === 'edi') {
    $id = filter_var($_GET['idraz'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $razaEditar = $id ? $mcofraz->getOne($id) : false;
    if ($razaEditar) {
        $idrazEditar = (int) $razaEditar['idraz'];
        $nombreRaza = (string) $razaEditar['nomraz'];
        $estadoFormulario = (int) $razaEditar['actraz'] === 1 ? 1 : 2;
    }
}

$razasMascotas = $mcofraz->getAll();
?>
