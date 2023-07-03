<?php

require_once("./clases/auto.php");
require_once("./clases/IParte1.php");
require_once("./clases/autoBD.php");

header("Access-Control-Allow-Origin: *");

$auto_json = isset($_POST["auto_json"]) ? $_POST["auto_json"] : NULL;

$autoDecodeado = json_decode($auto_json);

$auto = new Aguirre\Antonio\AutoDB($autoDecodeado->patente,
                            $autoDecodeado->marca,
                            $autoDecodeado->color,
                            (float)$autoDecodeado->precio,
                            "");

$retorno = new stdClass();

if($auto->agregar())
{
    $retorno->exito = true;
    $retorno->mensaje = "Auto agregado a la BD";
}   else    {
    $retorno->exito = false;
    $retorno->mensaje = "No pudo ser agregado";
}

echo json_encode($retorno);