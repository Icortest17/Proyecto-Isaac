<?php
require "configuracion/config.php";
require "configuracion/conexion.php";
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

#print_r($_SESSION);

$listacarrito = array();

#Ejecuto el select solo cuando los productos esten guardados correctamente
if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $listacarrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("location:index.php");
    exit;
}



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/agregarCarrito.js"> </script>
    <script src="js/modificarCarrito.js"> </script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo ID_CLIENTE ?>&currency=<?php echo CURRENCY ?>"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <title>Flores TereyMarta</title>
</head>
<?php include 'header.php' ?>

<body>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="col-6">
                    <div class="table-response">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Si el carrito esta vacio muestro un mensaje de error si no creo una tabla con la lista de los productos -->
                                <?php if ($listacarrito == null) {
                                    echo '<tr><td colspan="5" class="text-center">El carrito esta vacio</td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($listacarrito as $producto) {
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $descuento = $producto['descuento'];
                                        $cantidad = $producto['cantidad'];
                                        $precio2 = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio2;
                                        $total += $subtotal;
                                ?>

                                        <tr>
                                            <td><?php echo $nombre ?></td>
                                            <td>
                                                <div class="text-end" id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $subtotal ?>€</div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="2">
                                            <p class="h3 text-end" id="total"><?php echo $total ?>€</p>
                                        </td>
                                    </tr>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        paypal.Buttons({
                    style: {
                        color: 'blue',
                        shape: 'pill',
                        label: 'pay',
                    },
                    // Inicializa la transaccion al pulsar el boton
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: <?php echo $total ?> // Variable que contiene el precio del producto
                                }
                            }]
                        });
                    },

                    // Finaliza la transaccion al pulsar el boton de aprobar

                    onApprove: (data, actions) => {

                        return actions.order.capture().then(function(detalles) {
                            console.log(detalles)
                            console.log(detalles['id'])
                            console.log(detalles['payer']['name']['given_name'])
                            let url = "paypal/captura.php"

                            var cadena = JSON.stringify(detalles);
                           return $.ajax({
                                type: "POST",
                                url: url,
                                datatype: 'JSON',
                                data: {
                                    "detalles": detalles
                                },
                                success: function(data) {
                                    console.log("success:", data);
                                },
                                failure: function(errMsg) {
                                    alert("error:", errMsg);
                                }
                            });
                            alert(cadena);
                        });
                        
            },

            onCancel: function(data) {
                alert("Pago Cancelado")
                console.log(data);
            }


        }).render('#paypal-button-container');
    </script>
</body>

</html>