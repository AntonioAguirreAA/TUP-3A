<?php
namespace Aguirre\Antonio
{
    use Firebase\JWT\JWT;
    use PDOException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use \stdClass;
    use \PDO;

    class Perfiles
    {
        public $id;
        public $descripcion;
        public $estado;

        public function __construct($id=0, $descripcion="", $estado=0)
        {
            $this->id=$id;
            $this->descripcion=$descripcion;
            $this->estado=$estado;
        }

        public static function Alta(Request $request, Response $response, $args)
        {
            $idSiguiente = Perfiles::getSiguienteId();
            if($idSiguiente != "error")
            {
            $params=$request->getParsedBody();
            $perfil=$params['perfil'];

            $params=json_decode($perfil);
        
            
            $perfilNuevo=new Perfiles($idSiguiente, $params->descripcion, $params->estado);
        
                $objRetorno = new stdClass();
                $objRetorno->exito = true;
                $objRetorno->mensaje ="Alta de perfil exitosa";
                try
                {
                    $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                    $query = $conexion->prepare("INSERT INTO `perfiles` (`id`, `descripcion`, `estado`)
                                               VALUES ('$perfilNuevo->id','$perfilNuevo->descripcion', '$perfilNuevo->estado')");
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

        public static function Listado(Request $request, Response $response, $args)
        {
            $objRetorno = new stdClass();
            $objRetorno->exito=true;

            try
            {
                $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                $query = $conexion->prepare("SELECT * FROM perfiles");
                $query->execute();
                $arrayPerfiles = $query->fetchAll();
                $jsonPerfiles = json_encode($arrayPerfiles);
                $objRetorno->exito=true;
                $objRetorno->mensaje="Json obtenido con exito";
                $objRetorno->dato = $jsonPerfiles;
                $response->getBody()->write((string)json_encode($objRetorno, 200));
            }
            catch(PDOException $e)
            {
                $objRetorno->exito=false;
                $objRetorno->mensaje=$e->getMessage();
                $response->getBody()->write((string)json_encode($objRetorno, 424));
            }
            return $response = $response->withHeader('Content-Type', 'application/json');
        }

        public static function Borrar(Request $request, Response $response, $args)
        {
            $idBorrar=$_GET['id_perfil'];
            $objRetorno = new stdClass();
            $param=$request->getHeader('token');
            $token=$param[0];
            $clave="claveSecreta";
            try
            {
                $decodificado=JWT::decode($token, $clave, array('HS256'));
                try
                {
                    $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                    $query = $conexion->prepare("DELETE FROM perfiles WHERE id = :id");
                    $query->bindValue(':id', $idBorrar, PDO::PARAM_INT);
                    $query->execute();
                    $objRetorno->exito=true;
                    $objRetorno->mensaje="Se elimino al perfil con exito";
                    $response->getBody()->write((string)json_encode($objRetorno), 200);
                }
                catch(\Exception $e)
                {
                    $objRetorno->exito=false;
                    $objRetorno->mensaje="No se encontro al perfil";
                    $response->getBody()->write((string)json_encode($objRetorno, 418));    
                    return $response;
                }
            }
            catch(\Exception $e)
            {
                $objRetorno->exito=false;
                $objRetorno->mensaje="token invalido";
                $response->getBody()->write((string)json_encode($objRetorno, 403));
                return $response = $response->withHeader('Content-Type', 'application/json');
            }
            return $response = $response->withHeader('Content-Type', 'application/json');
        }


        public static function Modificar(Request $request, Response $response, $args)
        {
            $idModificar=$_GET['id_perfil'];
            $params=$_GET['perfil'];
            $perfil=json_decode($params);

            $objRetorno = new stdClass();
            $param=$request->getHeader('token');
            $token=$param[0];
            $clave="claveSecreta";
            try
            {
                $decodificado=JWT::decode($token, $clave, array('HS256'));
                try
                {
                    $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                    $query = $conexion->prepare("UPDATE perfiles 
                                                SET descripcion = :descripcion, estado = :estado
                                                WHERE id = :id");
                    $query->bindValue(':id', $idModificar, PDO::PARAM_INT);
                    $query->bindValue(':descripcion', $perfil->descripcion, PDO::PARAM_STR);
                    $query->bindValue(':estado', $perfil->estado, PDO::PARAM_INT);
                    if($query->execute())
                    {
                        $objRetorno->exito=true;
                        $objRetorno->mensaje="Se modifico al perfil con exito";
                        $response->getBody()->write((string)json_encode($objRetorno), 200);    
                    }
                    else
                    {
                        $objRetorno->exito=false;
                        $objRetorno->mensaje="No se pudo modificar el perfil";
                        $response->getBody()->write((string)json_encode($objRetorno, 418));    
                        return $response;
                    }
                }
                catch(\Exception $e)
                {
                    $objRetorno->exito=false;
                    $objRetorno->mensaje="No se pudo modificar el perfil";
                    $response->getBody()->write((string)json_encode($objRetorno, 418));    
                    return $response;
                }
            }
            catch(\Exception $e)
            {
                $objRetorno->exito=false;
                $objRetorno->mensaje="token invalido";
                $response->getBody()->write((string)json_encode($objRetorno, 403));
                return $response = $response->withHeader('Content-Type', 'application/json');
            }
            return $response = $response->withHeader('Content-Type', 'application/json');
        }
    }



}