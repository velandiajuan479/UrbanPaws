-- ============================================================
-- UrbanPaws - Esquema de Base de Datos Final, Modular y Escalable
-- ============================================================

DROP DATABASE IF EXISTS UrbanPaws;
CREATE DATABASE IF NOT EXISTS UrbanPaws
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE UrbanPaws;

-- 1. UBICACIONES (Municipios / Zonas)
CREATE TABLE ubicacion (
    idubi BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomubi VARCHAR(35) NOT NULL,
    depaubi VARCHAR(20) NOT NULL DEFAULT 'Cundinamarca'
);

-- 2. DOMINIOS Y VALORES (Diccionario de datos / Catálogos dinámicos)
CREATE TABLE dominio (
    iddom BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    nomdom VARCHAR(70) NOT NULL,
    actdom VARCHAR(3) NOT NULL DEFAULT 'SI'
);

CREATE TABLE valor (
    idval BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
    codval VARCHAR(255) NULL,
    PARAVAL VARCHAR(255) NULL,
    estaval VARCHAR(3) NOT NULL DEFAULT 'SI',
    iddom BIGINT(11) NOT NULL,
    FOREIGN KEY (iddom) REFERENCES dominio(iddom) ON DELETE CASCADE
);

-- 3. CONFIGURACIÓN GENERAL
CREATE TABLE config (
    idconf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomcon VARCHAR(25),
    logocon VARCHAR(255),
    emailcon VARCHAR(255),
    telecon VARCHAR(20),
    estacon INT(3)
);

-- 4. PERFILES Y MÓDULOS (Control de Acceso Modular)
CREATE TABLE perfil (
    idperf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nomperf VARCHAR(50) NOT NULL,
    estper INT(3) NOT NULL DEFAULT 1
);

CREATE TABLE pagina (
    idpag INT(3) PRIMARY KEY AUTO_INCREMENT,
    titpag VARCHAR(100),
    nompag VARCHAR(25),
    mostpag VARCHAR(3),
    icopag VARCHAR(100),
    rutpag VARCHAR(255),
    ordpag INT(3),
    descpag TEXT
);

CREATE TABLE pagxper (
    idpag INT(3),
    idperf BIGINT(10),
    FOREIGN KEY (idpag) REFERENCES pagina(idpag) ON DELETE CASCADE,
    FOREIGN KEY (idperf) REFERENCES perfil(idperf) ON DELETE CASCADE
);

CREATE TABLE modulo (
    idmod BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    nommod VARCHAR(50),
    icomod VARCHAR(50) NULL,
    estamod VARCHAR(3),
    ordmod INT(3),
    idperf BIGINT(10),
    FOREIGN KEY (idperf) REFERENCES perfil(idperf) ON DELETE SET NULL
);

-- 5. USUARIOS
CREATE TABLE usuario (
    iduser BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    docu BIGINT(12) UNIQUE NOT NULL,
    prinom VARCHAR(100) NOT NULL,
    seconom VARCHAR(100) NULL,
    priapel VARCHAR(100) NOT NULL,
    segapel VARCHAR(100) NULL,
    emailu VARCHAR(255) UNIQUE NOT NULL,
    teleu VARCHAR(20) UNIQUE NULL,
    passusu VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NULL,
    estusr TINYINT(1) NOT NULL DEFAULT 1,
    idperf BIGINT(10) NOT NULL,
    idubi BIGINT(10) NULL,
    direccion VARCHAR(255) NULL,
    FOREIGN KEY (idperf) REFERENCES perfil(idperf),
    FOREIGN KEY (idubi) REFERENCES ubicacion(idubi)
);

-- 6. ANTECEDENTES DE USUARIOS (Paseadores)
CREATE TABLE antecedente (
    idante BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tipante VARCHAR(50),
    desante TEXT,
    fechante DATE,
    iduser BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser) ON DELETE CASCADE
);

