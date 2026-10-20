# Inventario de Errores — Proyecto UrbanPaws

**Fecha de la auditoría:** 16 de octubre de 2026
**Alcance:** todo el código de la aplicación (`index.php`, `home.php`, `logout.php`, `controllers/`, `models/`, `views/`, `js/`, `css/`, `db/`). Se excluye `vendor/` y `.agents/`.
**Método:** verificación estática (lectura completa de los 92 archivos PHP), `php -l` sobre los 92 archivos, y contraste de cada consulta SQL contra el esquema real de `db/urbanpaws.sql`.

> **Nota sobre la verificación:** `php -l` no reporta **ningún** error de sintaxis en los 92 archivos PHP. Todos los errores que siguen son lógicos, de contrato entre capas, de esquema de base de datos o de seguridad. Los hallazgos marcados **[V]** fueron confirmados directamente por el auditor contra el esquema SQL o por ejecución de comandos.

---

## Resumen ejecutivo

Se documentan **122 errores**, agrupados en 8 bloques. Además, los **3 errores de A7 y A8** (función `ManejoError()` inexistente y clase `misFun` nunca cargada) se repiten en 22 puntos de código distintos, por lo que la superficie real de fallo es mayor que el número de entradas.

| Bloque | Tema | Errores |
|---|---|---|
| **A** | Funcionalidad crítica rota | 26 |
| **B** | Seguridad | 20 |
| **C** | Base de datos / SQL | 11 |
| **D** | Ruteo y código muerto | 17 |
| **E** | Contratos rotos entre capas | 15 |
| **F** | Errores de PHP | 10 |
| **G** | UI / HTML / CSS | 15 |
| **H** | Configuración y documentación | 8 |
| | **TOTAL** | **122** |

### Los 6 problemas que explican por sí solos la mayor parte del proyecto roto

1. **La tabla `ruta` está incompleta en el esquema** (`db/urbanpaws.sql:103-109`). Le faltan 5 columnas que el código usa: `idubi`, `estarut`, `horaini`, `horafin`, `precioini`. Esto deja **inoperante todo el módulo de Servicios**. **[V]**
2. **`index.php` no enruta por `pg`**. Lee el parámetro (línea 90) y nunca lo usa. Casi todos los formularios y redirecciones de Servicios, Facturas y Valores apuntan a `index.php?pg=N` y terminan en un **404** o en `pg=1`. **[V]**
3. **Colisión de la acción `ope="save"` entre tres controllers externos** cargados en la misma petición. Enviar el formulario "¿Olvidó su contraseña?" **borra la contraseña** de cualquier cuenta. **[V]**
4. **Recuperación de contraseña sin token ni verificación de identidad** → toma de control de cualquier cuenta. **[V]**
5. **Ninguno de los controllers verifica sesión ni rol, y no existe `.htaccess`**. Todos los controllers son URLs públicas que cualquiera puede invocar para borrar o aprobar registros. **[V]**
6. **El módulo Facturas y el módulo PQRS no existen** como código funcional: Facturas es HTML estático con datos inventados; PQRS no tiene controller, model ni view.

---

# BLOQUE A — ERRORES CRÍTICOS DE FUNCIONALIDAD

### A1. La tabla `ruta` no tiene las columnas que usa el código **[V]**
`db/urbanpaws.sql:103-109` define `ruta(idrut, nomrut, distrut, iduser)`. El código consulta 5 columnas inexistentes en 10 lugares:

| Ubicación | Columnas inexistentes |
|---|---|
| `models/mserrut.php:43-44` (`getAll`) | `r.idubi`, `r.estarut` |
| `models/mserrut.php:49`, `:68-69` (`getOne`) | `r.idubi`, `r.estarut` |
| `models/mserrut.php:75`, `:97-99`, `:103` (`getByUser`, `getActivas`) | `r.estarut`, `r.idubi` |
| `models/mserrut.php:126-128`, `:133-135` (`save`) | `r.idubi`, `r.estarut` |
| `models/mserrut.php:157-158` (`upd`) | `r.idubi`, `r.estarut`, `r.horaini`, `r.horafin`, `r.precioini` |
| `models/mserpas.php:39`, `:68`, `:100`, `:131` | `r.precioini`, `r.horaini`, `r.horafin` |

**Error resultante:** `SQLSTATE[42S22] ... 1054 Unknown column 'r.idubi' in 'field list'`. Los `catch` de `mserrut.php` tragan la excepción y devuelven `[]`, así que **las listas salen vacías sin avisar**. El único método que sí funciona es `mserpas::save()`, porque solo toca columnas de `paseo`.
**Consecuencia:** no se puede crear, editar ni listar ninguna ruta ni paseo.

### A2. Vistas incluidas por `home.php` que no existen en disco **[V]**
| Línea de `home.php` | `pg` | Archivo incluido | ¿Existe? | Menú que lo enlaza |
|---|---|---|---|---|
| `:52` | 12 | `views/vserlisrut.php` | **NO** | `views/header.php:58` |
| `:55` | 15 | `views/vserlisser.php` | **NO** | `views/header.php:61` |
| `:56` | 16 | `views/vserrepser.php` | **NO** | `views/header.php:62` |
| `:63` | 21 | `views/vreppqr.php` | **NO** | `views/header.php:85`, `:143` |
| `:64` | 22 | `views/vreplispqr.php` | **NO** | `views/header.php:86` |

Cada una genera exactamente:
```
Warning: include(views/vserlisrut.php): Failed to open stream: No such file or directory
Warning: include(): Failed opening 'views/vserlisrut.php' for inclusion
```
Son **5 entradas del menú principal** que llevan a una pantalla en blanco con warnings visibles.

### A3. El módulo PQRS no existe **[V]**
`home.php:62-64` enruta `pg=21` y `pg=22`, pero **no hay ningún controller, model ni view de PQRS en el repo**. La tabla `pqrsf` (`db/urbanpaws.sql:52-57`) nunca se consulta. Además `pqrsf` **no tiene columna `iduser`** y no existe tabla puente, así que el modelo de datos tampoco permitiría relacionar una PQRS con su autor.

### A4. Los 4 controllers de Facturas nunca se incluyen **[V]**
`home.php:58-61` incluye directamente `views/vfacfac.php`, `views/vfatdatfac.php`, `views/vfaclisfac.php`, `views/vfacrepfac.php`. Ninguna de esas 4 vistas contiene un `require_once` de su controller (todas arrancan con `<main class="container">`). **No hay ninguna referencia a `cfacfac.php`, `cfatdatfac.php`, `cfaclisfac.php` ni `cfacrepfac.php` en todo el proyecto.**

**Consecuencia:** el módulo Facturas es HTML hardcodeado. `models/mfacfac.php`, `mfatdatfac.php`, `mfaclisfac.php` y `mfacrepfac.php` son **código muerto**.

### A5. Columna `tipserv` inexistente en Facturas **[V]**
`models/mfatdatfac.php:83` y `:115` → `s.tipserv AS servicio`.
La tabla `servicio` (`db/urbanpaws.sql:124-132`) solo tiene `idserv, idpas, idrut, iduser`. La columna real es `paseo.servtipo` (`db:118`). Ambos métodos lanzan PDOException en **cada** llamada (error 1054).

### A6. `models/musucli.php` consulta 3 columnas que no existen **[V]**
El esquema define `usuario.iduser`, `usuario.segapel`, y relaciona el perfil mediante la tabla `usuario↔perfil` en `userxper`. El model usa nombres alternativos en 7 sitios:

| Línea | Código | Realidad (`db/urbanpaws.sql`) |
|---|---|---|
| `:167` | `WHERE idperf = :idperf` | `usuario` no tiene `idperf` (está en `userxper`, `sql:75-80`) |
| `:195` | `WHERE idusu = :idusu` | La PK es `iduser` (`sql:35`) |
| `:222`, `:227` | `INSERT (..., seapel, ..., idperf, idubi)` | Es `segapel`; `idperf` no existe |
| `:253`, `:259` | bind `:seapel`, `:idperf` | — |
| `:280`, `:284` | `UPDATE ... seapel = :seapel, idperf = :idperf` | — |
| `:287` | `WHERE idusu = :idusu` | — |
| `:332` | `DELETE FROM usuario WHERE idusu = :idusu` | — |

**Error resultante:** `Unknown column` (1054) en `getAll`, `getOne`, `save`, `upd` y `del`. **`models/musucli.php` es 100 % inoperable.** El error nace en `controllers/cusucli.php:25-27,67` que propaga `$_POST["seapel"]` y `setIdperf(2)`.

### A7. `models/musuadmin.php` y `models/musucli.php` llaman a una función que no existe **[V]**
`musucli.php:184, 212, 266, 322, 347` y `musuadmin.php:62, 87, 134, 149` llaman a `ManejoError($e)` como **función global**, sin instancia de clase y sin ningún `require`.

- La clase real es `misFun::ManejoError()` en `controllers/misfun.php:2-3`.
- `models/misfun.php` **no existe** (el archivo está en `controllers/`).
- No hay ningún `require` de `controllers/misfun.php` en todo el repo. **[V]**

**Error resultante:** `Fatal error: Uncaught Error: Call to undefined function ManejoError()`.
**Peor aún:** como este fatal ocurre *dentro* del `catch`, **tapa el error real de base de datos**. Los errores de columna de A6 quedan ocultos detrás de este.

### A8. `misFun` se instancia 17 veces pero la clase nunca se carga **[V]**
Cuatro models de Facturas instancian `misFun` sin ningún `require`:

| Model | Líneas |
|---|---|
| `models/mfacfac.php` | `:108`, `:140`, `:181`, `:214`, `:232` |
| `models/mfaclisfac.php` | `:125`, `:209`, `:241` |
| `models/mfarepfac.php` | `:112`, `:183`, `:234`, `:297` |
| `models/mfatdatfac.php` | `:99`, `:133`, `:171`, `:202`, `:220` |

