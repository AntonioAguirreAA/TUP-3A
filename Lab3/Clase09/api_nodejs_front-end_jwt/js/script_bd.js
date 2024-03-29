"use strict";
$(() => {
    VerificarJWT();
    AdministrarVerificarJWT();
    AdministrarLogout();
    AdministrarListar();
    AdministrarAgregar();
});
function VerificarJWT() {
    let jwt = localStorage.getItem("jwt");
    $.ajax({
        type: 'GET',
        url: URL_API + "verificar_token",
        dataType: "json",
        data: {},
        headers: { 'Authorization': 'Bearer ' + jwt },
        async: true
    })
        .done((obj_rta) => {
        console.log(obj_rta);
        if (obj_rta.exito) {
            let app = obj_rta.jwt.api;
            let version = obj_rta.jwt.version;
            let usuario = obj_rta.jwt.usuario;
            let alerta = ArmarAlert("ApiRest: " + app + "<br>Versión: " + version + "<br>Usuario: " + JSON.stringify(usuario));
            $("#divResultado").html(alerta).toggle(2000);
            $("#rol").html(usuario.Rol);
        }
        else {
            let alerta = ArmarAlert(obj_rta.mensaje, "danger");
            $("#divResultado").html(alerta).toggle(2000);
            setTimeout(() => {
                $(location).attr('href', URL_BASE + "index.html");
            }, 1500);
        }
    })
        .fail((jqXHR, textStatus, errorThrown) => {
        let retorno = JSON.parse(jqXHR.responseText);
        let alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta).show(2000);
    });
}
function AdministrarVerificarJWT() {
    $("#verificarJWT").on("click", () => {
        VerificarJWT();
    });
}
function AdministrarLogout() {
    $("#logout").on("click", () => {
        localStorage.removeItem("jwt");
        let alerta = ArmarAlert('Usuario deslogueado!!!');
        $("#divResultado").html(alerta).show(2000);
        setTimeout(() => {
            $(location).attr('href', URL_BASE + "index.html");
        }, 1500);
    });
}
function AdministrarListar() {
    $("#listar_producto").on("click", () => {
        ObtenerListadoProductos();
    });
}
function AdministrarAgregar() {
    $("#alta_producto").on("click", () => {
        ArmarFormularioAlta();
    });
}
function ObtenerListadoProductos() {
    $("#divResultado").html("");
    let jwt = localStorage.getItem("jwt");
    $.ajax({
        type: 'GET',
        url: URL_API + "productos_bd",
        dataType: "json",
        data: {},
        headers: { 'Authorization': 'Bearer ' + jwt },
        async: true
    })
        .done((resultado) => {
        console.log(resultado);
        let tabla = ArmarTablaProductos(resultado);
        $("#divResultado").html(tabla).show(1000);
    })
        .fail((jqXHR, textStatus, errorThrown) => {
        let retorno = JSON.parse(jqXHR.responseText);
        let alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta).show(2000);
    });
}
function ArmarTablaProductos(productos) {
    let tabla = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>CÓDIGO</th><th>MARCA</th><th>PRECIO</th><th>FOTO</th><th style="width:110px">ACCIONES</th></tr>';
    if (productos.length == 0) {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
    }
    else {
        productos.forEach((prod) => {
            tabla += "<tr><td>" + prod.codigo + "</td><td>" + prod.marca + "</td><td>" + prod.precio + "</td>" +
                "<td><img src='" + URL_API + prod.path + "' width='50px' height='50px'></td><th>" +
                "<a href='#' class='btn' data-action='modificar' data-obj_prod='" + JSON.stringify(prod) + "' title='Modificar'" +
                " data-toggle='modal' data-target='#ventana_modal_prod'><span class='fas fa-edit'></span></a>" +
                "<a href='#' class='btn' data-action='eliminar' data-obj_prod='" + JSON.stringify(prod) + "' title='Eliminar'" +
                " data-toggle='modal' data-target='#ventana_modal_prod'><span class='fas fa-times'></span></a>" +
                "</td></tr>";
        });
    }
    tabla += "</table>";
    return tabla;
}
function ArmarFormularioAlta() {
    $("#divResultado").html("");
    let formulario = MostrarForm("alta");
    $("#cuerpo_modal_prod").html(formulario);
    ((Object)($("#ventana_modal_prod"))).modal({ backdrop: "static" });
}
function MostrarForm(accion, obj_prod = null) {
    let funcion = "";
    let encabezado = "";
    let solo_lectura = "";
    let solo_lectura_pk = "readonly";
    switch (accion) {
        case "alta":
            funcion = 'Agregar(event)';
            encabezado = 'AGREGAR PRODUCTO';
            solo_lectura_pk = "";
            break;
        case "baja":
            funcion = 'Eliminar(event)';
            encabezado = 'ELIMINAR PRODUCTO';
            solo_lectura = "readonly";
            break;
        case "modificacion":
            funcion = 'Modificar(event)';
            encabezado = 'MODIFICAR PRODUCTO';
            break;
    }
    let codigo = "";
    let marca = "";
    let precio = "";
    let path = URL_BASE + "/img/producto_default.png";
    if (obj_prod !== null) {
        codigo = obj_prod.codigo;
        marca = obj_prod.marca;
        precio = obj_prod.precio;
        path = URL_API + obj_prod.path;
    }
    let form = '<h3 style="padding-top:1em;">' + encabezado + '</h3>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="codigo">Código:</label>\
                                        <input type="text" class="form-control" id="codigo" placeholder="Ingresar código"\
                                            value="' + codigo + '" ' + solo_lectura_pk + ' required>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="marca">Título:</label>\
                                        <input type="text" class="form-control" id="marca" placeholder="Ingresar marca"\
                                            name="marca" value="' + marca + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Precio:</label>\
                                        <input type="number" class="form-control" id="precio" placeholder="Ingresar precio" name="precio"\
                                            value="' + precio + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="foto">Foto:</label>\
                                        <input type="file" class="form-control" id="foto" name="foto" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="row justify-content-between"><img id="img_prod" src="' + path + '" width="400px" height="200px"></div><br>\
                                    <div class="row justify-content-between">\
                                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar">\
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="' + funcion + '" >Aceptar</button>\
                                    </div>\
                                </form>\
                            </div>\
                        </div>';
    return form;
}
function Agregar(e) {
    e.preventDefault();
    $("#cuerpo_modal_prod").html("Implementar...");
}
function Modificar(e) {
    e.preventDefault();
}
function Eliminar(e) {
    e.preventDefault();
    let codigo = $("#codigo").val();
    ((Object)($("#cuerpo_modal_prod"))).modal("hide");
    $("#cuerpo_modal_confirm").html('\<h5>¿Está seguro de eliminar el producto ' + codigo + '?</h5> \
    <input type="button" class="btn btn-danger" data-dismiss="modal" value="NO" style="float:right;margin-left:5px">\
    <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="ContinuarEliminar(' + codigo + ')" style="float:right">Sí </button>');
    ((Object)($("#ventana_modal_confirm"))).modal({ backdrop: "static" });
    return;
}
function ContinuarEliminar(codigo) {
}
//# sourceMappingURL=script_bd.js.map