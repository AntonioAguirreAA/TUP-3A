"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
function ArmarAlert(mensaje, tipo = "success") {
    let alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';
    return alerta;
}
$(() => {
    $("#btnEnviar").on("click", (e) => {
        e.preventDefault();
        let correo = $("#correo").val();
        let clave = $("#clave").val();
        let dato = {
            correo: correo,
            clave: clave
        };
        $.ajax({
            type: "POST",
            url: "http://localhost:2022/login",
            dataType: "json",
            data: dato,
            async: true,
        })
            .done(function (obj_ret) {
            console.log(obj_ret);
            let alerta = "";
            if (obj_ret.exito) {
                // GUARDO EN EL LOCALSTORAGE
                localStorage.setItem("jwt", obj_ret.jwt);
                alerta = ArmarAlert(obj_ret.mensaje + " redirigiendo al principal.html...");
                setTimeout(() => {
                    $(location).attr("href", "./principal.html");
                }, 2000);
            }
            $("#div_mensaje").html(alerta);
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            let retorno = JSON.parse(jqXHR.responseText);
            let alerta = ArmarAlert(retorno.mensaje, "danger");
            $("#div_mensaje").html(alerta);
        });
    });
});
//# sourceMappingURL=login.js.map