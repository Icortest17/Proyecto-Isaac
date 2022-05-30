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
    <title>Flores TereyMarta</title>
</head>
<?php include 'header.php' ?>

<body>

    <main>
        <div class="container">
            <div class="table-response">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th></th>
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
                                    <td><?php echo $precio2 ?>€</td>
                                    <td>
                                        <input type="number" min="1" max="99" step="1" value="<?php echo $cantidad; ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizar(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $subtotal ?>€</div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-danger btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo $total ?>€</p>
                                </td>
                            </tr>
                    </tbody>
                <?php } ?>
                </table>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
                </div>
            </div>
        </div>
    </main>
    <?php include 'ventanaeliminar.php' ?>
    <!-- Si pones este script en otro archivo da un error "Tipico de JavaScript" -->
    <script>
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let botonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            botonElimina.value = id
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>