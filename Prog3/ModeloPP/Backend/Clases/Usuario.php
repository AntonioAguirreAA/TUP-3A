<?php

class Usuario
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct(int $id, string $nombre, string $correo, string $clave, int $id_perfil, string $perfil)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }

    public function ToJson() : string
    {
        $obj = new StdClass();
        $obj->id = $this->id;
        $obj->nombre = $this->nombre;
        $obj->correo = $this->correo;
        $obj->clave = $this->clave;
        $obj->id_perfil = $this->id_perfil;
        $obj->perfil = $this->perfil;
        $cadenaJson = json_encode($obj);

        return $cadenaJson;
    }

    public function GuardarEnArchivo() : string
    {
        $retorno = new StdClass();
        $archivo = fopen("./Backend/Archivos/usuarios.json","a");
        $json = $this->ToJson() . "\r\n";
        if(fwrite($archivo,$json) != 0)
        {
            $retorno->exito = true;
            $retorno->mensaje = "Se escribió el usuario {$json} correctamente.";
        }   else    {
            $retorno->exito = false;
            $retorno->mensaje = "Error";
        }
        fclose($archivo);
        
        return json_encode($retorno);
    }

    public static function TraerTodosJson() : array
    {
        $listaUsuarios = array();
        $archivo = fopen("./Backend/Archivos/usuarios.json","r");
        if($archivo != false)   
        {
            while (!feof($archivo))
            {
                $usuarioArchivo = fgets($archivo);
                $atributosUsuario = json_decode(trim($usuarioArchivo));
                if($atributosUsuario != NULL)
                {
                    $usuario = new Usuario($atributosUsuario->id,
                                            $atributosUsuario->nombre,
                                            $atributosUsuario->correo,
                                            $atributosUsuario->clave,
                                            $atributosUsuario->id_perfil,
                                            $atributosUsuario->perfil);                        
                    array_push($listaUsuarios,$usuario);
                }
            }

        }
        fclose($archivo);
        return $listaUsuarios;
    }
}

?>