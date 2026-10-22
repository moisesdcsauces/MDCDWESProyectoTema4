<?php

/*
 * Moisés Alberto Dominguez Cruz
 * 19/10/2026
 * Ejercicio 02 (Tema 4) - Mostrar el contenido de la tabla Departamento y el número de registros.
 */

echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a><hr>";

// Inicio del codigo PHP que el servidor debe procesar
require_once '../config/configDBPDO.php';

// Imprimir el query aqui

try {
    $miDB = new PDO(HOST, USER, PASS);

    echo '<h2>CONSULTAS</h2>';
    echo '<br></br>';

    $consulta = $miDB->query('SELECT * FROM T02_Departamento');

    echo '<table>';
    echo '<tr class="titulo">';
    echo '<td>Codigo</td>';
    echo '<td>Descripcion</td>';
    echo '<td>FechaCreacion</td>';
    echo '<td>Volumen</td>';
    echo '<td>FechaBaja</td>';
    echo '</tr>';

    while ($registro = $consulta->fetchObject()) {
        echo '<tr>';
        echo '<td>' . $registro->T02_CodDepartamento . '</td>';
        echo '<td>' . $registro->T02_DescDepartamento . '</td>';

        $oFechaCreacionDepartamento = new DateTime($registro->T02_FechaCreacionDepartamento);
        echo '<td>' . $oFechaCreacionDepartamento->format('d/m/Y') . '</td>';
        echo '<td>' . number_format($registro->T02_VolumenDeNegocio, 2, ',', '.') . ' €</td>';
        if (is_null($registro->T02_FechaBajaDepartamento)) {
            echo '<td></td>';
        } else {
            $oFechaBajaDepartamento = new DateTime($registro->T02_FechaBajaDepartamento);
            echo '<td>' . $oFechaBajaDepartamento->format('d/m/Y') . '</td>';
        }
        echo '</tr>';
    }

    echo '</table>';

    echo '<h3>Número de registros: ' . $consulta->rowCount() . '</h3>';
} catch (PDOException $miExcepcionPDO) { // Lanza la Exception PDOException cuando ocurre un error.
    // Captura el codigo de error y lo imprime en un mensaje.   
    echo "Codigo del error: " . $miExcepcionPDO->getCode() . "<br/>";
    echo "Mensaje de error: " . $miExcepcionPDO->getMessage() . "<br/><hr>";
} finally {
    unset($miDB);
}
?>

