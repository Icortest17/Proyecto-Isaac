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
    <br />
    <div class="alet alert-success">
        <h1>Añadir Productos</h1>
        <form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="create.php" enctype="multipart/form-data">
            <div class="col-12">
                <label for="producto">Nombre:</label>
                <br>
                <input type="text" id="nombre" name="nombre">
            </div>
            <div class="col-12">
                <label for="descripcion">Descripcion:</label>
                <br>
                <textarea rows="5" cols="50" name="descripcion" id="descripcion"></textarea>
            </div>
            <div class="col-12">
                <label for="precio">Precio:</label>
                <br>
                <input input type='number' min='0' id='precio' name='precio'>
            </div>
            <div class="col-12">
                <label for="activo">Activo:</label>
                <br>
                <input input type='number' max='1' min='0' multiple id='activo' name='activo'>
            </div>
            <div class="col-12">
                <label for="descuento">Descuento:</label>
                <br>
                <input input type='number' max='100' min='0' id='descuento' name='descuento'>
            </div>
            <div class="col-12">
                <br>
                <button type="submit" value="Enviar" name="Enviar" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
    <br />
    <h1>Borrar o Modificar Productos</h1>
    <?php
    include("read.php");
    ?>

</body>

</html>