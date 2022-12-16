DROP DATABASE bdcyber;
CREATE DATABASE IF NOT EXISTS bdcyber;
USE bdcyber;

CREATE TABLE IF NOT EXISTS Usuario (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(25),
    clave VARCHAR(256),
    pin_recuperacion VARCHAR(256),
    cedula VARCHAR(15),
    subsistema ENUM('Todos', 'Cyber', 'Reparacion'),
    perfil ENUM('Solo lectura', 'Regular', 'Administrador', 'Super administrador')
);

CREATE TABLE IF NOT EXISTS Estado_equipo (
    id INTEGER PRIMARY KEY,
    tipo_estado ENUM('Activo', 'Inactivo', 'Por reparar', 'En reparacion', 'Desincorporado'),
    razon VARCHAR(256)
);

CREATE TABLE IF NOT EXISTS Ubicacion_equipo (
    id INTEGER PRIMARY KEY,
    nombre_ubicacion VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Equipo (
    id INTEGER PRIMARY KEY,
    identificador VARCHAR(30),
    desc_hardware VARCHAR(500),
    desc_software VARCHAR(500),
    ubicacion INTEGER REFERENCES Ubicacion_equipo(id),
    estado INTEGER REFERENCES Estado_equipo(id)
);

CREATE TABLE IF NOT EXISTS Repuesto (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(60),
    detalles VARCHAR(300),
    cantidad INTEGER
);

CREATE TABLE IF NOT EXISTS Cliente (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(75),
    telefono_contacto VARCHAR(20),
    cedula VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS Trabajo_reparacion (
    id INTEGER PRIMARY KEY,
    descripcion_equipo VARCHAR(150),
    problema VARCHAR(500),
    identificador VARCHAR(10),
    monto_total DECIMAL(20, 3) UNSIGNED,
    monto_cancelado DECIMAL(20, 3) UNSIGNED,
    estado_t ENUM('Pendiente', 'En proceso', 'Completado'),
    cliente INTEGER REFERENCES Cliente(id)
);
