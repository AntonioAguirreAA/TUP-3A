<?php
require_once("./clases/neumatico.php");
header("Access-Control-Allow-Origin: *");

$neumaticos = Aguirre\Antonio\Neumatico::traerJSON('./archivos/neumaticos.json');

$neumaticosArray = array();
foreach ($neumaticos as $neumatico) {
    $neumaticosArray[] = array(
        'marca' => $neumatico->getMarca(),
        'medidas' => $neumatico->getMedidas(),
        'precio' => $neumatico->getPrecio()
    );
}

echo json_encode($neumaticosArray);