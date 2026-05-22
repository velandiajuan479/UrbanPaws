CREATE DATABASE UrbanPaws;
USE UrbanPaws;

CREATE TABLE ubicacion(
idubi BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nomubi VARCHAR(35),
depubi VARCHAR(20)
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
mospag INT(3),
ordpag INT(3),
despag TEXT
);

CREATE TABLE usuario(
idusr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
docusr BIGINT(12),
nomusr VARCHAR(255),
emlusr VARCHAR(255),
tefusr VARCHAR(20),
fotusr VARCHAR(255),
passusr VARCHAR(255),
estusr TINYINT(1),
civusr VARCHAR(255),
fhsolusr DATETIME,
ECMusr TINYINT(1),
idubi BIGINT(10),
FOREIGN KEY (idubi) REFERENCES ubicacion(idubi)
);

CREATE TABLE pqrsf(
idpqr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
tippqr VARCHAR(50),
despqr TEXT,
fecpqr DATE
);

CREATE TABLE antecedente(
idante BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
tipante VARCHAR(50),
desante TEXT,
fecante DATE,
idusr BIGINT(10),
FOREIGN KEY (idusr) REFERENCES usuario(idusr)
);

CREATE TABLE userxante(
idusr BIGINT(10),
idante BIGINT(10),
FOREIGN KEY (idusr) REFERENCES usuario(idusr),
FOREIGN KEY (idante) REFERENCES antecedente(idante)
);

CREATE TABLE userxper(
idusr BIGINT(10),
idperf BIGINT(10),
FOREIGN KEY (idusr) REFERENCES usuario(idusr),
FOREIGN KEY (idperf) REFERENCES perfil(idperf)
);

CREATE TABLE mascotas(
idmas BIGINT(30) PRIMARY KEY AUTO_INCREMENT,
nommas VARCHAR(50),
sxmas VARCHAR(10),
fotvacn VARCHAR(255),
fotmas VARCHAR(255),
razmas VARCHAR(70),
desmas TEXT,
enfermas TEXT,
idusr BIGINT(10),
FOREIGN KEY (idusr) REFERENCES usuario(idusr)
);

CREATE TABLE duenomasc(
idduenomasc BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
idusr BIGINT(10),
idmas BIGINT(30),
FOREIGN KEY (idusr) REFERENCES usuario(idusr),
FOREIGN KEY (idmas) REFERENCES mascotas(idmas)
);

CREATE TABLE ruta(
idrut INT(6) PRIMARY KEY AUTO_INCREMENT,
nomrut VARCHAR(50),
distrut DECIMAL(7,2),
idusr BIGINT(10),
FOREIGN KEY (idusr) REFERENCES usuario(idusr)
);

CREATE TABLE paseo(
idpas BIGINT(5) PRIMARY KEY AUTO_INCREMENT,
estpas VARCHAR(20),
precioini DECIMAL(6,2),
idmas BIGINT(30),
idrut INT(6),
idusr BIGINT(10),
FOREIGN KEY (idmas) REFERENCES mascotas(idmas),
FOREIGN KEY (idrut) REFERENCES ruta(idrut),
FOREIGN KEY (idusr) REFERENCES usuario(idusr)
);

CREATE TABLE servicio(
idserv BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
tipserv VARCHAR(100),
desserv TEXT,
timpest TIME,
idpas BIGINT(10),
idrut INT(6),
idusr BIGINT(10),
FOREIGN KEY (idpas) REFERENCES paseo(idpas),
FOREIGN KEY (idrut) REFERENCES ruta(idrut),
FOREIGN KEY (idusr) REFERENCES usuario(idusr)
);

CREATE TABLE detallefac(
iddetfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
timpfn TIME,
subtotal DECIMAL(6,2),
idrut INT(6),
idserv BIGINT(10),
idmas BIGINT(30),
FOREIGN KEY (idrut) REFERENCES ruta(idrut),
FOREIGN KEY (idserv) REFERENCES servicio(idserv),
FOREIGN KEY (idmas) REFERENCES mascotas(idmas)
);

CREATE TABLE factura(
idfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
fecfac DATE,
preciolin DECIMAL(6,2),
estfac BOOLEAN,
comtfac TEXT,
idusr BIGINT(10),
iddetfac BIGINT(10),
FOREIGN KEY (idusr) REFERENCES usuario(idusr),
FOREIGN KEY (iddetfac) REFERENCES detallefac(iddetfac)
);

CREATE TABLE config(
idconf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nomconfg VARCHAR(25),
logoconfg VARCHAR(255),
emlcong VARCHAR(255),
tefconfg VARCHAR(20),
estconfg INT(3)
);

CREATE TABLE modulo(
idmod BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nommod VARCHAR(50),
estmod BOOLEAN,
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
parval VARCHAR(255),
eslval TINYINT(1),
iddom BIGINT(11),
FOREIGN KEY (iddom) REFERENCES dominio(iddom)
);
