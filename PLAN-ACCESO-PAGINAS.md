# Plan: hacer cumplir el acceso a páginas

## Objetivo

Al abrir directamente `home.php?pg=N`, permitir la página solo si está activa y al menos uno de los perfiles del usuario tiene esa página asignada. La relación `pagxper` será la fuente de verdad; no se añadirán permisos por módulo ni por usuario individual.

## Lo que ya existe

- `usuario` puede tener varios perfiles mediante `userxper(iduser, idperf)`.
- `pagxper(idpag, idperf)` relaciona páginas y perfiles.
- `models/mcofper.php` ya lee esa matriz y reemplaza asignaciones por perfil dentro de una transacción.
- `views/vusuadmin.php` ya permite administrar la matriz Página × Perfil.
- `db/seed_vusuadmin.sql` carga permisos iniciales, incluyendo todas las páginas para el perfil Admin.
- `home.php` resuelve `pg` y carga las vistas, pero actualmente no valida `pagxper` antes de incluirlas.
- `mostpag` indica si una página está habilitada. `home.php` conserva también un mapa de páginas con vistas implementadas.

## Trabajo propuesto

1. Revisar `AGENTS.md`, el estado de Git y el flujo actual antes de editar. Mantener el alcance en el control de acceso/configuración; no tocar Mascotas ni otros cambios existentes ajenos a esta tarea.
2. Añadir una comprobación central antes de incluir la vista en `home.php`:
   - obtener los perfiles del usuario autenticado desde `userxper`;
   - confirmar que la página solicitada existe y `mostpag` está activo;
   - autorizar si existe una fila correspondiente en `pagxper` para cualquiera de sus perfiles;
   - rechazar de forma segura la solicitud si la página no existe, está desactivada o no tiene asignación. No mostrar contenido protegido en el rechazo.
3. No implementar un bypass implícito para Admin: el acceso Admin debe seguir proviniendo de `pagxper`, como ya hace el seed. Así las casillas de la matriz siguen siendo efectivas también para Admin.
4. Mantener la matriz Página × Perfil en `views/vusuadmin.php` como interfaz única de permisos. `views/vcofpag.php` puede seguir gestionando el estado de cada página.
5. Revisar `views/header.php` para ocultar enlaces a páginas a las que el usuario no tiene acceso. Esto mejora la navegación, pero no sustituye la validación obligatoria de `home.php`.
6. Revisar `db/urbanpaws.sql` y los datos existentes de `pagxper`: la tabla no declara una clave única compuesta. Comprobar duplicados antes de decidir si añadir una restricción `UNIQUE (idpag, idperf)`; no borrar datos existentes sin una migración explícita y segura.
7. Revisar el flujo de guardado de la matriz en `controllers/cusuadmin.php` / `models/mcofper.php`; conservar validación CSRF y transacciones, y comprobar que IDs enviados pertenecen a páginas y perfiles existentes.

## Archivos a revisar

- `home.php` — aplicación del permiso antes de incluir la vista.
- `views/header.php` — visibilidad de enlaces de navegación.
- `controllers/cusuadmin.php`, `models/mcofper.php`, `views/vusuadmin.php` — gestión de la matriz ya existente.
- `views/vcofpag.php`, `models/mcofpag.php` — estado de páginas.
- `db/urbanpaws.sql`, `db/seed_vusuadmin.sql` — esquema y permisos iniciales.

## Comprobaciones

- Usuario sin perfil: acceso denegado a páginas protegidas.
- Usuario con varios perfiles: acceso si cualquiera tiene asignada la página.
- Página sin asignación, inexistente o desactivada: denegada aunque se solicite directamente por URL.
- Página permitida: sigue cargando la vista esperada.
- Los enlaces del menú coinciden con los permisos, pero la protección funciona aunque se escriba la URL manualmente.
- Validar sintaxis PHP con `/opt/lampp/bin/php -l` para cada archivo PHP modificado y probar los perfiles Cliente, Paseador y Admin con las asignaciones reales.

## Nota sobre los datos

El seed asigna páginas iniciales a los perfiles Cliente, Paseador y Admin, pero en una base ya existente debe comprobarse que se haya ejecutado y que el usuario Admin tenga su perfil en `userxper`. No asumir IDs de perfiles o usuarios distintos de los comprobados en esa base.
