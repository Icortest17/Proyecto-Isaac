<?php
#Incluyo los archivos necesarios para realizar la conexion
require "configuracion/config.php";
require "configuracion/conexion.php";
$db = new Database();
$con = $db->conectar();

#Recojo los datos que he enviado por GET
$id = isset($_GET['id']) ? $_GET['id'] : '';

$token = isset($_GET['token']) ? $_GET['token'] : '';

#Validacion para no poder enviar el token o la id en blanco
if ($id == '' || $token == '') {
    echo "Erro al acceder a los detalles del producto";
    exit;
} else {

#Cifro la id para comparala con el token y si coinciden muestro los detalles del producto
    $token_recibido = hash_hmac('sha256', $id, TOKEN);

    if ($token_recibido == $token) {

        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $imagen = "imagenes/productos/" . $id . "/principal.jpeg";
            $carpeta = "imagenes/productos/" . $id . "/";

#Compruebo que exista la imagen principal y en caso de que no exista mustro una imagen por defecto
            if (!file_exists($imagen)) {
                $imagen = "imagenes/sinfoto.jpg";
            }

#Calculo el descuento del producto en el caso de que exista

            $descuento = $row['descuento'];
            $precio2 = $precio - (($precio * $descuento) / 100);

            $imagenes = array();
            if (file_exists("imagenes/productos/")) {
                $dir = dir("imagenes/productos/" . $id . "/");

                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'principal.jpeg' && (strpos($archivo, 'jpeg') || strpos($archivo, 'jpg'))) {

                        $imagenes[] = $carpeta . $archivo;
                    }
                }

                $dir->close();
            }
        }
    } else {
        echo "Erro al acceder a los detalles del producto";
        exit;
    }
}

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


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
    <title>Flores TereyMarta</title>
</head>

<body>
    <?php include 'header.php' ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-2">
<!-- Incluyo el archivo con la funcionalidad del slider por si el producto tiene mas de una foto -->
                    <?php include 'slider.php' ?>

                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre; ?></h2>

                    <?php if ($descuento > 0) { ?>
                        <p><del><?php echo $precio; ?>€</del><small class="text-succes"></p>
                        <h2><?php echo $precio2; ?>€ </h2>

                    <?php } else { ?>
                        <h2><?php echo $precio; ?>€</h2>
                    <?php } ?>

                    <p class="lead">
                        <?php echo $descripcion; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button"> Comprar ahora</button>
                        <!-- Boton que realiza la llamada a la funcion de javascript para añadir los productos al carrito -->
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>,'<?php echo $token; ?>')"> Agegar al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
</body>

</html>