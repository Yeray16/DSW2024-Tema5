<?php
// Incluye el archivo que contiene la función para comprobar sesión.
require 'sesiones.php';

// Incluye el archivo que contiene las funciones relacionadas con la base de datos.
require_once 'bd.php';

// Verifica si el usuario ha iniciado sesión; si no, lo redirige.
comprobar_sesion();
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Configuración de codificación de caracteres para soportar acentos y caracteres especiales. -->
	<meta charset="UTF-8">
	<title>Tabla de productos por categoría</title>
</head>

<body>
	<!-- Incluye la cabecera común del sitio (menú o navegación). -->
	<?php
	require 'cabecera.php';

	// Carga la información de la categoría seleccionada, utilizando el parámetro recibido por GET.
	$cat = cargar_categoria($_GET['categoria']);

	// Carga los productos de la categoría seleccionada.
	$productos = cargar_productos_categoria($_GET['categoria']);

	// Verifica si hubo algún problema al obtener la información de la categoría o los productos.
	if ($cat === FALSE or $productos === FALSE) {
		// Muestra un mensaje de error si no se pudo conectar con la base de datos.
		echo "<p class='error'>Error al conectar con la base datos</p>";
		exit; // Finaliza la ejecución si hay un error.
	}

	// Muestra el nombre de la categoría como título principal.
	echo "<h1>" . $cat['nombre'] . "</h1>";

	// Muestra la descripción de la categoría.
	echo "<p>" . $cat['descripcion'] . "</p>";

	// Comienza una tabla para listar los productos.
	echo "<table>"; // Abre la tabla.
	echo "<tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Peso</th>
                <th>Stock</th>
                <th>Comprar</th>
              </tr>";

	// Recorre cada producto de la categoría.
	foreach ($productos as $producto) {
		// Extrae los datos relevantes del producto.
		$cod = $producto['CodProd']; // Código del producto.
		$nom = $producto['Nombre']; // Nombre del producto.
		$des = $producto['Descripcion']; // Descripción del producto.
		$peso = $producto['Peso']; // Peso del producto.
		$stock = $producto['Stock']; // Stock disponible.

		// Crea una fila en la tabla con la información del producto.
		echo "<tr>
                    <td>$nom</td>
                    <td>$des</td>
                    <td>$peso</td>
                    <td>$stock</td>
                    <td>
                        <form action='anadir.php' method='POST'>
                            <!-- Campo para indicar la cantidad a comprar. -->
                            <input name='unidades' type='number' min='1' value='1'>

                            <!-- Botón para enviar el formulario de compra. -->
                            <input type='submit' value='Comprar'>

                            <!-- Campo oculto para enviar el código del producto. -->
                            <input name='cod' type='hidden' value='$cod'>
                        </form>
                    </td>
                  </tr>";
	}

	// Cierra la tabla HTML.
	echo "</table>";
	?>
</body>

</html>