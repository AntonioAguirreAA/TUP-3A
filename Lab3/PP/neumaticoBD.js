"use strict";
/// <reference path="./neumatico.ts" />
var Entidades;
(function (Entidades) {
    class NeumaticoBD extends Entidades.Neumatico {
        constructor(marca, medidas, precio, id, pathFoto) {
            super(marca, medidas, precio);
            this.id = id || 0;
            this.pathFoto = pathFoto || "";
        }
        ToJSON() {
            return JSON.stringify(this);
        }
    }
    Entidades.NeumaticoBD = NeumaticoBD;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=neumaticoBD.js.map