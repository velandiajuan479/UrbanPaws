-- =====================================================================
-- Seed idempotente: usuario administrador para la vista vusuadmin
-- Ejecutar desde la raiz del proyecto:
--   /opt/lampp/bin/mysql -uroot < db/seed_admin.sql
--
-- Credenciales temporales:
--   documento : 1000000001
--   correo    : admin@urbanpaws.com
--   contrasena: Admin12345   (cambiar tras el primer ingreso)
-- El hash bcrypt es compatible con password_verify() de PHP.
-- =====================================================================
USE UrbanPaws;

-- 1) Perfiles base (no sobrescribe los que ya existan)
INSERT IGNORE INTO perfil (idperf, nomperf, estper) VALUES
    (1, 'Paseador', 1),
    (2, 'Cliente',  1),
    (3, 'Admin',    1);

-- 2) Usuario administrador (solo si no existe por correo o documento)
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
        SELECT 1
        FROM usuario
        WHERE emailu = 'admin@urbanpaws.com'
           OR docu = 1000000001
    ) AS u_existente
);

-- 3) Rol Admin (idperf = 3) para ese usuario, si no lo tiene
INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 3
FROM usuario u
WHERE u.emailu = 'admin@urbanpaws.com'
  AND NOT EXISTS (
      SELECT 1
      FROM userxper ux
      WHERE ux.iduser = u.iduser
        AND ux.idperf = 3
  );

-- 4) Paginas del sistema y matriz pagina x perfil de la vista vusuadmin.
--    El seed incluido es idempotente y ademas asegura Admin para iduser = 1.
SOURCE db/seed_vusuadmin.sql;
