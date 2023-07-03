<?php

use Aguirre\Antonio\Auto;
use Aguirre\Antonio\AutoDB;

require_once("./clases/auto.php");
require_once("./clases/IParte1.php");
require_once("./clases/IParte2.php");
require_once("./clases/autoBD.php");

$auto_json = isset($_POST["auto_json"]) ? $_POST["auto_json"] : NULL;

$json = json_decode($auto_json);
$auto = new AutoDB($json->patente,$json->marca,$json->color,$json->precio,"");

if($auto->modificar())
{
    echo "Se modifico el auto " . $auto->Mostrar();
}