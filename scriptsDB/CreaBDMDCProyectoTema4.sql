-- Creación de la base de datos, tabla y usuario de aplicación

CREATE DATABASE IF NOT EXISTS DB2MDCDWESProyectoTema4;

USE DB2MDCDWESProyectoTema4;

CREATE TABLE IF NOT EXISTS T02_Departamento (
  T02_CodDepartamento  CHAR(3) NOT NULL PRIMARY KEY,
  T02_DescDepartamento VARCHAR(255) NOT NULL,
  T02_FechaCreacionDepartamento DATETIME NOT NULL,
  T02_VolumenDeNegocio FLOAT NULL,
  T02_FechaBajaDepartamento DATETIME NULL) ENGINE=InnoDB;

DROP USER 'user2MDCDWESProyectoTema4'@'localhost';

CREATE USER 'user2MDCDWESProyectoTema4'@'localhost' 
  IDENTIFIED BY 'paso';

GRANT SELECT, INSERT, UPDATE, DELETE
  ON DB2JRDWESProyectoTema4.*
  TO 'user2MDCDWESProyectoTema4'@'localhost';

FLUSH PRIVILEGES;