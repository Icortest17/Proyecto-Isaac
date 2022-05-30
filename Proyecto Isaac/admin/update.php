<?php
    /*
    1. Recoger los valores del usuario
    2. Conectarme a la bbdd
    3. Crear la sentencia UPDATE ..
    4. Ejecutamos
    5. Nos dirija a la pagina de index.php
    */

    $nombre = $_REQUEST["nombre"];
    $precio = $_REQUEST["precio"];
    $descripcion = $_REQUEST["descripcion"];
    $activo = $_REQUEST["activo"];
    $descuento = $_REQUEST["descuento"];
    $id = $_REQUEST["id"];

    $mysqli = new mysqli("192.168.1.10", "isaac", "123", "proyecto");
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, activo=$activo, descuento=$descuento  WHERE id=$id";

    $mysqli->query($sql);
    $mysqli->close();

 

    // Redirecciona a otro sitio
  header("location: productos.php");


?>
