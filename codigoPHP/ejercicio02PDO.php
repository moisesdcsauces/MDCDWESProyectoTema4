<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 02 - Mostrar Departamento</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Inter:wght@400;500;600;700;800&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../webroot/css/styles.css">
        <link rel="stylesheet" href="../webroot/css/estilos.css">
        <style>
            /* sin selector "body": lo comparten la cabecera y el pie del sitio (fuente y color: .container) */

            .enlace-volver {
                color: #474a8a;
                font-weight: bold;
                text-decoration: none;
            }

            h2 {
                color: #777bb4;
                margin-top: 20px;
                margin-bottom: 15px;
            }

            .tabla-departamentos {
                width: 100%;
                max-width: 900px;
                border-collapse: collapse;
                margin-top: 15px;
                background-color: #ffffff;
                border-radius: 8px;
                overflow: hidden;
            }

            .tabla-departamentos th {
                background-color: #777bb4;
                color: #ffffff;
                padding: 12px 15px;
                font-size: 14px;
                font-weight: bold;
                text-align: left;
            }

            .tabla-departamentos td {
                padding: 10px 15px;
                border-bottom: 1px solid #e0e0e0;
                font-size: 14px;
            }

            .tabla-departamentos tr:nth-child(even) {
                background-color: #f8f9fc;
            }

            .tabla-departamentos tr:hover {
                background-color: #eef0f8;
            }

            .texto-centro { text-align: center !important; }
            .texto-derecha { text-align: right !important; }

            .contador-registros {
                margin-top: 15px;
                color: #555;
                font-size: 15px;
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
        <!--
        -- Moisés Alberto Dominguez Cruz
        -- 19/10/2026
        -- Ejercicio 02 (Tema 4) - Mostrar el contenido de la tabla Departamento y el número de registros.
        -->
        <a href='../indexProyectoTema4.php' class='enlace-volver'>⬅ Volver al inicio</a>
        <hr>

        <?php
        // Archivo con las variables de conexion a la base de datos
        require_once '../config/configDBPDO.php';

        try {
            // Instanciamiento del objeto PDO para establecer la conexion con mariadb
            $miDB = new PDO(HOST, USER, PASS);

            echo '<h2>CONSULTAS</h2>';

            // Consulta sql directa para obtener los campos de la tabla
            $consulta = $miDB->query('SELECT * FROM T02_Departamento');

            // tabla con sus encabezados
            echo '<table class="tabla-departamentos">';
            echo '<thead>';
            echo '<tr>';
            echo '<th class="texto-centro">Código</th>';
            echo '<th>Descripción</th>';
            echo '<th class="texto-centro">Fecha Creación</th>';
            echo '<th class="texto-derecha">Volumen de Negocio</th>';
            echo '<th class="texto-centro">Fecha Baja</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Recorre el conjunto de resultados fila por fila convirtiendo cada registro en un objeto
            while ($registro = $consulta->fetchObject()) {
                echo '<tr>';
                echo '<td class="texto-centro"><b>' . $registro->T02_CodDepartamento . '</b></td>';
                echo '<td>' . $registro->T02_DescDepartamento . '</td>';

                // Instancia un objeto DateTime a partir del valor de la base de datos y le aplica formato español (d/m/Y)
                $oFechaCreacionDepartamento = new DateTime($registro->T02_FechaCreacionDepartamento);
                echo '<td class="texto-centro">' . $oFechaCreacionDepartamento->format('d/m/Y') . '</td>';
                
                // Formatea el float con 2 decimales, coma decimal y punto de miles añadiendo el simbolo €
                echo '<td class="texto-derecha">' . number_format($registro->T02_VolumenDeNegocio, 2, ',', '.') . ' €</td>';
                
                // si el campo FechaBajaDepartamento es nulo en la base de datos
                if (is_null($registro->T02_FechaBajaDepartamento)) {
                    echo '<td class="texto-centro">-</td>';
                } else {
                    // Si contiene una fecha, la procesa como DateTime y la formatea a d/m/Y
                    $oFechaBajaDepartamento = new DateTime($registro->T02_FechaBajaDepartamento);
                    echo '<td class="texto-centro">' . $oFechaBajaDepartamento->format('d/m/Y') . '</td>';
                }
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Muestra el total de filas devueltas por la consulta mediante el metodo rowCount()
            echo '<h3 class="contador-registros">Número de registros: <b>' . $consulta->rowCount() . '</b></h3>';

        } catch (PDOException $miExcepcionPDO) { // Lanza la Exception PDOException cuando ocurre un error.
            // Captura el codigo de error y lo imprime en un mensaje.  
            echo "Código del error: " . $miExcepcionPDO->getCode() . "<br/>";
            echo "Mensaje de error: " . $miExcepcionPDO->getMessage() . "<br/><hr>";
        } finally {
            unset($miDB);
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