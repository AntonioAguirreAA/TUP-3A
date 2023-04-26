<?php
namespace Negocios;
require_once "Clases/Mascota.php";
use Animalitos\Mascota as Mascota;

class Guarderia
{
    public string $nombre;
    public $mascotas;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
        $this->mascotas = array();
    }

    public static function Equals(Guarderia $guarderia, Mascota $mascota) : bool
    {
        foreach ($guarderia->mascotas as $mascotaLista) {
            if ($mascota->Equals($mascotaLista))
            {
                return true;
            }
        }
        return false;
    }

    public function add(Mascota $mascota) : bool
    {
        if(Guarderia::Equals($this, $mascota))
        {
            return false;
        }   else    {
            array_push($this->mascotas,$mascota);
            return true;
        }
    }

    public function toString()
    {
        $suma = 0;
        $conteo = 0;
        $retorno = "Listado {$this->nombre}:<br>";
        foreach ($this->mascotas as $mascota ) {
            $retorno .= $mascota->toString()."<br>";
            $suma += $mascota->edad;
            $conteo ++;
        }
        $valor = $suma/$conteo;
        return $retorno."El promedio de edad es de {$valor}";
    }

}

?>