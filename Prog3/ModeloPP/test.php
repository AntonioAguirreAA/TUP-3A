<?php

require_once "./Backend/Clases/Usuario.php";

$usuario = new Usuario(1,"Antonio Aguirre","antiaguirre.aa@gmail.com","123","01","AntonioAguirreAA");


 var_dump(Usuario::TraerTodosJson());

?>