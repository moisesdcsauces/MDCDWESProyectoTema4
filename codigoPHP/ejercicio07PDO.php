<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 07 - Importar Departamentos desde XML</title>
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
                    -- Ejercicio 07 (Tema 4) - Página web que toma datos de un fichero xml y los añade a la tabla Departamento (IMPORTAR).
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
                        $rutaFicheroXML = $_SERVER["DOCUMENT_ROOT"] . '/MDCDWESProyectoTema4/tmp/departamentos.xml';

                        // Comprobamos si el archivo existe antes de intentar hacer nada
                        if (file_exists($rutaFicheroXML)) {

                            require_once '../config/configDBPDO.php';

                            try {
                                // Instanciacion del objeto PDO
                                $miDB = new PDO(HOST, USER, PASS);

                                // Instanciamos DOMDocument y cargamos el archivo XML
                                $documentoXML = new DOMDocument();
                                $documentoXML->load($rutaFicheroXML);

                                // Obtenemos una lista con todos los elementos departamento
                                $listaDepartamentosXML = $documentoXML->getElementsByTagName('departamento');

                                // Verificamos que el XML no este vacío
                                if ($listaDepartamentosXML->length > 0) {

                                    // Leemos todos los departamentos del XML en un array
                                    $aDepartamentosImportar = [];
                                    foreach ($listaDepartamentosXML as $departamento) {
                                        $nullFechaBaja = $departamento->getElementsByTagName('FechaBajaDepartamento')->item(0);

                                        $aDepartamentosImportar[] = [
                                            ':CodDepartamento' => $departamento->getElementsByTagName('CodDepartamento')->item(0)->nodeValue,
                                            ':DescDepartamento' => $departamento->getElementsByTagName('DescDepartamento')->item(0)->nodeValue,
                                            ':FechaCreacionDepartamento' => $departamento->getElementsByTagName('FechaCreacionDepartamento')->item(0)->nodeValue,
                                            ':VolumenDeNegocio' => $departamento->getElementsByTagName('VolumenDeNegocio')->item(0)->nodeValue,
                                            ':FechaBajaDepartamento' => ($nullFechaBaja && trim($nullFechaBaja->nodeValue) !== '') ? $nullFechaBaja->nodeValue : null
                                        ];
                                    }

                                    // Validamos antes de insertar: ningun codigo puede existir ya en la tabla
                                    //    ni estar repetido dentro del propio archivo (es la clave primaria)
                                    $consultaCodigo = $miDB->prepare('SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = :codigo');
                                    $aCodigosRepetidos = [];
                                    $aCodigosLeidos = [];
                                    foreach ($aDepartamentosImportar as $aDepartamento) {
                                        $codigo = $aDepartamento[':CodDepartamento'];
                                        $consultaCodigo->execute([':codigo' => $codigo]);

                                        if ($consultaCodigo->fetch(PDO::FETCH_ASSOC) || in_array($codigo, $aCodigosLeidos)) {
                                            $aCodigosRepetidos[] = $codigo;
                                        }
                                        $aCodigosLeidos[] = $codigo;
                                    }

                                    // Solo si no hay ningun codigo repetido se hace la transaccion con los INSERT
                                    if (empty($aCodigosRepetidos)) {
                                        // Iniciamos la transaccion para asegurar que o se importan todos, o ninguno
                                        $miDB->beginTransaction();

                                        // Preparamos la consulta de inserción con parámetros con nombre
                                        $sqlInsert = 'INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES (:CodDepartamento, :DescDepartamento, :FechaCreacionDepartamento, :VolumenDeNegocio, :FechaBajaDepartamento)';
                                        $sentenciaPreparada = $miDB->prepare($sqlInsert);

                                        // Ejecutamos la consulta preparada con cada departamento leido
                                        foreach ($aDepartamentosImportar as $aDepartamento) {
                                            $sentenciaPreparada->execute($aDepartamento);
                                        }

                                        // Si el bucle termina sin errores, confirmamos la transacción
                                        $miDB->commit();

                                        echo "<div class='mensaje-exito'>";
                                        echo "<h3>Importación completada con éxito.</h3>";
                                        echo "<p>Se han importado <b>" . count($aDepartamentosImportar) . "</b> departamentos desde el archivo XML a la base de datos.</p>";
                                        echo "</div>";
                                    } else {
                                        echo "<div class='error'>";
                                        echo "<h3 style='margin-top:0;'>No se ha importado nada.</h3>";
                                        echo "<p>Estos códigos ya existen en la tabla o están repetidos en el archivo: <b>" . implode(', ', $aCodigosRepetidos) . "</b></p>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<div class='error'>El archivo XML esta vacio o no tiene el formato correcto.</div>";
                                }
                            } catch (PDOException $miExceptionPDO) {
                                // Si ocurre un error, deshacemos todos los cambios
                                // Solo se deshace si hay una transaccion abierta: si fallo la conexion $miDB no existe
                                if (isset($miDB) && $miDB->inTransaction()) {
                                    $miDB->rollBack();
                                }

                                echo "<div class='error'>";
                                echo "<h3 style='margin-top:0;'>Error al importar en la base de datos.</h3>";
                                echo "<p>La transaccion ha sido cancelada. Ningun registro ha sido importado.</p>";
                                echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                                echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
                                echo "</div>";
                            } finally {
                                unset($miDB);
                            }
                        } else {
                            // Si no existe el archivo se avisa en vez de dejar la pagina en blanco
                            echo "<div class='error'>No se ha encontrado el archivo <b>departamentos.xml</b> en la carpeta tmp. Exporta primero los departamentos con el ejercicio 08.</div>";
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