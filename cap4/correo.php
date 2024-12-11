<?php
// Importa la clase PHPMailer desde el espacio de nombres PHPMailer\PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

// Incluye el archivo autoload generado por Composer para cargar dependencias
require dirname(__FILE__)."/../vendor/autoload.php";

/**
 * Función para enviar correos con información sobre un pedido.
 * @param array $carrito - Detalle de los productos en el carrito.
 * @param int $pedido - Número de pedido.
 * @param string $correo - Correo electrónico del cliente.
 * @return bool|string - TRUE si el correo se envía correctamente o un mensaje de error.
 */
function enviar_correos($carrito, $pedido, $correo) {
    // Genera el cuerpo del correo llamando a la función crear_correo
    $cuerpo = crear_correo($carrito, $pedido, $correo);
    
    // Llama a la función para enviar el correo a múltiples destinatarios
    return enviar_correo_multiples("$correo, pedidos@empresafalsa.com", 
                        	$cuerpo, "Pedido $pedido confirmado");
}

/**
 * Función para crear el cuerpo del correo con los detalles del pedido.
 * @param array $carrito - Detalle de los productos en el carrito.
 * @param int $pedido - Número de pedido.
 * @param string $correo - Correo electrónico del cliente.
 * @return string - Cuerpo del correo en formato HTML.
 */
function crear_correo($carrito, $pedido, $correo) {
    // Encabezado del correo con número de pedido y correo del cliente
    $texto = "<h1>Pedido nº $pedido </h1><h2>Restaurante: $correo </h2>";
    $texto .= "Detalle del pedido:";

    // Recupera información de los productos en el carrito
    $productos = cargar_productos(array_keys($carrito));
    
    // Abre la tabla HTML para mostrar los productos
    $texto .= "<table>";
    $texto .= "<tr><th>Nombre</th><th>Descripción</th><th>Peso</th><th>Unidades</th></tr>";
    
    // Recorre cada producto y agrega sus detalles como filas de la tabla
    foreach($productos as $producto) {
        $cod = $producto['CodProd']; // Código del producto
        $nom = $producto['Nombre'];  // Nombre del producto
        $des = $producto['Descripcion']; // Descripción del producto
        $peso = $producto['Peso'];  // Peso del producto
        $unidades = $_SESSION['carrito'][$cod]; // Cantidad seleccionada del producto
        
        // Agrega la fila a la tabla con los datos del producto
        $texto .= "<tr><td>$nom</td><td>$des</td><td>$peso</td><td>$unidades</td><td> </tr>";
    }
    $texto .= "</table>"; // Cierra la tabla
    
    return $texto; // Retorna el cuerpo del correo
}

/**
 * Función para enviar un correo a múltiples destinatarios.
 * @param string $lista_correos - Lista de correos separada por comas.
 * @param string $cuerpo - Cuerpo del correo en formato HTML.
 * @param string $asunto - Asunto del correo.
 * @return bool|string - TRUE si se envía correctamente o un mensaje de error.
 */
function enviar_correo_multiples($lista_correos, $cuerpo, $asunto = "") {
    $mail = new PHPMailer(); // Crea una instancia de PHPMailer
    
    // Configuración del servidor SMTP
    $mail->IsSMTP(); // Usa SMTP
    $mail->SMTPDebug  = 0; // Nivel de depuración (0 = sin mensajes, 1 o 2 para más detalles)
    $mail->SMTPAuth   = true; // Autenticación habilitada
    $mail->SMTPSecure = "tls"; // Usa TLS como método de seguridad
    $mail->Host       = "smtp.gmail.com"; // Servidor SMTP
    $mail->Port       = 587; // Puerto para conexión segura
    $mail->Username   = ""; // Usuario de Gmail (pendiente de configurar)
    $mail->Password   = ""; // Contraseña de Gmail (pendiente de configurar)
    
    // Configura el remitente del correo
    $mail->SetFrom('noreply@empresafalsa.com', 'Sistema de pedidos');
    $mail->Subject    = $asunto; // Asunto del correo
    $mail->MsgHTML($cuerpo); // Cuerpo del mensaje en HTML
    
    // Divide la lista de correos separada por comas y añade cada correo como destinatario
    $correos = explode(",", $lista_correos);
    foreach($correos as $correo) {
        $mail->AddAddress($correo, $correo); // Añade destinatarios
    }
    
    // Envía el correo y retorna el resultado
    if(!$mail->Send()) {
        return $mail->ErrorInfo; // Si falla, retorna el mensaje de error
    } else {
        return TRUE; // Si tiene éxito, retorna TRUE
    }
}
?>
