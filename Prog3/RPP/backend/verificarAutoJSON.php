<?php
require_once("./clases/auto.php");

$patente = isset($_POST["patente"]) ? $_POST["patente"] : NULL;

$auto = new Aguirre\Antonio\Auto($patente, "", "", 0);

echo Aguirre\Antonio\Auto::verificarAutoJSON($auto,'./archivos/autos.json');