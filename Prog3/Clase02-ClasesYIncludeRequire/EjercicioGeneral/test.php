<?php
require_once "Clases/Mascota.php";
require_once "Clases/Guarderia.php";

$mascotaUno = new Animalitos\Mascota("Sanson","Perro",6);
$mascotaDos = new Animalitos\Mascota("Sanson","Gato",3);

echo "<h1>Mascota 1</h1><br>";
echo Animalitos\Mascota::mostrar($mascotaUno)."<br>";
echo "<h1>Mascota 2</h1><br>";
echo Animalitos\Mascota::mostrar($mascotaDos)."<br>";
echo "<br>";
if ($mascotaUno->Equals($mascotaDos))
{
    echo "Las mascotas son iguales<br>";
}   else {
    echo "Las mascotas son distintas<br>";
}
echo "<br>";

$mascotaUno = new Animalitos\Mascota("Tyrone","Perro",6);
$mascotaDos = new Animalitos\Mascota("Tyrone","Perro",3);

echo "<h1>Mascota 1</h1><br>";
echo Animalitos\Mascota::mostrar($mascotaUno)."<br>";
echo "<h1>Mascota 2</h1><br>";
echo Animalitos\Mascota::mostrar($mascotaDos)."<br>";
echo "<br>";
if ($mascotaUno->Equals($mascotaDos))
{
    echo "Las mascotas son iguales<br>";
}   else {
    echo "Las mascotas son distintas<br>";
}
echo "<br>";

$mascotaUno = new Animalitos\Mascota("Sanson","Perro",6);
$mascotaDos = new Animalitos\Mascota("Mikkel","Gato",3);
$mascotaTres = new Animalitos\Mascota("Tyrone","Perro",3);
$mascotaCuatro = new Animalitos\Mascota("Tyrone","Perro",5);

$panchoGuarderia = new Negocios\Guarderia("La Guarderia de Pancho");
$panchoGuarderia->add($mascotaUno);
$panchoGuarderia->add($mascotaDos);
$panchoGuarderia->add($mascotaTres);
$panchoGuarderia->add($mascotaCuatro);
echo "<br><br><h1>Guarderia</h1><br>";
echo $panchoGuarderia->toString();
?>