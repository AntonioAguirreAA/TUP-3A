<?php
namespace Aguirre\Antonio;
require_once "accesoDatos.php";
require_once "IParte1.php";
require_once "IParte2.php";


use IParte1;
use IParte2;
use stdClass;
use PDO;

class NeumaticoDB extends Neumatico implements IParte1, IParte2
{
    protected int $id;
    protected string $pathFoto;

    public function __construct(string $marca, string $medidas, float $precio, int $id, string $pathFoto)
    {
        parent::__construct($marca, $medidas, $precio);
        $this->id = $id;
        $this->pathFoto = $pathFoto;
    }

    public function getPathFoto()
    {
        return $this->pathFoto;
    }

    public function toJson() : string
    {
        $obj = new StdClass();
        $obj->marca = $this->marca;
        $obj->medidas = $this->medidas;
        $obj->precio = $this->precio;
        $obj->id = $this->id;
        $obj->pathFoto = $this->pathFoto;
        $cadenaJson = json_encode($obj);

        return $cadenaJson;
    }

    function agregar() : bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO neumaticos (marca, medidas, precio, foto)"
                                                    . "VALUES(:marca, :medidas, :precio, :foto)");
        
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

        return $consulta->execute();
    }

    static function traer() : array
    {
        $neumaticos = array();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->retornarConsulta('SELECT marca AS marca, medidas AS medidas, precio AS precio , id AS id, foto AS pathFoto FROM neumaticos');        
        
        $consulta->execute();
        
        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) 
        {
            if($fila["pathFoto"] == NULL)
            {
                $fila["pathFoto"] = "";
            }
            $neumatico = new NeumaticoDB($fila["marca"],$fila["medidas"],$fila["precio"],$fila["id"],$fila["pathFoto"]);
            array_push($neumaticos,$neumatico);
        }

        return $neumaticos;
    }

    static function eliminar(int $id) : bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM neumaticos WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }

    function modificar() : bool
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("UPDATE neumaticos SET marca = :marca, medidas = :medidas, 
                                                        precio = :precio, foto = :foto WHERE id = :id");
        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':medidas', $this->medidas, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

        return $consulta->execute();
    }

    public function mostrar()
    {
        return $this->marca . " - " . $this->medidas . " - " . $this->precio;
    }
}