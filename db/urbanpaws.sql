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

CREATE TABLE pqrsf(
    idpqr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tippqr VARCHAR(50),
    descpqr TEXT,
    fechpqr DATE
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
    idmasc BIGINT(30),
    idrut INT(6),
    iduser BIGINT(10),
    descserv TEXT,
    servtipo VARCHAR(100),
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

INSERT INTO `dominio` (`iddom`, `nomdom`, `actdom`) VALUES
(1, 'Estado', '1'),
(2, 'Iconos', '1'),
(5, 'Razas', '1'),
(6, 'Tamaño Mascota', '1'),
(7, 'Estado', '2'),
(8, 'Prueba', '1');

INSERT INTO `valor` (`idval`, `codval`, `paraval`, `estaval`, `iddom`) VALUES
(1, 'Activo', '', '1', 1),
(2, 'Inactivo', '', '1', 1),
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
(1036, 'sdgfjd', 'kjkljk', '2', 1),
(1037, 'Pastor Aleman', '', '1', 5),
(1038, 'prueba', 'sdkfhsdjn', '1', 2);