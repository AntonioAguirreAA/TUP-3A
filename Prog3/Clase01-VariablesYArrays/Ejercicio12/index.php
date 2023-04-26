<?php

/**Aplicación No 13 (Arrays asociativos II)
Cargar los tres arrays con los siguientes valores y luego ‘juntarlos’ en uno. Luego mostrarlo por
pantalla.
“Perro”, “Gato”, “Ratón”, “Araña”, “Mosca”
“1986”, “1996”, “2015”, “78”, “86”
“php”, “mysql”, “html5”, “typescript”, “ajax”
Para cargar los arrays utilizar la función array_push. Para juntarlos, utilizar la función
array_merge.*/

$animales[1] = "Perro"; $animales[2] = "Gato"; $animales[3] = "Ratón"; $animales[4] = "Araña"; $animales[5] = "Mosca";

$numeros[1] = "1986";$numeros[2] = "1996";$numeros[3] = "2015";$numeros[4] = "78";$numeros[5] = "86";

$tecnologias[1] = "php"; $tecnologias[2] = "mysql";$tecnologias[3] = "html5";$tecnologias[4] = "typescript";$tecnologias[5] = "ajax";

$array = array_merge($animales , $numeros , $tecnologias);

echo var_dump($array);