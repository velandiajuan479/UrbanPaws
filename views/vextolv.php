<?php
require_once("controllers/cextolv.php");
?>
<div class="table-container mt-6 mx-auto" style="max-width: 700px;">
    <div class="table-responsive">
        <h5 class="text-center mb-4">¿Olvidó su contraseña?</h5>

        <!-- Formulario corregido: sin action duplicado, con ope=save, name="emailu" -->
        <form method="post" action="" class="mb-5">
            <input type="hidden" name="ope" value="save">
            <div class="mb-3">
                <label for="emailu" class="form-label d-block fw-semibold">
                    Ingrese su correo electrónico vinculado
                </label>
                <!-- name="emailu" coincide con lo que captura el controlador -->
                <input type="email" name="emailu" class="form-control" placeholder="ejemplo@ejemplo.com" required>
            </div>
            <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                <i class="fa-solid fa-envelope"></i> Enviar
            </button>
        </form>

        <!-- Tabla con columnas reales de la tabla usuario -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Clave Temporal</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if($datAll){ foreach ($datAll as $dt) { ?>
                <tr>
                    <td><?= htmlspecialchars($dt['prinom'] . ' ' . $dt['priapel']) ?></td>
                    <td><?= htmlspecialchars($dt['emailu']) ?></td>
                    <td>
                        <?= !empty($dt['claveu']) ? htmlspecialchars($dt['claveu']) : '<span class="text-muted">Sin generar</span>' ?>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>
</div>