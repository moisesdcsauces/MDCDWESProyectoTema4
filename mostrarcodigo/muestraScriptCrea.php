<?php
$archivo = '../scriptsDB/CreaBDMDCProyectoTema4.sql';

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

