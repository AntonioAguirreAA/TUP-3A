<?php
	//declare(strict_types=1);

//TIPADO FUERTE
	function saludar_tipado() : void
	{
		echo "Hola Mundo, desde una función tipada!!!";
	}

	function saludar2_tipado(string $nombre) : void
	{
		echo "Hola ", $nombre;
	}
		
	function saludar3_tipado(string $nombre, string $genero = "Masculino") : string
	{
		$retorno = "Hola $nombre. Tu g&eacute;nero es $genero";
		return $retorno;
	}

	function union_tipos(string|int $parametro) : string
	{
		if (gettype($parametro) == "string") {
			return "Es una cadena {$parametro}<br>";
		}
		if (gettype($parametro) == "integer") {
			return "Es un entero {$parametro}<br>";
		}
	}

	saludar_tipado();
	echo "<br/>";
		
	saludar2_tipado("Juan");
	echo "<br/>";
		
	echo saludar3_tipado("Rosa", "Femenino");
	echo "<br/>";

	echo saludar3_tipado("Carlos");
	echo "<br/>";

	echo union_tipos("hola");
	echo union_tipos(5);

	echo union_tipos(true);//php arregla incompatibilidades

	