**Error resultante:** `Error: Class "misFun" not found` — pantalla en blanco. Como PHP 8 lanza las excepciones SQL al `catch` por defecto, **cualquier** error de base de datos en Facturas produce un fatal en vez de un mensaje.

### A9. La función JavaScript `err()` no existe **[V]**
`controllers/misfun.php:14` → `echo '<script>err("' . $mjs . '");</script>';`
`grep` de `err(` / `function err` en `*.php`, `*.js`, `*.css` → **una sola coincidencia**: esa misma línea. No hay `function err()` en ningún archivo del proyecto.
**Error resultante:** aunque la clase existiera, el navegador lanzaría `ReferenceError: err is not defined` y el usuario nunca vería el mensaje de error. **El mecanismo de reporte de errores del proyecto está completo e inútil.**

### A10. `index.php` lee `pg` pero nunca lo usa para enrutar **[V]**
`index.php:90` → `$pg = isset($_GET["pg"]) ? $_GET["pg"] : NULL;`
Los únicos `include` de `index.php` son los 4 controllers de autenticación (`:128`, `:133`, `:138`, `:143`), fijos y no condicionados por `pg`. `pg` solo se lee en JavaScript (`:156-168`) y únicamente para activar las pestañas 28-31.

**Consecuencia:** todo `index.php?pg=N` distinto de 28-31 se descarta. Además `index.php:6-9` redirige a `home.php` **sin propagar `pg`** cuando ya hay sesión, de modo que el usuario aterriza en `pg=1`.

**Enlaces afectados:** `controllers/cserpas.php:41`, `controllers/cserserps.php:22,34`, `controllers/cserrutps.php:49,60`, `views/vserpas.php:13,54`, `views/vserserps.php:54,56`, `views/vserrutcl.php:68`, `views/vserrutps.php:13,102,105`, `views/vcofval.php:9,99,102`.

### A11. `pg=10` no existe en el ruteo **[V]**
`home.php:49-51` salta de `pg==9` a `pg==11`. Sin embargo existen completos `controllers/cmasdue.php` y `models/mmasdue.php`. El módulo "Dueños de Mascotas" es **inalcanzable desde cualquier URL**.

### A12. `pg=32` no existe en ninguna parte **[V]**
`controllers/cserrutps.php:49`, `:60` y `views/vserrutps.php:13`, `:102`, `:105` apuntan a `index.php?pg=32`. `home.php` termina en `pg==31` (`:75`) e `index.php` no enruta. Dead-end: crear, editar y borrar rutas son inalcanzables.

### A13. El módulo Mascotas postea a la pantalla equivocada **[V]**
| Línea | Código | Donde landinga realmente |
|---|---|---|
| `views/vmasmas.php:30` | `<form action="home.php?pg=27&ope=save">` | `home.php:70` → `views/vcofval.php` ("Valores") |
| `views/vmasmas.php:176` | `home.php?pg=27&ope=edi&idmasc=…` | `views/vcofval.php` |
| `views/vmasmas.php:179` | `home.php?pg=27&ope=eli&idmasc=…` | `views/vcofval.php` |
| `controllers/cmasmas.php:77`, `:89` | `window.location.href = "index.php?pg=27&iduser=…"` | 404 / `pg=1` (ver A10) |

`home.php?pg=27` es **Configuración → Valores**, no Mascotas (`pg=9`).
**Consecuencia:** guardar, editar y **borrar** una mascota no ejecutan `controllers/cmasmas.php`; el POST se pierde y se renderiza la pantalla de Valores.

### A14. Los formularios de Valores apuntan a `index.php` **[V]**
`views/vcofval.php:9` → `<form action="index.php?pg=27&ope=save">`
`views/vcofval.php:99` → `index.php?pg=27&ope=edi&idval=…`
`views/vcofval.php:102` → `index.php?pg=27&ope=eli&idval=…`
Con sesión activa, `index.php:6-9` redirige a `home.php` **sin `pg`** → el usuario aterriza en `pg=1`. Crear, editar y borrar valores no funciona y se pierden los datos del formulario.

### A15. Redirecciones a `../index.php` en el módulo Usuarios **[V]**
Los controllers de Usuarios usan `header('Location: ../index.php?pg=N')`:

| Archivo y línea | Destino | Efecto real |
|---|---|---|
| `controllers/cusudatper.php:16` | `../index.php?pg=7&ok=1` | `home.php?pg=1` |
| `controllers/cusulisusu.php:10, 16, 22` | `../index.php?pg=5` | `home.php?pg=1` |
| `controllers/cusuval.php:10, 16` | `../index.php?pg=6` | `home.php?pg=1` |
| `controllers/cusuubi.php:13, 22, 28` | `../index.php?pg=8` | `home.php?pg=1` |
| `views/vusuubi.php:47` | `index.php?pg=8` (cancelar) | 404 |

`index.php` no enruta por `pg` y con sesión redirige a `home.php` sin parámetros. **Guardar datos personales, activar/desactivar/borrar usuarios, validar paseadores y gestionar ubicaciones devuelven al usuario al panel de Cliente en lugar de a su módulo.**

### A16. El modo edición de Ubicación es inalcanzable **[V]**
`views/vusuubi.php:79` genera el enlace `index.php?pg=8&edi=<?=$dt['idubi'];?>`.
Pero el modo edición lo lee `views/vusuubi.php:7` (`isset($_GET['edi'])`) desde `home.php`. Como `index.php` descarta `pg` y redirige sin query string, **`edi` nunca llega**. Las ramas de `views/vusuubi.php:6, 21, 25, 26-28, 33, 39` (prellenar formulario, `ope=editar`, botón cancelar) son **código muerto**.

### A17. `header()` después de output: el `echo` del `catch` rompe la redirección **[V]**
Los `catch` de los models hacen `echo` directo:
- `models/musuubi.php:26, 40, 56, 68`
- `models/musudatper.php:44, 59, 85`
- `models/musulisusu.php:31, 45, 58`
- `models/musuval.php:33, 48`

Como ese `echo` emite salida, el `header('Location: …')` posterior de `cusuubi.php:13,22,28`, `cusudatper.php:16`, `cusulisusu.php:10,16,22` y `cusuval.php:10,16` falla con:
```
Warning: Cannot modify header information - headers already sent
```

### A18. `header()` tras salida en Servicios **[V]**
`home.php` **no tiene `ob_start()`** (a diferencia de `index.php:2`), y `home.php:34` ya renderizó `views/header.php`. Por lo tanto cualquier `header()` ejecutado desde un controller incluido en el routing falla:

| Ubicación | Redirección | Efecto |
|---|---|---|
| `controllers/cserpas.php:41` | `header("Location: index.php?pg=14&iduser=…")` | Warning; el paseo **sí** se guarda pero el usuario no se mueve |
| `controllers/cserserps.php:22`, `:34` | `header("Location: index.php?pg=15&iduser=…")` | Warning; "Aceptar"/"Rechazar" cambian el estado pero **nunca redirigen** |
| `controllers/cserrutps.php:49`, `:60` | `header("Location: index.php?pg=32&iduser=…")` | Warning (latente: vista huérfana) |

### A19. Tres controllers externos comparten el mismo `ope="save"` **[V]**
`index.php:128-143` incluye los 4 controllers de autenticación **siempre y todos en la misma petición**. Y tres de sus formularios envían exactamente el mismo valor:

| Vista | Línea | Campo oculto |
|---|---|---|
| `views/vextregis.php` | `:18` | `<input type="hidden" name="ope" value="save">` |
| `views/vextreccon.php` | `:18` | `<input type="hidden" name="ope" value="save">` |
| `views/vextolv.php` | `:18` | `<input type="hidden" name="ope" value="save">` |

**Consecuencias concretas y verificadas:**
- Enviar el formulario **"¿Olvidó su contraseña?"** (que solo manda `emailu`) → `controllers/cextreccon.php:5-7` recibe `$nueva_pass = ""` y `$confirm_pass = ""` → la línea `:15` evalúa `"" === ""` como **VERDADERO** → ejecuta `password_hash("")` y **sobrescribe `usuario.passusu` con el hash de una cadena vacía**. Cualquiera puede inutilizar la contraseña de cualquier cuenta escribiendo su correo. **Destrucción masiva de credenciales sin autenticación.**
- Enviar el formulario **"Registrarse"** → `cextreccon.php` también se ejecuta con contraseñas vacías → mismo borrado del `emailu` tecleado; además `cextolv.php:12` genera una clave temporal.
- Enviar **"Recuperar Contraseña"** → `cextolv.php:12` también genera una clave temporal, y `cextregis.php` muestra el falso mensaje "Las contraseñas no coinciden".

### A20. Recuperación de contraseña sin token ni verificación de identidad **[V]**
`controllers/cextreccon.php:14-24`: con `ope=save&emailu=<víctima>&nueva_pass=X&confirm_pass=X` basta para cambiar la contraseña de cualquier cuenta.
- `:17` → `getByEmail()` solo filtra `WHERE emailu=:emailu AND estusr=1` (`models/mextreccon.php:29-31`).
- `:20-23` → `password_hash($nueva_pass)` + `updPass()`.
- **No hay:** token aleatorio, código por correo, verificación de propiedad del correo, sesión, ni siquiera unChallenge. **[V]**

**Impacto: toma de control total de cualquier cuenta del sistema.**

### A21. `views/vusupef.php` tiene HTML roto por una línea partida **[V]**
```php
19:            <div class="f
20:            
21:            orm-grid">
```
El navegador crea un `<div>` **sin clase** y luego interpreta `orm-grid">` como texto plano. **Se rompe el grid completo de la página de Perfil (`pg=4`).**

