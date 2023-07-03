<?php
namespace Aguirre\Antonio;
require_once "accesoDatos.php";
require_once "IParte1.php";
require_once "IParte2.php";


use IParte1;
use IParte2;
use stdClass;
use PDO;

class AutoDB extends Auto implements IParte1, IParte2
{
    protected string $pathFoto;

    public function getPathFoto()
    {
        return $this->pathFoto;
    }

    public function __construct(string $patente, string $marca, string $color, float $precio, string $pathFoto)
    {
        parent::__construct($patente, $marca, $color, $precio);
        $this->pathFoto = $pathFoto;
    }

    public function toJson() : string
    {
        $obj = new StdClass();
        $obj->patente = $this->patente;
        $obj->marca = $this->marca;
        $obj->color = $this->color;
        $obj->precio = $this->precio;
        $obj->pathFoto = $this->pathFoto;
        $cadenaJson = json_encode($obj);

        return $cadenaJson;
    }

    function agregar() : bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO autos (patente, marca, color, precio, foto)"
                                                    . "VALUES(:patente, :marca, :color, :precio, :foto)");
        

        
        $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

        return $consulta->execute();
    }

    static function traer() : array
    {
        $autos = array();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->retornarConsulta('SELECT patente AS patente, marca AS marca, color AS color, precio AS precio, foto AS pathFoto FROM autos');        
        
        $consulta->execute();
        
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) 
        {
            if($fila["pathFoto"] == NULL)
            {
                $fila["pathFoto"] = "";
            }
            $auto = new AutoDB($fila["patente"],$fila["marca"],$fila["color"],$fila["precio"],$fila["pathFoto"]);
            array_push($autos,$auto);
        }

        return $autos;
    }

    static function eliminar(string $patente) : bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM autos WHERE patente = :patente");
        
        $consulta->bindValue(':patente', $patente, PDO::PARAM_STR);

        return $consulta->execute();
    }

    function modificar() : bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("UPDATE autos SET marca = :marca, color = :color, 
                                                        precio = :precio, foto = :foto WHERE patente = :patente");
        
        $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

        return $consulta->execute();
    }

    public function mostrar()
    {
        return $this->patente . " - " . $this->marca . " - " . $this->color . " - " . $this->precio;
    }
}