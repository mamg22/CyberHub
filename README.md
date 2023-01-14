# Sistema de gestión para el Cyber Rodríguez

Este programa forma parte del proyecto que se ha realizado en la comunidad del Cyber Rodríguez como parte del Proyecto Sociotecnológico III de la Universidad Politécnica Territorial de los Altos Mirandinos "Cecilio Acosta" (UPTAMCA).

# Requisitos

Se recomienda instalar XAMPP 8.1 o versiones más nuevas. [Click aquí para descargarlo](https://www.apachefriends.org/es/index.html). Instalando XAMPP 8.1 o posterior se puede instalar fácilmente todos estos requisitos.

Para ejecutar este programa, se deben tener instalado los siguientes programas:

* PHP 8.1 o más reciente
* Base de datos MySQL o MariaDB
* Servidor web

# Instalación

## Con XAMPP

1. Extraer el contenido del archivo ZIP en la carpeta `htdocs` de XAMPP (`C:\xampp\htdocs`); debe colocarse en la carpeta `htdocs` y no una carpeta dentro de ésta. Ejemplo: La carpeta `bd` debe quedar en `C:\xampp\htdocs\bd` luego de copiar los archivos.

2. Iniciar el servidor web y la base de datos (Iniciar Apache y MySQL en XAMPP).

3. Configurar la base de datos: Importar el archivo `bdcyber.sql` que se encuentra en la carpeta `bd` usando phpMyAdmin.

4. OPCIONAL: Importar el archivo `datos-de-prueba.sql` que también se encuentra en la carpeta `bd` usando phpMyAdmin para agregar para probar la aplicación.

5. Abrir la aplicación en el navegador con `http://localhost/`.

## Otros

Para otras configuraciones, seguir los pasos que se hacen en XAMPP, cambiando las ubicaciones de los archivos y la herramienta de gestión de base de datos a las que se estén utilizando.

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

El componente que se ejecuta en el lado del servidor ha sido probado exitosamente en sistemas Windows (Windows 11) y Linux (Fedora 37).