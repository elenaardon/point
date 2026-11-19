-- ============================================================
--  Point · Base de datos (MySQL / MariaDB)
--  Cómo usarlo: phpMyAdmin → pestaña "Importar" → elegir este archivo → Continuar.
-- ============================================================
CREATE DATABASE IF NOT EXISTS point_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE point_db;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS favoritos, contactos, usuarios, palas, clubes, marcas, plan_beneficios, planes, faqs;
SET FOREIGN_KEY_CHECKS = 1;

-- ---------- MARCAS (solo informativas: cada pala pertenece a una marca; no se muestran logos) ----------
CREATE TABLE marcas (
  id_marca   INT          NOT NULL AUTO_INCREMENT,
  nombre     VARCHAR(60)  NOT NULL,
  PRIMARY KEY (id_marca),
  UNIQUE KEY uq_marcas_nombre (nombre)
) ENGINE=InnoDB;

-- ---------- PALAS (cada pala pertenece a una marca) ----------
CREATE TABLE palas (
  id_pala      INT           NOT NULL AUTO_INCREMENT,
  id_marca     INT           NOT NULL,
  modelo       VARCHAR(80)   NOT NULL,
  nivel        VARCHAR(40)   NULL,
  peso_g       INT           NULL,
  balance_cm   DECIMAL(4,1)  NULL,
  tamano_cm2   INT           NULL,
  imagen       VARCHAR(200)  NULL,
  color_fondo  VARCHAR(9)    NULL,
  PRIMARY KEY (id_pala),
  UNIQUE KEY uq_pala_marca_modelo (id_marca, modelo),
  CONSTRAINT fk_palas_marca FOREIGN KEY (id_marca) REFERENCES marcas (id_marca)
) ENGINE=InnoDB;

