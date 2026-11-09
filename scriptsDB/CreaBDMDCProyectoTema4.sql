-- Creación de la base de datos, tabla y usuario de aplicación

CREATE DATABASE IF NOT EXISTS DBMDCDWESProyectoTema4;

USE DBMDCDWESProyectoTema4;

CREATE TABLE IF NOT EXISTS T02_Departamento (
  T02_CodDepartamento  CHAR(3) NOT NULL PRIMARY KEY,
  T02_DescDepartamento VARCHAR(255) NOT NULL,
  T02_FechaCreacionDepartamento DATETIME NOT NULL,
  T02_VolumenDeNegocio FLOAT NULL,
  T02_FechaBajaDepartamento DATETIME NULL) ENGINE=InnoDB;

CREATE USER 'userMDCDWESProyectoTema4'@'%' 
  IDENTIFIED BY 'paso';

GRANT ALL
  ON DBMDCDWESProyectoTema4.*
  TO 'userMDCDWESProyectoTema4'@'%';

FLUSH PRIVILEGES;