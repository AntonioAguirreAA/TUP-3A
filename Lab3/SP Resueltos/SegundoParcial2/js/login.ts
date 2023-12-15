/// <reference path="../node_modules/@types/jquery/index.d.ts" />

function ArmarAlert(mensaje:string, tipo:string = "success"):string
{
    let alerta:string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';

    return alerta;
}

$(() => {
  $("#btnEnviar").on("click", (e: any) => {
    e.preventDefault();

    let correo = $("#txtCorreo").val();
    let clave = $("#txtClave").val();

    let dato: any = {};
    dato.correo = correo;
    dato.clave = clave;

    $.ajax({
      type: "POST",
      url: "http://localhost:2022/login",
      dataType: "json",
      data: dato,
      async: true,
    })
      .done(function (obj_ret: any) {
        console.log(obj_ret);
        let alerta: string = "";

        if (obj_ret.exito) {
          //GUARDO EN EL LOCALSTORAGE
          localStorage.setItem("jwt", obj_ret.jwt);

          alerta = ArmarAlert(obj_ret.mensaje + " redirigiendo al principal.html...");

          setTimeout(() => {
            $(location).attr("href", "./principal.html");
          }, 2000);
        }

        $("#div_mensaje").html(alerta);
      })
      .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
        let retorno = JSON.parse(jqXHR.responseText);

        let alerta: string = ArmarAlert(retorno.mensaje, "danger");

        $("#div_mensaje").html(alerta);
      });
  });
  
});
