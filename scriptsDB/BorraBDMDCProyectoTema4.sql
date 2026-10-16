-- Borrado de la base de datos y del usuario de aplicación
USE mysql;
DROP USER IF EXISTS 'userMDCDWESProyectoTema4'@'%';
DROP DATABASE IF EXISTS DBMDCDWESProyectoTema4;
