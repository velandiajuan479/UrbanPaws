<header class="bg-primary text-white py-3 barsup">
    <div class="container d-flex justify-content-between align-items-center">
        <?php $ins = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : NULL; ?>
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fa-solid fa-paw"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">UrbanPaws</h5>
                <small class="opacity-75 d-none d-md-block">
                    <?php if($ins){
                        echo isset($_SESSION["nomusr"]) ? $_SESSION["nomusr"] : "";
                    }else{ ?>
                        Tu espacio personal para mascotas
                    <?php } ?>
                </small>
            </div>
        </div>
        <div class="d-none d-sm-block text-end">
            <?php if($ins){ ?>
                <a href="logout.php" title="Cerrar Sesión">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
                </a>
            <?php } ?>
        </div>
    </div>
</header>