<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 01 PDO - Conexión a la base de datos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Inter:wght@400;500;600;700;800&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../webroot/css/styles.css">
  <link rel="stylesheet" href="../webroot/css/estilos.css">
  
  <style>
      .container {
          max-width: 900px;
          margin: 40px auto;
          background-color: #ffffff;
          padding: 30px;
          border-radius: 8px;
      }

      h3 {
          color: #777bb4;
          text-align: center;
          margin-bottom: 25px;
          font-family: 'Inter', sans-serif;
      }

      .tabla-atributos {
          width: 100%;
          border-collapse: collapse;
          font-family: 'Inter', sans-serif;
      }

      .tabla-atributos th {
          background-color: #777bb4;
          color: white;
          padding: 12px 15px;
          text-align: left;
          font-weight: 600;
          border-radius: 4px 4px 0 0;
      }

      .tabla-atributos td {
          padding: 12px 15px;
          border-bottom: 1px solid #e0e0e0;
          color: #333;
      }

      .tabla-atributos tr:nth-child(even) {
          background-color: #f8f9fc;
      }

      .tabla-atributos tr:hover {
          background-color: #eef0f8;
      }

      .col-atributo {
          font-weight: bold;
          color: #474a8a;
          width: 40%;
      }

      .texto-error {
          color: #dc3545;
          font-style: italic;
          font-size: 0.9em;
      }

      .mensaje-error-global {
          background-color: #f8d7da;
          color: #721c24;
          padding: 20px;
          border-radius: 8px;
          border-left: 5px solid #dc3545;
      }
  </style>
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

// Inicio del codigo PHP que el servidor debe procesar
require_once '../config/configDBPDO.php';

$atributosConexion = [
    "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
    "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION", "TIMEOUT"
];

echo "<h3>Conexión a la base de datos establecida</h3>";

try {
    // Instancia la conexion recogiendo el host, usuario y la contraseña.
    $conexionPDO = new PDO(HOST, USER, PASS);
    
    // Inicio de la tabla HTML para presentar los datos ordenados
    echo '<table class="tabla-atributos">';
    echo '<thead><tr><th>Atributo PDO</th><th>Valor del atributo</th></tr></thead>';
    echo '<tbody>';
    
    // Recorrido de los atributos
    foreach ($atributosConexion as $atributo){
        echo '<tr>';
        echo '<td class="col-atributo">PDO::ATTR_' . $atributo . '</td>';
        
        try {
            $valor = $conexionPDO->getAttribute(constant("PDO::ATTR_$atributo"));
            
            if ($valor === true) $valor = "TRUE";
            if ($valor === false) $valor = "FALSE";
            
            echo '<td>' . $valor . '</td>';
            
        } catch(PDOException $exception) { // Lanza la Exception PDOException cuando ocurre un error.
            // Captura e imprime en un mensaje formateado como error dentro de la tabla.
            echo '<td class="texto-error">No soportado por el driver (' . $exception->getMessage() . ')</td>';
        }
        
        echo '</tr>';
    }
    
    echo '</tbody></table>';

} catch (PDOException $exception) { // Lanza la Exception PDOException cuando ocurre un error.
    // Captura el codigo de error y lo imprime en un bloque de error estructurado.
    echo "<div class='mensaje-error-global'>";
    echo "<strong>¡Error de Conexión!</strong><br><br>";
    echo "Código del error: <b>" . $exception->getCode() . "</b><br/>";
    echo "Mensaje de error: <b>" . $exception->getMessage() . "</b>";
    echo "</div>";
} finally {
    unset($conexionPDO);
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