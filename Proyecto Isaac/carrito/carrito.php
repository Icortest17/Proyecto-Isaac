<?php 
#Cuento los datos del carrito haciendo las validaciones necesarias
require '../configuracion/config.php';

if(isset($_POST['id'])){

    $id = $_POST['id'];
    $token = $_POST['token'];

    $token_recibido = hash_hmac('sha256', $id, TOKEN);

    if ($token_recibido == $token) {

        if(isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            $_SESSION['carrito']['productos'][$id] = 1;
        }

        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;

    }else {
        $datos['ok'] = false;
    }

}else {
    $datos['ok'] = false;
}

echo json_encode($datos);