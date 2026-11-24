-- =====================================================================
-- UrbanPaws - Migración completa y no destructiva
-- =====================================================================
-- Sincroniza la base de datos viva con el código actual SIN borrar tablas
-- ni datos. Es idempotente: se puede ejecutar las veces que sea necesario.
--
-- Ejecutar desde la raíz del proyecto:
--   /opt/lampp/bin/mysql -uroot < db/migration_full.sql
--
-- NO usar db/urban2.sql: elimina userxper, ECMusr, claveu, sizemasc,
-- actmasc y duenomasc, que el proyecto sí necesita.
--
-- No se usan procedimientos almacenados porque este XAMPP tiene
-- mysql.proc desactualizado; se emplea SQL dinámico con PREPARE.
-- =====================================================================
USE UrbanPaws;

-- ---------------------------------------------------------------------
-- 1) Columnas que los modelos de servicios consultan y hoy faltan
-- ---------------------------------------------------------------------
SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ruta' AND COLUMN_NAME = 'idubi') = 0,
    'ALTER TABLE `ruta` ADD COLUMN `idubi` BIGINT(10) NULL AFTER `iduser`',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ruta' AND COLUMN_NAME = 'estarut') = 0,
    'ALTER TABLE `ruta` ADD COLUMN `estarut` TINYINT(1) NOT NULL DEFAULT 1 AFTER `idubi`',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ruta' AND COLUMN_NAME = 'horaini') = 0,
    'ALTER TABLE `ruta` ADD COLUMN `horaini` DATETIME NULL AFTER `estarut`',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ruta' AND COLUMN_NAME = 'horafin') = 0,
    'ALTER TABLE `ruta` ADD COLUMN `horafin` DATETIME NULL AFTER `horaini`',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ruta' AND COLUMN_NAME = 'precioini') = 0,
    'ALTER TABLE `ruta` ADD COLUMN `precioini` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `horafin`',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'servicio' AND COLUMN_NAME = 'tipserv') = 0,
    'ALTER TABLE `servicio` ADD COLUMN `tipserv` VARCHAR(100) NULL DEFAULT ''Paseo'' AFTER `iduser`',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

-- ---------------------------------------------------------------------
-- 2) Integridad e índices usados por permisos y paneles
-- ---------------------------------------------------------------------
SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
     WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'ruta'
       AND CONSTRAINT_NAME = 'fk_ruta_idubi') = 0,
    'ALTER TABLE `ruta` ADD CONSTRAINT `fk_ruta_idubi` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`)',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'userxper' AND INDEX_NAME = 'idx_userxper_iduser') = 0,
    'CREATE INDEX `idx_userxper_iduser` ON `userxper` (`iduser`)',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'userxper' AND INDEX_NAME = 'idx_userxper_idperf') = 0,
    'CREATE INDEX `idx_userxper_idperf` ON `userxper` (`idperf`)',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pagxper' AND INDEX_NAME = 'idx_pagxper_idperf') = 0,
    'CREATE INDEX `idx_pagxper_idperf` ON `pagxper` (`idperf`)',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'paseo' AND INDEX_NAME = 'idx_paseo_idrut') = 0,
    'CREATE INDEX `idx_paseo_idrut` ON `paseo` (`idrut`)',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

SET @up_sql = IF(
    (SELECT COUNT(*) FROM information_schema.STATISTICS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'calificacion' AND INDEX_NAME = 'idx_calificacion_idpaseador') = 0,
    'CREATE INDEX `idx_calificacion_idpaseador` ON `calificacion` (`idpaseador`)',
    'SELECT 1'
);
PREPARE up_stmt FROM @up_sql; EXECUTE up_stmt; DEALLOCATE PREPARE up_stmt;

-- ---------------------------------------------------------------------
-- 3) Perfiles base (los únicos tres roles del sistema)
-- ---------------------------------------------------------------------
INSERT IGNORE INTO perfil (idperf, nomperf, estper) VALUES
    (1, 'Paseador', 1),
    (2, 'Cliente',  1),
    (3, 'Admin',    1);

-- ---------------------------------------------------------------------
-- 4) Páginas del mapa de home.php (pg=1 .. pg=27)
-- ---------------------------------------------------------------------
INSERT IGNORE INTO pagina
    (idpag, titpag, nompag, mostpag, icopag, rutpag, ordpag, descpag)
