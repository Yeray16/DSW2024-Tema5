<?php
/* 
Este archivo implementa la página del carrito de la compra.
- Comprueba que el usuario haya iniciado sesión.
- Muestra los productos en el carrito.
- Permite eliminar unidades de productos del carrito.
*/

// Importa las funciones necesarias para manejar sesiones y la base de datos.
require_once 'sesiones.php';
require_once 'bd.php';

// Verifica si el usuario ha iniciado sesión; de lo contrario, redirige a la página de login.
comprobar_sesion();
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Configuración de codificación para acentos y caracteres especiales. -->
	<meta charset="UTF-8">
	<title>Carrito de la compra</title>
</head>

<body>
	<?php
	// Incluye el archivo de cabecera, que normalmente contiene el menú y opciones comunes.
	require 'cabecera.php';

	// Carga los productos del carrito usando sus códigos (claves del array de la sesión).
	$productos = cargar_productos(array_keys($_SESSION['carrito']));

	// Si no hay productos en el carrito, muestra un mensaje y detiene la ejecución.
	if ($productos === FALSE) {
		echo "<p>No hay productos en el pedido</p>";
		exit;
	}

	// Muestra el título de la página.
	echo "<h2>Carrito de la compra</h2>";

	// Abre la tabla para listar los productos del carrito.
	echo "<table>";
	echo "<tr><th>Nombre</th><th>Descripción</th><th>Peso</th><th>Unidades</th><th>Eliminar</th></tr>";

	// Recorre cada producto del carrito y muestra sus detalles en una fila de la tabla.
	foreach ($productos as $producto) {
		$cod = $producto['CodProd'];       // Código del producto.
		$nom = $producto['Nombre'];       // Nombre del producto.
		$des = $producto['Descripcion'];  // Descripción del producto.
		$peso = $producto['Peso'];        // Peso del producto.
		$unidades = $_SESSION['carrito'][$cod]; // Cantidad de unidades del producto en el carrito.

		// Crea una fila con los detalles del producto y un formulario para eliminar unidades.
		echo "<tr>
                    <td>$nom</td>
                    <td>$des</td>
                    <td>$peso</td>
                    <td>$unidades</td>
                    <td>
                        <form action='eliminar.php' method='POST'>
                            <!-- Campo para ingresar la cantidad de unidades a eliminar -->
                            <input name='unidades' type='number' min='1' value='1'>
                            <!-- Botón para enviar el formulario -->
                            <input type='submit' value='Eliminar'>
                            <!-- Campo oculto con el código del producto -->
                            <input name='cod' type='hidden' value='$cod'>
                        </form>
                    </td>
                </tr>";
	}

	// Cierra la tabla.
	echo "</table>";
	?>
	<hr>
	<!-- Enlace para procesar el pedido -->
	<a href="procesar_pedido.php">Realizar pedido</a>
</body>

</html>