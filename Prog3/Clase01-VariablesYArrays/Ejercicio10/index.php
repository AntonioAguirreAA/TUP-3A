<?php

/**Aplicación No 10 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach. */

$count = 0;
$vecEspacios = 0;

while($vecEspacios < 10)
{
    $count++;
    if(($count % 2) != 0)
    {
        $vec[$vecEspacios] = $count;
        $vecEspacios++;
    }
}

foreach($vec as $int)
{
    echo $int."<br/>";
}