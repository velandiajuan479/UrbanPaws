# Integración de API de Mapas - Urban Paws

## Descripción
Esta integración añade funcionalidad de mapas interactivos a las páginas de **Rutas** y **Paseos** del sistema Urban Paws, utilizando tecnologías gratuitas y de código abierto.

## Tecnologías Utilizadas

### Librerías de Mapas (Gratuitas)
- **Leaflet.js** (v1.9.4) - Librería JavaScript para mapas interactivos
- **OpenStreetMap** - Proveedor de tiles de mapa gratuito
- **Nominatim** - Servicio de geocodificación gratuito de OpenStreetMap
- **Leaflet Routing Machine** (v3.2.12) - Plugin para trazado de rutas

## Archivos Creados/Modificados

### 1. Página de Rutas (`views/vruta.html`)
**Funcionalidades:**
- Mapa interactivo para visualizar rutas
- Campos para ingresar dirección de inicio y fin
- Geocodificación de direcciones usando Nominatim
- Trazado automático de ruta entre dos puntos
- Cálculo de distancia y tiempo estimado
- Tabla de rutas guardadas con información detallada
- Botón para guardar nuevas rutas

**Elementos clave:**
```html
<!-- Panel de selección de direcciones -->
<input id="startAddress" placeholder="Dirección de Inicio">
<input id="endAddress" placeholder="Dirección de Fin">
<button onclick="geocodeAddress('start')">Buscar Ubicación</button>
<button onclick="drawRoute()">Trazar Ruta</button>

<!-- Contenedor del mapa -->
<div id="map"></div>
```

### 2. Página de Paseos (`views/vpaseo.html`)
**Funcionalidades:**
- Búsqueda de rutas similares basadas en una ubicación de referencia
- Lista interactiva de rutas cercanas ordenadas por distancia
- Visualización de múltiples rutas en el mapa
- Selección de ruta para ver detalles completos
- Tarjeta de seguimiento del paseo con información detallada
- Cálculo de distancias usando fórmula de Haversine

**Elementos clave:**
```html
<!-- Búsqueda de rutas similares -->
<input id="ubicacionReferencia" placeholder="Ubicación de Referencia">
<button onclick="buscarRutas()">Buscar Rutas Cercanas</button>

<!-- Lista de rutas similares -->
<div id="rutasSimilaresContainer"></div>

<!-- Mapa de paseos -->
<div id="map-paseos"></div>
```

### 3. Script de Rutas (`js/ruta-mapa.js`)
**Funciones principales:**
- `initMap()` - Inicializa el mapa Leaflet
- `geocodeAddress(type)` - Geocodifica una dirección (inicio/fin)
- `updateMarker(type, coords, address)` - Actualiza marcadores en el mapa
- `drawRoute()` - Traza ruta entre dos puntos usando Routing Machine
- `showRouteInfo(distance, time)` - Muestra información de la ruta
- `guardarRuta()` - Guarda la ruta creada (placeholder para backend)
- `buscarRutasSimilares(location)` - Busca rutas similares (para paseos)

### 4. Script de Paseos (`js/paseos-rutas.js`)
**Funciones principales:**
- `initMapPaseos()` - Inicializa el mapa para paseos
- `buscarRutas()` - Busca rutas similares a una ubicación
- `encontrarRutasCercanas(refCoords, radioKm)` - Encuentra rutas dentro de un radio
- `calcularDistancia(lat1, lon1, lat2, lon2)` - Calcula distancia usando Haversine
- `mostrarRutasSimilares(rutas)` - Renderiza lista de rutas similares
- `mostrarRutasEnMapa(rutas)` - Muestra rutas en el mapa
- `seleccionarRuta(index)` - Selecciona una ruta específica

**Base de datos simulada:**
El script incluye 6 rutas de ejemplo con:
- Coordenadas de inicio y fin
- Información del paseador y dueño
- Precio y distancia
- Código de ruta único

