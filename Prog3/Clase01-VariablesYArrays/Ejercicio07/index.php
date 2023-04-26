<?php

/**Aplicación No 7 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple. */

$fecha = date("d/m/Y");
echo $fecha . "<br/>";

$fecha = date("F j, Y");
echo $fecha . "<br>";

$fecha = date('d \, F');
echo $fecha . "<br/>";

$fecha = date("m");

switch ($fecha) {
    case '1':
        echo "Estamos en verano<br/>";
        break;
    case '2':
        echo "Estamos en verano<br/>";
        break;
    case '3':
        echo "Estamos en otoño<br/>";
        break;
    case '4':
        echo "Estamos en otoño<br/>";
        break;
    case '5':
        echo "Estamos en otoño<br/>";
        break;
    case '6':
        echo "Estamos en invierno<br/>";
        break;
    case '7':
        echo "Estamos en invierno<br/>";
        break;
    case '8':
        echo "Estamos en invierno<br/>";
        break;
    case '9':
        echo "Estamos en primavera<br/>";
        break;
    case '10':
        echo "Estamos en primavera<br/>";
        break;
    case '11':
        echo "Estamos en primavera<br/>";
        break;
    case '12':
        echo "Estamos en verano<br/>";
        break;
    
}
?>