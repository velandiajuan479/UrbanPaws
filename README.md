# UrbanPaws

Aplicación web para la gestión de servicios de cuidado de mascotas.

## Descripción

UrbanPaws es una plataforma MVC (Modelo-Vista-Controlador) desarrollada en PHP que permite a los usuarios gestionar servicios relacionados con sus mascotas, incluyendo:

- Registro y gestión de usuarios con diferentes perfiles (cliente, administrador, paseador)
- Gestión de mascotas y dueños
- Sistema de cofre digital y pagos
- Facturación y reportes
- Ubicación geográfica
- PQRSF (Peticiones, Quejas, Reclamos, Sugerencias y Felicitaciones)

## Estructura del Proyecto

```
├── controllers/     # Controladores de la aplicación
├── css/            # Hojas de estilo
├── db/             # Scripts de base de datos
├── img/            # Imágenes del proyecto
├── js/             # Archivos JavaScript
├── models/         # Modelos y conexión a base de datos
└── views/          # Vistas de la aplicación
```

## Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7 o superior / MariaDB
- Servidor web (Apache, Nginx)

## Instalación

1. Clona este repositorio
2. Configura tu servidor web para apuntar al directorio del proyecto
3. Importa la base de datos:
   ```bash
   mysql -u usuario -p < db/urbanpaws.sql
   ```
4. Configura las credenciales de la base de datos en `models/conexion.php` y `models/config.php`
5. Accede a la aplicación desde tu navegador

## Tecnologías Utilizadas

- **Backend:** PHP
- **Base de Datos:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Frameworks/Librerías:**
  - Bootstrap 5.3.3
  - Bootstrap Icons
  - jQuery 3.7.1
  - DataTables
  - Font Awesome
  - Google Fonts (Poppins, Nunito)

## Módulos Principales

### Usuarios (`c/ musu*`)
- Registro y autenticación
- Gestión de perfiles
- Administración de usuarios

### Mascotas (`c/ mmas*`)
- Registro de mascotas
- Asociación con dueños
- Historial médico

### Pagos y Cofre (`c/ mcof*`)
- Gestión de cofre digital
- Procesamiento de pagos
- Validación de transacciones

### Facturación (`c/ mfac*`)
- Generación de facturas
- Listado y consulta
- Reportes

## Configuración

Edita los archivos de configuración en la carpeta `models/`:

- `conexion.php`: Parámetros de conexión a la base de datos
- `config.php`: Configuraciones generales de la aplicación

## Rutas de Navegación

La aplicación utiliza parámetros GET para navegación:

| pg | Vista | Descripción |
|----|-------|-------------|
| 1  | vusucli | Usuario Cliente |
| 2  | vusuadmin | Usuario Administrador |
| 3  | vusupas | Usuario Paseador |
| 4  | vusupef | Perfil de Usuario |
| 5  | vusulisusu | Lista de Usuarios |
| 6  | vusuval | Validación de Usuario |
| 7  | vusudatper | Datos Personales |
| 8  | vusuubi | Ubicación |
| 9  | vmasmas | Gestión de Mascotas |
| 10 | vmasdue | Dueños de Mascotas |

## Licencia

Este proyecto es de uso privado.

## Contacto

Para más información, contacta al equipo de desarrollo.