-- ---------- PLANES y sus beneficios ----------
CREATE TABLE planes (
  id_plan       INT         NOT NULL AUTO_INCREMENT,
  nombre        VARCHAR(40) NOT NULL,
  precio_texto  VARCHAR(40) NOT NULL,
  destacado     TINYINT(1)  NOT NULL DEFAULT 0,
  PRIMARY KEY (id_plan),
  UNIQUE KEY uq_planes_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE plan_beneficios (
  id_beneficio INT          NOT NULL AUTO_INCREMENT,
  id_plan      INT          NOT NULL,
  texto        VARCHAR(120) NOT NULL,
  orden        INT          NOT NULL DEFAULT 1,
  PRIMARY KEY (id_beneficio),
  CONSTRAINT fk_beneficios_plan FOREIGN KEY (id_plan) REFERENCES planes (id_plan) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------- USUARIOS (tienen un plan y, opcionalmente, una pala actual) ----------
CREATE TABLE usuarios (
  id_usuario      INT          NOT NULL AUTO_INCREMENT,
  nombre          VARCHAR(80)  NOT NULL,
  email           VARCHAR(120) NOT NULL,
  password_hash   VARCHAR(255) NOT NULL,
  id_plan         INT          NOT NULL DEFAULT 1,
  id_pala_actual  INT          NULL,
  fecha_registro  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_usuario),
  UNIQUE KEY uq_usuarios_email (email),
  CONSTRAINT fk_usuarios_plan FOREIGN KEY (id_plan)        REFERENCES planes (id_plan),
  CONSTRAINT fk_usuarios_pala FOREIGN KEY (id_pala_actual) REFERENCES palas  (id_pala) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------- FAVORITOS (relación muchos a muchos: usuarios <-> palas) ----------
CREATE TABLE favoritos (
  id_favorito     INT      NOT NULL AUTO_INCREMENT,
  id_usuario      INT      NOT NULL,
  id_pala         INT      NOT NULL,
  fecha_agregado  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_favorito),
  UNIQUE KEY uq_favorito_usuario_pala (id_usuario, id_pala),
  CONSTRAINT fk_favoritos_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE,
  CONSTRAINT fk_favoritos_pala    FOREIGN KEY (id_pala)    REFERENCES palas    (id_pala)    ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------- CLUBES (para el buscador de la sección Play) ----------
CREATE TABLE clubes (
  id_club      INT          NOT NULL AUTO_INCREMENT,
  nombre       VARCHAR(100) NOT NULL,
  ciudad       VARCHAR(80)  NOT NULL,
  pais         VARCHAR(40)  NOT NULL,
  canchas      INT          NOT NULL DEFAULT 1,
  ofrece       VARCHAR(160) NOT NULL,
  PRIMARY KEY (id_club),
  UNIQUE KEY uq_club_nombre_ciudad (nombre, ciudad)
) ENGINE=InnoDB;

-- ---------- CONTACTOS (mensajes del formulario de contacto) ----------
CREATE TABLE contactos (
  id_contacto  INT          NOT NULL AUTO_INCREMENT,
  nombre       VARCHAR(100) NOT NULL,
  email        VARCHAR(150) NOT NULL,
  asunto       VARCHAR(100) NOT NULL,
  mensaje      TEXT         NOT NULL,
  fecha_envio  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_contacto)
) ENGINE=InnoDB;

-- ---------- PREGUNTAS FRECUENTES ----------
CREATE TABLE faqs (
  id_faq     INT          NOT NULL AUTO_INCREMENT,
  pregunta   VARCHAR(200) NOT NULL,
  respuesta  TEXT         NOT NULL,
  orden      INT          NOT NULL DEFAULT 1,
  PRIMARY KEY (id_faq)
) ENGINE=InnoDB;

-- ============================================================
--  DATOS INICIALES
-- ============================================================
INSERT INTO marcas (id_marca, nombre) VALUES
 (1,'Bullpadel'),(2,'Babolat'),(3,'Siux'),(4,'Nox'),(5,'Head'),(6,'Adidas'),(7,'Wilson');

INSERT INTO palas (id_pala, id_marca, modelo, nivel, peso_g, balance_cm, tamano_cm2, imagen, color_fondo) VALUES
 (1,1,'Wonder 2026','Nivel avanzado',365,26.0,365,'assets/img/palas/bullpadel-wonder-2026.webp',NULL),
 (2,1,'Vertex',NULL,NULL,NULL,NULL,'assets/img/palas/bullpadel-vertex.jpg','#e5e5e5'),
 (3,2,'Technical Viper',NULL,NULL,NULL,NULL,'assets/img/palas/babolat-technical-viper.webp',NULL),
 (4,3,'Diablo',NULL,NULL,NULL,NULL,'assets/img/palas/siux-diablo.webp',NULL),
 (5,4,'AT10 Genius',NULL,NULL,NULL,NULL,'assets/img/palas/nox-at10-genius.webp',NULL),
 (6,5,'Speed Pro',NULL,NULL,NULL,NULL,NULL,NULL),
 (7,6,'Metalbone',NULL,NULL,NULL,NULL,NULL,NULL),
 (8,1,'Hack 03',NULL,NULL,NULL,NULL,NULL,NULL),
 (9,1,'Vertex 04',NULL,NULL,NULL,NULL,NULL,NULL),
 (10,2,'Air Viper',NULL,NULL,NULL,NULL,NULL,NULL),
 (11,3,'Fenix',NULL,NULL,NULL,NULL,NULL,NULL),
 (12,4,'ML10 Pro Cup',NULL,NULL,NULL,NULL,NULL,NULL),
 (13,5,'Delta Pro',NULL,NULL,NULL,NULL,NULL,NULL),
 (14,6,'Adipower',NULL,NULL,NULL,NULL,NULL,NULL),
 (15,7,'Bela Pro',NULL,NULL,NULL,NULL,NULL,NULL);

INSERT INTO planes (id_plan, nombre, precio_texto, destacado) VALUES
 (1,'Jugadores','Gratis',0),
 (2,'Club Básico','USD 200',0),
 (3,'Club Completo','USD 300',1);

INSERT INTO plan_beneficios (id_plan, texto, orden) VALUES
 (1,'Registro de partidos con Live Match',1),(1,'Estadísticas y Mi raqueta',2),(1,'Reservar canchas, clases y americanos',3),(1,'Partidos abiertos y torneos',4),
 (2,'Reserva de canchas desde la app',1),(2,'Perfil del club con imágenes de cada cancha',2),(2,'Tu club visible en el buscador Cerca de mí',3),
 (3,'Todo lo del plan Básico',1),(3,'Sesión de fotos para coaches y visuales en la app',2),(3,'Publicidad mediante notificaciones',3),(3,'Americanos y torneos con llaves automáticas al cargar el resultado',4),(3,'Sección Actividades de la semana de tu club',5);

INSERT INTO clubes (id_club, nombre, ciudad, pais, canchas, ofrece) VALUES
 (1,'Club Demo Palermo','Buenos Aires','Argentina',6,'Reserva de canchas, clases y americanos'),
 (2,'Club Demo Belgrano','Buenos Aires','Argentina',4,'Reserva de canchas y torneos'),
 (3,'Club Demo Escalón','San Salvador','El Salvador',5,'Reserva de canchas, clases y torneos'),
 (4,'Club Demo Santa Tecla','Santa Tecla','El Salvador',3,'Reserva de canchas'),
 (5,'Club Demo Zona 10','Ciudad de Guatemala','Guatemala',6,'Reserva de canchas, clases y americanos');

INSERT INTO faqs (pregunta, respuesta, orden) VALUES
 ('¿Point cuesta algo para los jugadores?','No. Point es totalmente gratis para los jugadores. Los clubes son quienes se suscriben para ofrecer reservas, americanos y torneos.',1),
 ('¿Necesito un reloj para usar Point?','No. Puedes usar la app con el token electrónico, sin Apple Watch. También puedes cargar los puntos desde el celular al terminar el partido.',2),
 ('¿Qué puedo reservar desde la app?','Canchas, clases y americanos. También puedes encontrar partidos abiertos, canchas libres e inscribirte a torneos.',3),
 ('¿Se pueden registrar partidos individuales?','Por ahora Point registra partidos de dobles, que es como se juega el pádel.',4),
 ('¿Cómo se paga una reserva?','Con Apple Pay o con tarjeta, desde la misma app.',5),
 ('¿Mis estadísticas son públicas?','No necesariamente. En Perfil puedes elegir entre perfil privado o público.',6),
 ('¿Mi pala no aparece en la lista?','Escríbela en Mi raqueta: si tienes sesión iniciada, puedes agregarla a Point con su marca y modelo.',7),
 ('¿En qué países está Point?','Estamos empezando en Argentina, El Salvador y Guatemala.',8);


-- ============================================================
--  DATOS DE PRUEBA (para probar el login, la zona segura y las relaciones)
-- ============================================================
-- Usuario de prueba -> correo: demo@point.com   contraseña: Point1234
-- (la contraseña está guardada cifrada, igual que las cuentas creadas desde la web)
INSERT INTO usuarios (id_usuario, nombre, email, password_hash, id_plan, id_pala_actual) VALUES
 (1,'Usuario Demo','demo@point.com','$2y$10$l3YTyDzUHeolAJhXvpzmIe9jg9ob0NlUtsZX4yjwBxttI3VMcZZ9u',1,1);

-- Palas favoritas del usuario de prueba (Bullpadel Wonder 2026 y Babolat Technical Viper)
INSERT INTO favoritos (id_usuario, id_pala) VALUES
 (1,1),(1,3);

-- Un mensaje de ejemplo del formulario de contacto
INSERT INTO contactos (nombre, email, asunto, mensaje) VALUES
 ('Martina Suárez','martina@correo.com','Quiero sumar mi club','Hola, tengo un club en Buenos Aires y me gustaría conocer el plan Club Completo.');
