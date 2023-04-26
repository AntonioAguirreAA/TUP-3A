<?php

/**Aplicación No 4 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron. */

$resultado = 0;

for($count = 1; ($count+$resultado)<1000 ; $count++)
{
    $resultado+= $count;
}

echo "El numero más alto antes de 1000 es: ". $resultado . "<br/>";
echo "La cantidad de enteros sucesivos sumados es: " . $count . "<br/>";

?>