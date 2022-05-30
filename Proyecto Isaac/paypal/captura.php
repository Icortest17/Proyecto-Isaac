<?php
require "../configuracion/config.php";
require "../configuracion/conexion.php";
$db = new Database();
$con = $db->conectar();

$detalles = $_POST['detalles'];


if(is_array($detalles)){
   $id_transaccion = $detalles['id'];
   $total = $detalles['purchase_units'][0]['amount']['value'];
   $estado = $detalles['status'];
   $fecha = $detalles['update_time'];
   $fechaok = date('Y-m-d H:i:s', strtotime($fecha));
   $correo = $detalles['payer']['email_address'];
   $id_cliente = $detalles['payer']['payer_id'];
  
    $sql = $con->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$id_transaccion, $fechaok, $estado, $correo, $id_cliente, $total]);
    $id = $con->lastInsertId();
    if( $id > 0 ){

        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
                $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo=1");
                $sql->execute([$clave]);
                $producto = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $producto['precio'];
                $descuento = $producto['descuento'];
                $cantidad = $cantidad;
                $precio2 = $precio - (($precio * $descuento) / 100);

                $sql_insert = $con->prepare("INSERT INTO detalle_pedidos (id_compra, id_producto, nombre, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
                $sql_insert->execute([$id, $clave, $producto['nombre'], $precio2, $cantidad]);


            }
        }
    }

    
}
