<?php

    
    $nombre = $_REQUEST["nombre"];
    $precio = $_REQUEST["precio"];
    $descripcion = $_REQUEST["descripcion"];
    $activo = $_REQUEST["activo"];
    $descuento = $_REQUEST["descuento"];

    /*
        1. Conectarme a la base de datos
        2. Construir un INSERT INTO.....
        3. Ejecutar la consulta
        4. Cerrar conexión
    */
    $mysqli = new mysqli("192.168.1.10", "isaac", "123", "proyecto");
    $sql = "INSERT INTO productos (nombre, descripcion, precio, activo, descuento) VALUES ('$nombre','$descripcion','$precio','$activo',' $descuento');";
    $mysqli->query($sql);
    $mysqli->close();


    // Redirecciona a otro sitio
    header("location: productos.php");
