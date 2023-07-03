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
            $path_foto = "./fotos/" . $params->correo . "_" . $idSiguiente . "." . $extension[0];
            
            $usuarioNuevo = new Usuario($idSiguiente ,$params->correo, $params->clave, $params->nombre, $params->apellido, $path_foto , $params->id_perfil);
        
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
    }
}