namespace Entidades
{
    export class Neumatico
    {
      marca: string;
      medidas: string;
      precio: number;
  
      constructor(marca: string, medidas: string, precio: number)
      {
        this.marca = marca;
        this.medidas = medidas;
        this.precio = precio;
      }
  
      ToString(): string
      {
        return `Marca: ${this.marca}, Medidas: ${this.medidas}, Precio: ${this.precio}`;
      }
  
      ToJSON(): string
      {
        return JSON.stringify(this);
      }
    }
}