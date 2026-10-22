# UrbanPaws · Paleta de colores

Documento de referencia del sistema de color implementado tras el rediseño de la interfaz.
Los tokens viven en `css/style.css` (bloque `:root`) y son la única fuente de verdad: **no escribir hexadecimales sueltos en las vistas**, se referencian con `var(--token)`.

- Concepto visual: *cuidado botánico* — fondo crema cálido, superficies blancas, salvia para superficies suaves y terracota como único acento.
- Contraste: todos los pares texto/fondo listados cumplen WCAG AA en tamaño normal, salvo los señalados en [Contraste y accesibilidad](#contraste-y-accesibilidad).

---

## Colores principales

```
color:texto      → #232a25
color:background → #f8f4ec
color:primary    → #385746
color:secundary  → #1f332b
color:accent     → #c46a4a
```

| Esquema | Token CSS | Hex | Rol | Cómo se usa | Dónde se usa |
| --- | --- | --- | --- | --- | --- |
| `color:texto` | `--text-main` | `#232a25` | Texto principal de la interfaz | Color por defecto de todo el texto; se combina con superficies claras (`--bg-card`, `--bg-body`) | `body`, `.table tbody td`, celdas de formularios, títulos de tarjeta |
| `color:background` | `--bg-body` | `#f8f4ec` | Fondo general de la aplicación | Relleno del `body`; da el tono crema que separa las tarjetas del lienzo | `body` de `index.php` y `home.php`, fondo general del panel |
| `color:primary` | `--brand-primary` | `#385746` | Verde bosque: color de marca y de acciones secundarias | Botones secundarios, iconos de módulo, texto de enlaces, bordes de foco verdes | `.btn-primary:hover`, `.barsup .nav-link i`, `.dashboard-card .tile-icon`, `.auth-story .eyebrow`, iconos de tablas |
| `color:secundary` | `--brand-dark` | `#1f332b` | Verde muy oscuro: estructura y jerarquía | Botón principal, títulos, panel de marca del login, texto sobre fondo verde | `.btn-primary` / `.btn-dark`, `h1`–`h6`, `.auth-brand-panel`, texto del total en facturas |
| `color:accent` | `--brand-accent` | `#c46a4a` | Terracota: único color de acento | Botón de acción destacada, iconos de acento, estados activos, foco de teclado | `.btn-accent`, `.icon-circle`, `.section-title > i`, `:focus-visible`, item activo del menú, borde inferior de la navegación activa |

Derivado immediate del acento:

| Token | Hex | Uso |
| --- | --- | --- |
| `--brand-accent-hover` | `#a95539` | Estado `hover`/apretado de los botones de acento; mantiene el mismo tono pero más profundo para conservar contraste con texto blanco |

---

## Otros tokens del design system

| Token | Hex | Cómo se usa | Dónde se usa |
| --- | --- | --- | --- |
| `--bg-card` | `#fffefa` | Superficie de tarjetas y de campos de formulario; blanco cálido para no chocar con el fondo crema | `.card`, `.form-control`, `.form-select`, `.input-control`, `.user-menu`, `.mobile-menu`, `.dropdown-menu` |
| `--bg-soft-blue` | `#e5ece3` | Tinte salvia para superficies secundarias y chips neutros de color. El mismo valor se aplica hoy de forma literal en `.badge.bg-primary` y `.badge-male`; el token queda para unificarlo | `.badge.bg-primary`, `.badge-male` |
| `--bg-soft-orange` | `#f5e9df` | Tinte durazno para acentos blandos e iconos alternos | `.icon-circle`, `.badge-female`, `.dashboard-card:nth-child(3n+2) .tile-icon` |
| `--text-muted` | `#6d756f` | Texto secundario: descripciones, textos de ayuda de formularios, etiquetas de DataTables | `p`, `.form-text`, `.user-meta small`, `.dataTables_wrapper`, `.welcome-panel p` |
| `--border-light` | `#e6ddd0` | Borde de tarjetas, campos y separadores | `.card`, `.form-control`, `.user-menu`, `.dropdown-menu`, `.table td > a:hover`, `.profile-divider` |
| `--line` | `rgba(31,51,43,.12)` | Separador semántico fino; reservado, hoy el separador del perfil usa `--border-light` | `.profile-divider` |
| `--success` | `#397251` | Estado positivo (aprobado, activo) | `.badge.bg-success`, `.btn-success` |
| `--warning` | `#a96a21` | Estado de advertencia (pendiente); el chip lo aplica hoy con los literales `#f7efd9` / `#8b621e` | `.badge.bg-warning` |
| `--danger` | `#ae5148` | Estado de error o rechazo | `.text-danger`, `.btn-danger`, `.alert-danger` |
| `--shadow` | `rgba(42,54,45,.065)` | Sombra base de tarjetas | `.card` |
| `--shadow-hover` | `rgba(42,54,45,.12)` | Sombra elevada al interactuar | `.dashboard-card:hover` |

---

## Colores literales y su uso

Estos valores están escritos directamente en `css/style.css` porque son degradados, transparencias o ajustes de estado. Si se agrega un color nuevo, primero se evalúa si puede reemplazarse por un token.

### Navegación y shell

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#20372d` | Fondo del panel de marca del login y color de la barra del navegador | `.auth-brand-panel`, `<meta name="theme-color">` en `index.php` y `home.php` |
| `#59645c` | Texto de los enlaces de navegación | `.barsup .nav-link` |
| `#eaf0e8` | Fondo del enlace de navegación en hover y del activo | `.barsup .nav-link:hover`, `.barsup .nav-link.is-active` |
| `#edf1e9` | Hover de ítems de menú, de dropdown y de botones secundarios | `.barsup .dropdown-item:hover`, `.btn-outline:hover`, `.mobile-menu .nav-link:hover` |
| `#c8d2c5` | Borde del botón de usuario en hover | `.user-menu:hover` |
| `#f5f6f0` | Fondo del botón de usuario en hover | `.user-menu:hover` |
| `#e4ebe0` | Fondo del avatar con la inicial del usuario | `.user-avatar` |
| `#f4e6d7` | Fondo del contenedor del logotipo | `.logo-icon` |
| `rgba(31,51,43,.1)` | Línea inferior del header translúcido | `.barsup` |
| `rgba(255,254,250,.94)` | Fondo translúcido del header con desenfoque | `.barsup` |

### Formularios y controles

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#44534a` | Color de las etiquetas de formulario | `label.form-label` |
| `#ddd9cf` | Borde de los campos de entrada | `.form-control`, `.form-select`, `.input-control`, `.input-group-text` |
| `#8fa78d` | Borde y halo de foco de los campos | `.form-control:focus`, `.form-check-input:focus` |
| `#9a9f98` | Texto de marcador de posición | `::placeholder` |
| `#f4f1e9` | Fondo del prefijo dentro de un grupo de campos | `.input-group-text`, `css/custom.css` (botón "Elegir archivo") |
| `#c7cfc3` | Borde de casillas y radios | `.form-check-input` |
| `rgba(73,112,84,.12)` | Halo verde de foco | `.form-control:focus` |
| `rgba(196,106,74,.62)` | Anillo de foco de teclado | `:focus-visible` |

### Botones

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#d5d8cd` | Borde de los botones secundarios | `.btn-outline` |
| `#b9c8b9` | Borde del botón secundario en hover | `.btn-outline:hover` |
| `#d9ddce` | Borde de la tarjeta en hover | `.card:hover` |
| `#fffefa` | Texto de los botones principal y de acento | `.btn-primary`, `.btn-accent` |
| `rgba(31,51,43,.14)` / `rgba(196,106,74,.16)` | Sombra de los botones | `.btn-primary`, `.btn-accent` |

### Tablas

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#f5f2eb` | Fondo del encabezado de la tabla | `.table thead th` |
| `#6a7169` | Texto del encabezado (versalitas) | `.table thead th` |
| `#e4ded3` | Línea inferior del encabezado | `.table thead th` |
| `#3f4841` | Texto de las celdas | `.table tbody td` |
| `#eeeae2` | Separadores horizontales entre filas | `.table > :not(caption) > * > *` |
| `#fbfaf6` | Fondo de las filas impares | `.table-striped > tbody > tr:nth-of-type(odd)` |
| `#f1f3ec` | Fondo de la fila bajo el cursor | `.table` (hover) |
| `#f2f2eb` | Fondo del enlace de acción al pasar el cursor | `.table td > a:not(.btn):hover` |
| `#fff` | Texto del botón de paginación activo | `.dataTables_wrapper .paginate_button.current` |

### Paneles, tarjetas de acceso y perfil

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#d9e1d4` | Borde del panel de bienvenida | `.welcome-panel` |
| `#e8eee3` / `#f2f1e7` | Degradado del panel de bienvenida (salvia → crema) | `.welcome-panel` |
| `rgba(212,222,203,.9)` | Resplandor salvia sobre el panel | `.welcome-panel` (radial-gradient) |
| `#59685c` | Texto secundario del panel de bienvenida | `.welcome-panel p` |
| `#cbd6c9` | Borde de la tarjeta de acceso en hover | `.dashboard-card:hover` |
| `#e7eee4` | Fondo del icono de la tarjeta de acceso | `.dashboard-card .tile-icon` |
| `#d4dfd1` | Borde del avatar grande de perfil | `.profile-avatar` |
| `#dce7d9` | Fondo del icono de la nota de perfil | `.profile-note .tile-icon` |

### Login

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#f0ede5` | Fondo de la barra de pestañas (Ingresar / Crear cuenta) | `.auth-tabs` |
| `#e4ded3` | Borde de la barra de pestañas | `.auth-tabs` |
| `#687168` | Texto de la pestaña inactiva | `.auth-tabs .nav-link` |
| `#d9e3d2` | Antetítulo del panel de marca | `.auth-story .eyebrow` |
| `#f0d1bd` | Texto del sello "Bienestar pensado para ellos" | `.auth-story-mark` |
| `#e0906e` | Icono del sello | `.auth-story-mark i` |
| `rgba(237,232,215,.2)` | Círculos decorativos del panel de marca | `.auth-brand-panel::before/after` |
| `rgba(255,254,250,.55)` | Fondo translúcido de la ilustración de la huella | `.welcome-art` |
| `rgba(196,106,74,.45)` | Círculos de acento de la ilustración | `.welcome-art::before` |

### Alertas y chips de estado

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#edf3e9` + `#cddbcf` + `#385746` | Alerta informativa (fondo, borde, texto) | `.alert-info` |
| `#edf5ed` + `#c9dfce` + `#326346` | Alerta de éxito | `.alert-success` |
| `#fbf3e4` + `#ead7b3` + `#86591c` | Alerta de advertencia | `.alert-warning` |
| `#fbefed` + `#e8c9c4` + `#8f443e` | Alerta de error | `.alert-danger` |
| `#e6f0e5` + `#396548` | Chip "Activo" / "Aceptado" | `.badge.bg-success` |
| `#f8e8e4` + `#a34d43` | Chip "Rechazado" / "Inactivo" | `.badge.bg-danger` |
| `#f7efd9` + `#8b621e` | Chip "Pendiente" | `.badge.bg-warning` |
| `#e9e9e1` + `#656b61` | Chip neutro (inactivo) | `.badge.bg-secondary` |
| `#f1eee7` + `#62685f` | Chip neutro claro (sin registros) | `.badge.bg-light` |

### Piezas de facturación (vistas heredadas)

Estas pantallas siguen usando colores en línea dentro de las vistas; son candidatas naturales a tokenización futura.

| Color | Cómo se usa | Dónde se usa |
| --- | --- | --- |
| `#e5e7eb` | Separadores del resumen de factura | `views/vfacfac.php` |
| `#ebece5` | Separadores y barras de progreso (versión del design system) | `.billing-page [style*="background: #e5e7eb"]` |
| `#d1d5db` | Línea base del gráfico de barras | `views/vfacrepfac.php` |
| `#10b981` | Barra de "Pagadas" | `views/vfacrepfac.php` |
| `#f59e0b` | Barra de "Pendientes" | `views/vfacrepfac.php` |
| `#ef4444` | Barra de "Vencidas" | `views/vfacrepfac.php` |
| `#fee2e2` + `#dc2626` | Chip inline "VENCIDA" | `views/vfaclisfac.php` |
| `#f3efe6` | Fondo del pie de página | `.footer` |

---

## Contraste y accesibilidad

| Combinación | Ratio | Resultado |
| --- | --- | --- |
| `--text-main` `#232a25` sobre `--bg-body` `#f8f4ec` | 13.0 : 1 | AAA |
| `#fffefa` sobre `--brand-dark` `#1f332b` | 13.4 : 1 | AAA |
| `#fffefa` sobre `--brand-primary` `#385746` | 7.9 : 1 | AA/AAA |
| `#fffefa` sobre `--brand-accent` `#c46a4a` | 3.8 : 1 | AA solo para texto grande (≥ 18.7 px en negrita) |
| `#fffefa` sobre `--brand-accent-hover` `#a95539` | 5.2 : 1 | AA en tamaño normal |
| `--text-muted` `#6d756f` sobre `--bg-body` `#f8f4ec` | 4.3 : 1 | AA en tamaño normal, justo |

Recomendaciones:

- Texto blanco sobre `--brand-accent` solo en títulos grandes o botones con etiqueta ≥ 18 px; para etiquetas pequeñas usar `--brand-accent-hover` o texto `--brand-dark`.
- `--text-muted` es válido para descripciones de 14 px o más; en textos más pequeños usar `--text-main`.
- Los chips de estado usan fondo pastel + texto oscuro, nunca color saturado sobre blanco, para no perder legibilidad.
- El foco de teclado siempre es visible: anillo terracota de 3 px (`rgba(196,106,74,.62)`) con `outline-offset` de 3 px.

---

## Reglas de uso

1. **Un solo acento.** Terracota se reserva para acciones destacadas, iconos de acento y estados activos. No se introduce un segundo color de acento.
2. **Verde para estructura.** `--brand-primary` y `--brand-dark` sostienen la marca, los títulos y las acciones secundarias.
3. **Superficies antes que sombras.** Las tarjetas se separan por borde cálido (`--border-light`) y radio de 18 px; la sombra solo aparece en elevación y hover.
4. **Antes de escribir un hex nuevo**, revisar si ya existe un token que cumpla el mismo rol y agregarlo a `:root` si la respuesta es no.
5. **Estados de formulario** usan siempre los pares fondo pastel + texto oscuro de la tabla de alertas, no el color puro del estado.

---

## Nota de compatibilidad con `AGENTS.md`

`AGENTS.md` todavía cita la paleta original del documento "Colores UP-1.pdf" (`--brand-dark: #1a3a5c`, `--brand-primary: #2c5f8a`, `--brand-accent: #f58220`, tipografías Poppins + Nunito). Esa referencia quedó desactualizada por el rediseño: la paleta realmente implementada en `css/style.css` es la de este documento, con tipografías Bricolage Grotesque + Manrope.

Para volver a la paleta original habría que revertir `css/style.css` y `css/custom.css` y volver a cargar Poppins + Nunito en `index.php` y `home.php`; conviene decidirlo antes de seguir construyendo sobre la base actual.
