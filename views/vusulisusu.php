<?php
require_once 'models/musulisusu.php';
$lis = new mUsuLisUsu();
$datAll = $lis->getAll();
?>

<div class="table-container mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-users"></i>
        Listado de Usuarios
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Perfil(es)</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if($datAll){ foreach ($datAll as $dt) { ?>
                <tr>
                    <td><?=$dt['docu'];?></td>
                    <td><?=$dt['prinom'];?> <?=$dt['seconom'];?> <?=$dt['priapel'];?></td>
                    <td><?=$dt['emailu'];?></td>
                    <td><?=$dt['teleu'];?></td>
                    <td><?=$dt['nomubi'];?></td>
                    <td><?=$dt['perfiles'];?></td>
                    <td>
                        <?php if($dt['estusr'] == 1){ ?>
                            <span class="badge bg-success">Activo</span>
                        <?php } else { ?>
                            <span class="badge bg-secondary">Inactivo</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($dt['estusr'] == 1){ ?>
                            <a href="controllers/cusulisusu.php?ope=desactivar&iduser=<?=$dt['iduser'];?>" title="desactivar" onclick="return confirm('¿Desactivar este usuario?');">
                                <i class="fa-solid fa-toggle-on fa-2x"></i>
                            </a>
                        <?php } else { ?>
                            <a href="controllers/cusulisusu.php?ope=activar&iduser=<?=$dt['iduser'];?>" title="activar" onclick="return confirm('¿Activar este usuario?');">
                                <i class="fa-solid fa-toggle-off fa-2x"></i>
                            </a>
                        <?php } ?>
                        <a href="controllers/cusulisusu.php?ope=borrar&iduser=<?=$dt['iduser'];?>" title="borrar" onclick="return confirm('¿Está seguro que desea eliminar este usuario?');">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Perfil(es)</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>