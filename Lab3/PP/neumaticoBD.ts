/// <reference path="./neumatico.ts" />

namespace Entidades
{
    export class NeumaticoBD extends Neumatico {
        id: number;
        pathFoto: string;

        constructor(marca: string, medidas: string, precio: number, id?: number, pathFoto?: string)
        {
            super(marca, medidas, precio);
            this.id = id || 0;
            this.pathFoto = pathFoto || "";
        }

        ToJSON(): string
        {
            return JSON.stringify(this);
        }
  }
}