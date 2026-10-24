-- =====================================================================
-- Seed para vusuadmin: páginas del sistema + asignación página×perfil
-- Idempotente: se puede re-ejecutar sin duplicar registros.
-- Relación: idpag = número de página (?pg=N) usado por home.php
-- =====================================================================
USE UrbanPaws;

-- ---------------------------------------------------------------
-- 1) Páginas del sistema (mapa de home.php: pg 1 .. 27)
--    mostpag = '1' cuando la vista existe; '0' cuando está en preparación
-- ---------------------------------------------------------------
INSERT IGNORE INTO pagina (idpag, titpag, nompag, mostpag, icopag, rutpag, ordpag, descpag) VALUES
(1,  'Inicio',                        'Inicio',       '1', 'fa-solid fa-house',             'home.php?pg=1',  10,  'Vista vusucli.php (dashboard)'),
(2,  'Administradores',               'Admin',        '1', 'fa-solid fa-user-shield',       'home.php?pg=2',  20,  'Vista vusuadmin.php (gestion de usuarios, roles y paginas)'),
(3,  'Paseador',                      'Paseador',     '1', 'fa-solid fa-person-walking',    'home.php?pg=3',  30,  'Vista vusupas.php (dashboard paseador)'),
(4,  'Mi perfil',                     'Mi perfil',    '1', 'fa-solid fa-id-card',           'home.php?pg=4',  40,  'Vista vusupef.php'),
(5,  'Usuarios',                      'Usuarios',     '1', 'fa-solid fa-users',             'home.php?pg=5',  50,  'Vista vusulisusu.php (listado de usuarios)'),
(6,  'Validacion de paseadores',      'Validacion',   '1', 'fa-solid fa-user-check',        'home.php?pg=6',  60,  'Vista vusuval.php (aprobar/rechazar paseadores)'),
(7,  'Datos personales',              'Datos per.',   '1', 'fa-solid fa-address-card',      'home.php?pg=7',  70,  'Vista vusudatper.php'),
(8,  'Ubicaciones',                   'Ubicaciones',  '1', 'fa-solid fa-location-dot',      'home.php?pg=8',  80,  'Vista vusuubi.php (CRUD ciudades)'),
(9,  'Mascotas',                      'Mascotas',     '1', 'fa-solid fa-paw',               'home.php?pg=9',  90,  'Vista vmasmas.php'),
(10, 'Duenos de mascotas',            'Duenos',       '0', 'fa-solid fa-users',             'home.php?pg=10', 100, 'Vista en preparacion'),
(11, 'Rutas disponibles',             'Rutas',        '1', 'fa-solid fa-map-location-dot',  'home.php?pg=11', 110, 'Vista vserrutcl.php'),
(12, 'Listado de rutas',              'List. rutas',  '0', 'fa-solid fa-list',              'home.php?pg=12', 120, 'Vista en preparacion'),
(13, 'Agendar paseo',                 'Agendar',      '1', 'fa-solid fa-person-walking',    'home.php?pg=13', 130, 'Vista vserpas.php'),
(14, 'Solicitudes de paseo',          'Solicitudes',  '1', 'fa-solid fa-list-check',        'home.php?pg=14', 140, 'Vista vserserps.php'),
(15, 'Servicios',                     'Servicios',    '0', 'fa-solid fa-concierge-bell',    'home.php?pg=15', 150, 'Vista en preparacion'),
(16, 'Reporte de servicios',          'Rep. serv.',   '0', 'fa-solid fa-chart-column',      'home.php?pg=16', 160, 'Vista en preparacion'),
(17, 'Nueva factura',                 'Nueva fact.',  '1', 'fa-solid fa-file-circle-plus',  'home.php?pg=17', 170, 'Vista vfacfac.php'),
(18, 'Detalle de factura',            'Detalle fact.','1', 'fa-solid fa-list',              'home.php?pg=18', 180, 'Vista vfatdatfac.php'),
(19, 'Facturas',                      'Facturas',     '1', 'fa-solid fa-file-invoice',      'home.php?pg=19', 190, 'Vista vfaclisfac.php'),
(20, 'Reporte de facturas',           'Rep. fact.',   '1', 'fa-solid fa-chart-column',      'home.php?pg=20', 200, 'Vista vfacrepfac.php'),
(21, 'PQRSF',                         'PQRSF',        '0', 'fa-solid fa-message',           'home.php?pg=21', 210, 'Vista en preparacion'),
(22, 'Solicitudes PQRSF',             'Solic. PQRSF', '0', 'fa-solid fa-inbox',             'home.php?pg=22', 220, 'Vista en preparacion'),
(23, 'Paginas',                       'Paginas',      '1', 'fa-solid fa-window-maximize',   'home.php?pg=23', 230, 'Vista vcofpag.php (CRUD paginas)'),
(24, 'Modulos',                       'Modulos',      '1', 'fa-solid fa-cubes',             'home.php?pg=24', 240, 'Vista vcofmod.php'),
(25, 'Configuracion del sistema',     'Config.',      '1', 'fa-solid fa-gear',              'home.php?pg=25', 250, 'Vista vcofcof.php'),
(26, 'Dominios',                      'Dominios',     '1', 'fa-solid fa-tags',              'home.php?pg=26', 260, 'Vista vcofdom.php'),
(27, 'Valores',                       'Valores',      '1', 'fa-solid fa-list-ol',           'home.php?pg=27', 270, 'Vista vcofval.php');

-- ---------------------------------------------------------------
-- 2) Asignacion por defecto de paginas por perfil (pagxper)
--    Admin = todas | Cliente = compras/paseos/facturacion | Paseador = operacion
-- ---------------------------------------------------------------
-- Admin (3): todas las paginas 1..27
INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 3
FROM pagina p
WHERE NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 3
);

-- Cliente (2)
INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 2
FROM pagina p
WHERE p.idpag IN (1,4,7,9,11,13,14,17,18,19,20)
  AND NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 2
);

-- Paseador (1)
INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 1
FROM pagina p
WHERE p.idpag IN (1,3,4,7,11,13,14,17,19)
  AND NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 1
);

-- ---------------------------------------------------------------
-- 3) Rol Admin al usuario actual (iduser = 1) para no quedar fuera
--    cuando se active la restriccion de la vista de administracion
-- ---------------------------------------------------------------
INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 3
FROM usuario u
WHERE u.iduser = 1
  AND NOT EXISTS (
    SELECT 1 FROM userxper ux WHERE ux.iduser = u.iduser AND ux.idperf = 3
  );
