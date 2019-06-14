  <?php
    use App\Model\DenunciaModel;

    $app->group('/denuncia/',function(){

     $this->get('test', function ($req, $res, $args) {
            return $res->getBody()
                       ->write('Hello denuncia');
        });
    $this->post('getimagen',function($req, $res,$args){

    $params = $req->getParams();
    $id=$params["id"];
    $d= new DenunciaModel();
    return $d->getImagen($id);

        });
    $this->post('nuevoevento',function($request, $response,$args){
    $ruta="./imagenes/";
    $params=$request->getParams();
    $nombre=$params['nombre'];
    $descripcion=$params['descripcion'];
    $longitud=$params['longitud'];
    $latitud=$params['latitud'];
    $idEstado=$params['idEstado'];
    $activo=$params['activo'];

    try{

    $denuncia = new DenunciaModel();//creo el modelo
    $gestor = fopen($_FILES["foto"]["tmp_name"], "rb");//obtengo el archivo que viene
    $foto= stream_get_contents($gestor);//lo paso a foto 
    fclose($gestor);
    $tmp_name = $_FILES["foto"]['tmp_name'];
    if (is_dir($ruta) && is_uploaded_file($tmp_name))
        {
        $img_file = $_FILES[$nombre_fichero]['name'];
        $img_type = $_FILES[$nombre_fichero]['type'];
        echo 1;
        // Si se trata de una imagen   
        if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
        strpos($img_type, "jpg")) || strpos($img_type, "png")))
        {
            //¿Tenemos permisos para subir la imágen?
            echo 2;
            if (move_uploaded_file($tmp_name, $ruta . '/' . $img_file))
            {
                return true;
            }
        }
    }
    $data=["nombre"=>$nombre,
    "descripcion"=>$descripcion,
    "longitud"=>$longitud,
    "latitud"=>$latitud,
    "foto"=>$foto,
    "idEstado"=>$idEstado,
    "activo"=>$activo];

if($denuncia->InsertOrUpdate($data)){
      $response = $response->withStatus(200)->withHeader('Content-type', 'application/json;charset=utf-8')->write(json_encode(['codigo' => 1,'mensaje'=>"Agregado ok"]));
    }else{
      $response = $response->withStatus(200)->withHeader('Content-type', 'application/json;charset=utf-8')->write(json_encode(['codigo' => 0,'mensaje'=>"Ya existe"]));
    }
    
    /*$response = $response->withHeader('Content-type', 'application/json')
             ->getBody()->write(json_encode($denuncia->InsertOrUpdate($data)));*/
   
    }catch(Exception $e){
   $response = $response->withHeader('Content-type', 'application/json')
             ->getBody()->write(json_encode(['codigo' => 2,'mensaje'=>"ERROR"]));
    }
      return $response;

    });

  $this->post('altaprueba',function($req, $res, $args){
   $params=$req->getParams();
    $nombre2=$params['nombre'];
    $descripcion2=$params['descripcion'];
    $longitud2=$params['longitud'];
    $latitud2=$params['latitud'];
    $idEstado2=1;
    $activo2=1;


  try{

    $data2=[$nombre2,
    $descripcion2,
   $longitud2,
    $latitud2,
    "cosos",
   $idEstado2,
    $activo2];


    $denuncia = new DenunciaModel();
   $respuesta=$denuncia->insert($data2);
      return $res
             ->withHeader('Content-type', 'application/json')
             ->getBody()
             ->write(json_encode($denuncia->insert($data2)));

  }
      
      
  catch(Exception $e){
    return $res->withHeader('Content-type', 'application/json')
             ->getBody()->write(json_encode(['codigo' => 2,'mensaje'=>$e]));
    }




  });

  $this->get('eventos',function($req,$res,$args){
  try{  
    $dm = new DenunciaModel();
    $eventos=$dm->getEventos();
    return $res->withStatus(200)->withHeader('Content-type', 'application/json;charset=utf-8')->write(json_encode(['codigo' => 1,'mensaje'=>"OK",'eventos'=> $eventos]));

  }catch(Exception $e){
    return $res->withHeader('Content-type', 'application/json')
             ->getBody()->write(json_encode(['codigo' => 2,'mensaje'=>$e]));}


  });

});