<?php
namespace Aguirre\Antonio
{
    use Firebase\JWT\JWT;
    use PDOException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use \stdClass;
    use \PDO;

    class Auto
    {
        public $id;
        public $color;
        public $marca;
        public $precio;
        public $modelo;

        public function __construct($id=0, $color = "" , $marca = "" , $precio = 0 , $modelo = "")
        {
            $this->id = $id;
            $this->color = $color;
            $this->marca = $marca;
            $this->precio = $precio;
            $this->modelo = $modelo;
        }

        public static function Alta(Request $request, Response $response, $args)
        {
            $idSiguiente = Perfiles::getSiguienteId();
            if($idSiguiente != "error")
            {
            $params=$request->getParsedBody();
            $auto=$params['auto'];

            $params=json_decode($auto);
        
            
            $autoNuevo=new Auto($idSiguiente, $params->color, $params->marca, $params->precio, $params->modelo);
        
                $objRetorno = new stdClass();
                $objRetorno->exito = true;
                $objRetorno->mensaje ="Alta de auto exitosa";
                try
                {
                    $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                    $query = $conexion->prepare("INSERT INTO `autos` (`id`, `descripcion`, `estado`)
                                               VALUES ('$autoNuevo->id','$perfilNuevo->descripcion', '$perfilNuevo->estado')");
                    $query->execute();
                } 
                catch(PDOException $e)
                {
                    $objRetorno->exito=false;
                    $objRetorno->mensaje=$e->getMessage();
                    $response->getBody()->write((string)json_encode($objRetorno, 418));    
                    return $response;
                }
                $response->getBody()->write((string)json_encode($objRetorno, 200));
                $response = $response->withHeader('Content-Type', 'application/json');
                return $response;
        
        }   
        else
        {
            $objRetorno2 = new stdClass();
            $objRetorno2->exito=false;
            $objRetorno2->mensaje="No se pudo acceder a la base de datos";
            $response->getBody()->write((string)json_encode($objRetorno2, 418));    
            return $response;
        }

        }

        public static function getSiguienteId()
        {
            try
            {
                $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                $query = $conexion->prepare("SELECT * FROM perfiles");
                $query->execute();
                $arrayperfiles = $query->fetchAll();
                $id = 0;
                foreach ($arrayperfiles as $key) {
                    for ($id=0; $id!=$key['id'] ; $id++) { 
                    }
                }
                $id++;
                return $id;
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
            
        }
    }
}