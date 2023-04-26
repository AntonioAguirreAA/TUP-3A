<?php

/**Aplicación No 8 (Números en letras)
Realizar un programa que en base al valor numérico de la variable $num, pueda mostrarse por
pantalla, el nombre del número que tenga dentro escrito con palabras, para los números entre
el 20 y el 60. */

$num = random_int(20,60);

if ($num == 20) {
    $decena = "Veinte";
}elseif ($num < 30) {
    $decena = "Veinti";
}elseif ($num == 30) {
    $decena = "Treinta";
}elseif ($num < 40) {
    $decena = "Treinta y ";
}elseif ($num == 40) {
    $decena = "Cuarenta";
}elseif ($num < 50) {
    $decena = "Cuarenta y ";
}elseif ($num == 50) {
    $decena = "Cincuenta";
}elseif ($num < 60) {
    $decena = "Cincuenta y ";
}elseif ($num == 60) {
    $decena = "Sesenta";
}

switch($num % 10)
{
    case 1:
        $decimal = "uno";
        break;
    case 2:
        $decimal = "dos";
        break;
    case 3:
        $decimal = "tres";
        break;
    case 4:
        $decimal = "cuatro";
        break;
    case 5:
        $decimal = "cinco";
        break;
    case 6:
        $decimal = "seis";
        break;
    case 7:
        $decimal = "siete";
        break;
    case 8:
        $decimal = "ocho";
        break;
    case 9:
        $decimal = "nueve";
        break;
    default:
        $decimal = "";
        break;
}

echo "El numero {$num} se escribe \"{$decena}{$decimal}\"."

?>