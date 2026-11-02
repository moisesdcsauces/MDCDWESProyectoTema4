<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 08 - Importar Departamentos desde XML</title>
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
                    -- 02/11/2026
                    -- Ejercicio 07 (Tema 4) - Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento (IMPORTAR).
                    -->
                    <a href='../indexProyectoTema4.php' class='enlace-volver'>⬅ Volver al inicio</a>
                    <hr>

                    <div class="buscador">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <h2 style="margin-top: 0;">Restaurar Copia (XML)</h2>
                            <p style="margin-bottom: 20px; color: #555;">Importar departamentos desde el archivo <b>departamentos.xml</b> hacia la base de datos.</p>
                            <button type="submit" name="importar">Importar departamentos.xml</button>
                        </form>  
                    </div>

                    <?php
                    if (isset($_REQUEST['importar'])) {

                        // Calculamos la ruta del archivo XML en la carpeta tmp
                        $directorioTMP = dirname(__DIR__) . '/tmp/';
                        $rutaFicheroXML = $directorioTMP . 'departamentos.xml';

                        // Comprobamos si el archivo existe antes de intentar hacer nada
                        if (file_exists($rutaFicheroXML)) {
                            
                            require_once '../config/configDBPDOCasa.php';

                            try {
                                // Instanciacion del objeto PDO
                                $miDB = new PDO(HOST, USER, PASS);

                                // Instanciamos DOMDocument y cargamos el archivo XML
                                $documentoXML = new DOMDocument();
                                
                                // Carga el archivo XML desde un fichero: https://www.php.net/manual/es/domdocument.load.php
                                $documentoXML->load($rutaFicheroXML);

                                // Obtenemos una lista con todos los elementos departamento
                                // Busca elementos por su nombre de etiqueta: https://www.php.net/manual/es/domdocument.getelementsbytagname.php
                                $listaDepartamentosXML = $documentoXML->getElementsByTagName('departamento');

                                // Verificamos que el XML no este vacio
                                if ($listaDepartamentosXML->length > 0) {
                                    
                                    // Iniciamos la transaccion para asegurar que o se importan todos, o ninguno
                                    $miDB->beginTransaction();

                                    // Preparamos la consulta de insercion
                                    $sqlInsert = 'INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES (?, ?, NOW(), NULL, NULL)';
                                    $sentenciaPreparada = $miDB->prepare($sqlInsert);

                                    $registrosImportados = 0;

                                    // Recorremos cada departamento del XML
                                    foreach ($listaDepartamentosXML as $departamento) {
                                        
                                        // Extraemos los valores leyendo los hijos (<codigo> y <descripcion>)
                                        // Uso de getElementsByTagName: https://www.php.net/manual/es/domdocument.getelementsbytagname.php
                                        $codigo = $departamento->getElementsByTagName('codigo')->item(0)->nodeValue;
                                        $descripcion = $departamento->getElementsByTagName('descripcion')->item(0)->nodeValue;

                                        // Ejecutamos la consulta preparada con los datos extraidos
                                        $sentenciaPreparada->execute([$codigo, $descripcion]);
                                        
                                        $registrosImportados++;
                                    }

                                    // Si el bucle termina sin errores, confirmamos la transacción
                                    $miDB->commit();

                                    echo "<div class='mensaje-exito'>";
                                    echo "<h3>Importación completada con éxito.</h3>";
                                    echo "<p>Se han importado <b>{$registrosImportados}</b> departamentos desde el archivo XML a la base de datos.</p>";
                                    echo "</div>";

                                } else {
                                    echo "<div class='error'>El archivo XML esta vacio o no tiene el formato correcto.</div>";
                                }
                            } catch (PDOException $miExceptionPDO) {
                                // Si ocurre un error, deshacemos todos los cambios
                                $miDB->rollBack();
                                
                                echo "<div class='error'>";
                                echo "<h3 style='margin-top:0;'>Error al importar en la base de datos.</h3>";
                                echo "<p>La transaccion ha sido cancelada. Ningun registro ha sido importado.</p>";
                                echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                                echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                                echo "</div>";
                            }finally {
                                unset($miDB);
                            }
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