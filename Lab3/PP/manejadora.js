"use strict";
/// <reference path="./neumatico.ts" />
/// <reference path="./neumaticoBD.ts" />
var PrimerParcial;
(function (PrimerParcial) {
    class Manejadora {
        constructor() {
            this.xhttp = new XMLHttpRequest();
            this.formData = new FormData();
        }
        static AgregarNeumaticoJSON() {
            let manejadora = new Manejadora();
            let marca = document.getElementById("marca").value;
            let medidas = document.getElementById("medidas").value;
            let precio = (Number)(document.getElementById("precio").value);
            manejadora.xhttp.open("POST", "./backend/altaNeumaticoJSON.php", true);
            //xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            manejadora.formData.append('marca', marca);
            manejadora.formData.append('medidas', medidas);
            manejadora.formData.append('precio', precio.toString());
            manejadora.xhttp.send(manejadora.formData);
            manejadora.xhttp.onreadystatechange = () => {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200) {
                    let respuesta = JSON.parse(manejadora.xhttp.responseText);
                    alert(respuesta.mensaje);
                    console.log(respuesta.mensaje);
                }
            };
        }
        static MostrarNeumaticosJSON() {
            let manejadora = new Manejadora();
            manejadora.xhttp.open("GET", "./backend/listadoNeumaticosJSON.php", true);
            manejadora.xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            manejadora.xhttp.send();
            manejadora.xhttp.onreadystatechange = () => {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200) {
                    console.log(manejadora.xhttp.responseText);
                    let neumaticos = JSON.parse(manejadora.xhttp.responseText);
                    let tablaHTML = '<table border="1"><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th></tr></thead><tbody>';
                    neumaticos.forEach((neumatico) => {
                        let marca = neumatico.marca;
                        let medidas = neumatico.medidas;
                        let precio = neumatico.precio;
                        let filaHTML = `<tr><td>${marca}</td><td>${medidas}</td><td>${precio}</td></tr>`;
                        tablaHTML += filaHTML;
                    });
                    tablaHTML += "</tbody></table>";
                    document.getElementById("divTabla").innerHTML = tablaHTML;
                }
            };
        }
        static VerificarNeumaticoJSON() {
            let manejadora = new Manejadora();
            let marca = document.getElementById("marca").value;
            let medidas = document.getElementById("medidas").value;
            manejadora.xhttp.open("POST", "./backend/verificarNeumaticoJSON.php", true);
            manejadora.formData.append('marca', marca);
            manejadora.formData.append('medidas', medidas);
            manejadora.xhttp.send(manejadora.formData);
            manejadora.xhttp.onreadystatechange = () => {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200) {
                    let respuesta = JSON.parse(manejadora.xhttp.responseText);
                    alert(respuesta.mensaje);
                    console.log(respuesta.mensaje);
                }
            };
        }
        static AgregarNeumaticoSinFoto() {
            let manejadora = new Manejadora();
            let marca = document.getElementById("marca").value;
            let medidas = document.getElementById("medidas").value;
            let precio = (Number)(document.getElementById("precio").value);
            manejadora.xhttp.open("POST", "./backend/agregarNeumaticoSinFoto.php", true);
            let neumatico = new Entidades.Neumatico(marca, medidas, precio);
            manejadora.formData.append('neumatico_json', neumatico.ToJSON());
            manejadora.xhttp.send(manejadora.formData);
            manejadora.xhttp.onreadystatechange = () => {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200) {
                    let respuesta = JSON.parse(manejadora.xhttp.responseText);
                    alert(respuesta.mensaje);
                    console.log(respuesta.mensaje);
                }
            };
        }
        static MostrarNeumaticosBD() {
            let manejadora = new Manejadora();
            manejadora.xhttp.open("GET", "./backend/listadoNeumaticoBD.php?tabla=mostrar", true);
            manejadora.xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            manejadora.xhttp.send();
            manejadora.xhttp.onreadystatechange = () => {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200) {
                    document.getElementById("divTabla").innerHTML = manejadora.xhttp.responseText;
                    console.log(manejadora.xhttp.responseText);
                }
            };
        }
        static EliminarNeumatico(json) {
            alert(json);
        }
    }
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
//# sourceMappingURL=manejadora.js.map