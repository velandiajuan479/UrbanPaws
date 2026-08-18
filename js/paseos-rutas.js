/**
 * Script para la página de Paseos
 * Muestra lista de rutas similares basadas en una ubicación y las visualiza en el mapa
 */

// Variables globales
let mapPaseos;
let markersLayer;
let selectedRouteMarker;

// Coordenadas por defecto (Bogotá, Colombia)
const DEFAULT_COORDS_PASEOS = [4.7110, -74.0721];

// Base de datos simulada de rutas disponibles
const RUTAS_DISPONIBLES = [
    {
        id: 1,
        nombre: 'Ruta Parque Central',
        descripcion: 'Recorrido de 3km por senderos principales del parque, ideal para perros de tamaño mediano.',
        distancia: '3.0 km',
        precio: '$45,000',
        dueno: 'María Rodríguez',
        codigo: 'RUTA-2026-045',
        paseador: 'Andrés López',
        coords: { lat: 4.7110, lon: -74.0721 },
        inicio: { lat: 4.7110, lon: -74.0721 },
        fin: { lat: 4.7200, lon: -74.0650 }
    },
    {
        id: 2,
        nombre: 'Ruta Laguna Norte',
        descripcion: 'Paseo de 4km con acceso a orilla de laguna para hidratación y juego.',
        distancia: '4.0 km',
        precio: '$55,000',
        dueno: 'Carlos Mendoza',
        codigo: 'RUTA-2026-046',
        paseador: 'Laura Gómez',
        coords: { lat: 4.7300, lon: -74.0600 },
        inicio: { lat: 4.7300, lon: -74.0600 },
        fin: { lat: 4.7400, lon: -74.0500 }
    },
    {
        id: 3,
        nombre: 'Ruta Urbana Express',
        descripcion: 'Recorrido rápido de 1.5km por calles residenciales, perfecto para paseos cortos.',
        distancia: '1.5 km',
        precio: '$30,000',
        dueno: 'Ana Pérez',
        codigo: 'RUTA-2026-047',
        paseador: 'Diego Silva',
        coords: { lat: 4.7000, lon: -74.0800 },
        inicio: { lat: 4.7000, lon: -74.0800 },
        fin: { lat: 4.7050, lon: -74.0750 }
    },
    {
        id: 4,
        nombre: 'Ruta Sendero Bosque',
        descripcion: 'Trayecto de 5km por senderos naturales con áreas de sombra y descanso.',
        distancia: '5.0 km',
        precio: '$65,000',
        dueno: 'Luis Fernández',
        codigo: 'RUTA-2026-048',
        paseador: 'María Rodríguez',
        coords: { lat: 4.6900, lon: -74.0900 },
        inicio: { lat: 4.6900, lon: -74.0900 },
        fin: { lat: 4.6800, lon: -74.1000 }
    },
    {
        id: 5,
        nombre: 'Ruta Deportiva',
        descripcion: 'Ruta de 6km con zonas para trote y ejercicios, recomendada para perros energéticos.',
        distancia: '6.0 km',
        precio: '$70,000',
        dueno: 'Patricia Gómez',
        codigo: 'RUTA-2026-049',
        paseador: 'Carlos Mendoza',
        coords: { lat: 4.7150, lon: -74.0500 },
        inicio: { lat: 4.7150, lon: -74.0500 },
        fin: { lat: 4.7250, lon: -74.0400 }
    },
    {
        id: 6,
        nombre: 'Ruta Familiar',
        descripcion: 'Recorrido de 2km por zonas seguras y tranquilas, apto para perros y familias.',
        distancia: '2.0 km',
        precio: '$35,000',
        dueno: 'Roberto Sánchez',
        codigo: 'RUTA-2026-050',
        paseador: 'Andrea Pérez',
        coords: { lat: 4.7050, lon: -74.0650 },
        inicio: { lat: 4.7050, lon: -74.0650 },
        fin: { lat: 4.7100, lon: -74.0600 }
    }
];

/**
 * Inicializar el mapa cuando se carga la página
 */
document.addEventListener('DOMContentLoaded', function() {
    initMapPaseos();
});

/**
 * Inicializar el mapa de Leaflet para paseos
 */
