<?php

use Aguirre\Antonio\Neumatico;
use Aguirre\Antonio\NeumaticoDB;

require_once("./clases/neumatico.php");
require_once("./clases/IParte1.php");
require_once("./clases/neumaticoDB.php");

$neumatico_json = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;

$json = json_decode($neumatico_json);
$neumatico = new NeumaticoDB($json->marca,$json->medidas,$json->precio,$json->id,"");

if($neumatico->modificar())
{
    echo "Se modifico el neumatico " . var_dump($neumatico);
}