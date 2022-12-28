const Mensaje = {
    ok: "ok",
    error: "error",
    warn: "warn",
    info: "info"
}

function humanizar_tipo(tipo) {
    switch (tipo) {
        case "ok":
            return "Exito";
        case "error":
            return "Error";
        case "warn":
            return "Advertencia";
        case "info":
            return "Informacion";
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

    var close = document.createElement("span");
    close.innerHTML = "&times;";
    close.classList.add("popup-close");

    var mensaje = document.createElement("span");
    mensaje.innerHTML = `<b>${humanizar_tipo(tipo)}:</b><br>${contenido}`;
    mensaje.classList.add("popup-msg");

    box.append(close, mensaje);

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