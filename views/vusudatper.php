<?php
require_once 'models/musudatper.php';
require_once 'models/musuubi.php';

// TODO: cuando el login (módulo ext) esté conectado, reemplazar esta línea
// por el iduser real de la sesión, ej: $iduser = $_SESSION['iduser'];
$iduser = isset($_GET['iduser']) ? $_GET['iduser'] : 1;

$datper = new mUsuDatPer();
$usuario = $datper->getOne($iduser);

$ubiModel = new mUsuUbi();
$ubicaciones = $ubiModel->getAll();

$ok = isset($_GET['ok']) ? $_GET['ok'] : NULL;
?>

<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-id-card"></i>
        Datos Personales
    </h4>

    <?php if($ok == 1){ ?>
        <div class="alert alert-success">Datos actualizados correctamente.</div>
    <?php } ?>

    <?php if($usuario){ ?>
    <form action="controllers/cusudatper.php" method="POST" class="row g-3">
        <input type="hidden" name="ope" value="actualizar">
        <input type="hidden" name="iduser" value="<?=$usuario['iduser'];?>">

        <!--Primer nombre-->
        <div class="col-md-6">
            <label for="prinom" class="form-label">Primer Nombre</label>
            <input type="text" class="form-control" name="prinom" id="prinom" value="<?=$usuario['prinom'];?>" required>
        </div>
        <!--Segundo nombre-->
        <div class="col-md-6">
            <label for="seconom" class="form-label">Segundo Nombre</label>
            <input type="text" class="form-control" name="seconom" id="seconom" value="<?=$usuario['seconom'];?>">
        </div>
        <!--Primer apellido-->
        <div class="col-md-6">
            <label for="priapel" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" name="priapel" id="priapel" value="<?=$usuario['priapel'];?>" required>
        </div>
        <!--Correo-->
        <div class="col-md-6">
            <label for="emailu" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" name="emailu" id="emailu" value="<?=$usuario['emailu'];?>" required>
        </div>
        <!--Teléfono-->
        <div class="col-md-6">
            <label for="teleu" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="teleu" id="teleu" value="<?=$usuario['teleu'];?>">
        </div>
        <!--Ubicación-->
        <div class="col-md-6">
            <label for="idubi" class="form-label">Ciudad / Ubicación</label>
            <select class="form-control" name="idubi" id="idubi" required>
                <option value="">Seleccione...</option>
                <?php if($ubicaciones){ foreach ($ubicaciones as $u) { ?>
                    <option value="<?=$u['idubi'];?>" <?= ($u['idubi'] == $usuario['idubi']) ? 'selected' : ''; ?>>
                        <?=$u['nomubi'];?> - <?=$u['depaubi'];?>
                    </option>
                <?php }} ?>
            </select>
        </div>

        <!--Botones-->
        <div class="col-md-12 mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent">
                <i class="fa-solid fa-trash fa-xl"></i>
            </button>
        </div>
    </form>
    <?php } else { ?>
        <p class="text-center">No se encontró información del usuario.</p>
    <?php } ?>
</div>