DROP DATABASE bdcyber;
CREATE DATABASE IF NOT EXISTS bdcyber;
USE bdcyber;

CREATE TABLE IF NOT EXISTS Subsistema_usuario (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO Subsistema_usuario VALUES
    (1, 'Todos'),
    (2, 'Cyber'),
    (3, 'Servicio Tecnico');

CREATE TABLE IF NOT EXISTS Perfil_usuario (
    nivel INTEGER PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO Perfil_usuario VALUES
    (10, 'Super administrador'),
    (20, 'Administrador'),
    (30, 'Regular'),
    (40, 'Solo lectura');

CREATE TABLE IF NOT EXISTS Usuario (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(25) NOT NULL UNIQUE,
    clave VARCHAR(256) NOT NULL,
    pin_recuperacion VARCHAR(256) NOT NULL,
    cedula VARCHAR(15) NOT NULL,
    subsistema INTEGER NOT NULL REFERENCES Subsistema_usuario(id),
    perfil INTEGER NOT NULL REFERENCES Perfil_usuario(nivel)
);

-- Usuarios por defecto, las contrasenas y pines estan en forma de hash
-- para ser comprobados con la funcion `password_verify()` de PHP y
-- generadas mediante `password_hash()`.
-- Estas estan documentadas en la documentacion de la apliacion.
INSERT INTO Usuario VALUES
    (1, 'root',
    '$2y$10$6Yqs4y2WPN1xoNDqYma73Oo7RRhclHRh78qN/HEnbD6Y4PC2Wr8cS',
    '$2y$10$/tDGsZKhqFJyjBazev9Hf.3P26DPq9gl1SEgiqSPuNlbKb2xBDyVG',
    'N/A', 1, 10),
    (2, 'admincyber',
    '$2y$10$.pkT7Vkw0MN2svBjQ7e0S.QTBMYzFEOq95Bnbx/P7jD3H81RGSA2C',
    '$2y$10$LpCprNKL0.Hsyd8hnArFGeTfa3z.Sc6dEn0zPNWsaHaNtWYgBFQeS',
    'N/A', 2, 20),
    (3, 'adminserv',
    '$2y$10$X5z0UMr71ia8tl9m9wHy3OZgnkEUftDFRoIxk7krXf.q9v.pbdbyq',
    '$2y$10$WttEFFvzbvz.MCjr7replO7wpnjqjX089hXRCaw3T3bfCZc5ObPWe',
    'N/A', 3, 20),
    (4, 'regcyber',
    '$2y$10$yMyI5sX36idHQ2eMZ.tEw.LjokZ/NftHaxCW4/eo3i3g7nj6guLaC',
    '$2y$10$9TosP6/XFheZvSTyxpKhc.4QjGj35cRvReKcKltj1QLdoqAUzdKWi',
    'N/A', 2, 30),
    (5, 'regserv',
    '$2y$10$S4nWUfknNh9gPa1kjsCmVOkK39XvKXvCbioIee36xWXPNFdtCUmjO',
    '$2y$10$88.O4u9gEt6hMvbfA91MKOei.3IGbMM.75ET8OBrghLzWARSLKro2',
    'N/A', 3, 30),
    (6, 'rocyber',
    '$2y$10$RHW/MJHh2/cqGnV5Dxh6PelO.OJ3RTNI/BWIReAUYcx8E1UYEDi0W',
    '$2y$10$C4JmOwPK2QsVEZBcBkaKleCrr0ERitquWjZsuqP00W86Nt2hNFRwC',
    'N/A', 2, 40),
    (7, 'roserv',
    '$2y$10$mSGTXOmUbcn6rugaQI6.6.1z4cr/7ldceh1T96cqi7a8g1MxMqiYm',
    '$2y$10$gplCzF3LzaI1bdgHJN5GbuleKZj.eRaGGBo.lQmnTRHMmXCm3kbLO',
    'N/A', 3, 40);

CREATE VIEW Vista_usuario AS
    SELECT u.id as id,
        u.nombre as nombre,
        u.clave as clave,
        u.pin_recuperacion as pin_recuperacion,
        u.cedula as cedula,
        u.subsistema as subsistema,
        u.perfil as perfil,
        su.nombre as nombre_subsistema,
        pu.nombre as nombre_perfil
    FROM Usuario as u
    INNER JOIN Subsistema_usuario as su
        ON u.subsistema = su.id
    INNER JOIN Perfil_usuario as pu
        on u.perfil = pu.nivel;

CREATE TABLE IF NOT EXISTS Tipo_estado (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nombre_estado VARCHAR(50) NOT NULL
);

INSERT INTO Tipo_estado VALUES
    (1, 'Activo'),
    (2, 'Inactivo'),
    (3, 'Por reparar'),
    (4, 'En reparacion'),
    (5, 'Desincorporado');


CREATE TABLE IF NOT EXISTS Estado_equipo (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    tipo_estado INTEGER NOT NULL REFERENCES Tipo_estado(id),
    razon VARCHAR(256) NOT NULL
);

CREATE TABLE IF NOT EXISTS Ubicacion_equipo (
    id INTEGER PRIMARY KEY,
    nombre_ubicacion VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Equipo (
    id INTEGER PRIMARY KEY,
    identificador VARCHAR(30) UNIQUE NOT NULL,
    desc_hardware VARCHAR(500) NOT NULL,
    desc_software VARCHAR(500) NOT NULL,
    ubicacion INTEGER NOT NULL REFERENCES Ubicacion_equipo(id),
    estado INTEGER NOT NULL REFERENCES Estado_equipo(id)
);

CREATE VIEW Vista_equipo AS
    SELECT e.id AS id,
        e.identificador AS identificador,
        e.desc_hardware AS desc_hardware,
        e.desc_software AS desc_software,
        e.ubicacion AS ubicacion,
        e.estado AS estado,
        ue.nombre_ubicacion AS nombre_ubicacion,
        te.nombre_estado AS nombre_estado,
        ee.razon AS razon_estado
    FROM Equipo AS e
    INNER JOIN Ubicacion_equipo AS ue
        ON e.ubicacion = ue.id
    INNER JOIN Estado_equipo AS ee
        ON e.estado = ee.id
    INNER JOIN Tipo_estado AS te
        ON ee.tipo_estado = te.id;

CREATE TABLE IF NOT EXISTS Tipo_repuesto (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO Tipo_repuesto VALUES
    (1, 'Disco duro HDD/SSD'),
    (2, 'Memoria RAM'),
    (3, 'Tarjeta madre'),
    (4, 'Fuente de poder'),
    (5, 'Procesador'),
    (6, 'Tarjeta de video'),
    (7, 'Torre de CPU'),
    (8, 'Tarjeta de expansion'),
    (9, 'Lector de memorias/discos'),
    (10, 'Monitor'),
    (11, 'Teclado'),
    (12, 'Mouse'),
    (13, 'Cable'),
    (14, 'Miscelaneos');

CREATE TABLE IF NOT EXISTS Repuesto (
    id INTEGER PRIMARY KEY,
    tipo INTEGER NOT NULL REFERENCES Tipo_repuesto(id),
    detalles VARCHAR(300) NOT NULL,
    cantidad INTEGER NOT NULL
);

CREATE VIEW Vista_repuesto AS
    SELECT r.id AS id,
        r.tipo AS tipo,
        r.detalles AS detalles,
        r.cantidad AS cantidad,
        tr.nombre AS nombre_tipo
    FROM Repuesto as r
    INNER JOIN Tipo_repuesto as tr
        ON r.tipo = tr.id;

CREATE TABLE IF NOT EXISTS Cliente (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(75) NOT NULL,
    telefono_contacto VARCHAR(20) NOT NULL,
    cedula VARCHAR(15) NOT NULL
);

CREATE TABLE IF NOT EXISTS Estado_trabajo (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO Estado_trabajo VALUES
    (1, 'Pendiente'),
    (2, 'En proceso'),
    (3, 'Completado');

CREATE TABLE IF NOT EXISTS Trabajo_reparacion (
    id INTEGER PRIMARY KEY,
    descripcion_equipo VARCHAR(150) NOT NULL,
    problema VARCHAR(500) NOT NULL,
    identificador VARCHAR(15) UNIQUE  NOT NULL,
    monto_total DECIMAL(20, 3) UNSIGNED NOT NULL,
    monto_cancelado DECIMAL(20, 3) UNSIGNED NOT NULL,
    estado_t INTEGER NOT NULL REFERENCES Estado_trabajo(id),
    cliente INTEGER NOT NULL REFERENCES Cliente(id)
);

CREATE VIEW Vista_trabajos AS
    SELECT t.id AS id,
        t.descripcion_equipo AS descripcion_equipo,
        t.problema AS problema,
        t.identificador AS identificador,
        t.monto_total AS monto_total,
        t.monto_cancelado AS monto_cancelado,
        t.estado_t AS estado_t,
        t.cliente AS cliente,
        et.nombre AS nombre_estado_t
    FROM Trabajo_reparacion AS t
    INNER JOIN Estado_trabajo AS et
        ON t.estado_t = et.id;