VALUES
    (1,  'Inicio',                        'Inicio',        '1', 'fa-solid fa-house',             'home.php?pg=1',  10,  'Dashboard según el perfil'),
    (2,  'Administradores',               'Admin',         '1', 'fa-solid fa-user-shield',       'home.php?pg=2',  20,  'vusuadmin.php: usuarios, roles y páginas'),
    (3,  'Paseador',                      'Paseador',      '1', 'fa-solid fa-person-walking',    'home.php?pg=3',  30,  'vusupas.php: panel del paseador'),
    (4,  'Mi perfil',                     'Mi perfil',     '1', 'fa-solid fa-id-card',           'home.php?pg=4',  40,  'vusupef.php'),
    (5,  'Usuarios',                      'Usuarios',      '1', 'fa-solid fa-users',             'home.php?pg=5',  50,  'vusulisusu.php'),
    (6,  'Validación de paseadores',      'Validación',    '1', 'fa-solid fa-user-check',        'home.php?pg=6',  60,  'vusuval.php'),
    (7,  'Datos personales',              'Datos per.',    '1', 'fa-solid fa-address-card',      'home.php?pg=7',  70,  'vusudatper.php'),
    (8,  'Ubicaciones',                   'Ubicaciones',   '1', 'fa-solid fa-location-dot',      'home.php?pg=8',  80,  'vusuubi.php'),
    (9,  'Mascotas',                      'Mascotas',      '1', 'fa-solid fa-paw',               'home.php?pg=9',  90,  'vmasmas.php'),
    (10, 'Dueños de mascotas',            'Dueños',        '0', 'fa-solid fa-users',             'home.php?pg=10', 100, 'En preparación'),
    (11, 'Rutas disponibles',             'Rutas',         '1', 'fa-solid fa-map-location-dot',  'home.php?pg=11', 110, 'vserrutcl.php / vserrutps.php'),
    (12, 'Listado de rutas',              'List. rutas',   '0', 'fa-solid fa-list',              'home.php?pg=12', 120, 'En preparación'),
    (13, 'Agendar paseo',                 'Agendar',       '1', 'fa-solid fa-person-walking',    'home.php?pg=13', 130, 'vserpas.php'),
    (14, 'Solicitudes de paseo',          'Solicitudes',   '1', 'fa-solid fa-list-check',        'home.php?pg=14', 140, 'vserserps.php'),
    (15, 'Servicios',                     'Servicios',     '0', 'fa-solid fa-concierge-bell',    'home.php?pg=15', 150, 'En preparación'),
    (16, 'Reporte de servicios',          'Rep. serv.',    '0', 'fa-solid fa-chart-column',      'home.php?pg=16', 160, 'En preparación'),
    (17, 'Nueva factura',                 'Nueva fact.',   '1', 'fa-solid fa-file-circle-plus',  'home.php?pg=17', 170, 'vfacfac.php'),
    (18, 'Detalle de factura',            'Detalle fact.', '1', 'fa-solid fa-list',              'home.php?pg=18', 180, 'vfatdatfac.php'),
    (19, 'Facturas',                      'Facturas',      '1', 'fa-solid fa-file-invoice',      'home.php?pg=19', 190, 'vfaclisfac.php'),
    (20, 'Reporte de facturas',           'Rep. fact.',    '1', 'fa-solid fa-chart-column',      'home.php?pg=20', 200, 'vfacrepfac.php'),
    (21, 'PQRSF',                         'PQRSF',         '0', 'fa-solid fa-message',           'home.php?pg=21', 210, 'En preparación'),
    (22, 'Solicitudes PQRSF',             'Solic. PQRSF',  '0', 'fa-solid fa-inbox',             'home.php?pg=22', 220, 'En preparación'),
    (23, 'Páginas',                       'Páginas',       '1', 'fa-solid fa-window-maximize',   'home.php?pg=23', 230, 'vcofpag.php'),
    (24, 'Módulos',                       'Módulos',       '1', 'fa-solid fa-cubes',             'home.php?pg=24', 240, 'vcofmod.php'),
    (25, 'Configuración del sistema',     'Config.',       '1', 'fa-solid fa-gear',              'home.php?pg=25', 250, 'vcofcof.php'),
    (26, 'Dominios',                      'Dominios',      '1', 'fa-solid fa-tags',              'home.php?pg=26', 260, 'vcofdom.php'),
    (27, 'Valores',                       'Valores',       '1', 'fa-solid fa-list-ol',           'home.php?pg=27', 270, 'vcofval.php');

-- ---------------------------------------------------------------------
-- 5) Matriz página × perfil (pagxper): fuente de verdad del enrutador
--    Admin = 1..27 | Cliente = 11 páginas | Paseador = 9 páginas
-- ---------------------------------------------------------------------
INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 3
FROM pagina p
WHERE NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 3
);

INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 2
FROM pagina p
WHERE p.idpag IN (1, 4, 7, 9, 11, 13, 14, 17, 18, 19, 20)
  AND NOT EXISTS (
      SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 2
  );

INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 1
FROM pagina p
WHERE p.idpag IN (1, 3, 4, 7, 11, 13, 14, 17, 19)
  AND NOT EXISTS (
      SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 1
  );

-- ---------------------------------------------------------------------
-- 6) Usuario administrador y su rol (idempotente)
-- ---------------------------------------------------------------------
INSERT INTO usuario
    (docu, prinom, seconom, priapel, segapel, emailu, teleu, foto, passusu, estusr, ECMusr)
SELECT
    1000000001,
    'Admin',
    'UrbanPaws',
    'Administrador',
    'Principal',
    'admin@urbanpaws.com',
    '3000000001',
    NULL,
    '$2b$12$opgBW0rgOBhvxQh2uW099.gpK.B.JVdAAEecfbWVWLavHulSJs.3C',
    1,
    1
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 FROM (
        SELECT 1 FROM usuario
        WHERE emailu = 'admin@urbanpaws.com' OR docu = 1000000001
    ) AS u_existente
);

INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 3
FROM usuario u
WHERE u.emailu = 'admin@urbanpaws.com'
  AND NOT EXISTS (
      SELECT 1 FROM userxper ux
      WHERE ux.iduser = u.iduser AND ux.idperf = 3
  );

INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 3
FROM usuario u
WHERE u.iduser = 1
  AND NOT EXISTS (
      SELECT 1 FROM userxper ux
      WHERE ux.iduser = u.iduser AND ux.idperf = 3
  );

-- ---------------------------------------------------------------------
-- 7) Usuarios registrados públicamente que quedaron sin rol: Cliente
-- ---------------------------------------------------------------------
INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 2
FROM usuario u
WHERE u.iduser <> 1
  AND u.emailu <> 'admin@urbanpaws.com'
  AND NOT EXISTS (
      SELECT 1 FROM userxper ux WHERE ux.iduser = u.iduser
  );

SELECT 'Migración UrbanPaws aplicada correctamente' AS resultado;
