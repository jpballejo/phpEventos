<?php
namespace App\Lib;
use PDO;
use mysqli;
class Database
{
private $con;

      /*  public function StartUp(){
        // include_once dirname(__FILE__)  . 'app/lib/constants.php';

            $this->con = new mysqli('192.138.20.193', 'administrador', '1234', 'denunciabache'); 
            if(mysqli_connect_error()){
                echo "Failed  to connect " . mysqli_connect_error(); 
                return null; 
            }
            return $this->con; 
        }*/
  public static function conexion(){
        
        static $conexion = null;
        if (null === $conexion) {
             $conexion=new mysqli('localhost', 'administrador', '1234', 'denunciabache')
         or die ("No se puede conectar con el servidor");
        }
        
        $conexion->set_charset("utf8");
        return $conexion;
    }

 protected $db;

    public function Connection(){

    $conn = NULL;

        try{
            $conn = new PDO("mysql:host=localhost;dbname=denunciabache", "administrador", "1234");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo 'ERROR: ' . $e->getMessage();
                }   
           return $conn;
    }
   
    public function getConnection(){
        return $this->db;
    }
   
   
}