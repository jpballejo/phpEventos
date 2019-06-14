<?php

namespace App\Model;
use App\Lib\Database;
use App\Lib\Response;

class DenunciaModel{

private $con;
private $table = 'evento';
private $response;

public $nombre; 
public $descripcion; 
public $longitud;  
public $latitud;        
public $foto;      
public $idEstado;       
public $activo;   
public $id;  


 /* public function __CONSTRUCT()
    {
        $this->db = Database::Connection();
$this->response = new Response();
       
    }*/
    public function __CONSTRUCT($id="",$nombre="",$descripcion="",$longitud="",$latitud="",$foto="",$idEstado="",$activo=""){

    $this->id=$id;
    $this->nombre=$nombre;
    $this->descripcion=$descripcion;
    $this->longitud=$longitud;
    $this->latitud=$latitud;
    $this->foto=$foto;
    $this->idEstado=$idEstado;
    $this->activo=$activo;

    }

public function setId($idE){
    $this->id=$idE;
}
public function setNombre($nom){
    $this->nombre=$nom;
}
public function setDescripcion($desc){
    $this->descripcion=$desc;
}
public function setLongitud($longi){
    $this->longitud=$longi;
}
public function setLatitud($lati){
    $this->latitud=$lati;
}
public function setFoto($fotoE){
    $this->foto=$fotoE;
}
public function setIdEstado($idEstadoE){
    $this->idEstado=$idEstadoE;
}
public function setActivo($activoE){
    $this->activo=$activoE;
}


    /*  public function GetAll()
    {
		try
		{
			$result = array();

			$stm = $this->db->prepare("SELECT * FROM $this->table");
			$stm->execute();
            
			$this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
		}
		catch(Exception $e)
		{
			$this->response->setResponse(false, $e->getMessage());
            return $this->response;
		}
    }*/
    
    /*public function Get($id)
    {
		try
		{
			$result = array();

			$stm = $this->db->prepare("SELECT * FROM $this->table WHERE id = ?");
			$stm->execute(array($id));

			$this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            
            return $this->response;
		}
		catch(Exception $e)
		{
			$this->response->setResponse(false, $e->getMessage());
            return $this->response;
		}  
    }*/
    public function insert($data2){
        
    try{   $sql= "INSERT INTO evento (nombre, descripcion, longitud, latitud, foto, idEstado, activo) VALUES (?,?,?,?,?,?,?)";
 

    $this->db->prepare($sql)->execute($data2);
   
   

        return $data2;
        }catch (Exception $e) 
        {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
   
    public function InsertOrUpdate($data)
    {
		try 
		{                   $nombre=$data['nombre'];
                            $descripcion=$data['descripcion'];
                            $longitud=$data['longitud'];
                            $latitud=$data['latitud'];
                            $foto=$data['foto'];
                            $idEstado=$data['idEstado'];
                            $activo=$data['activo'];

            if(isset($data['id']))
            {
                $sql = "UPDATE evento SET 
                            nombre        	= ?,
                            descripcion     = ?,
                            longitud        = ?,
                            latitud         = ?,
                            foto    		= ?,
                            idEstado		= ?,
                            activo 			= ?
                        WHERE id = ?";
                
                //$this->db->prepare($sql)
                  //   ->execute($data);
                $sttm=Database::conexion()->prepare($sql);
                $sttm->execute($data);
              return true;     
            }
            else
            {
              $sql= "INSERT INTO evento (nombre, descripcion, longitud, latitud, foto, idEstado, activo) VALUES (?,?,?,?,?,?,?)";
                            $sttm=Database::conexion()->prepare($sql);
                           
                            $sttm->bind_param("ssddsii",$nombre,$descripcion,$longitud,$latitud,$foto,$idEstado,$activo);
                            $sttm->execute();
           //$this->db->prepare($sql)->execute($data);
                 return true;
            }
            
			//$this->response->setResponse(true);
        return true;
           // return $this->response;
		}catch (Exception $e) 
		{
            $this->response->setResponse(false, $e->getMessage());
		}
    }
    /*
    public function Delete($id)
    {
		try 
		{
			$stm = $this->db
			            ->prepare("DELETE FROM $this->table WHERE id = ?");			          

			$stm->execute(array($id));
            
			$this->response->setResponse(true);
            return $this->response;
		} catch (Exception $e) 
		{
			$this->response->setResponse(false, $e->getMessage());
		}
    }*/

    public function getImagen($id){

      //  $stm = $this->db->prepare("SELECT id, foto FROM evento WHERE id = ?");
        $stmt = Database::conexion()->prepare("SELECT id, foto FROM evento WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $resultado=$stmt->get_result();
        $a = $resultado->fetch_object();
        $path = "../tmp_file_".$a->id.".jpg";
        file_put_contents($path, $a->foto);
        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename='.$path);
        header('Pragma: no-cache');
        readfile($path);
        unlink($path);

    }
     public function getImage($id){
      $sql = "SELECT * FROM evento WHERE id = ?"; 
      $sth = $this->db->prepare($sql);
      $sth->execute($id);
      $num = $sth->rowCount();
    if( $num ){ 
        $row = $sth->fetch(PDO::FETCH_OBJECT); 
        header('Content-Type: image/jpeg'); 
        return $row['foto'];
        exit;
    }
        else{
            return null; 
        } 
    }
    
    //$id,$nombre,$descripcion,$longitud,$latitud,$foto,$idEstado,$activo
   /* public function getEventos(){
        $eventos=[];
            error_reporting(E_ALL & ~E_NOTICE);
            ini_set("display_errors", 1);
    $d = new DenunciaModel();
       while($fila=$resultado->fetch_object()){
    }
    $d->setActivo($fila->activo);
    $d->setDescripcion($fila->descripcion);
    $d->setFoto("data:image/jpeg;base64,".base64_encode($fila->foto));
    $d->setId($fila->id);
    $d->setIdEstado($fila->idEstado);
    $d->setLatitud($fila->latitud);
    $d->setLongitud($fila->longitud);
    $d->setNombre($fila->nombre);
    $eventos[]=$d;
    $resultado=$stm->fetchAll();
    $stm = $this->db->prepare("SELECT * FROM evento");
    $stm->execute();
    return $eventos;
 
    }*/
public function getEventos(){
        ini_set("display_errors", 1);
        error_reporting(E_ALL & ~E_NOTICE);
        $eventos = [];

        $stmt = Database::conexion()->prepare( "SELECT * from evento");         
        $stmt->execute();
        $resultado=$stmt->get_result();
        while($fila=$resultado->fetch_object()){

            $denuncia = new DenunciaModel($fila->id,$fila->nombre,$fila->descripcion,$fila->longitud,$fila->latitud,"data:image/jpeg;base64,".base64_encode($fila->foto),$fila->idEstado,$fila->activo);

            $eventos[] = $denuncia;
        }
        return $eventos;
    }
}