### A22. HTML con `class=` vacío **[V]**
`views/vfatdatfac.php:43` → `<span class=>PAGADA</span>`. El atributo queda sin valor y el `>` cierra la etiqueta, dejando "PAGADA" como texto suelto fuera de cualquier elemento con estilo.

### A23. `views/volv.php` tiene atributos `<form>` duplicados **[V]**
`views/volv.php:5`:
```html
<form method="post" action="" class="mb-5" action="colv.php" method="post">
```
El parser HTML usa la **primera** ocurrencia de cada atributo → `action=""` (ignora `colv.php`, que además **no existe** en el repo) y `method="post"`. La vista es huérfana, pero el error es real.

### A24. Las 4 vistas de Facturas muestran datos falsos **[V]**
Los controllers calculan `$datAll` / `$dton` / `$datResumen` / `$datPeriodo` / `$datEstado` / `$datFacturas` (4 consultas), pero las vistas **nunca los referencian**:

| Ubicación | Dato falso mostrado |
|---|---|
| `views/vfaclisfac.php:137-139` | "30 registros" |
| `views/vfaclisfac.php:241` | "Mostrando 1 a 4 de 30 registros" |
| `views/vfacrepfac.php:114,124,134,144` | KPIs (`$ 2.450.000`, "75%", etc.) |
| `views/vfacrepfac.php:163-173, 206,217,228` | Gráfico de barras y donuts |
| `views/vfacrepfac.php:264-289` | Tabla "Resumen financiero" completa |
| `views/vfatdatfac.php` (todo el archivo) | `#FAC-00001`, "05/05/2026", "Wilson Baratijas", conceptos y totales literales |

Descartados: `controllers/cfaclisfac.php:40,44`, `cfacfac.php:19`, `cfatdatfac.php:18`, `cfacrepfac.php:19-25`.

### A25. Los nombres de 7 campos del formulario de Factura no coinciden **[V]**
`views/vfacfac.php:34,46,58,67,82,94,108` envía `cliente`, `documento`, `fecha`, `estado`, `preciofin`, `descuento`, `comentarios`.
`controllers/cfacfac.php:6-11` lee `$_POST["fechfac"]`, `["preciolin"]`, `["estafac"]`, `["comenfac"]`, `["iduser"]`, `["iddetfac"]`.
**7 de 7 nombres错.** Además el `<form method="POST">` (`vfacfac.php:23`) **no tiene campo oculto `ope`**, así que `$ope` nunca vale `save`/`edi`/`eli`. **El formulario no puede hacer nada.**

### A26. `views/vfaclisfac.php` y `views/vfacrepfac.php` perder el contexto de página **[V]**
`views/vfaclisfac.php:31` y `views/vfacrepfac.php:40` usan `<form method="GET">` **sin `action` ni campo `pg` oculto**. El navegador reemplaza la query string actual (`home.php?pg=19`) por los datos del formulario → queda `home.php?cliente=…&estado=…`. Entonces `home.php:37` (`$pg = isset($_GET["pg"]) ? $_GET["pg"] : 1`) manda al usuario **silenciosamente a `pg=1` (Cliente)**.

---

# BLOQUE B — ERRORES DE SEGURIDAD

### B1. Ningún controller verifica sesión ni rol **[V]**
`home.php:5` valida `$_SESSION['iduser']`, pero **los controllers son URLs públicas bajo `/controllers/`** (las vistas los enlazan directamente: `views/vusulisusu.php:44`, `views/vusuval.php:40`, `views/vusuubi.php:82`) y **no existe ningún `.htaccess` en todo el repositorio** (verificado: 0 resultados). Además **ningún controller hace `require` de `models/seguridad.php`** (verificado: 0 coincidencias).

**Exploit trivial sin autenticación:**
```
/UrbanPaws/controllers/cusulisusu.php?ope=borrar&iduser=1
/UrbanPaws/controllers/cusuval.php?ope=aprobar&iduser=1
/UrbanPaws/controllers/cusuubi.php?ope=borrar&idubi=1
/UrbanPaws/controllers/cusuadmin.php?ope=eli&iduser=1
```

### B2. CSRF ausente en todas las acciones destructivas
Las operaciones de borrado y cambio de estado son **enlaces GET sin token**:
- `views/vusulisusu.php:44, 48, 52`
- `views/vusuval.php:40, 43`
- `views/vusuubi.php:82`
- `views/vmasmas.php:179`
- `views/vcofcof.php:117`, `views/vcofdom.php:84`, `views/vcofmod.php:125`, `views/vcofpag.php:139`, `views/vcofval.php:102`

Los formularios tampoco llevan token: `views/vusudatper.php:29-31`, `views/vusuubi.php:24-28`, `views/vextini.php:15`, `views/vextregis.php:17`, `views/vextreccon.php:17`, `views/vextolv.php:17` (todos con `action=""`).

Basta una etiqueta `<img src="…cusulisusu.php?ope=borrar&iduser=1">` en un comentario de otra web para ejecutar cualquiera de estas acciones con la sesión de la víctima. Combinado con B1, ni siquiera hace falta victimizar a nadie.

### B3. IDOR en "Datos Personales" — se puede editar cualquier usuario
`views/vusudatper.php:7` → `$iduser = isset($_GET['iduser']) ? $_GET['iduser'] : 1;`
El formulario reinyecta ese id como campo oculto (`:31`) y `controllers/cusudatper.php:8` lo usa directamente de `$_POST['iduser']` **sin contrastarlo con `$_SESSION['iduser']`**. Basta reenviar el POST cambiando ese campo para modificar el perfil de otro usuario. El propio `TODO` de `views/vusudatper.php:5-6` documenta que falta conectar la sesión.

### B4. IDOR en Mascotas — se ven y se borran mascotas de todos **[V]**
- `models/mmasmas.php:37-53` (`getAll`) → `SELECT … FROM mascotas m LEFT JOIN usuario u … ORDER BY m.idmasc ASC` **sin `WHERE m.iduser = …`**. Devuelve **todas las mascotas del sistema** a cualquier usuario, con botones de editar y borrar (`views/vmasmas.php:176-182`).
- `controllers/cmasmas.php:81-91` (`ope=eli`) borra la mascota **sin verificar propiedad** y mediante GET sin token.
- `controllers/cmasmas.php:25` → `$iduser = isset($_REQUEST["iduser"]) ? …` con el comentario *"SIN SESIÓN: el dueño llega por URL"*.

### B5. IDOR en Servicios
`controllers/cserpas.php:9`, `cserrutcl.php:9`, `cserrutps.php:10`, `csersercl.php:8`, `cserserps.php:8` aceptan `iduser` por `$_REQUEST`. Cualquier usuario logueado opera en nombre de otro.

`controllers/cserserps.php:17-36` (`updEstado`) cambia el estado de cualquier paseo sin verificar que la ruta pertenece al paseador autenticado.

### B6. IDOR en las vistas huérfanas de Servicios **[V]**
`controllers/cserrutps.php:10` y `csersercl.php:8`:
```php
$iduser = isset($_SESSION["iduser"]) ? $_SESSION["iduser"]
        : (isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL);
```
Sin sesión, cualquiera lee las rutas/servicios de cualquier usuario con `&iduser=X`.

### B7. Ausencia de control de roles: cualquier usuario registrado entra a Configuración **[V]**
`home.php:5` solo comprueba `if (!isset($_SESSION['iduser']))`.
`models/mextregis.php:80-83` inserta en `usuario` **sin crear filas en `userxper`**. Un usuario registrado públicamente tiene `nomperf = NULL` y aun así accede a `pg=2` (Administrador), `pg=23-27` (Página, Módulo, Config del sistema, Dominios, Valores) y puede `INSERT/UPDATE/DELETE` sobre las tablas de configuración.

### B8. Session fixation: sin `session_regenerate_id()` **[V]**
`controllers/cextini.php:21-27`:
```php
session_start();
$_SESSION['iduser'] = $user['iduser'];
…
header("Location: home.php");
```
No se regenera el ID de sesión tras autenticar. Un atacante que fije el `PHPSESSID` antes del login conserva la sesión válida después.

### B9. `session_start()` duplicado genera Notice en PHP 8 **[V]**
`controllers/cextini.php:21` llama `session_start()` cuando **ya hay sesión activa** (`index.php:3`). Resultado:
```
Notice: session_start(): Ignoring session_start() because a session is already active
```
Lo mismo en `models/control.php:18` frente a `models/control.php` incluido desde un contexto ya inicializado.

### B10. `models/seguridad.php` nunca se incluye — la bandera `aut` nunca existe **[V]**
`models/seguridad.php:4` exige `$_SESSION["aut"] == "urbanpaws_ok_2024"`. El único código que asigna ese valor es `models/control.php:22`, y **`models/control.php` tampoco lo incluye nadie** (verificado: 0 coincidencias).

**Resultado:** el archivo de seguridad del proyecto está muerto, y el único login vivo (`cextini.php:22-25`) nunca asigna `aut`. Si alguien activara `seguridad.php`, bloquearía **a todos los usuarios legítimos**.

### B11. Sin `password_hash` en el módulo Usuarios — usuarios que no pueden autenticarse **[V]**
`controllers/cusucli.php:61-78` (bloque `ope=save`) **nunca llama a `setPassusu()` ni a `setClaveu()`**, aunque ambos setters existen (`models/musucli.php:138`, `:143`). Por tanto `models/musucli.php:244-245, 257-258` insertan `NULL` en `passusu` y `claveu`, ambas columnas `UNIQUE NOT NULL`-en-la-práctica (`db/urbanpaws.sql:44-45`).
Como `cextini.php:20` usa `password_verify($contrasena, $user['passusu'])`, **todo usuario creado por esta vía nace con contraseña nula y no puede iniciar sesión jamás**. El módulo Usuarios no usa `password_verify` en ningún punto.

