<?php
/*
 * Moisés Alberto Dominguez Cruz
 * 19/10/2026
 * Ejercicio 01 (Tema 4) - Conexión a la base de datos MariaDB mediante MYSQLi y PDO con control de excepciones.
 */

echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a><hr>";

// Inicio del codigo PHP que el servidor debe procesar
require_once '../config/configDB00.php';

$atributosConexion = ["AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
    "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION", "TIMEOUT"
];

echo "<h3>Conexion a la base de datos</h3>";

try {
    // Instancia la conexion recogiendo el host, usuario y la contraseña.
    $conexionPDO = new PDO(HOST, USER, PASS);
    
    // Recorrido de los atributos
    foreach ($atributosConexion as $atributo){
        echo "PDO: ATTR_$atributo: ";
        try{
            echo $conexionPDO->getAttribute(constant("PDO::ATTR_$atributo" ))."<br/>";
        }catch(PDOException $exception){ // Lanza la Exception PDOException cuando ocurre un error.
            // Captura e imprime en un mensaje.
            echo "Mensaje de error: ".$exception->getMessage()."<br/>";
        }
    }
} catch (PDOException $exception) { // Lanza la Exception PDOException cuando ocurre un error.
    // Captura el codigo de error y lo imprime en un mensaje.   
    echo "Codigo del error: " . $exception->getCode() . "<br/>";
    echo "Mensaje de error: " . $exception->getMessage() . "<br/><hr>";
} finally {
    unset($conexionPDO);
}

try {
    echo "<h3>Conexion incorrecta</h3>";
    // Instancia la conexion incorrecta.
    $conexion = new PDO("mysql:host=10.199.9.184;dbname=DBMDCDWESProyectoTema4;", "usuarioIncorrecto","paso");

} catch (PDOException $exception) {
    echo "Codigo del error: " . $exception->getCode() . "<br/>";
    echo "Mensaje de error: ". $exception->getMessage()."<br/>";
}
?>

