<?php
/*
 * Moisés Alberto Dominguez Cruz
 * 19/10/2026
 * Ejercicio 01 (Tema 4) - Conexión a la base de datos MariaDB mediante MYSQLi y PDO con control de excepciones.
 */

echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a><hr>";

// Importacion del archivo de configuracion que contiene las constantes de conexion
require_once '../config/configDB00.php';

// Errores y manejo de excepciones en MySQLi
$controlador = new mysqli_driver();
$controlador->report_mode = MYSQLI_REPORT_ALL;

try {
    // Establecemos la conexion usando las constantes de configDB00.php
    $oConexionMYSQLi = new mysqli(SERVER, USER, PASS, DBNAME);

    echo "Conectado a MariaDB con MYSQLi de forma exitosa.<br/>";
    echo "Informacion del servidor: " . $oConexionMYSQLi->server_info . "<br/>"; // Muestra la informacion del servidor

    // Cerramos la conexion
    $oConexionMYSQLi->close();

} catch (mysqli_sql_exception $miExceptionMySQLi) { // Lanza la excepcion para errores en lugar de para advertencias
    echo 'Error: ' . $miExceptionMySQLi->getMessage() . '<br/>'; // Captura el error
    echo 'Codigo de error: ' . $miExceptionMySQLi->getCode() . '<br/>'; // Captura el codigo de error
}

echo "<hr>";

try {
    // Intentamos la conexion con un usuario incorrecto para forzar la excepción
    $oConexionPDO = new PDO(HOST, "usuarioIncorrecto", PASS);

    // Como la conexion va a fallar, nunca muestra este mensaje
    echo "Conectado a MariaDB con PDO de forma exitosa.<br/>";

} catch (PDOException $oExceptionPDO) { // Lanza la excepcion 
    echo 'Error: ' . $oExceptionPDO->getMessage() . '<br/>'; // Captura el error
    echo 'Código de error: ' . $oExceptionPDO->getCode() . '<br/>'; // Captura el codifgo de error
}
?>

