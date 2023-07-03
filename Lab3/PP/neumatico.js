"use strict";
var Entidades;
(function (Entidades) {
    class Neumatico {
        constructor(marca, medidas, precio) {
            this.marca = marca;
            this.medidas = medidas;
            this.precio = precio;
        }
        ToString() {
            return `Marca: ${this.marca}, Medidas: ${this.medidas}, Precio: ${this.precio}`;
        }
        ToJSON() {
            return JSON.stringify(this);
        }
    }
    Entidades.Neumatico = Neumatico;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=neumatico.js.map