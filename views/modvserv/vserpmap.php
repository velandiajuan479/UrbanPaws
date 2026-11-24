<?php
$mapTitulo = isset($mapTitulo) ? $mapTitulo : 'Mapa de la ruta';
$mapDireccion = isset($mapDireccion) ? $mapDireccion : '';
$mapReferencia = isset($mapReferencia) ? $mapReferencia : '';
?>
<div class="card p-3 route-map-placeholder"
     data-route-map
     data-direccion="<?= servH($mapDireccion) ?>"
     data-referencia="<?= servH($mapReferencia) ?>">
    <span class="eyebrow"><?= servH($mapTitulo) ?></span>
    <h2 class="h5 mb-2">Aquí se mostrará el mapa</h2>
    <p class="text-muted mb-2">La integración con la API de mapas se hará cuando el módulo esté validado.</p>
    <p class="mb-1"><strong>Dirección:</strong> <?= $mapDireccion !== '' ? servH($mapDireccion) : 'Sin dirección registrada' ?></p>
    <p class="mb-0"><strong>Referencia:</strong> <?= $mapReferencia !== '' ? servH($mapReferencia) : 'Sin referencia' ?></p>
</div>
