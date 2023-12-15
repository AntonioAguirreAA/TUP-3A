/// <reference path="../libs/jquery/index.d.ts" />

namespace Main {
    
    export function ModificarPorId():void {

        //A UN DETERMINADO ELEMENTO LE CAMBIO EL CONTENIDO
        let contenidoAnterior = $("#idP").html();
        alert(contenidoAnterior);

        //A UN DETERMINADO ELEMENTO LE CAMBIO EL CONTENIDO
        $("#idP").html("Establezco un nuevo contenido en el elemento HTML.");

        console.log("para acceder (por id) a un elemento HTML");
        console.log("se coloca como selector el valor de su atributo ID");
        console.log("anteponiendole el simbolo '#'.");    
    }

    export function MostrarDatos():void {

        //OBTENGO LOS DISTINTOS VALORES POR ID DE ELEMENTO
        let nombre = $("#txtNombre").val();
        let opcion = $("#cboSeleccion").val();

        alert("Nombre: " + nombre + "\nOpción: " + opcion);

        //COLOCO LOS VALORES RECUPERADOS EN UN DIV
        $("#idDiv").html("Nombre: " + nombre + "<br>Opción: " + opcion);
    }

    export function CambiarDatos():void {

        //ESTABLEZCO NUEVOS VALORES
        alert("Cambia de valor la selección ('op2')\ny del nombre ('ROBERTO')");
        
        $("#txtNombre").val("ROBERTO");
        $("#cboSeleccion").val("op2");

    }

    export function JqueryAjaxConParametrosJSON():void {

        let pagina = "http://localhost:9876/productos";
        let datoObjeto = '{ "codigo" : "55", "marca" : "marca_55", "precio" : 55 }';

        //LIMPIO EL CONTENIDO DEL DIV    
        $("#divResultado").html("");
        
        $.ajax({
            type: 'POST',
            url: pagina,
            dataType: "text",
            data: datoObjeto,
            contentType:"application/json",
            async: true
        })
        .done(function (resultado:any) {
            //MUESTRO EL RESULTADO DE LA PETICION
            $("#divResultado").html(resultado);
        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });    
    }

    export function JqueryAjaxRetornoJSON():void {

        let pagina = "http://localhost:9876/productos";

        //LIMPIO EL CONTENIDO DEL DIV    
        $("#divResultado").html("");

        $.ajax({
            type: 'GET',
            url: pagina,
            dataType: "json"
        })
        .done(function (objJSON:any) {
            //MUESTRO EL RESULTADO DE LA PETICION
            console.log(objJSON);

            let cadena = "";

            objJSON.forEach((elemento:any) => {
                console.log(elemento);
                if(elemento !== "")
                {
                    let obj = JSON.parse(elemento);
                    cadena += obj.codigo + " - " + obj.marca + " - " + obj.precio + "<br>";
                }
            });

            $("#divResultado").html(cadena);

        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });  
    }
}