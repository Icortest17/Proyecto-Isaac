<?php
require "configuracion/config.php";
require "configuracion/conexion.php";
$db = new Database();
$con = $db->conectar();

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
  <!-- Incluyo la cabecera de la pagina -->
  <?php include 'header.php' ?>
  <main>
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <!-- Creo el bucle con el que mostrare los productos -->
        <?php foreach($resultado as $row) {?>
        <div class="col">
          <div class="card shadow-sm">
          <?php 
          
            $id = $row['id'];
            $imagen = "imagenes/productos/" . $id . "/principal.jpeg";
            if(!file_exists($imagen)){
              $imagen = "imagenes/sinfoto.jpg";
            }

          ?>

            <img src="<?php echo "$imagen"; ?>" class="card-img-top width="100%" height="400">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
              <p class="card-text"><?php echo number_format($row['precio'], 2, '.', ','); ?>€</p>
              <div class="d-flex justify-content-between align-items-center">
                <!-- Boton para acceder a los detalles del producto, genero un token de seguridad y lo envio por GET -->
                <div class="btn-group">
                  <a href="detalles.php?id=<?php echo $row['id'];  ?>&token=<?php echo hash_hmac('sha256', $row['id'], TOKEN);  ?>" class="btn btn-primary">Detalles</a>
                </div>
                <button class="btn btn-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>,'<?php echo hash_hmac('sha256', $row['id'], TOKEN); ?>')"> Agegar al carrito</button>
              </div>

            </div>
          </div>
        </div>
        <?php } ?>
      </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
</body>

</html>