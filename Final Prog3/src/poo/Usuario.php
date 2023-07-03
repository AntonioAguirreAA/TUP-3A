<?php
namespace Aguirre\Antonio
{
    use Firebase\JWT\JWT;
    use PDOException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use \stdClass;
    use \PDO;

    class Usuario

    {
        public $id;
        public $correo;
        public $clave;
        public $nombre;
        public $apellido;
        public $foto;
        public $id_perfil;

        public function __construct($id = 0, $correo = "", $clave = "", $nombre = "", $apellido = "", $foto = "", $id_perfil = "")
        {
            $this->id = $id;
            $this->correo = $correo;
            $this->clave = $clave;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->foto = $foto;
            $this->id_perfil = $id_perfil;
        }


        public static function Alta(Request $request, Response $response, $args)
        {
            $idSiguiente = Usuario::getSiguienteId();
            if($idSiguiente != "error")
            {
            $params=$request->getParsedBody();
            $usuario=$params['usuario'];

            $archivos=$request->getUploadedFiles();
            $destino = __DIR__ . "/../fotos/";

            $params=json_decode($usuario);
        
            $nombreAnterior = $archivos['foto']->getClientFilename();
            $extension = explode(".", $nombreAnterior);
            $extension = array_reverse($extension);
            $archivos['foto']->moveTo($destino . $params->correo . "_" . $idSiguiente . "." . $extension[0]);
            $path_foto = $idSiguiente . "_" . $params->apellido . "." . $extension[0];
            
            $usuarioNuevo=new Usuario($idSiguiente ,$params->correo, $params->clave, $params->nombre, $params->apellido, $path_foto , $params->id_perfil);
        
                $objRetorno = new stdClass();
                $objRetorno->exito = true;
                $objRetorno->mensaje ="Alta de usuario exitosa";
                try
                {
                    $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                    $query = $conexion->prepare("INSERT INTO `usuarios` (`id`, `correo`, `clave`, `nombre`, `apellido`, `foto`, `id_perfil`)
                                               VALUES ('$usuarioNuevo->id','$usuarioNuevo->correo', '$usuarioNuevo->clave', '$usuarioNuevo->nombre', '$usuarioNuevo->apellido', '$usuarioNuevo->foto', '$usuarioNuevo->id_perfil')");
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
                $query = $conexion->prepare("SELECT * FROM usuarios");
                $query->execute();
                $arrayUsuarios = $query->fetchAll();
                $id = 0;
                foreach ($arrayUsuarios as $key) {
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
                $query = $conexion->prepare("SELECT * FROM usuarios");
                $query->execute();
                $arrayUsuarios = $query->fetchAll();
                $jsonUsuarios = json_encode($arrayUsuarios);
                $objRetorno->exito=true;
                $objRetorno->mensaje="Json obtenido con exito";
                $objRetorno->dato = $jsonUsuarios;
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

        public static function Login(Request $request, Response $response, $args)
        {
            $objRetorno = new stdClass();
            $objRetorno->exito=true;
            $objRetorno->mensaje="Usuario no encontrado";
            $params=$request->getParsedBody();
            $usuarioObtenido=$params['user'];
            $listado = (Usuario::Traer());
            $params=json_decode($usuarioObtenido);
            
            if($listado !="error")
            {
                foreach ($listado as $key) {
                    if($params->correo == $key['correo'] && $params->clave == $key['clave']){
                        $encontrado = $key;
                        
                    }
                }
                if(isset($encontrado))
                {
                $objRetorno->exito=true;
                $objRetorno->mensaje="Exito al traer usuario";
                $Usuario = new stdClass();
                $Usuario->id=$encontrado['id'];
                $Usuario->correo=$encontrado['correo'];
                $Usuario->nombre=$encontrado['nombre'];
                $Usuario->apellido=$encontrado['apellido'];
                $Usuario->foto=$encontrado['foto'];
                $Usuario->perfil=$encontrado['id_perfil'];
                $ahora = time();
                $payload = array(
                    'iat' => $ahora,
                    'exp' => $ahora +(45),
                    'data' => $Usuario,
                );
                $token = jwt::encode($payload, "claveSecreta");
                $objRetorno->token=$token;
                $objRetorno->exito=true;
                $objRetorno->mensaje="Usuario encontrado";
                $response->getBody()->write((string)json_encode($objRetorno, 200));
                return $response = $response->withHeader('Content-Type', 'application/json');
                }
                //$UsuarioEncontrado = new Usuario($encontrado['id'], $encontrado['correo'], $encontrado['clave'], $encontrado['nombre'], $encontrado['apellido'], $encontrado['foto'], $encontrado['id_perfil']);
                else
                {
                    $objRetorno->exito=false;
                    $objRetorno->mensaje="No se encontro al usuario";
                    $response->getBody()->write((string)json_encode($objRetorno, 418));    
                    return $response;
                }
            }
            else
            {
                    $objRetorno->exito=false;
                    $objRetorno->mensaje="No se pudo acceder a la base de datos";
                    $response->getBody()->write((string)json_encode($objRetorno, 418));    
                    return $response;
            }
            $response->getBody()->write((string)json_encode($objRetorno, 418));    
            return $response;

        }

        public static function Traer()
        {
            try
            {
                $conexion = new PDO("mysql:host=localhost;dbname=administracion_bd", "root", "");
                $query = $conexion->prepare("SELECT * FROM usuarios");
                $query->execute();
                $arrayUsuarios = $query->fetchAll();
                return $arrayUsuarios;
            }
            catch(PDOException $e)
            {
                return "error";
            }
        }

        public static function LoginToken(Request $request, Response $response, $args)
        {
            $param=$request->getHeader('token');
            $token=$param[0];
            $clave="claveSecreta";
            $objRetorno = new stdClass();
            $objRetorno->exito=true;
            $objRetorno->mensaje="token correcto";

            try
            {
                $decodificado=JWT::decode($token, $clave ,array('HS256'));
            }
            catch(\Exception $e)
            {
                $objRetorno->exito=false;
                $objRetorno->mensaje="token invalido";
                $response->getBody()->write((string)json_encode($objRetorno, 403));
                return $response = $response->withHeader('Content-Type', 'application/json');
            }
            $response->getBody()->write((string)json_encode($objRetorno, 200));
                return $response = $response->withHeader('Content-Type', 'application/json');
        }

        public static function Borrar(Request $request, Response $response, $args)
        {
            
            $params=$request->getBody();
            $perfil=json_decode($params);
            $perfil=$perfil->id_usuario;
    
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
                    $query = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
                    $query->bindValue(':id', $perfil, PDO::PARAM_INT);
                    $query->execute();
                    $objRetorno->exito=true;
                    $objRetorno->mensaje="Se elimino al usuario con exito";
                    $response->getBody()->write((string)json_encode($objRetorno), 200);
                }
                catch(\Exception $e)
                {
                    $objRetorno->exito=false;
                    $objRetorno->mensaje="No se encontro al usuario";
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