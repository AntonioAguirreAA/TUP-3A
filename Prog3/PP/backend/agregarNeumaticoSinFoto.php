<?php

require_once("./clases/neumatico.php");
require_once("./clases/IParte1.php");
require_once("./clases/neumaticoDB.php");

$neumatico_json = isset($_POST["neumatico_json"]) ? $_POST["neumatico_json"] : NULL;

$neumaticoDecodeado = json_decode($neumatico_json);

$neumatico = new Aguirre\Antonio\NeumaticoDB($neumaticoDecodeado->marca,
                            $neumaticoDecodeado->medidas,
                            (float)$neumaticoDecodeado->precio,
                            0,
                            "");

$retorno = new stdClass();

if($neumatico->agregar())
{
    $retorno->exito = true;
    $retorno->mensaje = "Neumatico agregado a la BD";
}   else    {
    $retorno->exito = false;
    $retorno->mensaje = "No pudo ser agregado";
}

var_dump ($retorno);
return $retorno;