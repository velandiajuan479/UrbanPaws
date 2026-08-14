<?php require_once("models/seguridad.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbanPaws — Mi Espacio Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
<?php
    require_once('controllers/misfun.php');
    require_once('models/mcofpag.php');

    $pg = isset($_GET["pg"]) ? $_GET["pg"] : 1;

    $mcofpag = new mCofpag();
    $mcofpag->setIdpag($pg);
    $dtpg = $mcofpag->getOne();

    $misfun = new misFun();

    include 'views/header.php';
?>

<section class="menu">
    <?php include 'views/vmen.php'; ?>
</section>

<section class="cont">
    <?php
    if($dtpg){
        echo $misfun->titu($dtpg[0]['titpag'], $dtpg[0]['icopag']);
    }
    ?>
    <div id="error"></div>
    <?php
    if($dtpg && $dtpg[0]['arcpag']){
        include $dtpg[0]['arcpag'];
    }
    ?>
</section>

<?php include 'views/footer.php'; ?>
<script src="js/mytable.js"></script>
</body>
</html>