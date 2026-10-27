<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 01 MySQLi - Conexión a la base de datos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Inter:wght@400;500;600;700;800&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../webroot/css/styles.css">
  <link rel="stylesheet" href="../webroot/css/estilos.css">
</head>
<body class="pagina-ajustada">
  <!-- Bloque: Cabecera -->
  <header id="site-header" class="cabecera">
    <div class="cabecera__contenedor">
      <img class="monograma" src="../../webroot/images/cruz.png" alt="">
      <h1 class="titulo-header">TEMA 4: Técnicas de acceso a datos en PHP</h1>
      <img class="monograma" src="../../webroot/images/cruz.png" alt="">
    </div>
  </header>

  <main>
  <div class="container">
<?php
/*
 * Moisés Alberto Dominguez Cruz
 * 19/10/2026
 * Ejercicio 01 (Tema 4) - Conexión a la base de datos MariaDB mediante MYSQLi y PDO con control de excepciones.
 */

echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a><hr>";

// Importacion del archivo de configuracion que contiene las constantes de conexion
require_once '../config/configDBMYSQLi.php';

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
    // Establecemos la conexion usando las constantes de configDB00.php
    $oConexionMYSQLi = new mysqli(SERVER, "USUARIOINCORRECTO", PASS, DBNAME);

    echo "Conectado a MariaDB con MYSQLi de forma exitosa.<br/>";
    echo "Informacion del servidor: " . $oConexionMYSQLi->server_info . "<br/>"; // Muestra la informacion del servidor

    // Cerramos la conexion
    $oConexionMYSQLi->close();

} catch (mysqli_sql_exception $miExceptionMySQLi) { // Lanza la excepcion para errores en lugar de para advertencias
    echo 'Error: ' . $miExceptionMySQLi->getMessage() . '<br/>'; // Captura el error
    echo 'Codigo de error: ' . $miExceptionMySQLi->getCode() . '<br/>'; // Captura el codigo de error
}
?>
  </div>
  </main>

  <!-- Bloque: Pie -->
  <footer class="pie">
    <div class="pie__redes">
      <a class="pie__red" href="../indexProyectoTema4.php" title="Ir al índice del Tema 4" aria-label="Ir al índice del Tema 4">
        <img src="../../webroot/images/icons/casa.png" alt="">
      </a>
      <a class="pie__red" href="https://github.com/moisesdcsauces/MDCDWESProyectoTema4" target="_blank" rel="noopener" aria-label="GitHub">
        <img src="../../webroot/images/icons/github.png" alt="">
      </a>
      <a class="pie__red" href="https://www.linkedin.com/in/mois%C3%A9s-alberto-dom%C3%ADnguez-cruz/" target="_blank" rel="noopener" aria-label="LinkedIn">
        <img src="../../webroot/images/icons/linkedin.png" alt="">
      </a>
    </div>
      <p class="pie__texto">© <a class="titulo-enlace" href="../../index.html"> Moisés Alberto Domínguez Cruz</a> - IES Los Sauces<span id="year"></span></p>
  </footer>

  <script src="../../webroot/js/main.js" defer></script>
</body>
</html>

