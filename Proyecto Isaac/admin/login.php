<?php
require "../configuracion/config.php";


$usuario_correcto = hash_hmac('sha256', "admin", TOKEN);
$contraseña_correcta = hash_hmac('sha256', "123", TOKEN);


$usuario = hash_hmac('sha256', $_POST["usuario"], TOKEN);
$contraseña = hash_hmac('sha256', $_POST["palabra_secreta"], TOKEN);

if ($usuario === $usuario_correcto && $contraseña === $contraseña_correcta) {
   
    session_start();
    
    $_SESSION["usuario"] = $usuario;

    header("Location: productos.php");
} else { 
     echo "<script>
                alert('El usuario o la contraseña son incorrectos');
                window.location= 'index.php'
    </script>";
}