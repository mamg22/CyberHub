# CyberHub

[Leer en español/Read in spanish](README.es.md)

Program for the management of diverse areas on a cybercafe, currently provides functionality for managing equipement and replacement parts, and for managing clients and pending work for a technical service.

# Functionality

## Basic

* Manage equipement (Computers) of the cyber.
* Manage inventory of replacement parts in the cyber's depot.
* Manage technical service (repair shop) clients.
* Manage technical service repair jobs.
* Generate graphs and statistics based on the stored information.
* Integrated and interactive help.

## Management

* Manage system users and update their information.
* Allow each user to change their password.
* Separation into two subsystems:  "Inventario de cyber" and "Servicio técnico" ("Cyber inventory" and "Technical service")
* User profiles as access control:
    * Solo Lectura (Read Only): Can access the system and view information and statistics. Cannot make any modifications.
    * Regular: Regular user, can view, register, modify and delete information.
    * Administrador (Administrator): Has the same functions as a Regular user does, with the aditional of being able to manage users of their subsystem.
    * Super Administrator (Super Administrator): Total system access, can access both subsystems and functions as an adminstrator on both of them. Note: This is not a regular use user, it exists only as a last resort for unusual cases, for example: All administrators on a subsystem are removed.
* Password recovery using a user secret PIN code.

## Internal / Implementation

* User notification message passing sent between pages using a message stack (Message flashing). Usable on the server-side and also on the client-side using javascript for showing instant notification, such as the ones used in the help buttons.
* Restricting access to pages the user isn't autorized to see.

# Requirements

* PHP 8.1 or newer.
* MySQL or MariaDB database.
* Web server with PHP support (Such as Apache, nginx or the builtin PHP server)

XAMPP 8.1 or newer include all the software required by this program.

## Bundled dependencies

These dependencies have been bundled in the system's source code:

* [FontAwesome](https://fontawesome.com/) 5 (In `/styles/3rdparty`)
* [ChartJS](https://www.chartjs.org/) 4.0.0+ (In `/libs/3rdparty`)

# Instalation

1. Put all the files and folder in the web server root.

2. Import the database using the file `bd/bdcyber.sql`.

3. OPTIONAL: Import the file `bd/datos-de-prueba.sql` to load test data onto the database.

4. Open the app in a browser by going to `http://localhost/` or the configured address and/or port of your server.

# Default users

The system includes the following default users:

| Username   | password   | pin     | Profile             | Subsystem        |
|------------|------------|---------|---------------------|------------------|
| root       | root       | 1234321 | Super Administrador | Todos            |
| admincyber | admincyber | 1234    | Administrador       | Cyber            |
| adminserv  | adminserv  | 1234    | Administrador       | Servicio Técnico |
| regcyber   | regcyber   | 1234    | Regular             | Cyber            |
| regserv    | regserv    | 1234    | Regular             | Servicio Técnico |
| rocyber    | rocyber    | 1234    | Solo Lectura        | Cyber            |
| roserv     | roserv     | 1234    | Solo Lectura        | Servicio Técnico |

# Compatibility

The application has been tested successfully on these web browsers:

* Microsoft Edge
* Google Chrome
* Mozilla Firefox (Only desktop)

The mobile version of Mozilla Firefox does not provide the functionality required in some parts of the app, it is not recommended to use it with this program.

The server side component has been tested successfully on:

* Windows: Windows 11, running XAMPP 8.1.
* Linux: Fedora 37, running Apache 2.4.54, PHP 8.1.14, MariaDB 15.1.