<?php

require_once("./clases/neumatico.php");
require_once("./clases/IParte1.php");
require_once("./clases/neumaticoDB.php");

header("Access-Control-Allow-Origin: *");

$neumaticos = Aguirre\Antonio\NeumaticoDB::traer();

if (isset($_GET['tabla']) && $_GET['tabla'] === 'mostrar') {
    echo '<table border="1"><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th><th>Foto</th><th>Accion</th></tr></thead><tbody>';

    foreach ($neumaticos as $neumatico) {
        echo '<tr>';
        echo '<td>' . $neumatico->getMarca() . '</td>';
        echo '<td>' . $neumatico->getMedidas() . '</td>';
        echo '<td>' . $neumatico->getPrecio() . '</td>';
        if($neumatico->getPathFoto() == "")
        {
            echo '<td>Sin foto</td>';
        }   else    {
            echo '<td><img src="' . $neumatico->getPathFoto() . '" width="50px" height="50px"></td>';
        }
        echo '<td><input type="button" value="Eliminar" class="btn btn-danger" onclick="PrimerParcial.Manejadora.EliminarNeumatico('.$neumatico->toJSON().')" />
        <input type="button" value="Modificar" class="btn btn-dark" onclick="" /></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    $neumaticosArray = array();

    foreach ($neumaticos as $neumatico) {
        $json = new stdClass();
        $json->marca = $neumatico->getMarca();
        $json->medidas = $neumatico->getMedidas();
        $json->precio = $neumatico->getPrecio();
        $json->pathFoto = $neumatico->getPathFoto();
        array_push($neumaticosArray, $json);
    }

    echo json_encode($neumaticosArray);
}