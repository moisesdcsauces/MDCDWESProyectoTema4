-- Carga inicial


USE DBMDCDWESProyectoTema4;

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
