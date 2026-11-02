<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 07 - Exportar Departamentos a XML</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Inter:wght@400;500;600;700;800&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../webroot/css/styles.css">
        <link rel="stylesheet" href="../webroot/css/estilos.css">

        <style>
            .enlace-volver {
                color: #474a8a;
                font-weight: bold;
                text-decoration: none;
            }

            .container h2,
            .container h3 {
                color: #777bb4;
                margin-top: 20px;
                margin-bottom: 15px;
            }

            .container form {
                display: block;
                margin: 0 auto;
                text-align: center;
                background: white;
                padding: 30px;
                border-radius: 8px;
                min-width: 320px;
                max-width: 450px;
                width: 100%;
            }

            .container button[type="submit"] {
                margin-top: 10px;
                font-weight: bold;
                padding: 12px;
                width: 100%;
                background-color: #777bb4;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 15px;
            }

            .container button[type="submit"]:hover {
                background-color: #5c6096;
            }

            .mensaje-exito {
                background-color: #d4edda;
                color: #155724;
                padding: 12px;
                border-radius: 4px;
                border: 1px solid #c3e6cb;
                margin-top: 20px;
                margin-bottom: 15px;
                max-width: 900px;
                text-align: center;
            }

            .error {
                background-color: #f8d7da;
                color: #721c24;
                padding: 12px;
                border-radius: 4px;
                border: 1px solid #f5c6cb;
                margin-top: 20px;
                text-align: center;
            }
        </style>
    </head>
    <body class="pagina-ajustada">
        <header id="site-header" class="cabecera">
            <div class="cabecera__contenedor">
                <img class="monograma" src="../../webroot/images/cruz.png" alt="">
                <h1 class="titulo-header">TEMA 4: Técnicas de acceso a datos en PHP</h1>
                <img class="monograma" src="../../webroot/images/cruz.png" alt="">
            </div>
        </header>

        <main>
            <section>
                <div class="container">
                    <!--
                    -- Moisés Alberto Dominguez Cruz
                    -- 28/10/2026
                    -- Ejercicio 07 (Tema 4) - Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR).
                    -- QR: Si no se tiene la carpeta tmp creada, al crearla mira los permisos de esa carpeta.
                    -->
                    <a href='../indexProyectoTema4.php' class='enlace-volver'>⬅ Volver al inicio</a>
                    <hr>

                    <div class="buscador">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <h2 style="margin-top: 0;">Copia de Seguridad (XML)</h2>
                            <p style="margin-bottom: 20px; color: #555;">Exportar todos los departamentos a un archivo XML.</p>
                            <button type="submit" name="exportar">Generar y Exportar departamentos.xml</button>
                        </form>  
                    </div>

                    <?php
                    if (isset($_REQUEST['exportar'])) {

                        // Archivo con las variables de conexion a la base de datos
                        require_once '../config/configDBPDO.php';

                        try {
                            // Instanciacion del objeto PDO para conectar a MariaDB
                            $miDB = new PDO(HOST, USER, PASS);

                            // Consulta SQL para obtener código y descripción de todos los departamentos
                            $sql = 'SELECT T02_CodDepartamento, T02_DescDepartamento FROM T02_Departamento';
                            $consultaPreparada = $miDB->prepare($sql);
                            $consultaPreparada->execute();

                            // Si hay registros, comenzamos a generar el XML
                            if ($consultaPreparada->rowCount() > 0) {

                                // Instanciamos el objeto DOMDocument (versión 1.0, codificación UTF-8)
                                $documentoXML = new DOMDocument('1.0', 'UTF-8');
                                // Formatear la salida para que el XML tenga saltos de línea (sea legible)
                                $documentoXML->formatOutput = true;

                                // Creamos el elemento raiz departamentos y lo añadimos al documento
                                $raiz = $documentoXML->createElement('departamentos');
                                $documentoXML->appendChild($raiz);

                                // Recorremos los registros de la base de datos
                                while ($oDepartamento = $consultaPreparada->fetchObject()) {

                                    // Creamos el departamento para cada registro
                                    $sDepartamento = $documentoXML->createElement('departamento');

                                    // Creamos el codigo, añadimos el texto y lo colgamos de departamento
                                    $sCodigo = $documentoXML->createElement('codigo');
                                    $sCodigo->appendChild($documentoXML->createTextNode($oDepartamento->T02_CodDepartamento));
                                    $sDepartamento->appendChild($sCodigo);

                                    // Creamos la descripcion, añadimos el texto y lo colgamos de departamento
                                    $sDescripcion = $documentoXML->createElement('descripcion');
                                    $sDescripcion->appendChild($documentoXML->createTextNode($oDepartamento->T02_DescDepartamento));
                                    $sDepartamento->appendChild($sDescripcion);

                                    // Colgamos el departamento completo de la raiz departamentos
                                    $raiz->appendChild($sDepartamento);
                                }

                                // Preparamos el directorio /tmp/
                                $directorioTMP = dirname(__DIR__) . '/tmp/';

                                // Ruta completa absoluta para que el servidor guarde el archivo
                                $rutaFicheroGuardar = $directorioTMP . 'departamentos.xml';

                                // Guardamos el archivo XML generado en el servidor
                                $documentoXML->save($rutaFicheroGuardar);

                                // Ruta relativa que el navegador necesita para encontrar el archivo desde 'codigoPHP'
                                $rutaEnlaceWeb = '../tmp/departamentos.xml';

                                // Mostramos el mensaje y el enlace web
                                echo "<div class='mensaje-exito'>";
                                echo "<h3>Exportacion completada con exito.</h3>";
                                echo "<p>El archivo se ha guardado en: <b>{$rutaFicheroGuardar}</b></p>";
                                echo "<a href='{$rutaEnlaceWeb}' target='_blank' style='color: #155724; font-weight: bold; text-decoration: underline;'>Ver archivo XML</a>";
                                echo "</div>";
                                
                            } else {
                                echo "<div class='error'>No hay departamentos en la base de datos para exportar.</div>";
                            }
                        } catch (PDOException $miExceptionPDO) {
                            // Captura errores de PDO
                            echo "<div class='error'>";
                            echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
                            echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                            echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                            echo "</div>";
                        } finally {
                            // Cierra la conexión a la base de datos
                            unset($miDB);
                        }
                    }
                    ?>
                </div>
            </section>
        </main>

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