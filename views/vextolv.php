<div class="table-container mt-6 mx-auto" style="max-width: 600px;">

    <div class="table-responsive">
        <h5 class="text-center">¿Olvido su contraseña?</h5>
        <form method="post" action="" class="mb-5" action="colv.php" method="post">
            <div class="mb-3">
                <label for="emaper" class="form-label d-block ">Ingrese su correo electrónico vinculado</label>
                <input type="email" name="emaper" class="form-control" placeholder="ejemplo@ejem.com" required>
            </div>
            <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                            <i class="fa-solid fa-envelope"></i> Enviar
            </button>
        </form>
        <table class="table table-striped">
            <tbody id="tableBody">
                <?php if($datAll){ foreach ($datAll as $dt) {?>
                <tr>
                    <td><?php echo $dt["emaper"]; ?></td>                           
                    <td><?php echo $dt["pasper"]; ?></td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>                          
</div>                     