<?php

use Aguirre\Antonio\NeumaticoDB;

require_once("neumaticoDB.php");

interface IParte2
{
    static function eliminar(int $id) : bool;
	
    function modificar() : bool;	
}