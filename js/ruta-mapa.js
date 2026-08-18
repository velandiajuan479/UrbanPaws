/**
 * Script para la integración de mapa en la página de rutas
 * Utiliza Leaflet.js con OpenStreetMap (gratuito)
 * Permite seleccionar dirección de inicio y fin, trazar ruta y mostrar información
 */

// Variables globales
let map;
let routingControl;
let startMarker;
let endMarker;
let startCoords = null;
let endCoords = null;

// Coordenadas por defecto (Bogotá, Colombia)
const DEFAULT_COORDS = [4.7110, -74.0721];

/**
 * Inicializar el mapa cuando se carga la página
 */
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});

/**
 * Inicializar el mapa de Leaflet
 */
function initMap() {
    // Crear mapa centrado en coordenadas por defecto
    map = L.map('map').setView(DEFAULT_COORDS, 13);

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    console.log('Mapa inicializado correctamente');
}

/**
 * Geocodificar una dirección usando Nominatim (servicio gratuito de OpenStreetMap)
 * @param {string} type - 'start' o 'end'
 */
async function geocodeAddress(type) {
    const addressInput = document.getElementById(type === 'start' ? 'startAddress' : 'endAddress');
    const address = addressInput.value.trim();

    if (!address) {
        alert('Por favor ingrese una dirección');
        return;
    }

    try {
        // Usar Nominatim para geocodificación
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`);
        const data = await response.json();

        if (data && data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);
            const coords = [lat, lon];

            if (type === 'start') {
                startCoords = coords;
                updateMarker('start', coords, data[0].display_name);
            } else {
                endCoords = coords;
                updateMarker('end', coords, data[0].display_name);
            }

            // Centrar el mapa en la ubicación encontrada
            map.setView(coords, 15);

            console.log(`Dirección encontrada: ${data[0].display_name}`);
        } else {
            alert('No se encontró la dirección. Intente con otra.');
        }
    } catch (error) {
        console.error('Error al geocodificar:', error);
        alert('Error al buscar la dirección. Intente nuevamente.');
    }
}

/**
 * Actualizar o crear marcador en el mapa
 * @param {string} type - 'start' o 'end'
 * @param {Array} coords - Coordenadas [lat, lon]
 * @param {string} address - Dirección completa
 */
function updateMarker(type, coords, address) {
    // Eliminar marcador existente si lo hay
    if (type === 'start' && startMarker) {
        map.removeLayer(startMarker);
    }
    if (type === 'end' && endMarker) {
        map.removeLayer(endMarker);
    }

    // Crear nuevo marcador con color diferente
    const color = type === 'start' ? 'green' : 'red';
    const icon = L.divIcon({
        className: `custom-marker marker-${type}`,
        html: `<div style="background-color: ${color}; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>`,
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    const marker = L.marker(coords, { icon: icon })
        .addTo(map)
        .bindPopup(`<strong>${type === 'start' ? '📍 Inicio' : '🏁 Fin'}</strong><br>${address}`)
        .openPopup();

    if (type === 'start') {
        startMarker = marker;
    } else {
        endMarker = marker;
    }
}

/**
 * Trazar ruta entre los puntos de inicio y fin usando Leaflet Routing Machine
 */
function drawRoute() {
    if (!startCoords || !endCoords) {
        alert('Por favor seleccione ambas direcciones (inicio y fin)');
        return;
    }

    // Eliminar ruta anterior si existe
    if (routingControl) {
        map.removeControl(routingControl);
    }

    // Crear nueva ruta
    routingControl = L.Routing.control({
        waypoints: [
            L.latLng(startCoords[0], startCoords[1]),
            L.latLng(endCoords[0], endCoords[1])
        ],
        routeWhileDragging: false,
        language: 'es',
        showAlternatives: true,
        fitSelectedRoutes: true,
        lineOptions: {
            styles: [{ color: '#1a3a5c', opacity: 0.8, weight: 6 }]
        },
        createMarker: function(i, wp, nWps) {
            // Personalizar marcadores de la ruta
            const color = i === 0 ? 'green' : 'red';
            return L.marker(wp.latLng, {
                draggable: false,
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${color}; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            });
        }
    }).addTo(map);

    // Escuchar evento de ruta encontrada
    routingControl.on('routesfound', function(e) {
        const routes = e.routes;
        const summary = routes[0].summary;
        
        // Mostrar información de la ruta
        showRouteInfo(summary.totalDistance, summary.totalTime);
    });
}

/**
 * Mostrar información de la ruta (distancia y tiempo estimado)
 * @param {number} distance - Distancia en metros
 * @param {number} time - Tiempo en segundos
 */
function showRouteInfo(distance, time) {
    const routeInfoDiv = document.getElementById('routeInfo');
    const distanceKm = (distance / 1000).toFixed(2);
    const timeMinutes = Math.round(time / 60);

    routeInfoDiv.innerHTML = `
        <strong>ℹ️ Información de la Ruta:</strong><br>
        📏 Distancia: ${distanceKm} km | ⏱️ Tiempo estimado: ${timeMinutes} minutos
    `;
    routeInfoDiv.style.display = 'block';
}

/**
 * Guardar ruta (función placeholder - se puede integrar con backend)
 */
function guardarRuta() {
    if (!startCoords || !endCoords) {
        alert('Primero debe trazar una ruta');
        return;
    }

    const startAddress = document.getElementById('startAddress').value;
    const endAddress = document.getElementById('endAddress').value;

    // Aquí se podría hacer una petición AJAX al backend para guardar la ruta
    const rutaData = {
        inicio: startAddress,
        fin: endAddress,
        coordenadasInicio: startCoords,
        coordenadasFin: endCoords,
        fechaCreacion: new Date().toISOString()
    };

    console.log('Datos de ruta para guardar:', rutaData);
    alert('✅ Ruta guardada exitosamente (simulación)');
    
    // En producción, aquí harías:
    // fetch('/controllers/guardar_ruta.php', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify(rutaData)
    // });
}

/**
 * Función para buscar rutas similares (para usar en la página de paseos)
 * @param {string} location - Ubicación de referencia
 * @returns {Promise<Array>} - Lista de rutas similares
 */
async function buscarRutasSimilares(location) {
    try {
        // Geocodificar la ubicación de referencia
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}&limit=1`);
        const data = await response.json();

        if (data && data.length > 0) {
            const refCoords = {
                lat: parseFloat(data[0].lat),
                lon: parseFloat(data[0].lon)
            };

            // Simulación de búsqueda de rutas similares
            // En producción, esto consultaría una base de datos de rutas
            const rutasSimilares = [
                {
                    nombre: 'Ruta Parque Central',
                    descripcion: 'Recorrido de 3km por senderos principales',
                    distancia: '3.0 km',
                    coordenadas: { lat: refCoords.lat + 0.01, lon: refCoords.lon + 0.01 }
                },
                {
                    nombre: 'Ruta Laguna Norte',
                    descripcion: 'Paseo de 4km con acceso a laguna',
                    distancia: '4.0 km',
                    coordenadas: { lat: refCoords.lat - 0.01, lon: refCoords.lon + 0.01 }
                },
                {
                    nombre: 'Ruta Urbana Express',
                    descripcion: 'Recorrido rápido de 1.5km',
                    distancia: '1.5 km',
                    coordenadas: { lat: refCoords.lat + 0.01, lon: refCoords.lon - 0.01 }
                }
            ];

            console.log('Rutas similares encontradas:', rutasSimilares);
            return rutasSimilares;
        }

        return [];
    } catch (error) {
        console.error('Error al buscar rutas similares:', error);
        return [];
    }
}

/**
 * Exportar funciones para uso externo (ej: desde vpaseo.html)
 */
window.geocodeAddress = geocodeAddress;
window.drawRoute = drawRoute;
window.guardarRuta = guardarRuta;
window.buscarRutasSimilares = buscarRutasSimilares;
