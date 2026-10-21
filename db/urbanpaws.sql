DROP DATABASE IF EXISTS UrbanPaws;
CREATE DATABASE IF NOT EXISTS UrbanPaws;
USE UrbanPaws;

CREATE TABLE ubicacion(
    idubi BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomubi VARCHAR(35),
    depaubi VARCHAR(20)
);

CREATE TABLE dominio(
    iddom BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    nomdom VARCHAR(70),
    actdom VARCHAR(3)
);

CREATE TABLE perfil(
    idperf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomperf VARCHAR(50),
    estper INT(3)
);

CREATE TABLE pagina(
    idpag INT(3) PRIMARY KEY AUTO_INCREMENT,
    titpag VARCHAR(100),
    nompag VARCHAR(25),
    mostpag VARCHAR(3),
    icopag VARCHAR(100),
    rutpag VARCHAR(255),
    ordpag INT(3),
    descpag TEXT
);

CREATE TABLE usuario(
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
    FOREIGN KEY (idubi) REFERENCES ubicacion(idubi)
);

CREATE TABLE antecedente(
    idante BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tipante VARCHAR(50),
    desante TEXT,
    fechante DATE,
    iduser BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE userxante(
    iduser BIGINT(10),
    idante BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idante) REFERENCES antecedente(idante)
);

CREATE TABLE userxper(
    iduser BIGINT(10),
    idperf BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE mascotas(
    idmasc BIGINT(30) PRIMARY KEY AUTO_INCREMENT,
    nommasc VARCHAR(50),
    sexmasc VARCHAR(10),
    fotovacu VARCHAR(255),
    fotomasc VARCHAR(255),
    razamasc VARCHAR(70),
    descmasc TEXT,
    enfermasc TEXT,
    iduser BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE duenomasc(
    iddueno BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    iduser BIGINT(10),
    idmasc BIGINT(30),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc)
);

CREATE TABLE ruta(
    idrut INT(6) PRIMARY KEY AUTO_INCREMENT,
    nomrut VARCHAR(50),
    distrut DECIMAL(7,2),
    iduser BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE paseo(
    idpas BIGINT(5) PRIMARY KEY AUTO_INCREMENT,
    estapas VARCHAR(20),
    servtipo VARCHAR(100) NOT NULL,
    inicio_programado DATETIME,
    fin_programado DATETIME NULL,
    idmasc BIGINT(30),
    idrut INT(6),
    iduser BIGINT(10),
    descserv TEXT,
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE servicio(
    idserv BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    idpas BIGINT(10),
    idrut INT(6),
    iduser BIGINT(10),
    FOREIGN KEY (idpas) REFERENCES paseo(idpas),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE detallefac(
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

CREATE TABLE factura(
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

CREATE TABLE pqrsf (
    idpqr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tippqr VARCHAR(50) NOT NULL,
    descpqr TEXT NOT NULL,
    fechpqr DATE NOT NULL,
    iduser BIGINT(10) NOT NULL,
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE config(
    idconf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomcon VARCHAR(25),
    logocon VARCHAR(255),
    emailcon VARCHAR(255),
    telecon VARCHAR(20),
    estacon INT(3)
);

CREATE TABLE modulo(
    idmod   BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nommod  VARCHAR(50),
    icomod VARCHAR(50) NULL,
    estamod VARCHAR(3),
    ordmod  INT(3),
    idperf BIGINT(10)
);

CREATE TABLE pagxper(
    idpag INT(3),
    idperf BIGINT(10),
    FOREIGN KEY (idpag) REFERENCES pagina(idpag),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE valor(
    idval  BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    codval VARCHAR(255),
    paraval VARCHAR(255),
    estaval VARCHAR(3),
    iddom  BIGINT(11),
    FOREIGN KEY (iddom) REFERENCES dominio(iddom)
);

CREATE TABLE calificacion (
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

INSERT INTO `dominio` (`iddom`, `nomdom`, `actdom`) VALUES
(1, 'Estado', '1'),
(2, 'Iconos', '1'),
(3, 'Razas', '1'),
(4, 'Tamaño Mascota', '1'),
(5, 'Tipo de servicio', '1');

INSERT INTO `valor` (`idval`, `codval`, `paraval`, `estaval`, `iddom`) VALUES
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
(1035, 'fa fa-user-gear', '', '1', 2);

INSERT INTO `perfil` (`idperf`, `nomperf`, `estper`) VALUES
(1, 'Paseador', NULL),
(2, 'Cliente', NULL),
(3, 'Admin', NULL);