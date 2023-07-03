<?php
require_once("./clases/auto.php");

$lista = Aguirre\Antonio\Auto::traerJSON('./archivos/autos.json');

$listaJson = array();
foreach($lista as $auto)
{
    array_push($listaJson, $auto->toJson());
}

echo json_encode($listaJson);