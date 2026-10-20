<?php
/*
 * Moisés Alberto Dominguez Cruz
 * Archivo de configuración de acceso a la base de datos MariaDB.
 * Permite alternar fácilmente entre el entorno de Casa y Clase.
 */

// =========================================================
// CONFIGURACION DE CASA
// =========================================================
//define('HOST', "mysql:host=192.168.1.100;dbname=DBMDCDWESProyectoTema4;charset=utf8mb4"); // DSN para PDO
//define('SERVER', "192.168.1.100"); // Servidor para MYSQLi
//define('DBNAME', "DBMDCDWESProyectoTema4"); // Nombre de la BD para MYSQLi
//define('USER', "userMDCDWESProyectoTema4");
//define('PASS', "paso");

// =========================================================
// CONFIGURACION DE CLASE (Descomentar en clase)
// =========================================================

define('HOST', "mysql:host=10.199.9.184;dbname=DBMDCDWESProyectoTema4;charset=utf8mb4");
define('SERVER', "10.199.9.184");
define('DBNAME', "DBMDCDWESProyectoTema4");
define('USER', "userMDCDWESProyectoTema4");
define('PASS', "paso");

?>