<?php

use Aguirre\Antonio\Auto;
use Aguirre\Antonio\AutoDB;

require_once("./clases/auto.php");
require_once("./clases/IParte1.php");
require_once("./clases/IParte2.php");
require_once("./clases/autoBD.php");

$auto_json = isset($_POST["auto_json"]) ? $_POST["auto_json"] : NULL;

$auto = json_decode($auto_json);

if(\Aguirre\Antonio\AutoDB::eliminar($auto->patente))
{
    $guardar = new AutoDB($auto->patente,$auto->marca,$auto->color,$auto->precio,"");
    echo $guardar->guardarJSON('./archivos/autos_eliminados.json');
}