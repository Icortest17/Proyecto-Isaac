<?php
    /*  1. Conectarme a la base de datos
        2. Construir una consulta SELECT.....
        3. Recoger los resultados y mostrarlos
    */
    $mysqli = new mysqli("192.168.1.10", "isaac", "123", "proyecto");
    $sql = "SELECT * FROM productos";
    $result = $mysqli->query($sql);

    echo "<table class='table table-striped table-bordered'>";
    echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Nombre</th>";
        echo "<th>Descripcion</th>";
        echo "<th>Precio</th>";
        echo "<th>Activo</th>";
        echo "<th>Descuento</th>";
        echo "<th>Accion</th>";
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
        if (isset($_REQUEST["id"]) and $_REQUEST["id"] == $row['id']){
            // si me envias un parametro id y coincide con el de la linea pones esto
            echo "<tr>";
            echo "<td width='5%'>".$row["id"]."</td>";
            echo "<form method='post' action='update.php' enctype='multipart/form-data'>";
            echo "<td><input type='text' id='nombre' name='nombre' value='".$row["nombre"]."'></td>";
            echo "<td><textarea rows='5' cols='50' name='descripcion' id='descripcion'>".$row["descripcion"]."</textarea></td>";
            echo "<td><input type='number' min='0' id='precio' name='precio' value='".$row["precio"]."'></td>";
            echo "<td><input type='number' max='1' min='0' multiple id='activo' name='activo' value='".$row["activo"]."'></td>";
            echo "<td><input type='number' max='100' min='0' id='descuento' name='descuento' value='".$row["descuento"]."'></td>";
            echo "<input type='hidden'name='id' value='".$row["id"]."'>";
            echo "<td><input type='submit' value='Guardar'></td>";
            echo "</form>";
            echo "</tr>";
        } else {
            // si todo es normal se ejecute este trozo
            echo "<tr>";
            echo "<td width='5%'>".$row["id"]."</td>";
            echo "<td width='20%'>".$row["nombre"]."</td>";
            echo "<td width='40%'>".$row["descripcion"]."</td>";
            echo "<td width='10%'>".$row["precio"]."</td>";
            echo "<td widht='15%'>".$row["activo"]."</td>";
            echo "<td widht='15%'>".$row["descuento"]."</td>";
            echo "<td><a href='delete.php?id=".$row['id']."'><button type='button' class='btn btn-danger'>Borrar</button></a>";
            echo " <a href='productos.php?id=".$row['id']."'><button type='button' class='btn btn-warning'>Modificar</button></a></td>";
            echo "</tr>";
        }
    }
    echo "</table>";

    $mysqli->close();
?>
