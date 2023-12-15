
function ModificarPs(){

    //A TODOS LOS ELEMENTOS P DEL DOCUMENTO LES CAMBIO LA FUENTE
    $("p").css("font-family", "arial black");
    //document.getElementsByTagName("p").style.font-family=""
    console.log("para acceder (por nombre) a un elemento HTML");
    console.log("se coloca como selector el nombre del elemento.");
}

function ModificarPorId(){

    //A UN DETERMINADO ELEMENTO LE CAMBIO EL CONTENIDO
    var contenidoAnterior = $("#idP").html();
    alert(contenidoAnterior);

    //A UN DETERMINADO ELEMENTO LE CAMBIO EL CONTENIDO
    $("#idP").html("Establezco un nuevo contenido en el elemento HTML.");

    console.log("para acceder (por id) a un elemento HTML");
    console.log("se coloca como selector el valor de su atributo ID");
    console.log("anteponiendole el simbolo '#'.");    
}

function MostrarDatos(){

    //OBTENGO LOS DISTINTOS VALORES POR ID DE ELEMENTO
    var nombre = $("#txtNombre").val();
    var opcion = $("#cboSeleccion").val();

    alert("Nombre: " + nombre + "\nOpción: " + opcion);

    //COLOCO LOS VALORES RECUPERADOS EN UN DIV
    $("#idDiv").html("Nombre: " + nombre + "<br>Opción: " + opcion);
}

function CambiarDatos(){

    //ESTABLEZCO NUEVOS VALORES
    alert("Cambia de valor la selección ('op2')\ny del nombre ('ROBERTO')");
    
    $("#txtNombre").val("ROBERTO");
    $("#cboSeleccion").val("op2");

}