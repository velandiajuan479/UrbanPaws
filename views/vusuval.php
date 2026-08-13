<?php
require_once 'models/musuval.php';
$val = new mUsuVal();
$datAll = $val->getPendientes();
?>

<div class="table-container mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i>
        Validación de Paseadores
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Antecedentes</th>
                    <th></th>
                </tr>
                <tr></tr>
            </thead>
            <tbody>
                <?php if($datAll){ foreach ($datAll as $dt) { ?>
                <tr>
                    <td><?=$dt['docu'];?></td>
                    <td><?=$dt['prinom'];?> <?=$dt['seconom'];?> <?=$dt['priapel'];?></td>
                    <td><?=$dt['emailu'];?></td>
                    <td><?=$dt['teleu'];?></td>
                    <td>
                        <?php if($dt['antecedentes']){ ?>
                            <span class="badge bg-warning text-dark"><?=$dt['antecedentes'];?></span>
                        <?php } else { ?>
                            <span class="badge bg-light text-dark">Sin registros</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="controllers/cusuval.php?ope=aprobar&iduser=<?=$dt['iduser'];?>" title="aprobar" onclick="return confirm('¿Aprobar a este paseador?');">
                            <i class="fa-solid fa-circle-check fa-2x text-success"></i>
                        </a>
                        <a href="controllers/cusuval.php?ope=rechazar&iduser=<?=$dt['iduser'];?>" title="rechazar" onclick="return confirm('¿Rechazar a este paseador?');">
                            <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                        </a>
                    </td>
                </tr>
                <?php }} else { ?>
                <tr>
                    <td colspan="6" class="text-center">No hay paseadores pendientes de validación.</td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Antecedentes</th>
                    <th></th>
                </tr>
                <tr></tr>
            </tfoot>
        </table>
    </div>
</div>