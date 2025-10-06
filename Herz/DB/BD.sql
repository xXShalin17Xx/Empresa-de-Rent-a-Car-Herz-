CREATE DATABASE IF NOT EXISTS Herz; 

USE Herz;

CREATE TABLE Clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(15) NOT NULL UNIQUE,
    licencia VARCHAR(20),
    email VARCHAR(100) UNIQUE,
    telefono VARCHAR(20)
);


CREATE TABLE Sucursales (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(150),
    telefono VARCHAR(20)
);


CREATE TABLE Vehiculos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patente VARCHAR(10) NOT NULL UNIQUE,
    modelo VARCHAR(50),
    tipo VARCHAR(50), 
    estado VARCHAR(20) DEFAULT 'disponible', -- disponible, alquilado, mantenimiento
    idSucursal INT,
    kilometraje DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (idSucursal) REFERENCES Sucursales(id)
);


CREATE TABLE Reservas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estado VARCHAR(20) DEFAULT 'pendiente', -- pendiente, en curso, finalizada, cancelada
    idCliente INT,
    tipoVehiculo VARCHAR(50), 
    fechaInicio DATE,
    fechaFin DATE,
    FOREIGN KEY (idCliente) REFERENCES Clientes(id)
);


CREATE TABLE Alquileres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idReserva INT,
    idVehiculo INT,
    fechaRetiro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fechaDevolucion TIMESTAMP NULL,
    kmInicial DECIMAL(10,2),
    kmFinal DECIMAL(10,2),
    FOREIGN KEY (idReserva) REFERENCES Reservas(id),
    FOREIGN KEY (idVehiculo) REFERENCES Vehiculos(id)
);


CREATE TABLE Mantenimiento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idVehiculo INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tipo VARCHAR(50), -- ej: cambio de aceite, revisión, etc.
    costo DECIMAL(10,2),
    estado VARCHAR(20) DEFAULT 'pendiente', 
    FOREIGN KEY (idVehiculo) REFERENCES Vehiculos(id)
);

-- para cambiar los roles de los usuarios manualmente
UPDATE Clientes
SET idRol = 3
WHERE id = 5;

--  Económicos
INSERT INTO Vehiculos (patente, modelo, tipo, estado, idSucursal, kilometraje) VALUES
('AB123CD', 'Toyota Yaris', 'Económico', 'disponible', 1, 25300.75),
('CD234EF', 'Hyundai i10', 'Económico', 'disponible', 1, 18750.20),
('EF345GH', 'Kia Picanto', 'Económico', 'mantenimiento', 1, 32100.50),
('GH456IJ', 'Chevrolet Spark', 'Económico', 'disponible', 1, 29450.10),
('IJ567KL', 'Nissan March', 'Económico', 'alquilado', 1, 36890.00);

--  Eléctricos
INSERT INTO Vehiculos (patente, modelo, tipo, estado, idSucursal, kilometraje) VALUES
('EL101AA', 'Tesla Model 3', 'Eléctrico', 'disponible', 1, 10500.00),
('EL202BB', 'Nissan Leaf', 'Eléctrico', 'disponible', 1, 8800.30),
('EL303CC', 'BMW i3', 'Eléctrico', 'alquilado', 1, 7600.00),
('EL404DD', 'Renault Zoe', 'Eléctrico', 'disponible', 1, 4950.70),
('EL505EE', 'Hyundai Kona Electric', 'Eléctrico', 'mantenimiento', 1, 6200.40);

--  SUV
INSERT INTO Vehiculos (patente, modelo, tipo, estado, idSucursal, kilometraje) VALUES
('SUV111AA', 'Toyota RAV4', 'SUV', 'disponible', 1, 45000.00),
('SUV222BB', 'Ford Escape', 'SUV', 'disponible', 1, 39200.55),
('SUV333CC', 'Honda CR-V', 'SUV', 'alquilado', 1, 41750.90),
('SUV444DD', 'Kia Sportage', 'SUV', 'mantenimiento', 1, 46230.20),
('SUV555EE', 'Hyundai Tucson', 'SUV', 'disponible', 1, 38500.00);

--  De lujo
INSERT INTO Vehiculos (patente, modelo, tipo, estado, idSucursal, kilometraje) VALUES
('LUX111AA', 'Mercedes-Benz C-Class', 'De lujo', 'disponible', 1, 21400.00),
('LUX222BB', 'BMW 5 Series', 'De lujo', 'disponible', 1, 19850.00),
('LUX333CC', 'Audi A6', 'De lujo', 'alquilado', 1, 23500.80),
('LUX444DD', 'Lexus ES 350', 'De lujo', 'disponible', 1, 17200.10),
('LUX555EE', 'Jaguar XF', 'De lujo', 'mantenimiento', 1, 26500.65);

-- sucursales
INSERT INTO Sucursales (nombre, direccion, telefono) VALUES
('Sucursal Palermo', 'Av. Santa Fe 3456, Palermo, CABA', '011-4321-1000'),
('Sucursal Caballito', 'Av. Rivadavia 5400, Caballito, CABA', '011-4321-1001'),
('Sucursal Belgrano', 'Juramento 2345, Belgrano, CABA', '011-4321-1002'),
('Sucursal Recoleta', 'Av. Callao 1500, Recoleta, CABA', '011-4321-1003'),
('Sucursal Constitución', 'Lima 800, Constitución, CABA', '011-4321-1004');
