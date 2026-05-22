CREATE DATABASE UrbanPaws;
USE UrbanPaws;

CREATE TABLE ubicacion(
    idubi BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomubi VARCHAR(35),
    depaubi VARCHAR(20)
);

CREATE TABLE dominio(
    iddom BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    nomdom VARCHAR(70)
);

CREATE TABLE perfil(
    idperf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomperf VARCHAR(50),
    estper INT(3)
);

CREATE TABLE pagina(
    idpag INT(3) PRIMARY KEY AUTO_INCREMENT,
    nompag VARCHAR(25),
    mostpag INT(3), -- MOSTRAR PÁGINA
    ordpag INT(3),
    descpag TEXT
);

CREATE TABLE usuario(
    iduser BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    docu BIGINT(12) UNIQUE NOT NULL,
    prinom VARCHAR(100),
    seconom VARCHAR(100),
    priapel VARCHAR(100),
    emailu VARCHAR(255) REQUIRED UNIQUE,
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
    preciomini DECIMAL(6,2),
    idmasc BIGINT(30),
    idrut INT(6),
    iduser BIGINT(10),
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE servicio(
    idserv BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tipserv VARCHAR(100),
    desserv TEXT,
    timpest TIME,
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
    idmod BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nommod VARCHAR(50),
    estamod BOOLEAN,
    ordmod INT(3),
    idpag INT(3),
    idperf BIGINT(10),
    FOREIGN KEY (idpag) REFERENCES pagina(idpag),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE pagxper(
    idpag INT(3),
    idperf BIGINT(10),
    FOREIGN KEY (idpag) REFERENCES pagina(idpag),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE valor(
    idval BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    codval VARCHAR(255),
    PARAVAL VARCHAR(255),
    estaval TINYINT(1),
    iddom BIGINT(11),
    FOREIGN KEY (iddom) REFERENCES dominio(iddom)
);