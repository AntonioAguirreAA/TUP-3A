<?php
namespace Aguirre\Antonio
{
    use Firebase\JWT\JWT;
    use PDOException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use \stdClass;
    use \PDO;

    class Auto
    {
        public $id;
        public $color;
        public $marca;
        public $precio;
        public $modelo;

        public function __construct($id=0, $color = "" , $marca = "" , $precio = 0 , $modelo = "")
        {
            $this->id = $id;
            $this->color = $color;
            $this->marca = $marca;
            $this->precio = $precio;
            $this->modelo = $modelo;
        }
    }
}