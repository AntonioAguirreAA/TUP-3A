/*! Comentario visible en .js

Función para subir una foto al servidor web y 
mostrarla en un tag img, utilizando AJAX

*/     

//INSTANCIO OBJETO PARA REALIZAR COMUNICACIONES ASINCRONICAS
let xhr : XMLHttpRequest = new XMLHttpRequest();

function SubirFoto() : void {
    
    //MUESTRO EL SPINNER
    AdministrarGif(true);

    //RECUPERO LA IMAGEN SELECCIONADA POR EL USUARIO
    let foto : any = (<HTMLInputElement> document.getElementById("foto"));

    //INSTANCIO OBJETO FORMDATA
    let form : FormData = new FormData();

    //AGREGO PARAMETROS AL FORMDATA:

    //PARAMETRO RECUPERADO POR $_FILES
    form.append('foto', foto.files[0]);

    //PARAMETRO RECUPERADO POR $_POST O $_GET (SEGUN CORRESPONDA)
    form.append('op', "subirFoto");
    //form.append('op', "subirFotoJSON");

    //METODO; URL; ASINCRONICO?
    xhr.open('POST', './BACKEND/nexo.php', true);

    //ESTABLEZCO EL ENCABEZADO DE LA PETICION
    xhr.setRequestHeader("enctype", "multipart/form-data");

    //ENVIO DE LA PETICION
    xhr.send(form);

    //FUNCION CALLBACK
    xhr.onreadystatechange = () => {

        //OCULTO EL SPINNER
        AdministrarGif(false);

        respuestaArray();

        //respuestaJSON();
        
    };
}

function respuestaArray() {
    
    if (xhr.readyState == 4 && xhr.status == 200) {

        console.log(xhr.responseText);
        
        let ret = xhr.responseText;
        let retArray = ret.split("-");

        if(retArray[0] == "false"){
            console.error("NO se subió la foto!!!");
        }
        else{
            console.info("Foto subida OK!!!");
            (<HTMLImageElement> document.getElementById("imgFoto")).src = "./BACKEND/" + retArray[1];
        }
    }
}

function respuestaJSON() {
    
    if (xhr.readyState == 4 && xhr.status == 200) {

        console.log(xhr.responseText);
        
        let ret = xhr.responseText;
        let retJSON = JSON.parse(ret);

        if( ! retJSON.exito){
            console.error("NO se subió la foto!!!");
        }
        else{
            console.info("Foto subida OK!!!");
            (<HTMLImageElement> document.getElementById("imgFoto")).src = "./BACKEND/" + retJSON.path;
        }
    }
}

function AdministrarGif(mostrar:boolean):void 
    {
        var gif : string = "img/Earth_animated.gif";
        let div = <HTMLDivElement> document.getElementById("divGif");
        let img = <HTMLImageElement> document.getElementById("imgGif");

        if(mostrar)
        {
            div.style.display = "block";
            div.style.top = "45%";
            div.style.left = "45%"
            img.src = gif;
        }
        else
        {
            div.style.display = "none";
            img.src = "";
        }
    }