function JqueryAjax(){
// Invocación sin parámetros.
// Asigna manejadores después de la petición
// y recuerda el objeto jqxhr de la solicitud.
	var jqxhr = $.ajax("http://localhost:9876")
		.done(function(rta) {
			alert("done:\n" + rta);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert(jqXHR.responseText + "\n");
			alert(textStatus + ":\n" + errorThrown);
		})
		.always(function() {
			alert("siempre se ejecuta...");
		});
 
// Agregar tarea...
 
// Establece otra función de finalización de la solicitud anterior.
	jqxhr.always(function(rta) {
		alert("segunda función de finalización...\n" + rta);
	});

}

function JqueryAjaxConParametrosJSON(){

    var pagina = "http://localhost:9876/productos";
	var datoObjeto = '{ "codigo" : "55", "marca" : "marca_55", "precio" : 55 }';

	//LIMPIO EL CONTENIDO DEL DIV    
	$("#divResultado").html("");

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "text",
		contentType:"application/json",
        data: datoObjeto,
        async: true,
		statusCode: {//CODIGO NUMERICO DE RESPUESTA HTTP
			200: function(){
				alert("200 - Encontrado!!!");
			},
			404: function(){
				alert("404 - No encontrado!!!");
			}
		}
    })
	.done(function (resultado) {
		//MUESTRO EL RESULTADO DE LA PETICION
		$("#divResultado").html(resultado);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

function JqueryAjaxRetornoJSON(){

    var pagina = "http://localhost:9876/productos";

	//LIMPIO EL CONTENIDO DEL DIV    
	$("#divResultado").html("");

    $.ajax({
        type: 'GET',
        url: pagina,
        dataType: "json"
    })
	.done(function (objJSON) {
		//MUESTRO EL RESULTADO DE LA PETICION
		console.log(objJSON);

		var cadena = "";

		objJSON.forEach(elemento => {
			console.log(elemento);
			if(elemento !== "")
			{
				var obj = JSON.parse(elemento);
				cadena += obj.codigo + " - " + obj.marca + " - " + obj.precio + "<br>";
			}
		});

		$("#divResultado").html(cadena);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}