<?php
namespace Aguirre\Antonio;
use stdClass;

class Auto
{
    protected string $patente;
    protected string $marca;
    protected string $color;
    protected float $precio;

    public function getPatente()
    {
        return $this->patente;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function __construct(string $patente, string $marca, string $color, float $precio)
    {
        $this->patente = $patente;
        $this->marca = $marca;
        $this->color = $color;
        $this->precio = $precio;
    }

    public function toJson() : string
    {
        $obj = new StdClass();
        $obj->patente = $this->patente;
        $obj->marca = $this->marca;
        $obj->color = $this->color;
        $obj->precio = $this->precio;
        $cadenaJson = json_encode($obj);

        return $cadenaJson;
    }

    public function guardarJSON(string $path) : string
    {
        $retorno = new StdClass();
        $archivo = fopen($path,"a");
        $json = $this->toJson() . "\r\n";
        if(fwrite($archivo,$json) != 0)
        {
            $retorno->exito = true;
            $retorno->mensaje = "Se escribió el auto {$json} correctamente.";
        }   else    {
            $retorno->exito = false;
            $retorno->mensaje = "Error";
        }
        fclose($archivo);
        
        return json_encode($retorno);
    }

    public static function traerJSON(string $path) : array
    {
        $listaAutos = array();
        $archivo = fopen($path,"r");
        if($archivo != false)   
        {
            while (!feof($archivo))
            {
                $autoArchivo = fgets($archivo);
                $atributosAuto = json_decode(trim($autoArchivo));
                if($atributosAuto != NULL)
                {
                    $auto = new Auto($atributosAuto->patente,
                                            $atributosAuto->marca,
                                            $atributosAuto->color,
                                            $atributosAuto->precio);                        
                    array_push($listaAutos,$auto);
                }
            }

        }
        fclose($archivo);
        return $listaAutos;
    }

    public static function verificarAutoJSON(Auto $auto , string $path) : string
    {
        $autos = Auto::traerJSON($path);

        $retorno = new stdClass();
        $retorno->existe = false;
        $retorno->mensaje = "";

        foreach ($autos as $autoLista) {
            if($auto->patente == $autoLista->patente)
            {
                $retorno->existe = true;
            }
        }
        if($retorno->existe)
        {
            $retorno->mensaje = "El auto se encuentra en el listado!!";
        }   else    {
            $retorno->mensaje = "No se encontro el auto";
        }

        return json_encode($retorno);
    }
}

?>