### B12. Sin rate-limiting ni bloqueo de intentos en el login **[V]**
`controllers/cextini.php:12-31` no cuenta intentos ni bloquea cuentas. `models/mextini.php:31` consulta con un OR triple:
```sql
WHERE (u.docu = :docu OR u.emailu = :emailu OR u.teleu = :teleu) AND u.estusr = 1
GROUP BY u.iduser
```
Permite fuerza bruta ilimitada sobre documento, email y teléfono.

### B13. Enumeración de usuarios **[V]**
`controllers/cextolv.php:29` y `cextreccon.php:32` devuelven un mensaje distinto para "correo no encontrado" que para el éxito, permitiendo enumerar correos registrados.

### B14. La clave temporal nunca se envía (flujo inservible) **[V]**
`controllers/cextolv.php:17-22`:
```php
$claveTemp = bin2hex(random_bytes(8));
$mcextolv->setClaveu($claveTemp);
if($mcextolv->saveClave()){
    // TODO: enviar correo con $claveTemp
    $mensaje = "Se ha generado una clave temporal. Por favor revise su correo.";
```
Se genera la clave, se guarda en `usuario.claveu`, y **nunca se envía**. El usuario recibe un mensaje que le pide revisar un correo que no existe. PHPMailer está declarado en `composer.json` pero **no se usa en ninguna parte del proyecto**.

### B15. Colisión con índice UNIQUE al recuperar contraseña **[V]**
`db/urbanpaws.sql:45` → `claveu VARCHAR(255) UNIQUE`.
`controllers/cextreccon.php:23` → `setClaveu('')` escribe **cadena vacía**. Solo un usuario puede tener `claveu=''`; el segundo reset de contraseña lanza `PDOException` por duplicado (error 1062) y el `updPass()` **falla silenciosamente**.

### B16. Mass assignment del estado de cuenta
`controllers/cusuadmin.php:13-14, 30-31` toma `$estusr` y `$ECMusr` literalmente del POST y los persiste en `models/musuadmin.php:102-103`. Un POST forjado fija el estado de la cuenta sin autorización.
`controllers/cusupef.php:14-15, 41-42` → `models/musupef.php:127` idem.

### B17. Fuga de credenciales a la capa de presentación
`SELECT *` sobre `usuario` devuelve `passusu` (hash) y `claveu` (clave temporal en claro) al controller y potencialmente a la vista:

| Ubicación | Método |
|---|---|
| `models/musucli.php:165` | `getAll` |
| `models/mextini.php:27` | `login` |
| `models/mextregis.php:109, 122` | check de duplicados |
| `models/mextreccon.php:29`, `models/mextolv.php:20` | `getByEmail` |
| `models/mextreccon.php:61` | `getAll` (expone `claveu`) |

### B18. Subida de archivos sin validaciones suficientes
`controllers/cmasmas.php:8-20` (`subirArchivo()`):
- Línea 11: `in_array($ext, ["jpg","jpeg","png","pdf"])` acepta **PDF para `fotomasc`** (un logo/foto no debería ser PDF).
- **No valida tamaño**, pese a que `views/vmasmas.php:83` promete "máx. 5MB".
- **No usa `is_uploaded_file()`**.
- Escribe en `uploads/` (el directorio **no existe**, se crea con `mkdir(…,0777,true)`) **sin `.htaccess`** que impida ejecución o descarga de archivos subidos.

### B19. Credenciales de base de datos commiteadas al repositorio **[V]**
`models/config.php:2-5` → `$user = "root"` con `$pass = ""`. Está en el control de versiones.

### B20. `models/conexion.php` sin `charset` y sin modo de error explícito **[V]**
```php
$conexion = new PDO("mysql:host=$host;dbname=$bd;", $user, $pass);
```
- Sin `charset=utf8mb4` en el DSN (depende del default del servidor; afecta los emojis de `footer.php:48`).
- Sin `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` ni `ATTR_EMULATE_PREPARES`. El proyecto **depende del default** `ERRMODE_EXCEPTION` de PHP 8 en todo el manejo de errores.
- `include("config.php")` usa una **ruta relativa sin `__DIR__`**: si el entry point es un controller accedido por URL, el `include_path` resuelve contra el CWD y falla con *"Failed opening required 'config.php'"*.

---

# BLOQUE C — ERRORES DE BASE DE DATOS

### C1. Tres `GROUP BY` incompletos violan `ONLY_FULL_GROUP_BY`
MySQL 5.7+/8.0 (el de XAMPP) activa `ONLY_FULL_GROUP_BY` por defecto. Error **1055** en cada ejecución:

| Ubicación | `SELECT` no agregadas | `GROUP BY` |
|---|---|---|
| `models/musuadmin.php:69-77` (`getOne`) | 9 columnas: `u.docu, u.prinom, u.seconom, u.priapel, u.emailu, u.teleu, u.foto, u.estusr, u.ECMusr` | solo `u.iduser` |
| `models/musulisusu.php:18-25` | `u.docu, prinom, seconom, priapel, emailu, teleu, estusr, b.nomubi` | solo `u.iduser` |
| `models/musuval.php:19-27` | `u.docu, prinom, seconom, priapel, emailu, teleu, estusr` | solo `u.iduser` |

Contraste que demuestra la inconsistencia: `models/musuadmin.php:51-53` (`getAll`) **sí** lista todas las columnas en el `GROUP BY`.
**Consecuencia:** `pg=2`, `pg=5` (Listar Usuarios) y `pg=6` (Validar Usuario) quedan **completamente en blanco**.

### C2. El dump SQL no contiene ni un solo `INSERT` **[V]**
`db/urbanpaws.sql` (190 líneas) solo tiene `CREATE TABLE`. Cero sentencias `INSERT`.

**Consecuencias:**
- `dominio` y `valor` quedan **vacías** → `controllers/cmasmas.php:98-100` (`setIddom(5); $datRaz = $mcofvalRaz->getByDom();`) devuelve `[]` → el `<select name="razamasc" required>` de `views/vmasmas.php:58-66` queda **sin opciones** → **el formulario de mascota es imposible de enviar** (`required` con cero `<option>` reales).
- `perfil`, `usuario`, `ubicacion`, `config`, `modulo`, `pagina` también vacías: no hay ningún usuario administrador con el que entrar al sistema.
- `controllers/cmasmas.php:99` usa `setIddom(5)`, un **valor mágico** sin ningún `INSERT` que lo respalde.

### C3. Ningún model fija `charset` ni modo de error — ver B20 **[V]**

### C4. Placeholder duplicado con un solo `bindParam` **[V]**
`models/mserrut.php:135`:
```sql
AND (:idubi IS NULL OR r.idubi = :idubi)
```
`models/mserrut.php:143` → `$result->bindParam(":idubi", $idubi);` — **una sola vez**.
Funciona únicamente porque MySQL emula prepared statements por defecto. Con `ATTR_EMULATE_PREPARES => false` lanzaría **HY093**. (Y `r.idubi` no existe de todos modos — ver A1.)

### C5. `INNER JOIN` ocultan filas en Detalle de Factura
`models/mfatdatfac.php:86-88` usa tres `INNER JOIN` (ruta, servicio, mascotas) mientras `controllers/cfatdatfac.php:8-10` no valida ninguno de esos campos (llegan en `NULL` desde `isset(...) ? … : NULL`). Una fila insertada con `idrut`/`idserv`/`idmasc` nulos **desaparece de `getAll()` sin error ni aviso**.

### C6. `estafac` es BOOLEAN: el estado "Vencida" es imposible **[V]**
`db/urbanpaws.sql:150` → `estafac BOOLEAN`.
`models/mfaclisfac.php:168` mapea `'vencida'` a `f.estafac = 0`, **idéntico** a `'pendiente'` (`:170`). `models/mfaclisfac.php:108-111` y `mfacrepfac.php:192-195` solo generan `'Pagada'`/`'Pendiente'`.
**Los `<option value="vencida">` de `views/vfaclisfac.php:56` y `views/vfacrepfac.php:75` son indistinguibles de "Pendiente".**

### C7. JOIN a `valor` sin filtrar por `iddom` **[V]**
`models/mcofcof.php:33, 51` → `LEFT JOIN valor v ON c.estacon = v.idval`
`models/mcofdom.php:22, 38` → `LEFT JOIN valor v ON d.actdom = v.idval`
Falta `AND v.iddom = …`. Como `valor` contiene los valores de **todos** los dominios, el JOIN puede resolver contra un `idval` de otro dominio.
Además hay **coerción implícita de tipos**: `config.estacon INT(3)` vs `valor.idval BIGINT(11)`, y `dominio.actdom VARCHAR(3)` vs `BIGINT(11)`.

### C8. Fuga de mensajes SQL crudos al navegador **[V]**
Estos models hacen `echo` del mensaje crudo de PDO, saltándose por completo el patrón `misFun::ManejoError`:

| Model | Líneas | Contenido filtrado |
|---|---|---|
| `models/mcofcof.php` | `:41, 61, 87, 120, 135` | `"Error 1: " . $e->getMessage()`; `:135` imprime el **stack trace completo** |
| `models/mcofdom.php` | `:29, 48, 70, 118` | `"Error 1: " . $e->getMessage()` |
| `models/mcofpag.php` | `:42, 56, 74, 95, 107` | `"Error 1: " . $e->getMessage()` |
| `models/mmasmas.php` | `:51, 72, 106, 148, 163` | `"Error N: " . $e->getMessage()` |
| `models/mmasdue.php` | `:34, 57, 74, 91, 111, 126, 141` | `"Error N: " . $e->getMessage()` |

