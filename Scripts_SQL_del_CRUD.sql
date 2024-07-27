-- scripts de sql 
CREATE DATABASE crud_pasteles;
USE crud_pasteles;

-- creamos la tabla pasel 


CREATE TABLE Pastel (
    ID_pastel INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Preparado_por VARCHAR(100),
    Fecha_creacion DATE,
    Fecha_Vencimiento DATE
);

-- creamos la tabla ingredientes 

CREATE TABLE Ingrediente (
    ID_ingrediente INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Fecha_ingreso DATE,
    Fecha_Vencimiento DATE
);


-- creamos la tabla pasel ingredientes esta es una tabla pibote para la relación uno a muchos  
CREATE TABLE Pastel_Ingredientes (
    ID_Pastel_Ingrediente INT AUTO_INCREMENT PRIMARY KEY,
    ID_pastel INT,
    ID_ingrediente INT,
    FOREIGN KEY (ID_pastel) REFERENCES Pastel(ID_pastel) ON DELETE CASCADE,
    FOREIGN KEY (ID_ingrediente) REFERENCES Ingrediente(ID_ingrediente) ON DELETE CASCADE
);


-- datos de prueba 
INSERT INTO Pastel (Nombre, Descripcion, Preparado_por, Fecha_creacion, Fecha_Vencimiento)
VALUES
('Pastel de Chocolate', 'Pastel de chocolate con cobertura de chocolate', 'Ana', '2024-07-01', '2024-08-01'),
('Pastel de Vainilla', 'Pastel de vainilla con relleno de crema', 'Carlos', '2024-07-05', '2024-08-05');

INSERT INTO Ingrediente (Nombre, Descripcion, Fecha_ingreso, Fecha_Vencimiento)
VALUES
('Harina', 'Harina de trigo', '2024-06-20', '2025-06-20'),
('Azúcar', 'Azúcar blanca', '2024-06-22', '2025-06-22'),
('Huevos', 'Huevos frescos', '2024-06-25', '2024-07-25'),
('Chocolate', 'Chocolate en polvo', '2024-06-26', '2025-06-26'),
('Vainilla', 'Extracto de vainilla', '2024-06-27', '2025-06-27');

INSERT INTO Pastel_Ingredientes (ID_pastel, ID_ingrediente)
VALUES
(1, 1), -- Pastel de Chocolate con Harina
(1, 2), -- Pastel de Chocolate con Azúcar
(1, 3), -- Pastel de Chocolate con Huevos
(1, 4), -- Pastel de Chocolate con Chocolate
(2, 1), -- Pastel de Vainilla con Harina
(2, 2), -- Pastel de Vainilla con Azúcar
(2, 3), -- Pastel de Vainilla con Huevos
(2, 5); -- Pastel de Vainilla con Vainilla



