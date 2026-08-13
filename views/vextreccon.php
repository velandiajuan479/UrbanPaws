<?php
require_once("controllers/cextreccon.php");
?>
<div class="login-box w-100">
     <div class="row justify-content-center">
         <div class="col-md-8">                
             <div class="card card-form p-4">
                 <h2 class="text-center mb-4">Recuperación de Contraseña</h2>
                 
                 <?php if(isset($mensaje)): ?>
                    <div class="alert alert-info text-center"><?= $mensaje ?></div>
                 <?php endif; ?>

                 <form method="POST" action="">
                     <input type="hidden" name="ope" value="save">
                     
                     <div class="col-12 mb-3">
                         <label class="form-label fw-semibold">Correo Electrónico<span class="required-mark">*</span></label>
                         <input type="email" name="emailu" class="form-control" required placeholder="correo@ejemplo.com">
                     </div>
                     <div class="col-12 mb-3">
                         <label class="form-label fw-semibold">Nueva Contraseña<span class="required-mark">*</span></label>
                         <input type="password" name="nueva_pass" class="form-control" required placeholder="Mínimo 8 caracteres" minlength="8">
                         <div class="form-check">
                                 <input type="checkbox" class="form-check-input" id="showPassword">
                                 <label class="form-check-label small" for="showPassword">Mostrar contraseña</label>
                             </div>
                     </div>
                     <div class="col-12 mb-3">
                         <label class="form-label fw-semibold">Confirmar Contraseña<span class="required-mark">*</span></label>
                         <input type="password" name="confirm_pass" class="form-control" required placeholder="Repite tu contraseña">
                     </div>
                    <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                         <i class="fa-solid fa-envelope"></i> Enviar
                     </button>
                 </form>
             </div>
         </div>
     </div>
 </div>

<div class="table-container mt-4">
<h5 class="mb-3">Lista de Usuarios (Recuperaciones)</h5>
    <div class="table-responsive">
         <table class="table table-striped">
             <thead>
                 <tr>
                     <th>Nombre</th>
                     <th>Correo</th>
                     <th>Contraseña (Hash)</th>
                 </tr>
             </thead>
             <tbody id="tableBody">
    <?php if($datAll){ foreach ($datAll as $dt) { ?>
    <tr>
        <td><?= htmlspecialchars($dt['prinom'] . ' ' . $dt['priapel']) ?></td>
        <td><?= htmlspecialchars($dt['emailu']) ?></td>
        <td>
            <?php 
            echo isset($dt['passusu']) ? substr(htmlspecialchars($dt['passusu']), 0, 15) . '' : 'Sin definir'; 
            ?>
        </td>
    </tr>
    <?php }} ?>
</tbody>
         </table>
     </div>
 </div>