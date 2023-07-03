<?php
require_once("./clases/neumatico.php");
header("Access-Control-Allow-Origin: *");

$marca = isset($_POST["marca"]) ? $_POST["marca"] : NULL;
$medidas = isset($_POST["medidas"]) ? $_POST["medidas"] : NULL;
$precio = isset($_POST["precio"]) ? (float) $_POST["precio"] : 0;

$neumatico = new Aguirre\Antonio\Neumatico($marca, $medidas, $precio);

echo $neumatico->guardarJSON('./archivos/neumaticos.json');