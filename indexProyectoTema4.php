<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyecto Tema 4 PHP - Técnicas de acceso a datos en PHP</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Inter:wght@400;500;600;700;800&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../webroot/css/styles.css">
  <link rel="stylesheet" href="webroot/css/estilos.css">
</head>
<body class="pagina-ajustada">
  <!-- Bloque: Cabecera -->
  <header id="site-header" class="cabecera">
    <div class="cabecera__contenedor">
      <img class="monograma" src="../webroot/images/cruz.png" alt="">
      <h1 class="titulo-header">TEMA 4: Técnicas de acceso a datos en PHP</h1>
      <!-- <img class="cabecera__banner" src="../webroot/images/titulo-pagina.png" alt="Moisés Alberto Domínguez Cruz"> -->
      <img class="monograma" src="../webroot/images/cruz.png" alt="">
    </div>
  </header>

  <main>
    <div class="container">
        <a href='../MDCDWESProyectoDWES/indexProyectoDWES.php'>⬅ Volver al inicio</a><hr>
        <p>Panel de control de ejercicios</p>

        <table>
            <thead>
                <tr>
                    <th>Nombre Scripts</th>
                    <th>Mostrar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>CreaBDMDCProyectoTema4</td>
                    <td>
                        <a href="mostrarcodigo/muestraScriptCrea.php" class="btn btn-codigo">Código</a>
                    </td>
                </tr>
                <tr>
                    <td>CargaInicialBDMDCProyectoTema4</td>
                    <td>
                        <a href="mostrarcodigo/muestraScriptCarga.php" class="btn btn-codigo">Código</a>
                    </td>
                </tr>
                <tr>
                    <td>BorraBDMDCProyectoTema4</td>
                    <td>
                        <a href="mostrarcodigo/muestraScriptBorrar.php" class="btn btn-codigo">Código</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Enunciado de la Práctica</th>
                    <th colspan="2">PDO</th>
                    <th colspan="2">MySQLI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td> Conexión a la base de datos con la cuenta usuario y tratamiento de errores</td>
                    <td>
                        <a href="codigoPHP/ejercicio01PDO.php" class="btn btn-ejecutar">Ejecutar</a>
                    </td>
                    <td>
                        <a href="mostrarcodigo/muestraEjercicio01PDO.php" class="btn btn-codigo">Código</a>
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>2</td>
                    <td>Mostrar el contenido de la tabla Departamento y el número de registros</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>3</td>
                    <td>Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>4</td>
                    <td>Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos)</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>5</td>
                    <td>Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>6</td>
                    <td>Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>7</td>
                    <td>Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se encuentra en el directorio .../tmp/ del servidor</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                
                <tr>
                    <td>8</td>
                    <td>Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se encuentra en el directorio .../tmp/ del servidor</td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  </main>

  <!-- Bloque: Pie -->
  <footer class="pie">
    <div class="pie__redes">
      <a class="pie__red" href="https://github.com/moisesdcsauces/MDCDWESProyectoTema4" target="_blank" rel="noopener" aria-label="GitHub">
        <img src="../webroot/images/icons/github.png" alt="">
      </a>
      <a class="pie__red" href="https://www.linkedin.com/in/mois%C3%A9s-alberto-dom%C3%ADnguez-cruz/" target="_blank" rel="noopener" aria-label="LinkedIn">
        <img src="../webroot/images/icons/linkedin.png" alt="">
      </a>
    </div>
      <p class="pie__texto">© <a class="titulo-enlace" href="../index.html"> Moisés Alberto Domínguez Cruz</a> - IES Los Sauces<span id="year"></span></p>
  </footer>

  <script src="../webroot/js/main.js" defer></script>
</body>
</html>
