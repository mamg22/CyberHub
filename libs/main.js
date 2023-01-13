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
            return "fa-ban";
        case Mensaje.warn:
            return "fa-exclamation-triangle";
        case Mensaje.info:
            return "fa-info";
        default:
            return "";
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

function handle_menu() {
    /**
     * @var HTMLDivElement menu_toggle
     */
    var menu_toggle = document.getElementById('nav-menu');
    var menu_icon = document.getElementById('nav-menu-icon');
    var menu = document.getElementById('main-menu');

    if (!menu) {
        return;
    }

    menu_toggle.addEventListener('click', function() {
        menu_icon.classList.toggle("fa-rotate-90");
        menu.classList.toggle('visible');
    })
}

window.addEventListener('DOMContentLoaded', handle_menu);

function form_error_handler(ev) {
    if (!ev.target.checkValidity()) {
        agregar_popup("Uno o más campos del formulario están incompletos o son inválidos")
        ev.preventDefault();
    }
    ev.preventDefault();
}

function setup_error_handlers() {
    forms = Array.from(document.forms);
    forms.forEach(element => {
        element.addEventListener('submit', form_error_handler);
    });
}

//window.addEventListener('DOMContentLoaded', setup_error_handlers);

function popup_help(ev) {
    var msg = ev.target.getAttribute("help-content") ?? 'No se tiene ayuda sobre este elemento';
    agregar_popup(msg, Mensaje.info);
}

function setup_help() {
    var helps = Array.from(document.getElementsByClassName("help-item"));
    helps.forEach(element => {
        element.addEventListener('click', popup_help);
    });
}

window.addEventListener('DOMContentLoaded', setup_help);

function confirmation_handler(ev) {
    // Mensaje personalizado o tiramos un catch-all generico que funciona igual
    var msg = ev.target.getAttribute("confirm-content") ?? '¿Está seguro de que desea realizar esta acción? No se podrá deshacer';
    console.log(msg);
    if (confirm(msg)) {
        return true;
    }
    else {
        ev.preventDefault();
        return false;
    }
}

function setup_confirmation_handlers() {
    var confirmables = Array.from(document.getElementsByClassName("needs-confirm"));
    confirmables.forEach(element => {
        element.addEventListener('click', confirmation_handler);
    });
}

window.addEventListener('DOMContentLoaded', setup_confirmation_handlers);

function validation_handler(ev) {
    var f = ev.target;
    f.classList.add("submitted");
}

function setup_validation_handlers() {
    var forms = Array.from(document.forms);
    console.log(forms);
    forms.forEach(element => {
        element.addEventListener('submit', validation_handler);
    });
}

window.addEventListener('DOMContentLoaded', setup_validation_handlers);

function get_input_by_name(name) {
    var inputs = Array.from(document.querySelectorAll('input,textarea,select'));
    return inputs.filter(element => {
        return element.getAttribute("name") == name;
    })[0];
}