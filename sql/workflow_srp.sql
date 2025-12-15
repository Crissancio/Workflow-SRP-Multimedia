
-- =====================================================
-- TABLA: FLUJO
-- =====================================================
CREATE TABLE flujo (
    id_flujo INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

INSERT INTO flujo (codigo, nombre, descripcion) VALUES
('SRP', 'Workflow Vacunación SRP',
 'Proceso de vacunación contra Sarampión, Rubéola y Paperas');

-- =====================================================
-- TABLA: PROCESO
-- =====================================================
CREATE TABLE proceso (
    id_proceso INT AUTO_INCREMENT PRIMARY KEY,
    id_flujo INT,
    codigo VARCHAR(10),
    nombre VARCHAR(100),
    pantalla VARCHAR(50),
    orden INT,
    FOREIGN KEY (id_flujo) REFERENCES flujo(id_flujo)
);

INSERT INTO proceso (id_flujo, codigo, nombre, pantalla, orden) VALUES
(1, 'P1', 'Registro del Paciente', 'registro', 1),
(1, 'P2', 'Revisión Clínica', 'revision', 2),
(1, 'P3', 'Verificación del Esquema', 'esquema', 3),
(1, 'P4', 'Verificación de Edad', 'verificar_edad', 4),
(1, 'P5', 'Autorización del Tutor', 'autorizacion', 5),
(1, 'P6', 'Registro de Vacunación', 'registro_vacuna', 6),
(1, 'P7', 'Observación', 'observacion', 7),
(1, 'P8', 'Evento Adverso', 'evento', 8),
(1, 'P9', 'Fin del Proceso', 'fin', 9);

-- =====================================================
-- TABLA: PACIENTE
-- =====================================================
CREATE TABLE paciente (
    ci VARCHAR(15) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    sexo CHAR(1) NOT NULL
);

-- =====================================================
-- TABLA: SEGUIMIENTO
-- =====================================================
CREATE TABLE seguimiento (
    id_seguimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_flujo INT,
    id_proceso_actual INT,
    ci_paciente VARCHAR(15),
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    estado VARCHAR(20),
    FOREIGN KEY (id_flujo) REFERENCES flujo(id_flujo),
    FOREIGN KEY (id_proceso_actual) REFERENCES proceso(id_proceso),
    FOREIGN KEY (ci_paciente) REFERENCES paciente(ci)
);

-- =====================================================
-- TABLA: REGISTRO CLÍNICO
-- =====================================================
CREATE TABLE registro_clinico (
    id_registro INT AUTO_INCREMENT PRIMARY KEY,
    id_seguimiento INT NOT NULL,
    fiebre BOOLEAN DEFAULT 0,
    alergias BOOLEAN DEFAULT 0,
    inmunodeficiencia BOOLEAN DEFAULT 0,
    embarazo BOOLEAN DEFAULT 0,
    FOREIGN KEY (id_seguimiento) REFERENCES seguimiento(id_seguimiento)
);

-- =====================================================
-- TABLA: VACUNACIÓN SRP (HISTORIAL REAL)
-- =====================================================
CREATE TABLE vacunacion_srp (
    id_vacunacion INT AUTO_INCREMENT PRIMARY KEY,
    ci_paciente VARCHAR(15),
    fecha_aplicacion DATE,
    dosis INT,
    tipo_vacuna VARCHAR(50),
    FOREIGN KEY (ci_paciente) REFERENCES paciente(ci)
);

-- =====================================================
-- TABLA: EVENTO ADVERSO
-- =====================================================
CREATE TABLE evento_adverso (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_seguimiento INT,
    tipo VARCHAR(50),
    descripcion TEXT,
    fecha DATETIME DEFAULT NOW(),
    FOREIGN KEY (id_seguimiento) REFERENCES seguimiento(id_seguimiento)
);

-- =====================================================
-- TABLA: TRANSICIÓN (CORAZÓN DEL WORKFLOW)
-- =====================================================
CREATE TABLE transicion (
    id_transicion INT AUTO_INCREMENT PRIMARY KEY,
    proceso_origen INT,
    condicion VARCHAR(30),
    proceso_destino INT,
    FOREIGN KEY (proceso_origen) REFERENCES proceso(id_proceso),
    FOREIGN KEY (proceso_destino) REFERENCES proceso(id_proceso)
);

-- =====================================================
-- TRANSICIONES DEL WORKFLOW SRP
-- =====================================================
-- Registro → Revisión
INSERT INTO transicion VALUES (NULL, 1, 'siempre', 2);

-- Revisión clínica
INSERT INTO transicion VALUES (NULL, 2, 'riesgo', 9);
INSERT INTO transicion VALUES (NULL, 2, 'sin_riesgo', 3);

-- Verificación del esquema
INSERT INTO transicion VALUES (NULL, 3, 'completo', 9);
INSERT INTO transicion VALUES (NULL, 3, 'incompleto', 4);

-- Verificación de edad
INSERT INTO transicion VALUES (NULL, 4, 'mayor', 6);
INSERT INTO transicion VALUES (NULL, 4, 'menor', 5);

-- Autorización
INSERT INTO transicion VALUES (NULL, 5, 'autorizado', 6);
INSERT INTO transicion VALUES (NULL, 5, 'no_autorizado', 1);

-- Registro vacunación
INSERT INTO transicion VALUES (NULL, 6, 'aplicada', 7);

-- Observación
INSERT INTO transicion VALUES (NULL, 7, 'evento', 8);
INSERT INTO transicion VALUES (NULL, 7, 'normal', 9);

-- Evento adverso
INSERT INTO transicion VALUES (NULL, 8, 'registrado', 9);