**Expone al usuario final nombres de tablas, columnas y estructura de la base de datos.**

### C9. `strpos()` sin comparar contra `false` en `misfun.php` **[V]**
`controllers/misfun.php:7` → `if(strpos($e,'1115') || strpos($e,'1451'))`
`controllers/misfun.php:9` → `elseif(strpos($e,'1116') || strpos($e,'1062'))`

`strpos()` devuelve **`0`** cuando encuentra la coincidencia **al inicio del string**, y `0` es *falsy* en PHP. Si el mensaje de error empieza por esos dígitos, la rama **no** se toma y el error se muestra como genérico en vez del mensaje específico de FK o duplicado. Debería ser `strpos($e,'1115') !== false`.

### C10. Inconsistencia de tamaños de columna **[V]**
`db/urbanpaws.sql:88` → `mascotas.razamasc VARCHAR(70)`
`db/urbanpaws.sql:185` → `valor.codval VARCHAR(255)`
Un valor de dominio largo se **trunca** (error 1406 en modo estricto) al guardar la raza desde `views/vmasmas.php:58-66`.

### C11. Techos de `AUTO_INCREMENT` insuficientes **[V]**
| Tabla | Tipo | Techo |
|---|---|---|
| `paseo.idpas` | `BIGINT(5)` (`db:112`) | 99 999 paseos |
| `ruta.idrut` | `INT(6)` (`db:104`) | 2 147 483 647 rutas |
| `pagina.idpag` | `INT(3)` (`db:24`) | 2.1 × 10⁹ |
| `factura.idfac` | `BIGINT(10)` (`db:147`) | 1.1 × 10¹¹ |

`paseo.idpas` es el riesgo real: el `AUTO_INCREMENT` desborda al llegar a 100 000.

---

# BLOQUE D — ERRORES DE RUTEO Y CÓDIGO MUERTO

### D1. Los 3 controllers de Usuarios no incluyen su vista **[V]**
| Archivo | Línea | Problema |
|---|---|---|
| `controllers/cusuadmin.php` | `:44` | Termina en `?>` sin `include("views/vusuadmin.php")` |
| `controllers/cusucli.php` | `:93` | Termina sin incluir su vista |
| `controllers/cusupef.php` | `:75-77` | Termina sin incluir su vista |

Consecuencia:tras `ope=save` o `ope=eli` la respuesta HTTP es una **página completamente vacía**.

### D2. `controllers/cusupef.php` tiene un comentario que afirma algo falso **[V]**
`controllers/cusupef.php:75-76` dice *"La vista (vusupef.php) es quien incluye a este controlador"*. Pero **`views/vusupef.php` es HTML estático sin una sola etiqueta `<?php`**: no incluye nada.

### D3. Los 3 controllers de Usuarios no se referencia en ninguna parte **[V]**
`home.php:40-43` incluye directamente `views/vusucli.php`, `views/vusuadmin.php`, `views/vusupas.php`, `views/vusupef.php`, **saltándose los controllers**.
**Consecuencia funcional:**
- **`pg=4` (Perfil) es una maqueta sin datos** — muestra "Nombre del usuario" y "correo@ejemplo.com" literales (`views/vusupef.php:24, 29`).
- **`pg=1` (Cliente)** y **`pg=2` (Administrador)** son paneles estáticos.
- Los modelos `musuadmin.php` y `musupef.php` implementan CRUD completo que **nadie ejecuta**.

### D4. `controllers/cmasdue.php` es huérfano **[V]**
Ningún `include`/`require` lo carga. Además solo hace `require_once("models/mmasdue.php")`, y **ni `mmasdue.php` ni `musupef.php` cargan `models/conexion.php`** (a diferencia de `mserrut.php:3` y `mserpas.php:3`). Si se incluyera aislado: `Fatal error: Uncaught Error: Class "Conexion" not found`.

### D5. `views/vsersercl.php` + `controllers/csersercl.php` son huérfanos **[V]**
`home.php:54` mapea `pg=14` a `views/vserserps.php` (panel del **paseador**), pero `views/vsersercl.php:12` (`Entra con: index.php?pg=14&iduser=X`) y `controllers/csersercl.php:7` asumen que `pg=14` es el panel del **cliente**. **El listado de servicios del cliente no se puede abrir por ninguna URL.**

### D6. `views/vserrutps.php` + `controllers/cserrutps.php` son huérfanos **[V]**
Ningún `pg` de `home.php` los carga. Todo el módulo "Rutas del Paseador" (crear/editar/borrar ruta) es **inalcanzable**.

### D7. Vistas huérfanas de Usuarios **[V]**
`views/vregis.php` — **archivo vacío (0 bytes)** **[V]**
`views/vreccon.php` — **archivo vacío (0 bytes)** **[V]**
`views/volv.php` — huérfana, y además con errores propios (ver A23 y D9)

### D8. `views/volv.php` referencia columnas inexistentes **[V]**
`views/volv.php:16-17` usa `$dt["emaper"]` y `$dt["pasper"]`. **Ningún `emaper` ni `pasper` existe en `db/urbanpaws.sql`**; las columnas reales son `emailu` y `passusu`.
Además `$datAll` (`:14`) no lo define ningún controller de esta vista → `Warning: Undefined variable $datAll`.

### D9. `pg=28..31` incluyen vistas sin su controller **[V]**
`home.php:72-75` incluye `views/vextregis.php`, `vextini.php`, `vextreccon.php`, `vextolv.php`, pero **ninguna de las 4 vistas hace `require_once` de su controller** (los `require` solo están en `index.php:128-143`).
**Consecuencia:** al cargar `home.php?pg=28`, el `<form action="">` (`views/vextregis.php:17`) hace POST a `home.php?pg=28`, donde **`cextregis.php` nunca se carga** → `$ope` nunca se lee → **el registro desde el panel autenticado no hace absolutamente nada.** Igual para `pg=29/30/31`.

### D10. `pg=10` sin ruta pese a existir controller y model — ver A11 **[V]**

### D11. Label del menú que no corresponde a la vista **[V]**
`views/header.php:32` → `<a href="home.php?pg=3">Contraseña</a>`.
Pero `pg=3` → `views/vusupas.php`, que es el **panel del Paseador** (`views/vusupas.php:9, 17-18, 22`).
Además **no existe ningún endpoint de cambio de contraseña** en todo el proyecto, pese a que `views/vusupef.php:109` ofrece un botón "Cambiar contraseña".

### D12. `views/header.php:149` manda a un usuario autenticado al registro público **[V]]
`<a href="home.php?pg=28"><i class="fa-solid fa-cloud me-2"></i>Externo</a>` en el menú móvil. Apunta a la vista pública de registro, que además está rota por D9.

### D13. `require_once` sin `../` en 3 controllers **[V]**
| Archivo | Línea | Usa | Debería usar |
|---|---|---|---|
| `controllers/cusuadmin.php` | `:3` | `require_once("models/musuadmin.php")` | `'../models/…'` |
| `controllers/cusucli.php` | `:3` | `require_once("models/musucli.php")` | `'../models/…'` |
| `controllers/cusupef.php` | `:3` | `require_once("models/musupef.php")` | `'../models/…'` |

Los otros 4 controllers del mismo módulo sí usan `'../models/…'`. Accediendo por URL directa, PHP resuelve contra el directorio del script y falla con *"Failed opening required 'models/…'"*.

### D14. `require_once` inútil **[V]**
`controllers/ccofmod.php:4` → `require_once("models/musupef.php")`. Los perfiles se cargan con `mcofmod.php:142-149` (`getPerfiles()`). Ningún símbolo de `musupef` se usa en el controller ni en `views/vcofmod.php`.

### D15. Modelos que no cargan `conexion.php` **[V]**
`models/musuadmin.php` (usa `new Conexion()` en `:56, 79, 106, 142`) y `models/musupef.php` (en `:80, 104, 149, 180, 203, 234`) **no tienen ningún `require`**.
Contrasta con `musucli.php:2`, `musudatper.php:2`, `musulisusu.php:2`, `musuubi.php:2`, `musuval.php:2`, `mserrut.php:3`, `mserpas.php:3`, que **sí** lo hacen.
Estos modelos solo funcionan porque `home.php:10` los carga de antemano.

### D16. Métodos muertos (nunca invocados por ningún controller)
| Método | Ubicación |
|---|---|
| `mServPas::del()` | `models/mserpas.php:278` — **no existe forma de cancelar/eliminar un paseo desde la UI** |
| `mServRut::getAll()` | `models/mserrut.php:40` |
| `mServPas::getAll()`, `getOne()`, `upd()` | `models/mserpas.php:34, 63, 215` |
| `mCofdue::getOne()`, `upd()` | `models/mmasdue.php:39, 96` |
| `mPerfil::updUbicacion()` | `models/musupef.php:195-220` |
| `mExtreccon::getAll()` | `models/mextreccon.php:60-71` — además expondría `claveu` en claro si se conectara |
| `models/control.php` (completo) | Segunda implementación de login, **inalcanzable** |

### D17. Propiedades y variables muertas
| Ubicación | Elemento muerto |
|---|---|
| `models/musuadmin.php:15, 27, 39` | `$idperf` — getter/setter existen, `setIdperf()` nunca se llama |
| `models/musudatper.php:12, 21, 30` | `$foto` — se selecciona y tiene setter, `upd()` (`:67-74`) no la persiste |
| `models/musuval.php:6-7, 9-13` | `$iduser` / `$estusr` — setters nunca usados |
| `controllers/ccofdom.php:39` | `$datEst` — `getAll()` de todos los valores de todos los dominios; **la vista nunca lo usa** |
| `controllers/cmasdue.php:14` | `$dtOn` — nunca se asigna ni se usa |
| `controllers/cmasdue.php:31` | `$datAllDue` — `SELECT` completo cuyo resultado se descarta |
| `index.php:90` | `$pg` — se lee pero nunca se usa en PHP (solo en JS) |
| `controllers/cusuubi.php:7` | `$datAll = $ubi->getAll()` — corre en **todas** las peticiones, incluso en guardar/editar/borrar |

