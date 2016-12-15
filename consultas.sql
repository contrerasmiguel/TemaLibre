CREATE DATABASE temalibre
    DEFAULT CHARACTER SET=utf8
    DEFAULT COLLATE=utf8_general_ci
;

USE temalibre;

/*SELECT PASSWORD('administrador');*/

CREATE USER 'temalibre_administrador'@'%' IDENTIFIED VIA mysql_native_password USING '*EFC258DA67C9F942793CDD8A2050C469256C7192';
GRANT ALL PRIVILEGES ON *.* TO 'temalibre_administrador'@'%' REQUIRE NONE 
WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE USER 'temalibre_administrador'@'localhost' IDENTIFIED VIA mysql_native_password USING '*EFC258DA67C9F942793CDD8A2050C469256C7192';
GRANT ALL PRIVILEGES ON *.* TO 'temalibre_administrador'@'localhost' REQUIRE NONE 
WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

/*SELECT PASSWORD('aplicacion');*/

CREATE USER 'temalibre_aplicacion'@'%' IDENTIFIED VIA mysql_native_password USING '*75D8C379097F31BC63DDB4908E478B415985AC94';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'temalibre_aplicacion'@'%' REQUIRE NONE 
WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE USER 'temalibre_aplicacion'@'localhost' IDENTIFIED VIA mysql_native_password USING '*75D8C379097F31BC63DDB4908E478B415985AC94';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'temalibre_aplicacion'@'localhost' REQUIRE NONE 
WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE TABLE usuarios (
      id_usuario INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , nombre_usuario VARCHAR(32) NOT NULL UNIQUE
    , clave CHAR(255) NOT NULL
    , remember_token CHAR(100) NULL
    , correo_electronico VARCHAR(255) NOT NULL UNIQUE
    , fecha_registro DATETIME NOT NULL
    , nombre VARCHAR(35) NOT NULL
    , apellido VARCHAR(35) NOT NULL
    , pregunta_secreta VARCHAR(255) NOT NULL
    , respuesta_secreta VARCHAR(255) NOT NULL
) ENGINE=INNODB;

CREATE TABLE administradores (
      id_administrador INT NOT NULL PRIMARY KEY 
    , fecha_promocion DATETIME NOT NULL 
    , FOREIGN KEY (id_administrador) REFERENCES usuarios(id_usuario)
) ENGINE=INNODB;

CREATE TABLE bloqueos (
      id_bloqueo INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , id_usuario_bloqueado INT NOT NULL
    , id_usuario_que_bloquea INT NOT NULL
    , activo BOOLEAN NOT NULL
    , fecha_bloqueo DATETIME NOT NULL
    , FOREIGN KEY (id_usuario_bloqueado) REFERENCES usuarios(id_usuario)
    , FOREIGN KEY (id_usuario_que_bloquea) REFERENCES usuarios(id_usuario)
    , UNIQUE (id_usuario_bloqueado, id_usuario_que_bloquea)
    , CHECK (NOT (id_usuario_bloqueado = id_usuario_que_bloquea))
) ENGINE=INNODB;

CREATE TABLE suspensiones (
      id_suspension INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , id_usuario_suspendido INT NOT NULL
    , id_administrador_que_suspende INT NOT NULL
    , motivo VARCHAR (255) NULL
    , fecha_suspension DATETIME NOT NULL
    , FOREIGN KEY (id_usuario_suspendido) REFERENCES usuarios(id_usuario)
    , FOREIGN KEY (id_administrador_que_suspende) REFERENCES administradores(id_administrador)
    , CHECK (NOT (id_usuario_suspendido = id_administrador_que_suspende))
) ENGINE=INNODB;

CREATE TABLE temas (
      id_tema INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , id_usuario_creador INT NOT NULL
    , titulo VARCHAR(64) NOT NULL
    , descripcion VARCHAR(160) NULL
    , fecha_creacion DATETIME NOT NULL
    , FOREIGN KEY (id_usuario_creador) REFERENCES usuarios(id_usuario)
    , UNIQUE (id_usuario_creador, titulo)
) ENGINE=INNODB;

CREATE TABLE temas_eliminados (
      id_tema_eliminado INT NOT NULL PRIMARY KEY
    , id_usuario_que_elimina INT NOT NULL
    , motivo_eliminacion_tema VARCHAR(255) NULL
    , fecha_eliminacion DATETIME NOT NULL
    , FOREIGN KEY (id_tema_eliminado) REFERENCES temas(id_tema)
    , FOREIGN KEY (id_usuario_que_elimina) REFERENCES usuarios(id_usuario)
) ENGINE=INNODB;

CREATE TABLE suscripciones_temas (
      id_suscripcion INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , id_tema_suscrito INT NOT NULL
    , id_usuario_suscrito INT NOT NULL
    , activo BOOLEAN NOT NULL
    , fecha_suscripcion DATETIME NOT NULL
    , FOREIGN KEY (id_tema_suscrito) REFERENCES temas(id_tema)
    , FOREIGN KEY (id_usuario_suscrito) REFERENCES usuarios(id_usuario)
) ENGINE=INNODB;

CREATE TABLE comentarios (
      id_comentario INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , id_tema_comentado INT NOT NULL 
    , id_usuario_creador INT NOT NULL 
    , contenido_comentario VARCHAR(160) NOT NULL
    , fecha_creacion DATETIME NOT NULL
    , FOREIGN KEY (id_tema_comentado) REFERENCES temas(id_tema)
    , FOREIGN KEY (id_usuario_creador) REFERENCES usuarios(id_usuario)
) ENGINE=INNODB;

CREATE TABLE comentarios_eliminados (
      id_comentario_eliminado INT NOT NULL PRIMARY KEY 
    , id_usuario_que_elimina INT NOT NULL
    , motivo_eliminacion_comentario VARCHAR(255) NULL
    , fecha_eliminacion DATETIME NOT NULL
    , FOREIGN KEY (id_comentario_eliminado) REFERENCES comentarios(id_comentario)
    , FOREIGN KEY (id_usuario_que_elimina) REFERENCES usuarios(id_usuario)
) ENGINE=INNODB;

CREATE TABLE expiracion_suspensiones (
      id_suspension INT NOT NULL PRIMARY KEY
    , fecha_expiracion DATETIME NOT NULL
    , fecha_creacion_expiracion DATETIME NOT NULL
    , FOREIGN KEY (id_suspension) REFERENCES suspensiones(id_suspension)
) ENGINE=INNODB;

CREATE TABLE solicitudes_usuario (
      id_solicitud INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    , id_usuario_solicitante INT NOT NULL
    , contenido_solicitud VARCHAR(255) NOT NULL
    , fecha_solicitud DATETIME NOT NULL
    , FOREIGN KEY (id_usuario_solicitante) REFERENCES usuarios(id_usuario)
) ENGINE=INNODB;

CREATE TABLE solicitudes_usuario_atendidas (
      id_solicitud_atendida INT NOT NULL PRIMARY KEY
    , id_administrador_asistente INT NOT NULL
    , resolucion VARCHAR(255) NULL
    , fecha_atencion DATETIME NOT NULL
    , FOREIGN KEY (id_solicitud_atendida) REFERENCES solicitudes_usuario(id_solicitud)
    , FOREIGN KEY (id_administrador_asistente) REFERENCES administradores(id_administrador)
) ENGINE=INNODB;