<?php
// Incluye el archivo que contiene la función para comprobar sesión.
require 'sesiones.php';

// Incluye el archivo que contiene las funciones relacionadas con la base de datos.
require_once 'bd.php';

// Verifica si el usuario ha iniciado sesión; si no, lo redirige a la página de inicio de sesión.
comprobar_sesion();
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Configuración de codificación de caracteres para soportar acentos y caracteres especiales. -->
	<meta charset="UTF-8">
	<title>Lista de categorías</title>
</head>

<body>
	<!-- Incluye la cabecera, que probablemente contiene el menú o elementos comunes de navegación. -->
	<?php require 'cabecera.php'; ?>

	<!-- Título principal de la página. -->
	<h1>Lista de categorías</h1>

	<!-- Lista dinámica de categorías -->
	<?php
	// Llama a la función que carga las categorías desde la base de datos.
	$categorias = cargar_categorias();

	// Verifica si ocurrió algún error al obtener las categorías.
	if ($categorias === false) {
		// Muestra un mensaje de error si no se pudo conectar con la base de datos.
		echo "<p class='error'>Error al conectar con la base datos</p>";
	} else {
		// Si no hay errores, comienza una lista HTML.
		echo "<ul>"; // Abre la lista.

		// Recorre cada categoría obtenida.
		foreach ($categorias as $cat) {
			// Construye la URL para los productos de cada categoría.
			$url = "productos.php?categoria=" . $cat['codCat'];

			// Crea un elemento de lista con un enlace a la página de productos correspondiente.
			echo "<li><a href='$url'>" . $cat['nombre'] . "</a></li>";
		}

		// Cierra la lista HTML.
		echo "</ul>";
	}
	?>
</body>

</html>