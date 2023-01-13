USE bdcyber;

INSERT INTO `Cliente` VALUES
    (1,'Pablo','0212-1231231','10939493'),
    (2,'Natalia','0414-0120036','20985294'),
    (3,'Julia','0416-8575932','19589483'),
    (4,'Tincho','02129584001','15004021');


INSERT INTO `Equipo` VALUES
    (1,'PC-OFC-1','Intel i3 5ta gen, 8GB RAM, HDD 512GB','Windows XP Professional SP 3',2,2,'Actualizacion pendiente'),
    (2,'PC-CYB-1','Intel 4ta gen, 4GB RAM, SSD 128GB','Windows 10 Home, Suite Office',1,1,'Funcional'),
    (3,'PC-CYB-2','AMD Ryzen Threadripper, 64GB RAM, SSD 512GB, 2x HDD 2TB\r\n\r\nNVIDIA RTX 4090','Windows 11, Suite Office, Blender, Suite Adobe',1,1,'Funciona absolutamente bien, ultimo mantenimiento 09/01/2023'),
    (4,'PC-CYB-3','Intel i3 10ma gen, 8GB RAM, HDD 256GB','Windows 11, Suite Office',1,1,'Funciona, ultimo mantenimiento 03/08/2022'),
    (5,'PC-CYB-4','Intel i3 10ma gen, 8GB RAM, HDD 256GB','Windows 11, Suite Office',3,4,'Falla de luz causó que dejara de arrancar'),
    (6,'PC-CYB-5','Intel i3 10ma gen, 8GB RAM, HDD 256GB','Windows 11, Suite Office',5,1,'Funcional');

INSERT INTO `Repuesto` VALUES
    (1,1,'Seagate 256GB HDD',1),
    (2,1,'Seagate 512GB HDD\r\n',6),
    (3,1,'Kioxia 128GB SSD',2),
    (4,2,'Crucial 8GB DDR4',1),
    (5,5,'Intel i5 13700-K',1),
    (6,10,'LG 17\" LCD',2),
    (7,13,'USB-A a Mini USB-a',5),
    (8,14,'Tornillos 7mm',2),
    (9,3,'ASRock MiniATX ',1),
    (10,3,'ASRock MicroATX ',1),
    (11,3,'ASRock ATX ',2);

INSERT INTO `Trabajo_reparacion` VALUES
    (1,'Redmi 7A 2GB RAM, 32GB ROM','Pantalla rota, requiere cambio.','Redmi7a pablo',40.00,0.00,2,1),
    (2,'Laptop HP de 14\", color negro','No arranca, si hace POST y se llega a la BIOS, pero no arranca el sistema.\r\n\r\nTambién se mencionó que la tecla N no funciona a veces.','Laptop julia',60.00,30.00,3,3),
    (3,'IPhone 10, negro','Se apaga solo después de alrededor de 20 minutos de uso. El equipo se sobrecalienta bastante y la batería se agota rápido.','IPhone tincho',75.00,75.00,2,4);
