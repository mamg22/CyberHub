const Mensaje = {
    ok: "ok",
    error: "error",
    warn: "warn",
    info: "info"
}

function humanizar_tipo(tipo) {
    switch (tipo) {
        case Mensaje.ok:
            return "Exito";
        case Mensaje.error:
            return "Error";
        case Mensaje.warn:
            return "Advertencia";
        case Mensaje.info:
            return "Informacion";
        default:
            return "???";
    }
}

function icono_para_tipo(tipo) {
    switch (tipo) {
        case Mensaje.ok:
            return "fa-check";
        case Mensaje.error:
            return "fa-xmark";
        case Mensaje.warn:
            return "fa-exclamation-triangle";
        case Mensaje.info:
            return "fa-info";
        default:
            return "???";
    }
}


function agregar_popup(contenido, tipo) {
    var box = document.createElement("div");
    box.classList.add("popup-box");
    box.classList.add(tipo);
    box.addEventListener('click', function () {
        this.remove();
    });

    var icono = document.createElement("span");
    // Icono FontAwesome, xl: extra grande (1.5x), fw: ancho fijo
    icono.classList.add("popup-icon", "fa", "fa-xl", "fa-fw", icono_para_tipo(tipo));

    var close = document.createElement("span");
    close.innerHTML = "&times;";
    close.classList.add("popup-close");

    var mensaje = document.createElement("span");
    mensaje.innerHTML = `<b>${humanizar_tipo(tipo)}:</b><br>${contenido}`;
    mensaje.classList.add("popup-msg");

    box.append(icono, mensaje, close);

    popup_container = document.getElementById("popup-container");
    popup_container.append(box);
}

function setup_popups(lista_popups) {
    window.addEventListener('DOMContentLoaded', function () {
        lista_popups.forEach(element => {
            var contenido = element['contenido'];
            var tipo = element['tipo'];

            agregar_popup(contenido, tipo);
        });

    });
}