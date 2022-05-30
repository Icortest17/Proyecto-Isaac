<?php 
#Creo la conexion a la base de datos 
class Database {

    private $hostname = "192.168.1.10";
    private $database = "proyecto";
    private $username = "isaac";
    private $password = "123";
    private $codificacion = "utf8";

    function conectar()
    {
        try{
        $conexion = "mysql:host=" . $this->hostname . "; dbname=". $this->database .";
        charset=" . $this->codificacion;
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($conexion, $this->username, $this->password, $opciones);

        return $pdo;
    } catch(PDOException $e){
        echo 'Error conexion: ' . $e->getMessage();
        exit;

    }
    }

}


?>
