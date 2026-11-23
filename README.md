# Tema 4: Técnicas de acceso a datos en PHP

| CFGS DESARROLLO DE APLICACIONES WEB |
|:-----------:|
| DESARROLLO WEB EN ENTORNO SERVIDOR |

Ejercicios del Tema 4 de acceso a una base de datos MariaDB desde PHP con PDO y MySQLi: consultas, inserciones con validación, transacciones e importación y exportación en XML y JSON.

## Ejercicios

| Nº | Ejercicio |
|:--:|-----------|
| 1 | Conexión a la base de datos y tratamiento de errores ([PDO](codigoPHP/ejercicio01PDO.php) · [MySQLi](codigoPHP/ejercicio01MYSQli.php)) |
| 2 | [Contenido de la tabla Departamento y número de registros](codigoPHP/ejercicio02PDO.php) |
| 3 | [Formulario para añadir un departamento con validación](codigoPHP/ejercicio03PDO.php) |
| 4 | [Búsqueda de departamentos por descripción](codigoPHP/ejercicio04PDO.php) |
| 5 | [Tres inserciones en una transacción](codigoPHP/ejercicio05PDO.php) |
| 6 | [Tres inserciones en una transacción con arrays](codigoPHP/ejercicio06PDO.php) |
| 7 | Importar departamentos desde un fichero ([XML](codigoPHP/ejercicio07PDO.php) · [JSON](codigoPHP/ejercicio07_01PDO.php)) |
| 8 | Exportar departamentos a un fichero ([XML](codigoPHP/ejercicio08PDO.php) · [JSON](codigoPHP/ejercicio08_01PDO.php)) |

## Estructura

- `indexProyectoTema4.php`: índice con todos los ejercicios.
- `codigoPHP/`: ejercicios.
- `config/`: configuración de la conexión a la base de datos.
- `core/`: librería de validación de formularios.
- `scriptsDB/`: scripts para crear, cargar y borrar la base de datos.
- `tmp/`: ficheros XML y JSON de importación y exportación.
- `webroot/`: hojas de estilo.
- `error/`: páginas de error 404 y 403 del proyecto.
- `.htaccess`: índice del proyecto y páginas de error.

## Tecnologías

PHP 8 (PDO y MySQLi), MariaDB, HTML5 y CSS3, servidor Apache.

## Ramas

- `master`: version entregada.
- `developerMDC`: rama de trabajo.

> **Moisés Alberto Domínguez Cruz**
> Curso: 2026/2027
> 2º Curso CFGS Desarrollo de Aplicaciones Web — IES Los Sauces