CREATE TABLE userxante (
    iduser BIGINT(10),
    idante BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser) ON DELETE CASCADE,
    FOREIGN KEY (idante) REFERENCES antecedente(idante) ON DELETE CASCADE
);

-- 7. MASCOTAS
CREATE TABLE mascotas (
    idmasc BIGINT(30) PRIMARY KEY AUTO_INCREMENT,
    nommasc VARCHAR(50) NOT NULL,
    sexmasc VARCHAR(10) NULL,
    razamasc VARCHAR(70) NULL,
    peso_kg DECIMAL(5,2) NULL,
    tamano VARCHAR(20) NULL,
    vacunas_al_dia TINYINT(1) NOT NULL DEFAULT 0,
    fotovacu VARCHAR(255) NULL,
    fotomasc VARCHAR(255) NULL,
    descmasc TEXT NULL,
    enfermasc TEXT NULL,
    iduser BIGINT(10) NOT NULL,
    FOREIGN KEY (iduser) REFERENCES usuario(iduser) ON DELETE CASCADE
);

-- 8. RUTAS Y ZONAS DE COBERTURA
CREATE TABLE ruta (
    idrut INT(6) PRIMARY KEY AUTO_INCREMENT,
    nomrut VARCHAR(50) NOT NULL,
    distrut DECIMAL(7,2),
    zona VARCHAR(100) NULL,
    radio_m INT(5) NOT NULL DEFAULT 3000,
    iduser BIGINT(10) NOT NULL,
    FOREIGN KEY (iduser) REFERENCES usuario(iduser) ON DELETE CASCADE
);

-- 9. PASEOS Y SERVICIOS
CREATE TABLE paseo (
    idpas BIGINT(5) PRIMARY KEY AUTO_INCREMENT,
    estapas VARCHAR(20) NOT NULL DEFAULT 'SOLICITADO',
    servtipo VARCHAR(100) NOT NULL DEFAULT 'INDIVIDUAL',
    inicio_programado DATETIME NULL,
    fin_programado DATETIME NULL,
    descserv TEXT,
    idmasc BIGINT(30) NOT NULL,
    idrut INT(6) NOT NULL,
    iduser BIGINT(10) NOT NULL COMMENT 'Cliente que solicita',
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

CREATE TABLE servicio (
    idserv BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    idpas BIGINT(10),
    idrut INT(6),
    iduser BIGINT(10),
    FOREIGN KEY (idpas) REFERENCES paseo(idpas) ON DELETE CASCADE,
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
);

-- 10. FACTURACIÓN Y DETALLES
CREATE TABLE detallefac (
    iddetfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    timpfin TIME,
    subtotal DECIMAL(12,2),
    idrut INT(6),
    idserv BIGINT(10),
    idmasc BIGINT(30),
    FOREIGN KEY (idrut) REFERENCES ruta(idrut),
    FOREIGN KEY (idserv) REFERENCES servicio(idserv),
    FOREIGN KEY (idmasc) REFERENCES mascotas(idmasc)
);

CREATE TABLE factura (
    idfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    fechfac DATE NOT NULL,
    preciolin DECIMAL(12,2),
    estafac BOOLEAN NOT NULL DEFAULT 0,
    comenfac TEXT,
    iduser BIGINT(10) NOT NULL,
    iddetfac BIGINT(10),
    FOREIGN KEY (iduser) REFERENCES usuario(iduser),
    FOREIGN KEY (iddetfac) REFERENCES detallefac(iddetfac) ON DELETE SET NULL
);

-- 11. PQRSF Y CALIFICACIONES
CREATE TABLE pqrsf (
    idpqr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
    tippqr VARCHAR(50) NOT NULL,
    descpqr TEXT NOT NULL,
    fechpqr DATE NOT NULL,
    iduser BIGINT(10) NOT NULL,
    FOREIGN KEY (iduser) REFERENCES usuario(iduser)
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