---

# BLOQUE E — CONTRATOS ROTO ENTRE CAPAS

### E1. `controllers/cusupef.php:34-43` vs `models/musupef.php:141-147`: 5 campos enviados se descartan en silencio **[V]**
El controller asigna `docu`, `seconom`, `estusr`, `ECMusr` e `idubi`, pero `upd()` solo persiste `prinom, priapel, emailu, teleu, foto`.
**Un guardado "exitoso" pierde 5 de 10 datos sin ningún aviso.**

### E2. Nombres de filtros que no coinciden (Facturas) **[V]**
| Vista envía | Controller lee |
|---|---|
| `views/vfaclisfac.php:67, 78, 89, 102` → `fecha_inicio`, `fecha_fin`, `monto_min`, `monto_max` | `controllers/cfaclisfac.php:11-15` → `fechaInicio`, `fechaFin`, `montoMin`, `montoMax` |
| `views/vfacrepfac.php:51, 62` → `fecha_inicio`, `fecha_fin` | `controllers/cfacrepfac.php:5-8` → `fechaInicio`, `fechaFin` |

Solo `cliente` y `estado` coinciden. **Los 4 filtros de monto/fecha de `pg=19` y los 2 de `pg=20` son inalcanzables** (y `models/mfaclisfac.php:174-192` nunca construye esas condiciones SQL).

### E3. Campo `cliente` que no existe en el módulo Reporte **[V]**
`views/vfacrepfac.php:86` envía `cliente`. `models/mfarepfac.php` **no tiene** propiedad `cliente`, ni setter, ni condición SQL que lo use.

### E4. `views/vfaclisfac.php` muestra una columna "Servicio" que ningún query produce **[V]**
`views/vfaclisfac.php:152, 166, 183, 200, 221` renderizan una columna "Servicio", pero **ninguna** de las 3 consultas de `models/mfaclisfac.php` (`getAll` `:97-115`, `getFiltered` `:133-149`, `getOne` `:217-229`) devuelve un campo de servicio.

### E5. `views/vusupef.php:65` — formulario sin destino real **[V]**
```html
<form action="#" method="post">
```
Sin campo `ope`, sin `iduser` oculto, sin ningún controller escuchando. El botón "Guardar cambios" (`:94`) hace POST a la propia URL y **no ejecuta nada**.
Además los nombres de campo (`nombre`, `apellido`, `correo`, `telefono`, `direccion` — líneas `:69, 74, 79, 84, 89`) **no coinciden con ningún campo del modelo** (`prinom`, `seconom`, `priapel`, `emailu`, `teleu`).

### E6. 9 enlaces a archivos inexistentes en vistas estáticas **[V]**
Ninguno usa el patrón `home.php?pg=` correcto:

| Ubicación | Enlace | Problema |
|---|---|---|
| `views/vusuadmin.php:25` | `vmen.php` | No existe |
| `views/vusuadmin.php:37` | `vruta.html` | No existe ningún `.html` en el repo |
| `views/vusuadmin.php:43` | `vservicios.html` | No existe |
| `views/vusuadmin.php:55` | `vpqrs.html` | No existe (y el módulo PQRS no existe) |
| `views/vusuadmin.php:61` | `vcofmod.php` | El real está en `views/` |
| `views/vusupas.php:34` | `vserpas.php` | El real está en `views/` → **404** |
| `views/vusupas.php:40` | `vserrutcl.php` | El real está en `views/` → **404** |
| `views/vusupas.php:46` | `vserser.php` | El real es `views/vserserps.php` → **404** |
| `views/vusupas.php:52` | `vusupef.php` | El real está en `views/` → **404** |

### E7. `views/vusucli.php:43` manda al cliente al panel del paseador **[V]**
`<a href="home.php?pg=14">Servicios</a>` en la vista del **cliente**. Pero `home.php:54` carga `views/vserserps.php`, que ejecuta `mServPas::getByPaseador()` con `INNER JOIN ruta r ON r.iduser = :iduser` (`controllers/cserserps.php:44`). Para un cliente la tabla **siempre sale vacía**.

### E8. `views/vusuubi.php:79` / `views/vserpas.php:54` / `views/vserserps.php:54,56` — destinos no enrutados **[V]**
| Ubicación | Enlace | Problema |
|---|---|---|
| `views/vusuubi.php:79` | `index.php?pg=8&edi=…` | No enrutado (ver A16) |
| `views/vserpas.php:54` | `index.php?pg=13&iduser=…&ope=save` | No enrutado (ver A10) |
| `views/vserserps.php:54` | `index.php?pg=15&ope=aceptar&…` | No enrutado **y** `pg=15` apunta a `views/vserlisser.php` inexistente |
| `views/vserpas.php:13` | `index.php?pg=11&iduser=…` | Debería ser `home.php?pg=11`, que **sí** existe (`home.php:51`) |
| `views/vserrutcl.php:68` | `index.php?pg=13&…` | No enrutado |
| `views/vserrutps.php:13, 102, 105` | `index.php?pg=32` | `pg=32` no existe (ver A12) |

### E9. `ope=save` sin `iduser` es un no-op silencioso **[V]**
`controllers/cusuadmin.php:22-35` — el `if($iduser)` de la línea `:33` **no tiene rama `else`**, a diferencia de `controllers/cusucli.php:74-77` y `cusupef.php:45-49` que sí crean el registro.
**Guardar un usuario nuevo desde el panel admin no hace nada y no avisa.**

### E10. `controllers/cmasmas.php` no borra los dueños previos al editar **[V]**
`controllers/cmasmas.php:68-75`: al editar (`$idmasc` truthy → `$idmascNew = $idmasc`, línea `:63`) **no se borran los `duenomasc` previos**; solo se insertan los nuevos (`:72-73`). Si el formulario cambia de dueño, la mascota queda con **varios dueños** en `duenomasc`. `delByMasc()` (`:84`) solo corre en `ope=eli`.

### E11. Conflicto de semántica en `usuario.estusr` **[V]**
`db/urbanpaws.sql:46` → `estusr TINYINT(1)`.
`models/musuval.php:38` lo documenta como `1=aprobado, 2=rechazado, 0=pendiente` (usado en `:15` y `:26`).
Pero `controllers/cusulisusu.php:9, 15` escribe `1`/`0` sobre la **misma columna** con otro significado (activar/desactivar), y `views/vusulisusu.php:36-40` colapsa `0` y `2` en la misma etiqueta "Inactivo".
**Un paseador *rechazado* (2) puede "reactivarse" con un clic, y viceversa.** Y `controllers/cextini.php` + `models/mextini.php:31` autentican solo con `estusr=1`.

### E12. Estado de cuenta hardcodeado en la vista de Perfil **[V]**
`views/vusupef.php:49` → `<span class="badge badge-active">Activo</span>` fijo. Nunca se consulta `usuario.estusr`. Contrasta con `views/vusulisusu.php:36-40`, que **sí** lee la columna.

### E13. `$datEst` se carga con todos los valores de todos los dominios **[V]**
`controllers/ccofdom.php:39` → `$mcofval->getAll()` trae **todos** los valores de **todos** los dominios, y **`views/vcofdom.php` nunca usa `$datEst`**. Variable muerta con costo de consulta completa.

### E14. Radios `actdom` con valores mágicos **[V]**
`views/vcofdom.php:29, 33` → radios con `value="1"` / `value="2"` hardcodeados. Pero `dominio.actdom` se diseña como FK lógica a `valor.idval` (`models/mcofdom.php:22`) y `views/vcofdom.php:76-77` lee `== 1`. **Si el dominio de estados no tiene `idval` 1 y 2, se guardan referencias inválidas.** Y con C2 (tablas vacías) es literalmente el caso.

### E15. `nomesta` del JOIN nunca se usa **[V]**
`models/mcofcof.php:30-31` → `LEFT JOIN valor v … v.codval AS nomesta` se selecciona en `getAll` y `getOne`, pero `views/vcofcof.php:110-111` codifica `'Activo'/'Inactivo'` con `== 1`. **Si `valor.codval` cambia, la vista miente.**

---

# BLOQUE F — ERROROS DE PHP

### F1. Acceso a `$_POST`/`$_GET` sin `isset()` — 16 ocurrencias
En PHP 8.1+ cada acceso a una clave inexistente emite `Warning: Undefined array key`, y el valor `null` se pasa a los `bindParam` (que fallan al ejecutar en modo emulación).

| Archivo | Líneas |
|---|---|
| `controllers/cusudatper.php` | `:8-14` (7 accesos) |
| `controllers/cusuval.php` | `:9`, `:15` (`$_GET['iduser']`) |
| `controllers/cusulisusu.php` | `:9`, `:15`, `:21` (`$_GET['iduser']`) |
| `controllers/cusuubi.php` | `:27` (`$_GET['idubi']`) |

Contraste: el propio `controllers/cusudatper.php:4` **sí** usa `isset()` correctamente, lo que demuestra la inconsistencia dentro del mismo archivo.

### F2. `session_start()` ausente en 5 controllers que leen `$_SESSION` **[V]**
`controllers/cserpas.php:9`, `cserrutcl.php:9`, `cserrutps.php:10`, `csersercl.php:8`, `cserserps.php:8` leen `$_SESSION["iduser"]` pero **ninguno llama `session_start()`**: dependen de que `home.php:2` ya lo haya hecho. Contrato frágil.

