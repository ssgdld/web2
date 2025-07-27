-- Tabla PROYECTO
CREATE TABLE IF NOT EXISTS PROYECTO (
  id_proyecto   INT AUTO_INCREMENT PRIMARY KEY,
  nombre        VARCHAR(100) NOT NULL,
  descripcion   TEXT        NOT NULL,
  presupuesto   DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  fecha_inicio  DATE        NOT NULL,
  fecha_fin     DATE        NULL
) ENGINE=InnoDB;

-- Tabla DONANTE
CREATE TABLE IF NOT EXISTS DONANTE (
  id_donante    INT AUTO_INCREMENT PRIMARY KEY,
  nombre        VARCHAR(100) NOT NULL,
  email         VARCHAR(150) NOT NULL UNIQUE,
  direccion     VARCHAR(200),
  telefono      VARCHAR(20)
) ENGINE=InnoDB;

-- Tabla DONACION
CREATE TABLE IF NOT EXISTS DONACION (
  id_donacion   INT AUTO_INCREMENT PRIMARY KEY,
  monto         DECIMAL(10,2) NOT NULL,
  fecha         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_proyecto   INT NOT NULL,donacion
  id_donante    INT NOT NULL,
  FOREIGN KEY (id_proyecto) REFERENCES PROYECTO(id_proyecto) ON DELETE CASCADE,
  FOREIGN KEY (id_donante)  REFERENCES DONANTE(id_donante)   ON DELETE CASCADE
) ENGINE=InnoDB;