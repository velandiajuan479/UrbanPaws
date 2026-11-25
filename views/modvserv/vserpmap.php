<?php
$mapTitulo = isset($mapTitulo) ? $mapTitulo : 'Mapa de la ruta';
$mapDireccion = isset($mapDireccion) ? $mapDireccion : '';
$mapReferencia = isset($mapReferencia) ? $mapReferencia : '';
$mapQuery = trim($mapDireccion . ($mapReferencia !== '' ? ', ' . $mapReferencia : ''));
$mapEmbed = $mapQuery !== '' ? 'https://www.google.com/maps?q=' . rawurlencode($mapQuery) . '&output=embed' : '';
$mapLink = $mapQuery !== '' ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($mapQuery) : '';
?>
<div class="card p-3 route-map-placeholder"
     data-route-map
     data-direccion="<?= servH($mapDireccion) ?>"
     data-referencia="<?= servH($mapReferencia) ?>">
    <span class="eyebrow"><?= servH($mapTitulo) ?></span>
    <h2 class="h5 mb-2">Ubicación de la ruta</h2>
    <?php if ($mapEmbed !== '') { ?>
        <iframe class="route-map-frame" src="<?= servH($mapEmbed) ?>" title="<?= servH($mapTitulo . ': ' . $mapQuery) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <p class="text-muted small mb-2"><?= servH($mapQuery) ?></p>
        <a class="btn btn-sm btn-outline-primary" href="<?= servH($mapLink) ?>" target="_blank" rel="noopener noreferrer">
            <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Abrir en Google Maps
        </a>
    <?php } else { ?>
        <div class="alert alert-info mb-0">Registra una dirección en la ruta para visualizar el mapa.</div>
    <?php } ?>
</div>
