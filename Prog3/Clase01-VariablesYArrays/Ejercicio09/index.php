<?php

/**Aplicación No 9 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado. */

$vec[0] = rand(1,12);
$vec[1] = rand(1,12);
$vec[2] = rand(1,12);
$vec[3] = rand(1,12);
$vec[4] = rand(1,12);
$total = 0;

for ($i=0; $i < 5; $i++) { 
    $total += $vec[$i];
}

$prom = $total / 5;

echo "<h1>Var Dump</h1><br/>";
echo var_dump($vec)."<br/><br/>";
echo "<h1>El promedio de los números es ({$prom})";