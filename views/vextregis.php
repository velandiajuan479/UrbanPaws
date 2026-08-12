
<div class="card card-form p-4 mb-5 d-flex flex-column align-items-center justify-content-center">
<div style="max-width: 320px; margin: 30px auto; font-family: sans-serif;">
    
    <div style="margin-bottom: 15px;">
        <h2 style="font-size: 1.4rem; margin: 0;">Registrarse</h2>
    </div>

    <!-- Mostrar mensaje si existe -->
    <?php if(isset($mensaje) && $mensaje != ""): ?>
        <div style="padding: 10px; background-color: #f8d7da; color: #721c24; margin-bottom: 15px; border: 1px solid #f5c6cb;">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <form action="cextregis.php?ope=save" method="POST">
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Nombre*</label>
            <input type="text" name="prinom" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Apellido*</label>
            <input type="text" name="priapel" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Gmail*</label>
            <input type="email" name="emailu" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Contraseña*</label>
            <input type="password" name="passusu" id="passReg" style="width: 100%; padding: 8px; box-sizing: border-box;" required>
            <div style="margin-top: 5px;">
                <input type="checkbox" onclick="var x=document.getElementById('passReg');x.type=x.type==='password'?'text':'password';"> 
                <span style="font-size: 12px;">Mostrar contraseña</span>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" style="width: 100%; padding: 10px; background-color: #333; color: white; border: none; cursor: pointer;">
                Registrarse
            </button>
        </div>

    </form>
</div>
</div>