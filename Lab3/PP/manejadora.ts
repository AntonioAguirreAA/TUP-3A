/// <reference path="./neumatico.ts" />
/// <reference path="./neumaticoBD.ts" />

namespace PrimerParcial
{
    export class Manejadora
    {
        private xhttp : XMLHttpRequest
        private formData : FormData

        constructor()
        {
            this.xhttp = new XMLHttpRequest();
            this.formData = new FormData();
        }
        
        static AgregarNeumaticoJSON(): void
        {
            let manejadora = new Manejadora();

            let marca : string = (<HTMLInputElement> document.getElementById("marca")).value;
            let medidas: string = (<HTMLInputElement> document.getElementById("medidas")).value;
            let precio: number = (Number) ((<HTMLInputElement> document.getElementById("precio")).value);

            manejadora.xhttp.open("POST", "./backend/altaNeumaticoJSON.php", true);
            //xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            manejadora.formData.append('marca', marca);
            manejadora.formData.append('medidas', medidas);
            manejadora.formData.append('precio', precio.toString());

            manejadora.xhttp.send(manejadora.formData);

            manejadora.xhttp.onreadystatechange = () =>
            {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200)
                {
                    let respuesta = JSON.parse(manejadora.xhttp.responseText);
                    alert(respuesta.mensaje);
                    console.log(respuesta.mensaje);
                }
            };
        }

        static MostrarNeumaticosJSON(): void
        {
            let manejadora = new Manejadora();

            manejadora.xhttp.open("GET", "./backend/listadoNeumaticosJSON.php", true);
            manejadora.xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            manejadora.xhttp.send();

            manejadora.xhttp.onreadystatechange = () =>
            {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200)
                {
                    console.log(manejadora.xhttp.responseText);

                    let neumaticos: any[] = JSON.parse(manejadora.xhttp.responseText);
                    let tablaHTML: string = '<table border="1"><thead><tr><th>Marca</th><th>Medidas</th><th>Precio</th></tr></thead><tbody>';

                    neumaticos.forEach((neumatico: any) => {
                    let marca: string = neumatico.marca;
                    let medidas: string = neumatico.medidas;
                    let precio: number = neumatico.precio;

                    let filaHTML: string = `<tr><td>${marca}</td><td>${medidas}</td><td>${precio}</td></tr>`;
                    tablaHTML += filaHTML;
                    });

                    tablaHTML += "</tbody></table>";

                    (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = tablaHTML;
                }
            };
        }

        static VerificarNeumaticoJSON() : void
        {
            let manejadora = new Manejadora();

            let marca : string = (<HTMLInputElement> document.getElementById("marca")).value;
            let medidas: string = (<HTMLInputElement> document.getElementById("medidas")).value;

            manejadora.xhttp.open("POST", "./backend/verificarNeumaticoJSON.php", true);

            manejadora.formData.append('marca', marca);
            manejadora.formData.append('medidas', medidas);

            manejadora.xhttp.send(manejadora.formData);

            manejadora.xhttp.onreadystatechange = () =>
            {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200)
                {
                    let respuesta = JSON.parse(manejadora.xhttp.responseText);
                    alert(respuesta.mensaje);
                    console.log(respuesta.mensaje);
                }
            };
        }

        static AgregarNeumaticoSinFoto() : void
        {
            let manejadora = new Manejadora();

            let marca : string = (<HTMLInputElement> document.getElementById("marca")).value;
            let medidas: string = (<HTMLInputElement> document.getElementById("medidas")).value;
            let precio: number = (Number) ((<HTMLInputElement> document.getElementById("precio")).value);

            manejadora.xhttp.open("POST", "./backend/agregarNeumaticoSinFoto.php", true);

            let neumatico : Entidades.Neumatico = new Entidades.Neumatico(marca,medidas,precio);
            manejadora.formData.append('neumatico_json', neumatico.ToJSON());

            manejadora.xhttp.send(manejadora.formData);

            manejadora.xhttp.onreadystatechange = () =>
            {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200)
                {
                    let respuesta = JSON.parse(manejadora.xhttp.responseText);
                    alert(respuesta.mensaje);
                    console.log(respuesta.mensaje);
                }
            };
        }

        static MostrarNeumaticosBD() : void
        {
            let manejadora = new Manejadora();

            manejadora.xhttp.open("GET", "./backend/listadoNeumaticoBD.php?tabla=mostrar", true);
            manejadora.xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            manejadora.xhttp.send();

            manejadora.xhttp.onreadystatechange = () =>
            {
                if (manejadora.xhttp.readyState == 4 && manejadora.xhttp.status == 200)
                {
                    (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = manejadora.xhttp.responseText;
                    console.log(manejadora.xhttp.responseText);
                }
            };
        }

        static EliminarNeumatico(json: string) : void
        {
            alert(json);
        }
    }
    
}