<?php

require_once("./clases/neumatico.php");
require_once("./clases/IParte1.php");
require_once("./clases/neumaticoDB.php");

$neumaticos = Aguirre\Antonio\NeumaticoDB::traer();

echo "Marca - Medidas - Precio\r\n";
foreach ($neumaticos as $neumatico) {
    echo $neumatico->mostrar() . "\r\n";
}