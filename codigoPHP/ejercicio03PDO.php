<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Declaración de codificación de caracteres y vista adaptativa -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 03 PDO - Añadir Departamento</title>
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

            h2, h3 {
                color: #777bb4;
                margin-top: 20px;
                margin-bottom: 15px;
            }

            form {
                display: inline-block;
                text-align: left;
                background: white;
                padding: 30px;
                border-radius: 8px;
                min-width: 320px;
                max-width: 450px;
                width: 100%;
            }

            label {
                font-weight: bold;
                display: block;
                text-align: left;
                margin-top: 12px;
                margin-bottom: 5px;
            }

            /* Se reduce margin-bottom a 0 para ceder el espacio al span de error */
            input[type="text"],
            input[type="date"] {
                margin-bottom: 0px; 
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                width: 100%;
                box-sizing: border-box;
                background-color: #fff9c4;
            }

            input[type="submit"] {
                margin-top: 20px;
                font-weight: bold;
                padding: 10px;
                width: 100%;
                background-color: #777bb4;
                color: white;
                border: none;
                border-radius: 4px;
            }

            input[type="submit"]:hover {
                background-color: #5c6096;
            }

            /* min-height reserva un espacio fijo para que el formulario no salte */
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

            .tabla-departamentos {
                width: 100%;
                max-width: 900px;
                border-collapse: collapse;
                margin-top: 15px;
                background-color: #ffffff;
                border-radius: 8px;
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
        -- Ejercicio 03 (Tema 4) - Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.
        -->

        <a href='../indexProyectoTema4.php' class='enlace-volver'>⬅ Volver al inicio</a>
        <hr>

        <?php
        // Libreria de mrtodos estaticos para la validacion de formularios
        require_once '../core/231018libreriaValidacion.php';

        // Archivo de configuracion de conexión a la base de datos PDO
        require_once '../config/configDBPDO.php';

        // Variable flag indicadora del estado de la validacion
        $entradaOK = true;

        // Array para almacenar mensajes de error de cada campo
        $aError = [
            'codigoDep' => "",
            'descripcionDep' => "",
            'fechaCreacionDep' => "",
            'volumenNegocioDep' => ""
        ];

        // Array para almacenar las respuestas procesadas
        $aRespuesta = [
            'codigoDep' => "",
            'descripcionDep' => "",
            'fechaCreacionDep' => "",
            'volumenNegocioDep' => ""
        ];

        // Comprueba si el formulario ha sido enviado mediante el boton 'enviar'
        if (isset($_REQUEST["enviar"])) {
            // Valida el codigo de departamento (maximo 3 caracteres). Uso del metodo estatico comprobarAlfabetico
            $aError["codigoDep"] = validacionFormularios::comprobarAlfabetico($_REQUEST["codigoDep"], 3, 1, 1);

            // Valida la descripción del departamento (de 1 a 255 caracteres). Uso del metodo estatico comprobarAlfabetico
            $aError["descripcionDep"] = validacionFormularios::comprobarAlfabetico($_REQUEST["descripcionDep"], 255, 1, 1);

            // Valida la fecha de creacion entre el año 1900 y la fecha actual. Uso del metodo estatico validarFecha
            $aError["fechaCreacionDep"] = validacionFormularios::validarFecha($_REQUEST["fechaCreacionDep"], date("Y-m-d"), "1900-01-01", 1);

            // Valida el volumen de negocio en formato flotante monetario español (coma decimal). Uso del metodo estatico comprobarFloatMonetarioES
            $aError['volumenNegocioDep'] = validacionFormularios::comprobarFloatMonetarioES($_REQUEST["volumenNegocioDep"], PHP_FLOAT_MAX, 0, 1);

            // Comprueba globalmente si existe algun mensaje de error almacenado en el array
            foreach ($aError as $value) {
                if (!empty($value)) {
                    $entradaOK = false; // Si hay al menos un error, cambia el estado de validacion a falso
                }
            }
        } else {
            // Si el formulario no ha sido enviado, establece la bandera a falso
            $entradaOK = false;
        }

        if ($entradaOK) {
            // Recogida y preparación de los datos recibidos
            $aRespuesta["codigoDep"] = $_REQUEST["codigoDep"];
            $aRespuesta["descripcionDep"] = $_REQUEST["descripcionDep"];
            // Instanciacion del objeto DateTime
            $aRespuesta["fechaCreacionDep"] = new DateTime($_REQUEST["fechaCreacionDep"]);
            // Conversion del float con coma decimal a formato utilizable por PHP (punto decimal)
            $aRespuesta["volumenNegocioDep"] = floatval(str_replace(',', '.', $_REQUEST["volumenNegocioDep"]));

            try {
                // Instanciacion del objeto PDO para conectar a MariaDB usando las constantes del archivo de configuracion
                $miDB = new PDO(HOST, USER, PASS);

                // Asignacion de variables preparadas para la inserción
                $sCodigoDepInsert = $aRespuesta["codigoDep"];
                $sDescripcionDepInsert = $aRespuesta["descripcionDep"];
                $sFechaCreacionDepInsert = $aRespuesta["fechaCreacionDep"]->format("Y-m-d");
                $svolumenNegocioDepInsert = $aRespuesta["volumenNegocioDep"];

                // Construccion de la sentencia SQL para insertar el registro (codigo de juan)
                $sqlInsert = <<<sql
                INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio) VALUES (
                '$sCodigoDepInsert',
                '$sDescripcionDepInsert',
                '$sFechaCreacionDepInsert',
                $svolumenNegocioDepInsert)
            sql;

                // Ejecucion de la consulta de insercion devuelviendo el numero de filas (codigo de juan)
                $numRegistros = $miDB->exec($sqlInsert);

                echo "<div class='mensaje-exito'>Departamento insertado correctamente. Filas afectadas: <b>" . $numRegistros . "</b></div>";

                // Consulta para mostrar el estado actualizado de la tabla
                $consulta = $miDB->query("SELECT * FROM T02_Departamento");

                // tabla HTML para presentar todos los departamentos
                echo "<h3>DEPARTAMENTOS EN LA BASE DE DATOS</h3>";
                echo '<table class="tabla-departamentos">';
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

                // Bucle para recorrer los registros e imprimirlos fila por fila convirtiendo cada registro en un objeto
                while ($registro = $consulta->fetchObject()) {
                    echo "<tr>";
                    echo "<td class='texto-centro'><b>" . $registro->T02_CodDepartamento . "</b></td>";
                    echo "<td>" . $registro->T02_DescDepartamento . "</td>";

                    // Formateo de la fecha de alta a formato español (d/m/Y)
                    $oFechaAlta = new DateTime($registro->T02_FechaCreacionDepartamento);
                    echo "<td class='texto-centro'>" . $oFechaAlta->format('d/m/Y') . "</td>";

                    // Formateo del numero a moneda española
                    echo "<td class='texto-derecha'>" . number_format($registro->T02_VolumenDeNegocio, 2, ',', '.') . " €</td>";

                    // Comprobacion en la fecha de baja
                    if (is_null($registro->T02_FechaBajaDepartamento)) {
                        echo '<td class="texto-centro">-</td>';
                    } else {
                        $oFechaBaja = new DateTime($registro->T02_FechaBajaDepartamento);
                        echo '<td class="texto-centro">' . $oFechaBaja->format('d/m/Y') . '</td>';
                    }
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";

                // Muestra el total de filas devueltas por la consulta mediante el metodo rowCount()
                echo "<p class='contador-registros'>Número total de departamentos: <b>" . $consulta->rowCount() . "</b></p>";
            } catch (PDOException $miExcepcionPDO) { // Lanza la Exception PDOException cuando ocurre un error.
                // Captura el codigo de error y lo imprime en un mensaje.  
                echo "<div class='error'>Código de error: " . $miExcepcionPDO->getCode() . "<br/>Mensaje: " . $miExcepcionPDO->getMessage() . "</div>";
            } finally {
                // fin de la conexion con la base de datos
                unset($miDB);
            }

            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "' class='enlace-volver'>Añadir otro departamento</a></p>";
        } else {
            // Si el formulario no ha sido enviado o contiene errores, se vuelve a renderizar
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="formulario" method="post" novalidate>
                <h2>Añadir Departamento</h2>

                <!-- Campo Código -->
                <label for="codigoDep">Código:</label>
                <input type="text" name="codigoDep" id="codigoDep" value="<?php echo (!empty($_REQUEST['codigoDep']) && empty($aError['codigoDep'])) ? $_REQUEST['codigoDep'] : ''; ?>"/>
                <span class='error'><?php echo !empty($aError["codigoDep"]) ? $aError['codigoDep'] : ''; ?></span>

                <!-- Campo Descripción -->
                <label for="descripcionDep">Descripción:</label>
                <input type="text" name="descripcionDep" id="descripcionDep" value="<?php echo (!empty($_REQUEST['descripcionDep']) && empty($aError['descripcionDep'])) ? $_REQUEST['descripcionDep'] : ''; ?>"/>
                <span class='error'><?php echo !empty($aError["descripcionDep"]) ? $aError['descripcionDep'] : ''; ?></span>

                <!-- Campo Fecha de Alta -->
                <label for="fechaCreacionDep">Fecha de Alta:</label>
                <input type="date" name="fechaCreacionDep" id="fechaCreacionDep" value="<?php echo (!empty($_REQUEST['fechaCreacionDep']) && empty($aError['fechaCreacionDep'])) ? $_REQUEST['fechaCreacionDep'] : ''; ?>"/>
                <span class='error'><?php echo !empty($aError["fechaCreacionDep"]) ? $aError['fechaCreacionDep'] : ''; ?></span>

                <!-- Campo Volumen de Negocio -->
                <label for="volumenNegocioDep">Volumen de Negocio:</label>
                <input type="text" name="volumenNegocioDep" id="volumenNegocioDep" value="<?php echo (!empty($_REQUEST['volumenNegocioDep']) && empty($aError['volumenNegocioDep'])) ? $_REQUEST['volumenNegocioDep'] : ''; ?>"/>
                <span class='error'><?php echo !empty($aError["volumenNegocioDep"]) ? $aError['volumenNegocioDep'] : ''; ?></span>

                <p><input type="submit" name="enviar" id="enviar" value="Añadir Departamento"/></p>
            </form>  
            <?php
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