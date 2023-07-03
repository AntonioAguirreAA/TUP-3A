<?php

use Aguirre\Antonio\Neumatico;

require_once("./clases/neumatico.php");
require_once("./clases/IParte1.php");
require_once("./clases/neumaticoDB.php");

$neumatico_json = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;

$neumatico = json_decode($neumatico_json);

if(\Aguirre\Antonio\NeumaticoDB::eliminar($neumatico->id))
{
    $guardar = new Neumatico($neumatico->marca,$neumatico->medidas,$neumatico->precio);
    echo $guardar->guardarJSON('./archivos/neumaticos.json');
}