<?php

echo "<script>alert('El pago se ha realizado correctamente');</script>";

session_start();

session_destroy();

header("Location: index.php");
?>