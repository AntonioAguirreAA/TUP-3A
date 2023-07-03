<?php
require_once("./clases/neumatico.php");
header("Access-Control-Allow-Origin: *");

$marca = isset($_POST["marca"]) ? $_POST["marca"] : NULL;
$medidas = isset($_POST["medidas"]) ? $_POST["medidas"] : NULL;

$neumatico = new Aguirre\Antonio\Neumatico($marca, $medidas, 0);

echo Aguirre\Antonio\Neumatico::verificarNeumaticoJSON($neumatico,'./archivos/neumaticos.json');