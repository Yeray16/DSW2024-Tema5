<?php
// Importa el archivo para gestionar el envío de correos.
require 'correo.php';

// Importa el archivo que contiene las funciones para gestionar sesiones.
require 'sesiones.php';

// Importa las funciones relacionadas con la base de datos.
require_once 'bd.php';

// Comprueba si el usuario ha iniciado sesión; si no, lo redirige.
comprobar_sesion();
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Configuración de codificación de caracteres para soportar acentos y caracteres especiales. -->
	<meta charset="UTF-8">
	<title>Pedidos</title>
</head>

<body>
	<!-- Incluye la cabecera común del sitio (menú o navegación). -->
	<?php
	require 'cabecera.php';

	// Inserta un nuevo pedido en la base de datos usando los datos del carrito y el código del restaurante del usuario actual.
	$resul = insertar_pedido($_SESSION['carrito'], $_SESSION['usuario']['codRes']);

	// Verifica si la inserción del pedido fue exitosa.
	if ($resul === FALSE) {
		// Muestra un mensaje de error si no se pudo realizar el pedido.
		echo "No se ha podido realizar el pedido<br>";
	} else {
		// Recupera el correo del usuario actual desde la sesión.
		$correo = $_SESSION['usuario']['correo'];

		// Muestra un mensaje de éxito e indica que se enviará un correo de confirmación.
		echo "Pedido realizado con éxito. Se enviará un correo de confirmación a: $correo ";

		// Envía un correo de confirmación al cliente y al sistema.
		$conf = enviar_correos($_SESSION['carrito'], $resul, $correo);

		// Verifica si hubo problemas al enviar el correo.
		if ($conf !== TRUE) {
			// Muestra un mensaje de error si no se pudo enviar el correo.
			echo "Error al enviar: $conf <br>";
		};

		// Vacía el carrito después de completar el pedido.
		$_SESSION['carrito'] = [];
	}
	?>
</body>

</html>