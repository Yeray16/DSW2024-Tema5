<?php
// Importa las funciones relacionadas con la base de datos.
require_once 'bd.php';

/*
Este archivo implementa un formulario de login.
- Si el login es exitoso, se inicia una sesión, se guarda el usuario y se redirige a 'categorias.php'.
- Si el login falla, muestra un mensaje de error.
*/

// Comprueba si se ha enviado el formulario con el método POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Comprueba las credenciales del usuario usando la función `comprobar_usuario`.
	$usu = comprobar_usuario($_POST['usuario'], $_POST['clave']);

	// Si la función devuelve `false`, significa que las credenciales no son válidas.
	if ($usu === false) {
		$err = true; // Marca que hubo un error.
		$usuario = $_POST['usuario']; // Guarda temporalmente el nombre de usuario para mostrarlo en el formulario.
	} else {
		// Si las credenciales son válidas:
		session_start(); // Inicia una nueva sesión.

		// Guarda los datos del usuario (correo y código del restaurante) en la sesión.
		$_SESSION['usuario'] = $usu;

		// Inicializa el carrito vacío en la sesión.
		$_SESSION['carrito'] = [];

		// Redirige al usuario a la página de categorías.
		header("Location: categorias.php");

		// Termina la ejecución del script para evitar que continúe procesando.
		return;
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Configuración de codificación para acentos y caracteres especiales. -->
	<meta charset="UTF-8">
	<title>Formulario de login</title>
</head>

<body>
	<?php
	// Muestra un mensaje si el usuario llegó aquí porque fue redirigido.
	if (isset($_GET["redirigido"])) {
		echo "<p>Haga login para continuar</p>";
	}
	?>

	<?php
	// Muestra un mensaje de error si las credenciales no son válidas.
	if (isset($err) and $err == true) {
		echo "<p>Revise usuario y contraseña</p>";
	}
	?>

	<!-- Formulario de login -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
		<!-- Campo para el nombre de usuario -->
		<label for="usuario">Usuario</label>
		<input
			value="<?php if (isset($usuario)) echo $usuario; ?>"
			id="usuario"
			name="usuario"
			type="text">

		<!-- Campo para la contraseña -->
		<label for="clave">Clave</label>
		<input
			id="clave"
			name="clave"
			type="password">

		<!-- Botón de envío -->
		<input type="submit">
	</form>
</body>

</html>