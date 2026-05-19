CREATE DATABASE UrbanPaws;
USE UrbanPaws;

CREATE TABLE usuario(
idusuario BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nomusu VARCHAR(100),
telefono VARCHAR(20),
foto VARCHAR(255),
contraseña VARCHAR(255)
);

CREATE TABLE duenomasc(
iddueno BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
idusuario BIGINT(10),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario)
);

CREATE TABLE mascotas(
idmas BIGINT(30) PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(50),
sxmas VARCHAR(10),
edad INT(2),
razmas VARCHAR(70),
desmas TEXT,
enfermas TEXT,
fotmas VARCHAR(255),
iddueno BIGINT(10),
FOREIGN KEY (iddueno) REFERENCES duenomasc(iddueno)
);

CREATE TABLE paseo(
idpaseo BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
estpas VARCHAR(20),
preini DECIMAL(6,1),
iddueno BIGINT(10),
idusuario BIGINT(10),
FOREIGN KEY (iddueno) REFERENCES duenomasc(iddueno),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario)
);

CREATE TABLE ruta(
idruta BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
iddueno BIGINT(10),
FOREIGN KEY (iddueno) REFERENCES duenomasc(iddueno)
);

CREATE TABLE ubicacion(
idubi BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
pais VARCHAR(100),
departamento VARCHAR(50),
ciudad VARCHAR(120),
nomubi VARCHAR(35)
);

CREATE TABLE pqrsf(
idpqr BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nompqr VARCHAR(50),
tipoqpr VARCHAR(20),
descripcion TEXT,
fecha DATE,
idusuario BIGINT(10),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario)
);

CREATE TABLE factura(
idfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
fecha DATE,
estado BOOLEAN,
iddueno BIGINT(10),
idpqr BIGINT(10),
idusuario BIGINT(10),
FOREIGN KEY (iddueno) REFERENCES duenomasc(iddueno),
FOREIGN KEY (idpqr) REFERENCES pqrsf(idpqr),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario)
);

CREATE TABLE perfil(
idper BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nomper VARCHAR(50)
);

CREATE TABLE userxper(
idusuario BIGINT(10),
idper BIGINT(10),
PRIMARY KEY (idusuario, idper),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario),
FOREIGN KEY (idper) REFERENCES perfil(idper)
);

CREATE TABLE pagina(
idpag BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nompag VARCHAR(25),
despag TEXT
);

CREATE TABLE pagxper(
idpag BIGINT(10),
idper BIGINT(10),
PRIMARY KEY (idpag, idper),
FOREIGN KEY (idpag) REFERENCES pagina(idpag),
FOREIGN KEY (idper) REFERENCES perfil(idper)
);

CREATE TABLE servicio(
idserv BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
tipo VARCHAR(100),
descripcion TEXT,
idpaseo BIGINT(10),
idruta BIGINT(10),
iddueno BIGINT(10),
idusuario BIGINT(10),
FOREIGN KEY (idpaseo) REFERENCES paseo(idpaseo),
FOREIGN KEY (idruta) REFERENCES ruta(idruta),
FOREIGN KEY (iddueno) REFERENCES duenomasc(iddueno),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario)
);

CREATE TABLE modulo(
idmod BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nommod VARCHAR(50),
ordmod INT(3),
estado BOOLEAN
);

CREATE TABLE config(
idconf BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
nomconfg VARCHAR(25),
tema INT(1)
);

CREATE TABLE detallefac(
iddetfac BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
idserv BIGINT(10),
idfac BIGINT(10),
FOREIGN KEY (idserv) REFERENCES servicio(idserv),
FOREIGN KEY (idfac) REFERENCES factura(idfac)
);

CREATE TABLE antecedente(
idante BIGINT(10) PRIMARY KEY AUTO_INCREMENT,
desante TEXT,
fecante DATE
);

CREATE TABLE userxante(
idusuario BIGINT(10),
idante BIGINT(10),
PRIMARY KEY (idusuario, idante),
FOREIGN KEY (idusuario) REFERENCES usuario(idusuario),
FOREIGN KEY (idante) REFERENCES antecedente(idante)
);