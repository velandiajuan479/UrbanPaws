<?php require_once("controllers/cusuadmin.php"); ?>

<section class="welcome-panel" aria-labelledby="admin-welcome">
    <div>
        <span class="eyebrow">Administración UrbanPaws</span>
        <h1 id="admin-welcome">Una vista clara para cuidar cada detalle.</h1>
        <p>Crea y edita usuarios, asigna roles y define qué páginas trabaja cada perfil.</p>
    </div>
    <div class="welcome-art" aria-hidden="true"><i class="fa-solid fa-leaf"></i></div>
</section>

<?php if (!empty($msgOk)) { ?>
    <div class="alert alert-success" role="alert"><?= htmlspecialchars($msgOk, ENT_QUOTES, 'UTF-8') ?></div>
<?php } ?>
<?php if (!empty($msgErr)) { ?>
    <div class="alert alert-danger" role="alert"><?= htmlspecialchars($msgErr, ENT_QUOTES, 'UTF-8') ?></div>
<?php } ?>

<!-- ============== FORMULARIO USUARIO ============== -->
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-<?= $dtOn ? 'user-pen' : 'user-plus' ?>"></i>
        <?= $dtOn ? 'Editar usuario' : 'Nuevo usuario' ?>
    </h4>

    <form action="home.php?pg=2&ope=save" method="POST" class="row g-3">
        <input type="hidden" name="iduser" value="<?= $dtOn ? (int) $dtOn['iduser'] : '' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <!-- Documento -->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label class="form-label">Documento <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="docu" inputmode="numeric" required
                   placeholder="Ej: 1072658359"
                   value="<?= $dtOn ? htmlspecialchars($dtOn['docu'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <!-- Correo -->
        <div class="col-md-4">
            <i class="fa-solid fa-envelope"></i>
            <label class="form-label">Correo electrónico <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="emailu" required
                   placeholder="Ej: usuario@correo.com"
                   value="<?= $dtOn ? htmlspecialchars($dtOn['emailu'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <!-- Teléfono -->
        <div class="col-md-4">
            <i class="fa-solid fa-phone"></i>
            <label class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="teleu"
                   placeholder="Ej: 3001234567"
                   value="<?= $dtOn ? htmlspecialchars($dtOn['teleu'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <!-- Nombres -->
        <div class="col-md-4">
            <i class="fa-solid fa-address-card"></i>
            <label class="form-label">Primer nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="prinom" required
                   placeholder="Ej: Martin"
                   value="<?= $dtOn ? htmlspecialchars($dtOn['prinom'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <div class="col-md-4">
            <i class="fa-solid fa-address-card"></i>
            <label class="form-label">Segundo nombre</label>
            <input type="text" class="form-control" name="seconom"
                   value="<?= $dtOn ? htmlspecialchars($dtOn['seconom'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <!-- Apellidos -->
        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label">Primer apellido <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="priapel" required
                   placeholder="Ej: Cortes"
                   value="<?= $dtOn ? htmlspecialchars($dtOn['priapel'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label">Segundo apellido</label>
            <input type="text" class="form-control" name="segapel"
                   value="<?= $dtOn && isset($dtOn['segapel']) ? htmlspecialchars($dtOn['segapel'], ENT_QUOTES, 'UTF-8') : '' ?>">
        </div>

        <!-- Contraseña -->
        <div class="col-md-4">
            <i class="fa-solid fa-lock"></i>
            <label class="form-label">
                Contraseña <?= $dtOn ? '<small>(opcional)</small>' : '<span class="text-danger">*</span>' ?>
            </label>
            <input type="password" class="form-control" name="passusu" minlength="6"
                   autocomplete="new-password"
                   <?= $dtOn ? '' : 'required' ?>
                   placeholder="<?= $dtOn ? 'Deja vacío para no cambiarla' : 'Mínimo 6 caracteres' ?>">
        </div>

        <!-- Rol (perfil) -->
        <div class="col-md-4">
            <i class="fa-solid fa-user-shield"></i>
            <label class="form-label">Rol (perfil) <span class="text-danger">*</span></label>
            <select name="idperf" class="form-control form-select" required>
                <option value="">Seleccionar rol...</option>
                <?php if ($datPerf) { foreach ($datPerf as $perf) { ?>
                    <option value="<?= (int) $perf['idperf'] ?>"
                        <?= in_array((int) $perf['idperf'], $rolesUsuario, true) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($perf['nomperf'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php }} ?>
            </select>
        </div>

        <!-- Estado -->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label class="form-label">Estado</label>
            <select name="estusr" class="form-control form-select">
                <?php
                $estActual = $dtOn ? (int) $dtOn['estusr'] : 1;
                $estados = array(1 => 'Activo', 0 => 'Inactivo / Pendiente', 2 => 'Rechazado');
                foreach ($estados as $valorEst => $textoEst) { ?>
                    <option value="<?= $valorEst ?>" <?= $estActual === $valorEst ? 'selected' : '' ?>>
                        <?= $textoEst ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Botones -->
        <div class="col-md-12 mt-4 text-end">
            <?php if ($dtOn) { ?>
                <a href="home.php?pg=2" class="btn btn-secondary" aria-label="Cancelar edición">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar usuario">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent" aria-label="Limpiar formulario">
                <i class="fa-solid fa-trash fa-xl"></i>
            </button>
        </div>
    </form>
</div>

<!-- ============== LISTADO DE USUARIOS ============== -->
<div class="card card-form mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list"></i>
        Lista de usuarios
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol(es)</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($datAll) { foreach ($datAll as $dt) { ?>
                    <tr>
                        <td><?= htmlspecialchars($dt['docu'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?= htmlspecialchars(trim($dt['prinom'] . ' ' . $dt['seconom'] . ' ' . $dt['priapel']), ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td><?= htmlspecialchars($dt['emailu'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $dt['teleu'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php if (!empty($dt['nomperf'])) { ?>
                                <span class="badge bg-primary"><?= htmlspecialchars($dt['nomperf'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Sin rol</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ((int) $dt['estusr'] === 1) { ?>
                                <span class="badge bg-success">Activo</span>
                            <?php } elseif ((int) $dt['estusr'] === 2) { ?>
                                <span class="badge bg-danger">Rechazado</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="home.php?pg=2&ope=edi&iduser=<?= (int) $dt['iduser'] ?>" title="editar"
                               aria-label="Editar usuario <?= htmlspecialchars($dt['prinom'], ENT_QUOTES, 'UTF-8') ?>">
                                <i class="fa-solid fa-pencil fa-2x"></i>
                            </a>
                            <a href="home.php?pg=2&ope=eli&iduser=<?= (int) $dt['iduser'] ?>" title="borrar"
                               onclick="return confirm('¿Está seguro que desea eliminar este usuario?');"
                               aria-label="Eliminar usuario <?= htmlspecialchars($dt['prinom'], ENT_QUOTES, 'UTF-8') ?>">
                                <i class="fa-solid fa-trash-can fa-2x"></i>
                            </a>
                        </td>
                    </tr>
                <?php }} else { ?>
                    <tr>
                        <td colspan="7">No hay usuarios registrados.</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol(es)</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- ============== MATRIZ DE PAGINAS POR PERFIL ============== -->
<div class="card card-form mt-4">
    <h5 class="section-title">
        <i class="fa-solid fa-table-cells"></i>
        Páginas que trabaja cada perfil
    </h5>
    <p class="mb-3">
        Marca las páginas disponibles para <strong>Cliente</strong>, <strong>Paseador</strong> y
        <strong>Admin</strong>. Las casillas sin marcar quedarán sin acceso para ese perfil.
    </p>

    <form action="home.php?pg=2&ope=savepag" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Página</th>
                        <?php if ($datPerf) { foreach ($datPerf as $perf) { ?>
                            <th class="text-center">
                                <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
                                <?= htmlspecialchars($perf['nomperf'], ENT_QUOTES, 'UTF-8') ?>
                            </th>
                        <?php }} ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datPag) { foreach ($datPag as $pag) { ?>
                        <tr>
                            <td>
                                <i class="<?= htmlspecialchars($pag['icopag'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                                <strong><?= htmlspecialchars($pag['titpag'], ENT_QUOTES, 'UTF-8') ?></strong>
                                <br>
                                <small>
                                    <?= htmlspecialchars($pag['nompag'], ENT_QUOTES, 'UTF-8') ?> &nbsp;|&nbsp;
                                    <?= htmlspecialchars($pag['rutpag'], ENT_QUOTES, 'UTF-8') ?>
                                    <?php if ($pag['mostpag'] != '1') { ?>
                                        &nbsp;|&nbsp; <span class="badge bg-secondary">En preparación</span>
                                    <?php } ?>
                                </small>
                            </td>
                            <?php if ($datPerf) { foreach ($datPerf as $perf) {
                                $idp = (int) $perf['idperf'];
                                $asignadas = isset($datMatriz[$idp]) ? $datMatriz[$idp] : array();
                                $marcado = in_array((int) $pag['idpag'], $asignadas); ?>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input"
                                           name="pagxper[<?= $idp ?>][]"
                                           value="<?= (int) $pag['idpag'] ?>"
                                           <?= $marcado ? 'checked' : '' ?>>
                                </td>
                            <?php } } ?>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td colspan="4">No hay páginas registradas. Crea las páginas desde
                                <a href="home.php?pg=23">Páginas</a>.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary" aria-label="Guardar páginas por perfil">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
                Guardar páginas por perfil
            </button>
        </div>
    </form>
</div>
