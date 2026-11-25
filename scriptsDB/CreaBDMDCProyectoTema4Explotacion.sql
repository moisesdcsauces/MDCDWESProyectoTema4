-- Creación de la tabla y carga inicial para el entorno de EXPLOTACIÓN (Plesk)
-- La base de datos y el usuario se crean desde el panel de Plesk (Bases de datos > Añadir base de datos),
-- porque en Plesk no hay permisos para CREATE DATABASE, CREATE USER ni GRANT.
-- Este script se ejecuta en phpMyAdmin con la base de datos ya seleccionada.

-- Creación de la tabla
CREATE TABLE IF NOT EXISTS T02_Departamento (
  T02_CodDepartamento  CHAR(3) NOT NULL PRIMARY KEY,
  T02_DescDepartamento VARCHAR(255) NOT NULL,
  T02_FechaCreacionDepartamento DATETIME NOT NULL,
  T02_VolumenDeNegocio FLOAT NULL,
  T02_FechaBajaDepartamento DATETIME NULL) ENGINE=InnoDB;

-- Carga inicial
INSERT INTO T02_Departamento
  (T02_CodDepartamento,
   T02_DescDepartamento,
   T02_FechaCreacionDepartamento,
   T02_VolumenDeNegocio,
   T02_FechaBajaDepartamento)
VALUES
  ('ADM', 'Administración', '2024-01-15 09:00:00', 125000.00, NULL),
  ('COM', 'Comercial',      '2024-01-15 09:00:00', 240000.00, NULL),
  ('FIN', 'Finanzas',       '2024-01-15 09:00:00', 180000.00, NULL),
  ('TEC', 'Tecnología',     '2024-01-15 09:00:00', 310000.00, NULL),
  ('VEN', 'Ventas',         '2024-01-15 09:00:00', 275000.00, '2026-01-15 13:34:00');
