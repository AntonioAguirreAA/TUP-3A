<?php
namespace Aguirre\Antonio;
use stdClass;

class Neumatico
{
    protected string $marca;
    protected string $medidas;
    protected float $precio;

    public function getMarca()
    {
        return $this->marca;
    }

    public function getMedidas()
    {
        return $this->medidas;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function __construct(string $marca, string $medidas, float $precio)
    {
        $this->marca = $marca;
        $this->medidas = $medidas;
        $this->precio = $precio;
    }

    public function toJson() : string
    {
        $obj = new StdClass();
        $obj->marca = $this->marca;
        $obj->medidas = $this->medidas;
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
            $retorno->mensaje = "Se escribió el usuario {$json} correctamente.";
        }   else    {
            $retorno->exito = false;
            $retorno->mensaje = "Error";
        }
        fclose($archivo);
        
        return json_encode($retorno);
    }

    public static function traerJSON(string $path) : array
    {
        $listaNeumaticos = array();
        $archivo = fopen($path,"r");
        if($archivo != false)   
        {
            while (!feof($archivo))
            {
                $neumaticoArchivo = fgets($archivo);
                $atributosNeumatico = json_decode(trim($neumaticoArchivo));
                if($atributosNeumatico != NULL)
                {
                    $neumatico = new Neumatico($atributosNeumatico->marca,
                                            $atributosNeumatico->medidas,
                                            $atributosNeumatico->precio);                        
                    array_push($listaNeumaticos,$neumatico);
                }
            }

        }
        fclose($archivo);
        return $listaNeumaticos;
    }

    public static function verificarNeumaticoJSON(Neumatico $neumatico , string $path) : string
    {
        $neumaticos = Neumatico::traerJSON($path);

        $retorno = new stdClass();
        $retorno->existe = false;
        $retorno->mensaje = "";

        $suma = 0;

        foreach ($neumaticos as $neumaticoLista) {
            if($neumatico->marca == $neumaticoLista->marca && $neumatico->medidas == $neumaticoLista->medidas)
            {
                $retorno->existe = true;
                $suma += $neumaticoLista->precio;
            }
        }
        if($retorno->existe)
        {
            $retorno->mensaje = "La suma de los precios de todos los neumaticos similares es de {$suma}.";
        }   else    {
            $retorno->mensaje = "No se encontro el neumatico";
        }

        return json_encode($retorno);
    }
}

?>