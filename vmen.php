<?php require_once("controllers/cmen.php"); ?>

<nav id="navbar">
    <ul class="navbar-items flexbox-col">
        <li class="navbar-logo flexbox-left">
            <div class="flexbox">
                <div class="logo-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">SIREMC</h6>
                </div>
            </div>
        </li>
    <?php if($datMen){ foreach($datMen AS $dm){ ?>
        <li class="navbar-item flexbox-left">
            <a href="home.php?pg=<?=$dm["idpag"];?>" class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <i class="<?=$dm["icopag"];?>"></i>
                </div>
                <span class="link-text"><?=$dm["nompag"];?></span>
            </a>
        </li>
    <?php }} ?>
    </ul>
</nav>