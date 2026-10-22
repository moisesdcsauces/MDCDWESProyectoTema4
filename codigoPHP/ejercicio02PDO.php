<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 02 - Mostrar Departamento</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                background-color: #f4f5f7;
                color: #333;
            }

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
    <body>
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
    </body>
</html>