## Cómo Usar

### Página de Rutas (`vruta.html`)

1. **Ingresar dirección de inicio:**
   - Escribir la dirección en el campo "Dirección de Inicio"
   - Click en "Buscar Ubicación"
   - El mapa mostrará un marcador verde en la ubicación encontrada

2. **Ingresar dirección de fin:**
   - Escribir la dirección en el campo "Dirección de Fin"
   - Click en "Buscar Ubicación"
   - El mapa mostrará un marcador rojo en la ubicación encontrada

3. **Trazar ruta:**
   - Click en "Trazar Ruta"
   - El sistema calculará la mejor ruta entre los dos puntos
   - Se mostrará la distancia y tiempo estimado

4. **Guardar ruta:**
   - Click en "Guardar Ruta"
   - Los datos se preparan para envío al backend

### Página de Paseos (`vpaseo.html`)

1. **Buscar rutas similares:**
   - Ingresar una ubicación de referencia (ej: "Parque Central, Bogotá")
   - Click en "Buscar Rutas Cercanas"
   - El sistema mostrará rutas dentro de un radio de 5km

2. **Ver lista de rutas:**
   - Las rutas se muestran ordenadas por distancia
   - Cada tarjeta muestra: nombre, descripción, paseador y precio

3. **Seleccionar ruta:**
   - Click en cualquier ruta de la lista
   - El mapa se centra en la ruta seleccionada
   - Aparece la tarjeta de seguimiento con detalles completos

4. **Visualizar en mapa:**
   - Las rutas se muestran con líneas punteadas naranjas
   - La ruta seleccionada se muestra con línea sólida azul
   - Marcadores verdes (inicio) y rojos (fin)

## API Endpoints Utilizados

### Nominatim (Geocodificación)
```
GET https://nominatim.openstreetmap.org/search?format=json&q={direccion}&limit=1
```

**Ejemplo:**
```javascript
fetch('https://nominatim.openstreetmap.org/search?format=json&q=Parque%20Central,%20Bogota&limit=1')
```

### OpenStreetMap Tiles
```
https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
```

## Consideraciones Importantes

### Límites de Uso de Nominatim
- Máximo 1 solicitud por segundo
- Uso razonable requerido (no más de 10,000 solicitudes/día)
- Requiere atribución a OpenStreetMap

### Producción
Para usar en producción, se recomienda:
1. Implementar caché para geocodificación
2. Añadir manejo de errores robusto
3. Conectar con backend real para guardar rutas
4. Considerar servicios premium si se exceden límites

### Personalización
- Las coordenadas por defecto están configuradas para Bogotá, Colombia
- Se pueden modificar en las constantes `DEFAULT_COORDS` en cada script
- Los colores del mapa coinciden con la paleta de Urban Paws

## Estructura de Datos de Ruta

```javascript
{
    id: 1,
    nombre: 'Ruta Parque Central',
    descripcion: 'Recorrido de 3km...',
    distancia: '3.0 km',
    precio: '$45,000',
    dueno: 'María Rodríguez',
    codigo: 'RUTA-2026-045',
    paseador: 'Andrés López',
    coords: { lat: 4.7110, lon: -74.0721 },
    inicio: { lat: 4.7110, lon: -74.0721 },
    fin: { lat: 4.7200, lon: -74.0650 }
}
```

## Requisitos del Sistema

- Navegador moderno con soporte para ES6+
- Conexión a internet para cargar librerías CDN
- JavaScript habilitado

## Dependencias CDN

```html
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Leaflet Routing Machine (solo para vruta.html) -->
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

<!-- Bootstrap 5 (ya existente) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
```

## Soporte

Para problemas o preguntas sobre esta integración, revisar:
- Documentación oficial de Leaflet: https://leafletjs.com/
- Documentación de Nominatim: https://nominatim.org/
- OpenStreetMap: https://www.openstreetmap.org/
