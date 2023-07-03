<?php
require_once("./clases/auto.php");

$patente = isset($_POST["patente"]) ? $_POST["patente"] : NULL;
$marca = isset($_POST["marca"]) ? $_POST["marca"] : NULL;
$color = isset($_POST["color"]) ? $_POST["color"] : NULL;
$precio = isset($_POST["precio"]) ? (float) $_POST["precio"] : 0;

$neumatico = new Aguirre\Antonio\Auto($patente, $marca, $color, $precio);

echo $neumatico->guardarJSON('./archivos/autos.json');