### F3. `substr(null)` deprecado en PHP 8.1+ **[V]**
`substr($dt['horaini'], 11, 5)` sobre columnas que **no existen** (A1) produce:
```
Deprecated: substr(): Passing null to parameter #1 ($string) of type string is deprecated
```
Ocurrencias: `views/vserrutcl.php:64-65`, `views/vserrutps.php:34, 39, 91, 92`, `views/vserpas.php:37, 42`, `views/vsersercl.php:39-40`, `views/vserserps.php:40-41`.

### F4. `catch` sin `return` que produce un falso negativo **[V]**
`models/mmasmas.php:105-107` — el `catch` de `save()` no tiene `return`, así que ante fallo devuelve `NULL`.
En `controllers/cmasmas.php:68`, `if($iduser && $idmascNew)` queda en `false` y **no se registra la relación en `duenomasc`**, sin más aviso que el `echo` del model.

### F5. `models/musupef.php:3-7` se autocrea un `ManejoError()` que solo escribe al log **[V]**
```php
function ManejoError($e){
    error_log("UrbanPaws Error: " . $e->getMessage());
}
```
El usuario **nunca ve el error**, y los métodos devuelven `false`/`[]` silenciosamente (`:91, 133, 170, 190, 218, 245`). Rompe el patrón del proyecto (que además está roto — ver A9).

### F6. `ob_start()` sin `ob_end_flush()` **[V]**
`index.php:2` inicia un buffer de salida y **no existe ninguna llamada a `ob_end_flush()` en todo el repositorio**. El buffer solo se descarga por el shutdown de PHP.
Combinado con `controllers/cextini.php:26` (`header("Location: home.php")`, emitido después de ~3.5 KB de HTML ya capturado), el comportamiento de la redirección depende de que el buffer no se haya descargado. Frágil e incorrecto.

### F7. Inconsistencia en la recepción de parámetros **[V]**
`controllers/cmasdue.php:9-11` usa `isset($_REQUEST[...])`, mientras `controllers/cmasmas.php:22-32` usa `!empty($_REQUEST[...])`.
`!empty()` convierte el valor `"0"` en `NULL`; `isset()` no. Mismo parámetro, semántica distinta.

### F8. Fecha de ruta forzada al día de hoy **[V]]
`controllers/cserrutps.php:30-31`:
```php
$horaini = date("Y-m-d") . " " . $horaini . ":00";
```
Fija siempre la fecha de hoy: una ruta creada a las 23:50 con `horafin` 00:30 queda con `horafin < horaini`. (Es código muerto frente al esquema actual — A1 — y el modelo solo tiene `detallefac.timpfin TIME`, sin soporte de fecha.)

### F9. `$_SESSION["nomusr"]` nunca se asigna en el flujo vivo **[V]**
`views/header.php:14` → `echo isset($_SESSION["nomusr"]) ? $_SESSION["nomusr"] : "";`
`controllers/cextini.php:22-25` escribe `iduser`, `emailu`, `prinom`, `nomperf`. **`nomusr` solo lo escribe `models/control.php:20`, que es código muerto** (D16).
**El saludo del header queda siempre vacío** para los usuarios que inician sesión por `cextini.php`.

### F10. Parámetros de error que nadie lee **[V]**
`models/control.php:11` → `../index.php?error1=ok`
`models/control.php:26` → `../index.php?error=ok`
`index.php` solo lee `pg` (`:90`); **nunca lee `error` ni `error1`**. Aunque `control.php` se activara, esos mensajes no se mostrarían.

---

# BLOQUE G — ERRORES DE UI / HTML / CSS

### G1. Documento HTML anidado en 4 vistas **[V]**
`home.php:12-32` ya emite `<!DOCTYPE html><html><head>…</head><body>` y cierra en `:78-80`. Estas vistas abren un **segundo documento completo**:

| Vista | Abre | Cierra |
|---|---|---|
| `views/vusuadmin.php` | `:1-9` | `:78-79` |
| `views/vusucli.php` | `:1-9` | `:72-73` |
| `views/vusupef.php` | `:1-9` | `:131-132` |
| `views/vusupas.php` | `:4-12` | `:89-90` |

**Resultado:** DOCTYPE duplicado, dos `<head>`, dos `<title>`, un `</body></html>` en medio del body, y el footer y `mytable.js` (`home.php:79`) renderizados **fuera del documento**.

### G2. `../css/style.css` resuelve a la raíz del servidor → 404 **[V]**
`views/vusuadmin.php:7`, `views/vusucli.php:7`, `views/vusupef.php:7`, `views/vusupas.php:10` usan `href="../css/style.css"`.
Como la URL real es `/UrbanPaws/home.php?pg=N`, el `../` sube a la **raíz del servidor** → `/css/style.css` → **404**.
Además duplica el `<link>` correcto de `home.php:29` y **omite `css/custom.css`**.

### G3. `js/mytable.js` sin guardia: `TypeError` en páginas sin `id="mitabla"` **[V]**
`js/mytable.js:2` → `$('#mitabla').DataTable({...})` sin verificar que el elemento exista.
Páginas afectadas (usan `class="data-table"`, una clase que **no existe** en ningún CSS):
- `views/vfatdatfac.php:61`
- `views/vfaclisfac.php:145`
- `views/vfacrepfac.php:249`

**En esas 3 páginas salta `TypeError: undefined is not a function`.**

### G4. Los badges de estado pierden su distinción de color **[V]**
`css/custom.css:12-14`:
```css
.badge, .bg-success { background-color: var(--brand-primary) !important; }
```
El `!important` pisa tanto a `.badge-active` (`css/style.css:213`, `#10b981`, sin `!important`) como a `.bg-secondary`.
**Consecuencia verificable:** en `views/vusulisusu.php:37` y `:39` los badges **"Activo" e "Inactivo" se pintan del mismo azul**. En `views/vusuval.php:34` y `:36` el badge de antecedentes pierde su amarillo de advertencia. Afecta también a `views/vusupas.php:31`.

### G5. `i{font-size: 10px;}` degrada los iconos sin clase de tamaño **[V]**
`css/custom.css:5`. Aplica a todos los `<i>` sin `fa-lg`/`fa-2x`/`fa-xl`:
`views/vusuubi.php:31, 37`, `views/vusudatper.php:20`, `views/vusupef.php:20`, `views/vusuadmin.php:14`, `views/vusucli.php:14`, `views/vusupas.php:17`. **Quedan a 10 px.**

### G6. Color hardcodeado en vez de token **[V]**
`css/custom.css:4` codifica `#f58220` en duro en lugar de `var(--brand-accent)`. Incumple la regla de paleta de `AGENTS.md`.

### G7. Token CSS inexistente **[V]**
`index.php:35` → `background-color: var(--bg-light);`
**`--bg-light` no está definido** en `:root` (`css/style.css:6-26` define `--bg-body`, `--bg-card`, `--bg-soft-blue`, `--bg-soft-orange`). La declaración es inválida y **se descarta silenciosamente**: el fondo del login no se aplica.

### G8. 10 enlaces muertos con `href="#"` **[V]**
- `views/vfaclisfac.php:15, 173, 190, 209, 226, 246, 250, 254, 258, 262` — "Nueva factura", los 4 botones de "ver detalle", y **toda la paginación** (`Anterior`, `1`, `2`, `3`, `Siguiente`).
- `views/vfacrepfac.php:17, 22` — botones PDF/Excel sin acción.
- `views/vfatdatfac.php:15` — botón "Descargar factura" sin `type`, `onclick`, `href` ni destino. **No hace nada.**
- `views/vusupef.php:109, 115` — "Cambiar contraseña" y "Consultar estado".

### G9. `<label for="">` con `for` vacío — 6 ocurrencias **[V]**
`views/vcofdom.php:19, 26`, `views/vcofval.php:14, 29, 35, 41`. El atributo apunta a `""`, que no es ningún elemento: el label no queda asociado a su input (falla de accesibilidad y el click no enfoca).
`views/vcofval.php:16` → `<select name="iddom" id="">` con `id` vacío, que es justamente el destino del `for=""` de la línea 14.

### G10. Labels sin `for` e inputs sin `id` en el formulario de Mascotas **[V]**
`views/vmasmas.php:38, 46, 57, 72, 82, 96, 104` — los `<label class="form-label">` no tienen `for` y sus `<input>`/`<select>`/`<textarea>` **tampoco tienen `id`** (solo `name`). El label no es clicable ni anunciable por lector de pantalla.
Contraste: `views/vserrutps.php` **sí lo hace bien** (`for="nomrut"` / `id="nomrut"`).

### G11. Filas `<tr></tr>` vacías en `<thead>` y `<tfoot>` **[V]**
`views/vusuval.php:23, 63`. Generan filas fantasma y descuadran la indexación de columnas de DataTables (`js/mytable.js:2`, `pageLength: 10`).

### G12. Ids inconsistentes de `<tbody>` **[V]**
`id="tableBody"` (`views/vcofdom.php:64`) vs `id="tablebody"` (`views/vcofval.php:81`) — mayúsculas distintas, y `views/volv.php:13` usa `tableBody` otra vez. **Ningún JS los usa**, así que son inconsistencias latentes.

### G13. Botón `type="reset"` con icono de papelera **[V]**
`views/vusudatper.php:76-78`, `views/vusuubi.php:51-53` — icono `fa-trash` en un botón `reset`. En `views/vusuubi.php` el `reset` solo se muestra en modo "nueva" (rama `else` de `:50`), donde la papelera sugiere borrar algo que no existe. **Botón engañoso sin acción real.**

### G14. Placeholders sin implementar visibles en la UI **[V]**
| Ubicación | Texto |
|---|---|
| `views/vmasmas.php:26` | `Entra con: home.php?pg=??&iduser=X` — placeholder **"??" sin resolver** y `pg` equivocado (el correcto sería `pg=9`) |
| `views/vserrutcl.php:27` | `Api ..... mapa de la ruta` |
| `views/vusupas.php:1-3` | Bloque `<?php ?>` vacío que emite una línea en blanco **antes del `<!DOCTYPE html>`** |

