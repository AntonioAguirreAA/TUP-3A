<?php
namespace Animalitos;

class Mascota
{
    public string $nombre;
    public string $tipo;
    public int $edad;

    public function __construct(string $nombre, string $tipo, int $edad = 0) {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->edad = $edad;  
    }

    public function toString() : string
    {
        return "{$this->nombre} - {$this->tipo} - {$this->edad}";
    }

    public static function mostrar(Mascota $mascota) : string
    {
        return $mascota->toString();
    }

    public function Equals(Mascota $mascota) : bool
    {
        return ($this->nombre == $mascota->nombre && $this->tipo == $mascota->tipo);
    }
}

?>