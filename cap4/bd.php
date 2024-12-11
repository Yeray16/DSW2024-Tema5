<?php
/**
 * Lee un archivo de configuración XML validado con un esquema XSD.
 * @param string $nombre - Ruta del archivo de configuración XML.
 * @param string $esquema - Ruta del archivo de esquema XSD.
 * @return array - Devuelve un array con la cadena de conexión, usuario y contraseña.
 * @throws InvalidArgumentException - Si el archivo de configuración no pasa la validación.
 */
function leer_config($nombre, $esquema) {
    // Carga el archivo XML.
    $config = new DOMDocument();
    $config->load($nombre);

    // Valida el archivo XML contra el esquema XSD.
    $res = $config->schemaValidate($esquema);
    if ($res === FALSE) { 
        throw new InvalidArgumentException("Revise fichero de configuración");
    } 
    
    // Carga el XML como un objeto SimpleXML para acceder a los datos.
    $datos = simplexml_load_file($nombre);    

    // Extrae los valores de las etiquetas necesarias usando XPath.
    $ip = $datos->xpath("//ip");
    $nombre = $datos->xpath("//nombre");
    $usu = $datos->xpath("//usuario");
    $clave = $datos->xpath("//clave");

    // Construye la cadena de conexión para PDO.
    $cad = sprintf("mysql:dbname=%s;host=%s", $nombre[0], $ip[0]);

    // Devuelve un array con la cadena de conexión, usuario y contraseña.
    return [$cad, $usu[0], $clave[0]];
}

/**
 * Comprueba si un usuario existe en la base de datos.
 * @param string $nombre - Nombre de usuario o correo.
 * @param string $clave - Contraseña del usuario.
 * @return array|bool - Devuelve los datos del usuario si existe, o FALSE si no.
 */
function comprobar_usuario($nombre, $clave) {
    // Lee la configuración para conectarse a la base de datos.
    $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);

    // Consulta SQL para buscar al usuario con correo y contraseña.
    $ins = "select codRes, correo from restaurantes where correo = '$nombre' and clave = '$clave'";
    $resul = $bd->query($ins);

    // Si hay exactamente un resultado, devuelve los datos del usuario; si no, FALSE.
    if ($resul->rowCount() === 1) {        
        return $resul->fetch();        
    } else {
        return FALSE;
    }
}

/**
 * Carga todas las categorías disponibles.
 * @return PDOStatement|bool - Devuelve el cursor de categorías o FALSE si falla.
 */
function cargar_categorias() {
    $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);

    // Consulta SQL para obtener las categorías.
    $ins = "select codCat, nombre from categorias";
    $resul = $bd->query($ins);

    // Si no hay resultados o ocurre un error, devuelve FALSE.
    if (!$resul || $resul->rowCount() === 0) {    
        return FALSE;
    }

    // Devuelve el cursor con los resultados.
    return $resul;
}

/**
 * Carga los detalles de una categoría específica.
 * @param int $codCat - Código de la categoría.
 * @return array|bool - Devuelve los datos de la categoría o FALSE si no existe.
 */
function cargar_categoria($codCat) {
    $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);

    // Consulta SQL para obtener los datos de una categoría específica.
    $ins = "select nombre, descripcion from categorias where codcat = $codCat";
    $resul = $bd->query($ins);

    // Si no hay resultados o ocurre un error, devuelve FALSE.
    if (!$resul || $resul->rowCount() === 0) {    
        return FALSE;
    }

    // Devuelve los datos de la categoría.
    return $resul->fetch();
}

/**
 * Carga los productos de una categoría específica.
 * @param int $codCat - Código de la categoría.
 * @return PDOStatement|bool - Devuelve el cursor con los productos o FALSE si falla.
 */
function cargar_productos_categoria($codCat) {
    $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);

    // Consulta SQL para obtener los productos de la categoría.
    $sql = "select * from productos where CodCat = $codCat";
    $resul = $bd->query($sql);

    // Si no hay resultados o ocurre un error, devuelve FALSE.
    if (!$resul || $resul->rowCount() === 0) {    
        return FALSE;
    }

    // Devuelve el cursor con los productos.
    return $resul;
}

/**
 * Carga los datos de productos específicos.
 * @param array $codigosProductos - Array con los códigos de productos.
 * @return PDOStatement|bool - Devuelve el cursor con los datos de los productos o FALSE si falla.
 */
function cargar_productos($codigosProductos) {
    $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);

    // Convierte el array de códigos a una lista separada por comas.
    $texto_in = implode(",", $codigosProductos);

    // Consulta SQL para obtener los productos.
    $ins = "select * from productos where CodProd in($texto_in)";
    $resul = $bd->query($ins);

    // Devuelve el cursor con los resultados o FALSE si falla.
    return $resul ?: FALSE;
}

/**
 * Inserta un pedido y sus detalles en la base de datos.
 * @param array $carrito - Array asociativo con los códigos de producto y sus cantidades.
 * @param int $codRes - Código del restaurante.
 * @return int|bool - Devuelve el ID del pedido insertado o FALSE si falla.
 */
function insertar_pedido($carrito, $codRes) {
    $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
    $bd = new PDO($res[0], $res[1], $res[2]);

    // Inicia una transacción.
    $bd->beginTransaction();

    // Inserta el pedido en la tabla de pedidos.
    $hora = date("Y-m-d H:i:s", time());
    $sql = "insert into pedidos(fecha, enviado, restaurante) values('$hora', 0, $codRes)";
    $resul = $bd->query($sql);

    // Si falla, cancela la transacción.
    if (!$resul) {
        return FALSE;
    }

    // Obtiene el ID del pedido insertado.
    $pedido = $bd->lastInsertId();

    // Inserta los detalles del pedido.
    foreach ($carrito as $codProd => $unidades) {
        $sql = "insert into pedidosproductos(CodPed, CodProd, Unidades) values($pedido, $codProd, $unidades)";
        $resul = $bd->query($sql);
        if (!$resul) {
            $bd->rollback(); // Cancela la transacción si falla.
            return FALSE;
        }
    }

    // Confirma la transacción.
    $bd->commit();
    return $pedido;
}
?>