function initMapPaseos() {
    // Crear mapa centrado en coordenadas por defecto
    mapPaseos = L.map('map-paseos').setView(DEFAULT_COORDS_PASEOS, 12);

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(mapPaseos);

    // Capa para los marcadores
    markersLayer = L.layerGroup().addTo(mapPaseos);

    console.log('Mapa de paseos inicializado correctamente');
}

/**
 * Buscar rutas similares basadas en una ubicación
 */
async function buscarRutas() {
    const ubicacionInput = document.getElementById('ubicacionReferencia');
    const ubicacion = ubicacionInput.value.trim();

    if (!ubicacion) {
        alert('Por favor ingrese una ubicación de referencia');
        return;
    }

    try {
        // Geocodificar la ubicación de referencia
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(ubicacion)}&limit=1`);
        const data = await response.json();

        if (data && data.length > 0) {
            const refCoords = {
                lat: parseFloat(data[0].lat),
                lon: parseFloat(data[0].lon)
            };

            // Centrar el mapa en la ubicación encontrada
            mapPaseos.setView([refCoords.lat, refCoords.lon], 13);

            // Añadir marcador de ubicación de referencia
            markersLayer.clearLayers();
            L.marker([refCoords.lat, refCoords.lon])
                .bindPopup(`<strong>📍 Ubicación de Referencia</strong><br>${data[0].display_name}`)
                .addTo(markersLayer);

            // Buscar rutas similares (dentro de un radio aproximado)
            const rutasSimilares = encontrarRutasCercanas(refCoords, 5); // 5km de radio

            // Mostrar rutas en la lista
            mostrarRutasSimilares(rutasSimilares);

            // Mostrar rutas en el mapa
            mostrarRutasEnMapa(rutasSimilares);

        } else {
            alert('No se encontró la ubicación. Intente con otra.');
        }
    } catch (error) {
        console.error('Error al buscar rutas:', error);
        alert('Error al buscar la ubicación. Intente nuevamente.');
    }
}

/**
 * Encontrar rutas cercanas a una coordenada
 * @param {Object} refCoords - Coordenadas de referencia {lat, lon}
 * @param {number} radioKm - Radio en kilómetros
 * @returns {Array} - Lista de rutas cercanas
 */
function encontrarRutasCercanas(refCoords, radioKm = 5) {
    const rutasCercanas = [];

    RUTAS_DISPONIBLES.forEach(ruta => {
        const distancia = calcularDistancia(refCoords.lat, refCoords.lon, ruta.coords.lat, ruta.coords.lon);
        if (distancia <= radioKm) {
            rutasCercanas.push({
                ...ruta,
                distanciaReferencia: distancia.toFixed(2) + ' km'
            });
        }
    });

    // Ordenar por distancia
    rutasCercanas.sort((a, b) => parseFloat(a.distanciaReferencia) - parseFloat(b.distanciaReferencia));

    return rutasCercanas;
}

/**
 * Calcular distancia entre dos coordenadas usando la fórmula de Haversine
 * @returns {number} - Distancia en kilómetros
 */
function calcularDistancia(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radio de la Tierra en km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

/**
 * Mostrar rutas similares en la lista
 * @param {Array} rutas - Lista de rutas similares
 */
function mostrarRutasSimilares(rutas) {
    const container = document.getElementById('rutasSimilaresContainer');

    if (rutas.length === 0) {
        container.innerHTML = `
            <div class="alert alert-info">
                <p class="mb-0 text-center">No se encontraron rutas cercanas a esta ubicación.</p>
            </div>
        `;
        return;
    }

    let html = '<div class="list-group">';
    rutas.forEach((ruta, index) => {
        html += `
            <div class="list-group-item list-group-item-action ruta-similar-card" onclick="seleccionarRuta(${index})">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${ruta.nombre}</h5>
                    <small class="text-primary fw-bold">${ruta.distancia}</small>
                </div>
                <p class="mb-1 text-muted small">${ruta.descripcion}</p>
                <small class="text-success">🚶 ${ruta.paseador}</small>
                <small class="text-dark ms-2">💰 ${ruta.precio}</small>
            </div>
        `;
    });
    html += '</div>';

    container.innerHTML = html;
}

/**
 * Mostrar rutas en el mapa
 * @param {Array} rutas - Lista de rutas para mostrar
 */
function mostrarRutasEnMapa(rutas) {
    // Limpiar marcadores anteriores (excepto el de referencia)
    markersLayer.clearLayers();

    rutas.forEach((ruta, index) => {
        // Marcador de inicio
        const startMarker = L.marker([ruta.inicio.lat, ruta.inicio.lon])
            .bindPopup(`<strong>🟢 Inicio: ${ruta.nombre}</strong><br>${ruta.descripcion}`);

        // Marcador de fin
        const endMarker = L.marker([ruta.fin.lat, ruta.fin.lon])
            .bindPopup(`<strong>🔴 Fin: ${ruta.nombre}</strong>`);

        // Línea de ruta
        const routeLine = L.polyline([
            [ruta.inicio.lat, ruta.inicio.lon],
            [ruta.fin.lat, ruta.fin.lon]
        ], {
            color: '#f58220',
            weight: 4,
            opacity: 0.7,
            dashArray: '10, 10'
        });

        markersLayer.addLayer(startMarker);
        markersLayer.addLayer(endMarker);
        markersLayer.addLayer(routeLine);
    });
}

/**
 * Seleccionar una ruta de la lista
 * @param {number} index - Índice de la ruta seleccionada
 */
function seleccionarRuta(index) {
    // Obtener la ubicación de referencia actual
    const ubicacionInput = document.getElementById('ubicacionReferencia');
    const ubicacion = ubicacionInput.value.trim();

    if (!ubicacion) {
        alert('Primero debe buscar una ubicación');
        return;
    }

    // Buscar rutas nuevamente para obtener la lista actual
    const rutasSimilares = encontrarRutasCercanas(
        { lat: mapPaseos.getCenter().lat, lon: mapPaseos.getCenter().lng },
        5
    );

    const rutaSeleccionada = rutasSimilares[index];

    if (!rutaSeleccionada) {
        return;
    }

    // Mostrar tarjeta de seguimiento
    document.getElementById('seguimientoCard').style.display = 'block';

    // Actualizar información del paseo
    document.getElementById('precioPaseo').textContent = rutaSeleccionada.precio;
    document.getElementById('nombreDueno').textContent = rutaSeleccionada.dueno;
    document.getElementById('codigoRuta').textContent = rutaSeleccionada.codigo;
    document.getElementById('nombrePaseador').textContent = rutaSeleccionada.paseador;
    document.getElementById('distanciaPaseo').textContent = rutaSeleccionada.distancia;
    document.getElementById('rutaSeleccionada').textContent = rutaSeleccionada.nombre;

    // Centrar mapa en la ruta seleccionada
    mapPaseos.setView([rutaSeleccionada.inicio.lat, rutaSeleccionada.inicio.lon], 14);

    // Limpiar marcadores y mostrar solo la ruta seleccionada
    markersLayer.clearLayers();

    // Marcador de inicio
    L.marker([rutaSeleccionada.inicio.lat, rutaSeleccionada.inicio.lon])
        .bindPopup(`<strong>🟢 Inicio: ${rutaSeleccionada.nombre}</strong><br>${rutaSeleccionada.descripcion}`)
        .addTo(markersLayer)
        .openPopup();

    // Marcador de fin
    L.marker([rutaSeleccionada.fin.lat, rutaSeleccionada.fin.lon])
        .bindPopup(`<strong>🔴 Fin: ${rutaSeleccionada.nombre}</strong>`)
        .addTo(markersLayer);

    // Línea de ruta sólida para la seleccionada
    L.polyline([
        [rutaSeleccionada.inicio.lat, rutaSeleccionada.inicio.lon],
        [rutaSeleccionada.fin.lat, rutaSeleccionada.fin.lon]
    ], {
        color: '#1a3a5c',
        weight: 6,
        opacity: 0.9
    }).addTo(markersLayer);

    // Scroll suave hacia la tarjeta de seguimiento
    document.getElementById('seguimientoCard').scrollIntoView({ behavior: 'smooth' });

    console.log('Ruta seleccionada:', rutaSeleccionada.nombre);
}

// Exportar funciones para uso externo
window.buscarRutas = buscarRutas;
window.seleccionarRuta = seleccionarRuta;