### G15. Celda sin fallback **[V]**
`views/vsersercl.php:38` → `<?= $dt['prinom'] . ' ' . $dt['priapel'] ?>` sin alternativa, a diferencia de `:37` (`$dt['nommasc'] ? … : '—'`). Con el `LEFT JOIN usuario ps` de `models/mserpas.php:106` sin coincidencia, **imprime una celda con un espacio en blanco**.

---

# BLOQUE H — CONFIGURACIÓN, ENTORNO Y DOCUMENTACIÓN

### H1. No existe ningún `.htaccess` en el repositorio **[V]**
Verificado: 0 resultados. Consecuencias:
- Los directories `controllers/`, `models/`, `db/`, `vendor/` son **accesibles directamente por URL**.
- **`db/urbanpaws.sql` es descargable**: expone el esquema completo, y `models/config.php` es **accesible en texto plano** (credenciales `root` sin contraseña, ver B19).
- Cualquier `.php` de `controllers/` es invocable sin autenticación (ver B1).

### H2. `.gitignore` sin reglas reales **[V]**
`AGENTS.md` lo reporta: contiene texto suelto sin patrones de exclusión válidos. **No protege nada** (ni `uploads/`, ni logs, ni `.env`).

### H3. El directorio `uploads/` no existe **[V]**
`controllers/cmasmas.php:12` lo crea en runtime con `mkdir(…, 0777, true)`. Permisos 0777 excesivos, y sin `.htaccess` que impida ejecutar lo que se suba (ver B18).

### H4. `img/logo.png` referenciado sin `alt` en el header **[V]**
`views/header.php:8` → `<img class="logo-img" src="img/logo.png">` — sin atributo `alt` (problema de accesibilidad). El archivo sí existe.
`views/footer.php:7` sí tiene `alt="UP"`.

### H5. `AGENTS.md` documenta una ruta que no existe **[V]**
`AGENTS.md` indica que los errores de BD se muestran vía **`models/misfun.php`** (`misFun::ManejoError`). El archivo real está en **`controllers/misfun.php`**. `models/misfun.php` no existe.
Esta discrepancia es precisamente lo que hace que **nadie encuentre el archivo que nunca se incluye** (ver A8).

### H6. `AGENTS.md` y `README.md` desactualizados **[V]**
- `AGENTS.md` dice que `README.md` "solo documenta 1-10 y está desactualizado"; el propio `AGENTS.md` mantiene esa nota sin resolverla.
- `README.md` no refleja: las 5 vistas inexistentes, el módulo PQRS ausente, Facturas estático, ni la ausencia de `.htaccess`.
- El texto **"© 2025"** de `views/footer.php:48` está desactualizado respecto de la fecha del proyecto.

### H7. `vendor/` commiteado con una dependencia no usada **[V]**
`composer.json` declara `phpmailer/phpmailer`, pero **ninguna línea de código del proyecto lo usa** (verificado: `composer.json` es la única referencia). Es ~90 archivos (`vendor/phpmailer/phpmailer/`) inflando el repositorio, y es irónico porque **el envío de correos es justamente lo que falta** (ver B14: el `// TODO: enviar correo`).

### H8. Nomenclatura de clases incoherente **[V]**
`models/mmasmas.php:2` → `class mCofmas` y `models/mmasdue.php:2` → `class mCofdue`: los models del módulo Mascotas usan el **prefijo de Configuración** (`mCof*`) en lugar de `mmas*`, y el nombre de archivo no coincide con el de la clase.
Contraste con el módulo Servicios: `mServRut` en `mserrut.php:5`, `mServPas` en `mserpas.php:5`.

---

# PLAN DE CORRECCIÓN SUGERIDO (por prioridad)

> Esto es solo referencia de orden. **Ninguna corrección ha sido aplicada**: los cambios requieren tu aprobación previa, especialmente los de CSS (regla de `AGENTS.md`).

### Prioridad 1 — Seguridad (arreglar antes de cualquier despliegue)
1. **A19 + A20**: aislar los 4 controllers externos (que cada uno se ejecute solo, p. ej. con un parámetro de acción único por formulario) e implementar recuperación de contraseña **con token**.
2. **B1**: incluir `models/seguridad.php` en **todos** los controllers + crear `.htaccess` que bloquee el acceso directo a `controllers/`, `models/`, `db/` y `vendor/`.
3. **B2**: token CSRF en todos los formularios y acciones destructivas.
4. **B3, B4, B5, B6**: eliminar todos los `iduser` por `$_REQUEST` y usar exclusivamente `$_SESSION['iduser']`.
5. **B7**: implementar control de acceso por perfil (`userxper`).
6. **B8**: `session_regenerate_id(true)` tras autenticar.
7. **H1**: `.htaccess` de raíz (bloquear `db/`, `models/`, `vendor/`).

### Prioridad 2 — Esquema de base de datos
8. **A1**: agregar a `ruta` las columnas `idubi`, `estarut`, `horaini`, `horafin`, `precioini` (con `ALTER TABLE`) o adaptar el código al esquema real.
9. **C2**: crear un `db/seed.sql` con los `INSERT` mínimos: 1 administrador, `perfil`, `dominio`, `valor` (incluidos `idval` 1 y 2), `config`, `modulo`, `pagina`.
10. **A6**: corregir `models/musucli.php` → `idusu`→`iduser`, `seapel`→`segapel`, `idperf`→ tabla `userxper`.
11. **A5**: `s.tipserv` → `p.servtipo` en `models/mfatdatfac.php:83, 115`.
12. **C1**: completar los 3 `GROUP BY` de `musuadmin.php:77`, `musulisusu.php:25`, `musuval.php:27`.
13. **C7**: añadir `AND v.iddom = …` a los JOIN de `mcofcof.php` y `mcofdom.php`.
14. **C9**: `strpos(...) !== false` en `controllers/misfun.php:7, 9`.
15. **C11**: ampliar `paseo.idpas` a `BIGINT(20)`.

### Prioridad 3 — Ruteo (desbloquea la mitad del sistema)
16. **A2 + A3 + A11**: crear `views/vserlisrut.php`, `vserlisser.php`, `vserrepser.php`; crear el módulo PQRS completo (controller + model + view); añadir `pg=10`.
17. **A10**: elegir una sola estrategia de ruteo. Recomiendo: **todo por `home.php?pg=N`** → corregir los ~15 enlaces y redirecciones que apuntan a `index.php?pg=`.
18. **A4**: hacer que las vistas de Facturas incluyan sus controllers (o mover la lógica a `home.php`).
19. **A13, A14**: `home.php?pg=27` → `home.php?pg=9` en `views/vmasmas.php`; `index.php?pg=27` → `home.php?pg=27` en `views/vcofval.php`.
20. **A15, A16**: `../index.php?pg=N` → `home.php?pg=N` en los 4 controllers de Usuarios.
21. **A12**: crear `pg=32` o corregir las referencias.
22. **A18**: añadir `ob_start()` al inicio de `home.php` (junto con `ob_end_flush()`), o mover los `echo`+`exit` de los `catch`.
23. **D1**: los 3 controllers de Usuarios deben incluir su vista.
24. **D9**: las vistas `vext*.php` deben incluir su controller.

### Prioridad 4 — Contratos entre capas
25. **A25, E2, E3**: alinear los `name` de los formularios con lo que leen los controllers.
26. **A24**: o conectar los datos reales a las vistas de Facturas, o **retirar las cifras inventadas**.
27. **E1**: `models/musupef.php::upd()` debe persistir los 5 campos que el controller envía.
28. **E5**: conectar `views/vusupef.php` al controller, o retirar el formulario.
29. **E6, E7, E8**: corregir los 15+ enlaces que apuntan a rutas inexistentes.
30. **D16, D17**: eliminar código muerto.

### Prioridad 5 — Manejo de errores
31. **A7 + A8 + H5**: mover `misfun.php` a `models/` (como dice `AGENTS.md`) y hacer `require_once` en los 17 lugares que lo usan; reemplazar las 5 llamadas a la función suelta `ManejoError()` por `misFun::ManejoError()`.
32. **A9**: definir la función JS `err()` (o migrar a Bootstrap Toast).
33. **C8**: eliminar los `echo` de mensajes SQL crudos en los 5 models.
34. **B20**: añadir `charset=utf8mb4` y `ATTR_ERRMODE`/`ATTR_EMULATE_PREPARES` explícitos en `models/conexion.php`; usar `__DIR__` en los `include`.

### Prioridad 6 — UI (requiere tu aprobación previa por la regla de CSS)
36. **G1**: quitar el documento anidado de las 4 vistas.
37. **G2**: cambiar `../css/style.css` por `css/style.css`.
38. **G3**: añadir guardia en `js/mytable.js` (`if ($('#mitabla').length)`) y poner `id="mitabla"` en las 3 tablas de Facturas.
39. **G4**: revisar el `!important` de `css/custom.css:12-14` que aplana los badges de estado.
40. **G5**: acotar `i{font-size: 10px;}` de `css/custom.css:5`.
41. **G6**: reemplazar `#f58220` por `var(--brand-accent)`.
42. **G7**: `--bg-light` → `--bg-body` en `index.php:35`.
43. **G8, G9, G10, G11, G12, G13, G14, G15**: enlaces muertos, `label for=""`, labels sin `for`, `<tr>` vacías, placeholders.

---

*Fin del inventario. 122 errores verificados sobre 92 archivos PHP, 32 vistas, 30 controllers, 30 models, 2 CSS, 1 JS y 1 esquema SQL.*