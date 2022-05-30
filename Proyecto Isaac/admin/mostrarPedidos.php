<?php
require "../configuracion/config.php";
require "../configuracion/conexion.php";
$db = new Database();
$con = $db->conectar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tienda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
<?php
include "headeradmin.php";
?>
    <br />
    <br />
    <div class="container">
        <br>
        <div class="row">
            <?php
            $sql = $con->prepare("SELECT * FROM detalle_pedidos");
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <h1>Pedidos Por Fecha</h1>

            <table class='table table-striped table-bordered'>
                <tr>
                    <th>ID_Compra</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
                <?php $contador = 0 ?>

                <?php foreach ($resultado as $pedido) {
                    $idcomparar = $pedido["id_compra"];
                    $arrayproductos[$idcomparar] = $pedido["nombre"];
                    $sql1 = $con->prepare("SELECT * FROM compra where id in (select id_compra from detalle_pedidos where id_compra='$idcomparar')");
                    $sql1->execute();
                    $resultado1 = $sql1->fetchAll(PDO::FETCH_ASSOC);

                    $sql2 = $con->prepare("SELECT * FROM detalle_pedidos where id_compra='$idcomparar'");
                    $sql2->execute();
                    $resultado2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultado1 as $pedido1) {
                    } ?>

                    <tr>
                        <th><?php echo $pedido1["id"] ?></th>
                        <th><?php echo $pedido1["email"] ?></th>
                        <th><?php echo $pedido1["fecha"] ?></th>
                        <th><?php echo $pedido1["total"] ?></th>
                    </tr>

                    <?php foreach ($resultado2 as $prodped) { ?>

                        <tr>
                            <td><?php echo $prodped["nombre"] ?></td>
                            <td><?php echo $prodped["cantidad"] ?></td>
                            <td><?php echo $prodped["precio"] ?></td>
                        </tr>
                    <?php } ?>

                <?php } ?>
            </table>
            <?php
            ?>
</body>

</html>
