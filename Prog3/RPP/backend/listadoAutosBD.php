<?php

require_once("./clases/auto.php");
require_once("./clases/IParte1.php");
require_once("./clases/autoBD.php");

header("Access-Control-Allow-Origin: *");

$autos = Aguirre\Antonio\AutoDB::traer();

if (isset($_GET['tabla']) && $_GET['tabla'] === 'mostrar') {
    echo '<table border="1"><thead><tr><th>Patente</th><th>Marca</th><th>Color</th><th>Precio</th><th>Foto</th></tr></thead><tbody>';

    foreach ($autos as $auto) {
        echo '<tr>';
        echo '<td>' . $auto->getPatente() . '</td>';
        echo '<td>' . $auto->getMarca() . '</td>';
        echo '<td>' . $auto->getColor() . '</td>';
        echo '<td>' . $auto->getPrecio() . '</td>';
        if($auto->getPathFoto() == "")
        {
            echo '<td>Sin foto</td>';
        }   else    {
            echo '<td><img src="' . $auto->getPathFoto() . '" width="50px" height="50px"></td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    $autosArray = array();

    foreach ($autos as $auto) {
        $json = new stdClass();
        $json->patente = $auto->getPatente();
        $json->marca = $auto->getMarca();
        $json->color = $auto->getColor();
        $json->precio = $auto->getPrecio();
        $json->pathFoto = $auto->getPathFoto();
        array_push($autosArray, $json);
    }

    echo json_encode($autosArray);
}