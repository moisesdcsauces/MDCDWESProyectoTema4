<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 04 - Mantenimiento de departamentos</title>
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

            /*TABLA*/
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
            
            .buscador{
                text-align: center;
            }

            /*FORMULARIO*/
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
            
            .container label.titulo-busqueda {
                font-weight: bold;
                display: block;
                text-align: center;
                color: #777bb4;
                font-size: 18px;
                margin-top: 5px;
                margin-bottom: 15px;
            }
          
            .container label {
                font-weight: bold;
                display: block;
                text-align: left;
                margin-top: 12px;
                margin-bottom: 5px;
            }
            
            .container input[type="text"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-bottom: 0;
            }

            .container input[type="submit"],
            .container button[type="submit"] {
                margin-top: 20px;
                font-weight: bold;
                padding: 10px;
                width: 100%;
                color: white;
                background-color: #777bb4;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .container input[type="submit"]:hover,
            .container button[type="submit"]:hover {
                background-color: #5c6096;
            }

            .error {
                color: red;
                display: block;
                font-size: 13px;
                min-height: 16px;
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
        <!-- Bloque: Cabecera (no la cambies, es igual en todo el proyecto) -->
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
                -- 28/10/2026
                -- Ejercicio 04 (Tema 4) - Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos)
                -->
                <a href='../indexProyectoTema4.php' class='enlace-volver'>⬅ Volver al inicio</a>
                <hr>

                <?php
                // Archivo con las variables de conexion a la base de datos
                require_once '../config/configDBPDOCasa.php';

                // Libreria de validacion de formularios
                require_once '../core/231018libreriaValidacion.php';

                // Flag para controlar si se debe ejecutar la consulta
                $entradaOK = true;

                // Array para almacenar mensajes de error
                $aError = [
                    'departamentoBus' => "",
                ];

                // Array para almacenar las respuestas procesadas
                $aRespuesta = [
                    'departamentoBus' => "",
                ];

                // Comprueba si el formulario ha sido enviado mediante el boton 'buscar'
                if (isset($_REQUEST["buscar"])) {
                    // Valida el departamento que estamos buscando (maximo 50 caracteres). Opcional -> 0
                    $aError["departamentoBus"] = validacionFormularios::comprobarAlfabetico($_REQUEST["departamentoBus"], 50, 1, 0);
                    
                    // Si la validación devuelve algún error, bloqueamos la entrada
                    if ($aError["departamentoBus"] != null) {
                        $entradaOK = false;
                    }
                }
                ?>

                <div class="buscador"">
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                        <label for="departamentoBus" class="titulo-busqueda">Mantenimiento de Departamentos</label><br>

                        <input type="text" name="departamentoBus" id="departamentoBus" placeholder="Descripción (vacío busca todos)" value="<?php echo isset($_REQUEST['departamentoBus']) ? htmlspecialchars($_REQUEST['departamentoBus']) : ''; ?>">
                        <span class="error"><?php echo $aError['departamentoBus']; ?></span>

                        <button type="submit" name="buscar">Buscar</button>
                    </form>  
                </div>

                <?php
                // Solo nos conectamos a la BD si la validación ha sido correcta
                if ($entradaOK) {
                    
                    $aRespuesta["departamentoBus"] = isset($_REQUEST['departamentoBus']) ? $_REQUEST["departamentoBus"] : "";

                    try {
                        // Instanciacion del objeto PDO para conectar a MariaDB usando las constantes del archivo de configuracion
                        $miDB = new PDO(HOST, USER, PASS);
                        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Construccion de la sentencia SQL concatenando como pide el profesor                 
                        $listaDepartamentos = $miDB->query("select * from T02_Departamento where T02_DescDepartamento like '%" . $aRespuesta['departamentoBus'] . "%'");
                        
                        // Comprobamos que existan registros para esa búsqueda antes de pintar la tabla
                        if ($listaDepartamentos->rowCount() > 0) {
                            
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
                            
                            while ($oDepartamento = $listaDepartamentos->fetchObject()) {
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
                        }                       
                    } catch (PDOException $miExcepcionPDO) { 
                        // Lanza la Exception PDOException cuando ocurre un error.
                        echo "<div class='error' style='text-align: center; margin-top: 20px;'>";
                        echo "Código de error: " . $miExcepcionPDO->getCode() . "<br/>";
                        echo "Mensaje de error: " . $miExcepcionPDO->getMessage();
                        echo "</div>";
                    } finally {
                        // fin de la conexion con la base de datos
                        unset($miDB);
                    }
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