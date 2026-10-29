<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 05 - Transacciones</title>
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

            /* TABLA */
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

            .texto-centro {
                text-align: center !important;
            }
            .texto-derecha {
                text-align: right !important;
            }

            .contador-registros {
                margin-top: 15px;
                color: #555;
                font-size: 15px;
            }

            /* FORMULARIO */
            .container form {
                display: inline-block;
                text-align: left;
                background: white;
                padding: 30px;
                border-radius: 8px;
                min-width: 320px;
                max-width: 450px;
                width: 100%;
            }

            .container label {
                font-weight: bold;
                display: block;
                text-align: left;
                margin-top: 12px;
                margin-bottom: 5px;
            }

            .container input[type="text"],
            .container input[type="date"] {
                margin-bottom: 5px;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                width: 100%;
                box-sizing: border-box;
                background-color: #fff9c4;
            }

            .container input[type="submit"] {
                margin-top: 20px;
                font-weight: bold;
                padding: 10px;
                width: 100%;
                background-color: #777bb4;
                color: white;
                border: none;
                border-radius: 4px;
            }

            .container input[type="submit"]:hover {
                background-color: #5c6096;
            }

            .error {
                color: red;
                display: block;
                font-size: 13px;
                margin-top: 3px;
                margin-bottom: 5px;
            }

            .mensaje-exito {
                background-color: #d4edda;
                color: #155724;
                padding: 12px;
                border-radius: 4px;
                border: 1px solid #c3e6cb;
                margin-bottom: 15px;
                max-width: 900px;
            }
        </style>
    </head>
    <body class="pagina-ajustada">
        <!-- Bloque: -->
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
                -- DD/MM/AAAA
                -- Ejercicio 05 (Tema 4) - Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.
                -->
                <a href='../indexProyectoTema4.php' class='enlace-volver'>⬅ Volver al inicio</a>
                <hr>

                <?php
                // Archivo con las variables de conexion a la base de datos
                require_once '../config/configDBPDO.php';

                require_once '../core/231018libreriaValidacion.php';

                try {
                    // Instanciamiento del objeto PDO para establecer la conexion con mariadb
                    $miDB = new PDO(HOST, USER, PASS);

                    // Array con las tres inserciones
                    $aDepartamentos = [
                        [
                            "codDepartamento" => "KMS",
                            "descripcionDepartamento" => "Departamento prueba 1",
                            "volumenDepartamento" => 10000
                        ],
                        [
                            "codDepartamento" => "AAA",
                            "descripcionDepartamento" => "Departamento prueba 2",
                            "volumenDepartamento" => 7658.4
                        ],
                        [
                            "codDepartamento" => "WWE",
                            "descripcionDepartamento" => "Departamento de wrestling",
                            "volumenDepartamento" => 70546.90
                        ]
                    ];

                    $miDB->beginTransaction(); // Deshabilito el modo autocommit
                    // Recorrido con un foreach insertando la sentencia sql.
                    foreach ($aDepartamentos as $departamento) {
                        $sqlInsert = 'INSERT into T02_Departamento VALUES ("' . $aDepartamentos["codDepartamento"] . '","' . $aDepartamentos["descripcionDepartamento"] . '", now(),"' . $aDepartamentos["volumenDepartamento"] . ',null)';
                        echo '<p>' . $sqlInsert . '</p>';
                        $miDB->exec($sqlInsert);
                    }

                    $miDB->commit(); // Confirma los cambios y los consolida

                    echo '<p>Transaccion completada.</p>';

                    $consulta = $miDB->query('SELECT * FROM T02_Departamento');

                    echo '<table class="tabla-departamentos" style="margin: 15px auto;">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="texto-centro">Código</th>';
                    echo '<th>Descripción</th>';
                    echo '<th class="texto-centro">Fecha de Alta</th>';
                    echo '<th class="texto-derecha">Volumen de Negocio</th>';
                    echo '<th class="texto-centro">Fecha de Baja</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    while ($oDepartamento = $consulta->fetchObject()) {
                        echo '<tr>';
                        echo '<td class="texto-centro"><b>' . $oDepartamento->T02_CodDepartamento . '</b></td>';
                        echo '<td>' . $oDepartamento->T02_DescDepartamento . '</td>';

                        // Formateo de la fecha de alta a formato español (d/m/Y)
                        $fechaCreacionDepartamento = new DateTime($oDepartamento->T02_FechaCreacionDepartamento);
                        echo '<td class="texto-centro">' . $fechaCreacionDepartamento->format('d/m/Y') . '</td>';

                        // Formateo del numero a moneda española
                        echo '<td class="texto-derecha">' . number_format($oDepartamento->T02_VolumenDeNegocio, 2, ',', '.') . ' €</td>';

                        // Comprobacion en la fecha de baja
                        if (is_null($oDepartamento->T02_FechaBajaDepartamento)) {
                            echo '<td class="texto-centro">-</td>';
                        } else {
                            $fechaBajaDepartamento = new DateTime($oDepartamento->T02_FechaBajaDepartamento);
                            echo '<td class="texto-centro">' . $fechaBajaDepartamento->format('d/m/Y') . '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } catch (PDOException $miExcepcionPDO) { // Lanza la Exception PDOException cuando ocurre un error.
                    // Revierte o deshace los cambios
                    $miDB->rollBack();

                    echo '<p>Transaccion completada.</p>';

                    // Captura el codigo de error y lo imprime en un mensaje.
                    echo "Código del error: " . $miExcepcionPDO->getCode() . "<br/>";
                    echo "Mensaje de error: " . $miExcepcionPDO->getMessage() . "<br/><hr>";
                } finally {
                    // Cierra la conexion con la base de datos
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