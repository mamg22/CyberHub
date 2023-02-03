# Sistema de gestión para el Cyber Rodríguez

[Leer en inglés/Read in english](README.en.md)

Este programa forma parte del proyecto que se ha realizado en la comunidad del Cyber Rodríguez como parte de la asignatura de Proyecto Sociotecnológico III, durante el Trayecto 3 del Programa Nacional de Formación en Informática (PNFI) en la Universidad Politécnica Territorial de los Altos Mirandinos "Cecilio Acosta" (UPTAMCA).

# Funciones

## Básico

* Administrar equipos (computadoras) del cyber.
* Administrar repuestos en el almacén del cyber.
* Administrar clientes del servicio técnico.
* Administrar trabajos de reparación del servicio técnico.
* Generación de gráficos y estadísticas en base a la información registrada.
* Ayuda integrada e interactiva.

## Administrativo

* Administrar usuarios del sistema y actualizar su información.
* Permitir a cada usuario cambiar su contraseña
* Separación en dos subsistemas: "Inventario de cyber" y "Servicio técnico"
* Perfiles de usuario como control de acceso:
    * Solo Lectura: Puede entrar al sistema y visualizar la información y las
    estadísticas. No puede efectuar modificaciones.
    * Regular: Usuario regular, puede visualizar, registrar, modificar y eliminar información.
    * Administrador: Posee las funciones de un usuario Regular, con el
    adicional de poder administar los usuarios de su subsistema.
    * Super Administrador: Acceso total al sistema, puede acceder a ambos
    subsistemas y actúa como Administrador en ámbos. Nota: No es un usuario para uso regular, existe solo como un último recurso para casos inusuales, por ejemplo: Todos los administradores de un subsistema son eliminados.
* Recuperación de contraseñas mediante un PIN secreto del usuario.

## Internos / Implementación

* Pase de mensajes de notificación para el usuario enviados entre paginas
mediante una pila de mensajes (Message flashing). Utilizable del lado del servidor y también del lado del cliente con javascript para mostrar
notificaciones instantaneas, como las utilizadas en los botones de ayuda.
* Restricción de acceso a páginas a las que el usuario no esté autorizado.

# Requisitos

* PHP 8.1 o más reciente
* Base de datos MySQL o MariaDB
* Servidor web

XAMPP 8.1 o más nuevo incluye todo el software requerido por este programa.

# Instalación

1. Colocar los archivos en la carpeta raíz del servidor web.

2. Importar la base de datos usando el archivo `bd/bdcyber.sql`.

3. OPCIONAL: Importar el archivo `bd/datos-de-prueba.sql` para cargar información de prueba en la base de datos.

4. Abrir la aplicación en un navegador yendo a `http://localhost/` o la dirección y/o puerto configurado en el servidor.

# Usuarios por defecto

El sistema incluye los siguientes usuarios por defecto:

| Usuario    | contraseña | pin     | Perfil              | Subsistema       |
|------------|------------|---------|---------------------|------------------|
| root       | root       | 1234321 | Super Administrador | Todos            |
| admincyber | admincyber | 1234    | Administrador       | Cyber            |
| adminserv  | adminserv  | 1234    | Administrador       | Servicio Técnico |
| regcyber   | regcyber   | 1234    | Regular             | Cyber            |
| regserv    | regserv    | 1234    | Regular             | Servicio Técnico |
| rocyber    | rocyber    | 1234    | Solo Lectura        | Cyber            |
| roserv     | roserv     | 1234    | Solo Lectura        | Servicio Técnico |


# Compatibilidad

La aplicación ha sido probada exitosamente en los siguientes navegadores:

* Microsoft Edge
* Google Chrome
* Mozilla Firefox (sólo versión de escritorio)

La versión móvil de Mozilla Firefox no provee la funcionalidad necesaria en algunas partes de la aplicación, por lo que no se recomienda utilizarlo para esta aplicación.

El componente que se ejecuta en el lado del servidor ha sido probado exitosamente en:

* Windows: Windows 11, usando XAMPP 8.1.
* Linux: Fedora 37, usando Apache 2.4.54, PHP 8.1.14, MariaDB 15.1.
