<?php 
#Creo la constante del token de seguridad y su respectiva contraseña pra cifrar/descifrar
define("TOKEN","Passw0rd");

#Inicio la sesion para el carrito
session_start();

#Cuento los productos del carrito
$num = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num = count($_SESSION['carrito']['productos']);
}

define("ID_CLIENTE","Af_m5xirCIkbVNem71XACk5B_1Vef0PHjXGxAJInukEvT0vLgpsOaagUv7EfeyZOCz9mbQCbb1CAJDYk");
define("CURRENCY","EUR");


?>

