CREATE DATABASE IF NOT EXISTS UrbanPaws;
USE UrbanPaws;

CREATE TABLE IF NOT EXISTS ubicacion(
    idubi BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomubi VARCHAR(35),
    depaubi VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS dominio(
    iddom BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    nomdom VARCHAR(70),
    actdom VARCHAR(3)
);

CREATE TABLE IF NOT EXISTS perfil(
    idperf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomperf VARCHAR(50),
    estper INT(3)
);

CREATE TABLE IF NOT EXISTS pagina(
    idpag INT(3) PRIMARY KEY AUTO_INCREMENT,
    titpag VARCHAR(100),
    nompag VARCHAR(25),
    mostpag VARCHAR(3),
    icopag VARCHAR(100),
    rutpag VARCHAR(255),
    ordpag INT(3),
    descpag TEXT
);

CREATE TABLE IF NOT EXISTS usuario(
    iduser BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    docu BIGINT(12) UNIQUE NOT NULL,
    prinom VARCHAR(100),
    seconom VARCHAR(100),
    priapel VARCHAR(100),
    segapel VARCHAR(100),
    emailu VARCHAR(255) UNIQUE,
    teleu VARCHAR(20) UNIQUE,
    foto VARCHAR(255),
    passusu VARCHAR(255) UNIQUE,
    claveu VARCHAR(255) UNIQUE,
    estusr TINYINT(1),
    ECMusr TINYINT(1),
    idubi BIGINT(10),
    advusr INT(11) NOT NULL DEFAULT 0,
    multausr DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    vetousr TINYINT(1) NOT NULL DEFAULT 0,
    sancionusr VARCHAR(20) NULL,
    fecsancion DATETIME NULL,
    obssancion VARCHAR(255) NULL,
    FOREIGN KEY (idubi) REFERENCES ubicacion(idubi)
);

CREATE TABLE IF NOT EXISTS antecedente(
    idante BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tipante VARCHAR(50),
    desante TEXT,
    fechante DATE,
    iduser BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE IF NOT EXISTS userxante(
    iduser BIGINT(10),
    idante BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idante) REFERENCES antecedente(idante)
);

CREATE TABLE IF NOT EXISTS userxper(
    iduser BIGINT(10),
    idperf BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE IF NOT EXISTS raza_mascota(
    idraz BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    nomraz VARCHAR(255) NOT NULL UNIQUE,
    actraz TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS mascotas(
    idmasc BIGINT(30) PRIMARY KEY AUTO_INCREMENT,
    nommasc VARCHAR(50),
    sexmasc VARCHAR(10),
    fotovacu VARCHAR(255),
    fotomasc VARCHAR(255),
    razamasc VARCHAR(70),
    descmasc TEXT,
    enfermasc TEXT,
    iduser BIGINT(10),
    sizemasc varchar(20) DEFAULT NULL,
    actmasc TINYINT(1) NOT NULL DEFAULT 1,
    idraz BIGINT(11) NULL,
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idraz) REFERENCES raza_mascota(idraz)
);

CREATE TABLE IF NOT EXISTS duenomasc(
    iddueno BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    iduser BIGINT(10),
    idmasc BIGINT(30),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc)
);

CREATE TABLE IF NOT EXISTS ruta(
    idrut INT(6) PRIMARY KEY AUTO_INCREMENT,
    nomrut VARCHAR(50),
    distrut DECIMAL(7,2),
    iduser BIGINT(10),
    direccion_rut VARCHAR(255) NULL,
    referencia_rut VARCHAR(255) NULL,
    idubi BIGINT(10) NULL,
    estarut BIGINT(11) NOT NULL DEFAULT 1,
    horaini TIME NULL,
    horafin TIME NULL,
    precioini DECIMAL(10,2) NOT NULL DEFAULT 0,
    KEY idx_ruta_ubi (idubi),
    KEY idx_ruta_user_est (iduser, estarut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE IF NOT EXISTS paseo(
    idpas BIGINT(5) PRIMARY KEY AUTO_INCREMENT,
    estapas VARCHAR(20),
    servtipo VARCHAR(100) NOT NULL,
    inicio_programado DATETIME,
    fin_programado DATETIME NULL,
    idmasc BIGINT(30),
    idrut INT(6),
    iduser BIGINT(10),
    descserv TEXT,
    idpaseador BIGINT(10) NULL,
    precio_pactado DECIMAL(10,2) NULL,
    direccion_pactada VARCHAR(255) NULL,
    referencia_pactada VARCHAR(255) NULL,
    fecha_cancelacion DATETIME NULL,
    motivo_cancelacion TEXT NULL,
    cancelado_por BIGINT(10) NULL,
    cancelacion_tardia TINYINT(1) NOT NULL DEFAULT 0,
    KEY idx_paseo_paseador_fecha (idpaseador, inicio_programado, fin_programado),
    KEY idx_paseo_cliente_estado (iduser, estapas),
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE IF NOT EXISTS servicio(
    idserv BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    idpas BIGINT(10),
    idrut INT(6),
    iduser BIGINT(10),
    tipserv VARCHAR(100) NULL DEFAULT 'Paseo',
    FOREIGN KEY (idpas) REFERENCES paseo(idpas),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE IF NOT EXISTS detallefac(
    iddetfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    timpfin TIME,
    subtotal DECIMAL(6,2),
    idrut INT(6),
    idserv BIGINT(10),
    idmasc BIGINT(30),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (idserv) REFERENCES servicio(idserv),
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc)
);

CREATE TABLE IF NOT EXISTS factura(
    idfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    fechfac DATE,
    preciolin DECIMAL(6,2),
    estafac BOOLEAN,
    comenfac TEXT,
    iduser BIGINT(10),
    iddetfac BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (iddetfac) REFERENCES detallefac(iddetfac)
);

CREATE TABLE IF NOT EXISTS pqrsf (
    idpqr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tippqr VARCHAR(50) NOT NULL,
    descpqr TEXT NOT NULL,
    fechpqr DATE NOT NULL,
    iduser BIGINT(10) NOT NULL,
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE IF NOT EXISTS config(
    idconf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomcon VARCHAR(25),
    logocon VARCHAR(255),
    emailcon VARCHAR(255),
    telecon VARCHAR(20),
    estacon INT(3)
);

CREATE TABLE IF NOT EXISTS modulo(
    idmod   BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nommod  VARCHAR(50),
    icomod VARCHAR(50) NULL,
    estamod VARCHAR(3),
    ordmod  INT(3),
    idperf BIGINT(10)
);

CREATE TABLE IF NOT EXISTS pagxper(
    idpag INT(3),
    idperf BIGINT(10),
    FOREIGN KEY (idpag) REFERENCES pagina(idpag),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE IF NOT EXISTS valor(
    idval  BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    codval VARCHAR(255),
    paraval VARCHAR(255),
    estaval VARCHAR(3),
    iddom  BIGINT(11),
    FOREIGN KEY (iddom) REFERENCES dominio(iddom)
);

CREATE TABLE IF NOT EXISTS calificacion (
    idcal BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    puntuacion TINYINT(1) NOT NULL,
    comentario TEXT NULL,
    idpas BIGINT(5) NOT NULL,
    idcliente BIGINT(10) NOT NULL,
    idpaseador BIGINT(10) NOT NULL,
    FOREIGN KEY (idpas) REFERENCES paseo(idpas),
    FOREIGN KEY (idcliente) REFERENCES usuario(iduser),
    FOREIGN KEY (idpaseador) REFERENCES usuario(iduser)
);

INSERT IGNORE INTO `dominio` (`iddom`, `nomdom`, `actdom`) VALUES
(1, 'Estado', '1'),
(2, 'Iconos', '1'),
(3, 'Razas', '1'),
(4, 'Tamaño Mascota', '1'),
(5, 'Tipo de servicio', '1');

INSERT IGNORE INTO `valor` (`idval`, `codval`, `paraval`, `estaval`, `iddom`) VALUES
-- ESTADOS
(1, 'Activo',     '', '1', 1),
(2, 'Inactivo',   '', '1', 1),
(3, 'Solicitado', '', '1', 1),
(4, 'Cancelado', '', '1', 1),
(5, 'Terminado', '', '1', 1),

-- Tamaño Masc
(10, 'Pequeño', '', '1', 4),
(11, 'Mediano', '', '1', 4),
(12, 'Grande', '', '1', 4),

-- tipo servicio
(20, 'Individual', '', '1', 5),
(21, 'Grupal', '', '1', 5),
-- Razas

(100, 'Affenpinscher', '', '1', 3),
(101, 'Airedale Terrier', '', '1', 3),
(102, 'Akita Inu', '', '1', 3),
(103, 'Akita Americano', '', '1', 3),
(104, 'Alano Espanol', '', '1', 3),
(105, 'Alaskan Malamute', '', '1', 3),
(106, 'American Staffordshire Terrier', '', '1', 3),
(107, 'Basenji', '', '1', 3),
(108, 'Basset Hound', '', '1', 3),
(109, 'Beagle', '', '1', 3),
(110, 'Beauceron', '', '1', 3),
(111, 'Bearded Collie', '', '1', 3),
(112, 'Bichon Frise', '', '1', 3),
(113, 'Bichon Habanero', '', '1', 3),
(114, 'Bichon Maltes', '', '1', 3),
(115, 'Bloodhound', '', '1', 3),
(116, 'Border Collie', '', '1', 3),
(117, 'Border Terrier', '', '1', 3),
(118, 'Borzoi', '', '1', 3),
(119, 'Boston Terrier', '', '1', 3),
(120, 'Boxer', '', '1', 3),
(121, 'Boyero de Berna', '', '1', 3),
(122, 'Braco Aleman', '', '1', 3),
(123, 'Braco de Weimar', '', '1', 3),
(124, 'Bulldog Americano', '', '1', 3),
(125, 'Bulldog Frances', '', '1', 3),
(126, 'Bulldog Ingles', '', '1', 3),
(127, 'Bull Terrier', '', '1', 3),
(128, 'Bullmastiff', '', '1', 3),
(129, 'Cairn Terrier', '', '1', 3),
(130, 'Caniche', '', '1', 3),
(131, 'Cane Corso', '', '1', 3),
(132, 'Cavalier King Charles Spaniel', '', '1', 3),
(133, 'Chesapeake Bay Retriever', '', '1', 3),
(134, 'Chihuahua', '', '1', 3),
(135, 'Chin Japones', '', '1', 3),
(136, 'Chow Chow', '', '1', 3),
(137, 'Cocker Spaniel Americano', '', '1', 3),
(138, 'Cocker Spaniel Ingles', '', '1', 3),
(139, 'Collie', '', '1', 3),
(140, 'Coton de Tulear', '', '1', 3),
(141, 'Curly-Coated Retriever', '', '1', 3),
(142, 'Dalmata', '', '1', 3),
(143, 'Dandie Dinmont Terrier', '', '1', 3),
(144, 'Dobermann', '', '1', 3),
(145, 'Dogo Argentino', '', '1', 3),
(146, 'Dogo Canario', '', '1', 3),
(147, 'Dogo de Burdeos', '', '1', 3),
(148, 'Elkhound Noruego', '', '1', 3),
(149, 'Eurasier', '', '1', 3),
(150, 'Fila Brasileiro', '', '1', 3),
(151, 'Flat-Coated Retriever', '', '1', 3),
(152, 'Fox Terrier', '', '1', 3),
(153, 'Galgo Espanol', '', '1', 3),
(154, 'Galgo Italiano', '', '1', 3),
(155, 'Golden Retriever', '', '1', 3),
(156, 'Goldendoodle', '', '1', 3),
(157, 'Gran Danes', '', '1', 3),
(158, 'Gran Pirineo', '', '1', 3),
(159, 'Greyhound', '', '1', 3),
(160, 'Grifon de Bruselas', '', '1', 3),
(161, 'Havanes', '', '1', 3),
(162, 'Hovawart', '', '1', 3),
(163, 'Husky Siberiano', '', '1', 3),
(164, 'Jack Russell Terrier', '', '1', 3),
(165, 'Keeshond', '', '1', 3),
(166, 'Komondor', '', '1', 3),
(167, 'Kuvasz', '', '1', 3),
(168, 'Labradoodle', '', '1', 3),
(169, 'Labrador Retriever', '', '1', 3),
(170, 'Landseer', '', '1', 3),
(171, 'Leonberger', '', '1', 3),
(172, 'Lhasa Apso', '', '1', 3),
(173, 'Lowchen', '', '1', 3),
(174, 'Mastin Espanol', '', '1', 3),
(175, 'Mastin Ingles', '', '1', 3),
(176, 'Mastin Napolitano', '', '1', 3),
(177, 'Mastin Tibetano', '', '1', 3),
(178, 'Mestizo', '', '1', 3),
(179, 'Mudi', '', '1', 3),
(180, 'Nova Scotia Duck Tolling Retriever', '', '1', 3),
(181, 'Papillon', '', '1', 3),
(182, 'Pastor Aleman', '', '1', 3),
(183, 'Pastor Anatolio', '', '1', 3),
(184, 'Pastor Australiano', '', '1', 3),
(185, 'Pastor Belga Groenendael', '', '1', 3),
(186, 'Pastor Belga Laekenois', '', '1', 3),
(187, 'Pastor Belga Malinois', '', '1', 3),
(188, 'Pastor Belga Tervuren', '', '1', 3),
(189, 'Pastor Bergamasco', '', '1', 3),
(190, 'Pastor Blanco Suizo', '', '1', 3),
(191, 'Pastor Briard', '', '1', 3),
(192, 'Pastor Catalan', '', '1', 3),
(193, 'Pastor Caucasico', '', '1', 3),
(194, 'Pastor de Asia Central', '', '1', 3),
(195, 'Pastor de los Pirineos', '', '1', 3),
(196, 'Pastor de Shetland', '', '1', 3),
(197, 'Pastor Holandes', '', '1', 3),
(198, 'Pastor Ingles Antiguo', '', '1', 3),
(199, 'Pastor Maremmano', '', '1', 3),
(200, 'Pekines', '', '1', 3),
(201, 'Perro Crestado Chino', '', '1', 3),
(202, 'Perro de Agua Espanol', '', '1', 3),
(203, 'Perro de Agua Irlandes', '', '1', 3),
(204, 'Perro de Agua Portugues', '', '1', 3),
(205, 'Perro de Presa Canario', '', '1', 3),
(206, 'Perro Lobo Checoslovaco', '', '1', 3),
(207, 'Perro Lobo de Saarloos', '', '1', 3),
(208, 'Perro sin Pelo del Peru', '', '1', 3),
(209, 'Perro sin Pelo Mexicano Xoloitzcuintle', '', '1', 3),
(210, 'Petit Basset Griffon Vendeen', '', '1', 3),
(211, 'Pharaoh Hound', '', '1', 3),
(212, 'Pinscher Aleman', '', '1', 3),
(213, 'Pinscher Miniatura', '', '1', 3),
(214, 'Pit Bull Terrier Americano', '', '1', 3),
(215, 'Podenco Canario', '', '1', 3),
(216, 'Podenco Ibicenco', '', '1', 3),
(217, 'Pointer Ingles', '', '1', 3),
(218, 'Pomerania', '', '1', 3),
(219, 'Presa Mallorquin', '', '1', 3),
(220, 'Pug Carlino', '', '1', 3),
(221, 'Puli', '', '1', 3),
(222, 'Pumi', '', '1', 3),
(223, 'Rhodesian Ridgeback', '', '1', 3),
(224, 'Rottweiler', '', '1', 3),
(225, 'Sabueso Espanol', '', '1', 3),
(226, 'Saluki', '', '1', 3),
(227, 'Samoyedo', '', '1', 3),
(228, 'San Bernardo', '', '1', 3),
(229, 'Schipperke', '', '1', 3),
(230, 'Schnauzer Estandar', '', '1', 3),
(231, 'Schnauzer Gigante', '', '1', 3),
(232, 'Schnauzer Miniatura', '', '1', 3),
(233, 'Setter Gordon', '', '1', 3),
(234, 'Setter Ingles', '', '1', 3),
(235, 'Setter Irlandes', '', '1', 3),
(236, 'Shar Pei', '', '1', 3),
(237, 'Shiba Inu', '', '1', 3),
(238, 'Shih Tzu', '', '1', 3),
(239, 'Spaniel Tibetano', '', '1', 3),
(240, 'Spitz Aleman', '', '1', 3),
(241, 'Spitz Japones', '', '1', 3),
(242, 'Springer Spaniel Ingles', '', '1', 3),
(243, 'Staffordshire Bull Terrier', '', '1', 3),
(244, 'Terranova', '', '1', 3),
(245, 'Terrier Brasileiro', '', '1', 3),
(246, 'Terrier Escoces', '', '1', 3),
(247, 'Terrier Irlandes', '', '1', 3),
(248, 'Terrier Tibetano', '', '1', 3),
(249, 'Vizsla', '', '1', 3),
(250, 'Weimaraner', '', '1', 3),
(251, 'Welsh Corgi Cardigan', '', '1', 3),
(252, 'Welsh Corgi Pembroke', '', '1', 3),
(253, 'West Highland White Terrier', '', '1', 3),
(254, 'Whippet', '', '1', 3),
(255, 'Wolfhound Irlandes', '', '1', 3),
(256, 'Yorkshire Terrier', '', '1', 3),
(257, 'Otra raza', '', '1', 3),

-- ICONOS
(1001, 'fa fa-school', NULL, '1', 2),
(1002, 'fa fa-user-graduate', NULL, '1', 2),
(1003, 'fa fa-book-open', NULL, '1', 2),
(1004, 'fa fa-file', NULL, '1', 2),
(1005, 'fa fa-address-card', NULL, '1', 2),
(1006, 'fa fa-graduation-cap', NULL, '1', 2),
(1007, 'fa fa-cube', NULL, '1', 2),
(1008, 'fa fa-user', NULL, '1', 2),
(1009, 'fa fa-gear', NULL, '1', 2),
(1010, 'fa fa-coins', NULL, '1', 2),
(1011, 'fa fa-address-book', NULL, '1', 2),
(1012, 'fa fa-bars', NULL, '1', 2),
(1013, 'fa fa-bug', NULL, '1', 2),
(1014, 'fa fa-calendar', NULL, '1', 2),
(1015, 'fa fa-calendar', NULL, '1', 2),
(1016, 'fa fa-clipboard', NULL, '1', 2),
(1017, 'fa fa-clipboard-check', NULL, '1', 2),
(1018, 'fa fa-code', NULL, '1', 2),
(1019, 'fa fa-comment', NULL, '1', 2),
(1020, 'fa fa-computer', NULL, '1', 2),
(1021, 'fa fa-cookie', NULL, '1', 2),
(1022, 'fa fa-cubes', NULL, '1', 2),
(1023, 'fa fa-envelope', NULL, '1', 2),
(1024, 'fa-hard-drive', NULL, '1', 2),
(1025, 'fa fa-house', NULL, '1', 2),
(1026, 'fa fa-image', NULL, '1', 2),
(1027, 'fa-solid fa-address-card', '', '1', 2),
(1028, 'fa fa-inbox', '', '1', 2),
(1029, 'fa fa-message', '', '1', 2),
(1030, 'fa fa-newspaper', '', '1', 2),
(1031, 'fa fa-phone', '', '1', 2),
(1032, 'fa- fa-rectangle-list', '', '1', 2),
(1033, 'fa fa-server', '', '1', 2),
(1034, 'fa fa-user-group', '', '1', 2),
(1035, 'fa fa-user-gear', '', '1', 2),

-- ESTADOS DE PASEOS / SOLICITUDES
(1036, 'Aceptado',  '', '1', 1),
(1037, 'Rechazado', '', '1', 1);

INSERT IGNORE INTO raza_mascota (idraz, nomraz, actraz)
SELECT idval, codval, CASE WHEN estaval = '1' THEN 1 ELSE 0 END
FROM valor
WHERE iddom = 3;

INSERT IGNORE INTO `perfil` (`idperf`, `nomperf`, `estper`) VALUES
(1, 'Paseador', NULL),
(2, 'Cliente', NULL),
(3, 'Admin', NULL);

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
(12, 'Listado de rutas',              'List. rutas',  '1', 'fa-solid fa-list',              'home.php?pg=12', 120, 'Vista vserrutps.php'),
(13, 'Agendar paseo',                 'Agendar',      '1', 'fa-solid fa-person-walking',    'home.php?pg=13', 130, 'Vista vserpas.php'),
(14, 'Solicitudes de paseo',          'Solicitudes',  '1', 'fa-solid fa-list-check',        'home.php?pg=14', 140, 'Vista vserserps.php'),
(15, 'Servicios',                     'Servicios',    '1', 'fa-solid fa-concierge-bell',    'home.php?pg=15', 150, 'Vista vsersercl.php'),
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

UPDATE pagina SET mostpag = '1', descpag = 'Vista vserrutps.php' WHERE idpag = 12;
UPDATE pagina SET mostpag = '1', descpag = 'Vista vsersercl.php' WHERE idpag = 15;

INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 3
FROM pagina p
WHERE NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 3
);

INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 2
FROM pagina p
WHERE p.idpag IN (1,4,7,9,11,13,14,15,17,18,19,20)
  AND NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 2
);

INSERT INTO pagxper (idpag, idperf)
SELECT p.idpag, 1
FROM pagina p
WHERE p.idpag IN (1,3,4,7,11,12,13,14,15,17,19)
  AND NOT EXISTS (
    SELECT 1 FROM pagxper px WHERE px.idpag = p.idpag AND px.idperf = 1
);

INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 3
FROM usuario u
WHERE u.iduser = 1
  AND NOT EXISTS (
    SELECT 1 FROM userxper ux WHERE ux.iduser = u.iduser AND ux.idperf = 3
);

INSERT INTO ubicacion (idubi, nomubi, depaubi)
SELECT 9001, 'Chapinero', 'Bogota'
WHERE NOT EXISTS (SELECT 1 FROM ubicacion WHERE idubi = 9001);

INSERT INTO usuario (docu, prinom, seconom, priapel, segapel, emailu, teleu, foto, passusu, claveu, estusr, ECMusr, idubi)
SELECT 900000001, 'Admin', '', 'UrbanPaws', '', 'admin.servicios@urbanpaws.local', '3000000001', NULL, '$2y$10$Z1NIUJnakGLbbDhqEf3Yfuf0Syn1GPird70o/vxQLTlLg/S2Pd9.S', NULL, 1, 1, 9001
WHERE NOT EXISTS (SELECT 1 FROM usuario WHERE docu = 900000001);

INSERT INTO usuario (docu, prinom, seconom, priapel, segapel, emailu, teleu, foto, passusu, claveu, estusr, ECMusr, idubi)
SELECT 900000002, 'Paseo', '', 'Prueba', '', 'paseador.servicios@urbanpaws.local', '3000000002', NULL, '$2y$10$PP8J2thbW065Xaw00yL4WOvrub81sgRQ6zYBzUk9wONJEV1RKTFLm', NULL, 1, 1, 9001
WHERE NOT EXISTS (SELECT 1 FROM usuario WHERE docu = 900000002);

INSERT INTO usuario (docu, prinom, seconom, priapel, segapel, emailu, teleu, foto, passusu, claveu, estusr, ECMusr, idubi)
SELECT 900000003, 'Cliente', '', 'Prueba', '', 'cliente.servicios@urbanpaws.local', '3000000003', NULL, '$2y$10$GDZjzKx/z3d2TFnRlb/DSe4.WvOxIzyQVlK7WmduDC6L0ZUv5I8JC', NULL, 1, 1, 9001
WHERE NOT EXISTS (SELECT 1 FROM usuario WHERE docu = 900000003);

UPDATE usuario SET emailu = 'admin.servicios@urbanpaws.local', teleu = '3000000001', passusu = '$2y$10$Z1NIUJnakGLbbDhqEf3Yfuf0Syn1GPird70o/vxQLTlLg/S2Pd9.S', estusr = 1, ECMusr = 1, idubi = 9001 WHERE docu = 900000001;
UPDATE usuario SET emailu = 'paseador.servicios@urbanpaws.local', teleu = '3000000002', passusu = '$2y$10$PP8J2thbW065Xaw00yL4WOvrub81sgRQ6zYBzUk9wONJEV1RKTFLm', estusr = 1, ECMusr = 1, idubi = 9001 WHERE docu = 900000002;
UPDATE usuario SET emailu = 'cliente.servicios@urbanpaws.local', teleu = '3000000003', passusu = '$2y$10$GDZjzKx/z3d2TFnRlb/DSe4.WvOxIzyQVlK7WmduDC6L0ZUv5I8JC', estusr = 1, ECMusr = 1, idubi = 9001 WHERE docu = 900000003;

INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 3 FROM usuario u WHERE u.docu = 900000001
  AND NOT EXISTS (SELECT 1 FROM userxper ux WHERE ux.iduser = u.iduser AND ux.idperf = 3);

INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 1 FROM usuario u WHERE u.docu = 900000002
  AND NOT EXISTS (SELECT 1 FROM userxper ux WHERE ux.iduser = u.iduser AND ux.idperf = 1);

INSERT INTO userxper (iduser, idperf)
SELECT u.iduser, 2 FROM usuario u WHERE u.docu = 900000003
  AND NOT EXISTS (SELECT 1 FROM userxper ux WHERE ux.iduser = u.iduser AND ux.idperf = 2);

INSERT INTO mascotas (nommasc, sexmasc, razamasc, idraz, descmasc, enfermasc, iduser)
SELECT 'Luna', 'H', r.nomraz, r.idraz, 'Mascota de prueba para validar el modulo servicios', '', u.iduser
FROM usuario u
INNER JOIN raza_mascota r ON r.nomraz = 'Mestizo'
WHERE u.docu = 900000003
  AND NOT EXISTS (SELECT 1 FROM mascotas m WHERE m.iduser = u.iduser AND m.nommasc = 'Luna');

INSERT INTO ruta (nomrut, distrut, iduser, direccion_rut, referencia_rut, idubi, estarut, horaini, horafin, precioini)
SELECT 'Ruta Chapinero', 3.50, u.iduser, 'Calle 85 # 12-34', 'Frente al parque', 9001, 1, '08:00:00', '10:00:00', 25000
FROM usuario u
WHERE u.docu = 900000002
  AND NOT EXISTS (SELECT 1 FROM ruta r WHERE r.iduser = u.iduser AND r.nomrut = 'Ruta Chapinero');