<?php
$archivo = '../config/configDBMYSQLi.php';

if ($archivo && file_exists($archivo)) {
    echo "<h2>Viendo el codigo de: " . htmlspecialchars($archivo) . "</h2>";
    echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a><hr>";
    
    // funcion nativa de PHP, lee el archivo y lo imprime con colores.
    highlight_file($archivo);
} else {
    echo "<h2>Error: El archivo no existe.</h2>";
    echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a>";
}
?>

<?php
$archivo = '../config/configDBMYSQLiCasa.php';

if ($archivo && file_exists($archivo)) {
    echo "<h2>Viendo el codigo de: " . htmlspecialchars($archivo) . "</h2>";
    
    // funcion nativa de PHP, lee el archivo y lo imprime con colores.
    highlight_file($archivo);
} else {
    echo "<h2>Error: El archivo no existe.</h2>";
    echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a>";
}
?>
