CREATE TABLE estudiante (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_users int(11) NOT NULL,
  id_sexo int(11) NOT NULL DEFAULT '1',
  id_edo_civil int(11) NOT NULL DEFAULT '1',
  id_estudio int(11) NOT NULL DEFAULT '1',
  id_ocupacion int(11) NOT NULL DEFAULT '1',
  id_tiempo_dedicado int(11) NOT NULL DEFAULT '1',
  id_estatus int(11) NOT NULL DEFAULT '1',
  id_fiscal int(11) NOT NULL DEFAULT '1',
  identidad varchar(22)  NOT NULL DEFAULT '1',
  nombre varchar(255)  NOT NULL,
  apellido varchar(40)  NOT NULL,
  fecha_nacimiento date NOT NULL,
  ultima_sesion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  estatus varchar(3)  DEFAULT 'DES',
  PRIMARY KEY (id) 
);

CREATE TABLE sede (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(45) NOT NULL,
  descripcion varchar(65) DEFAULT NULL,
  ciudad varchar(45) DEFAULT NULL,
  direccion varchar(65) DEFAULT NULL,
  telefono varchar(45) DEFAULT NULL,
  fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  estatus varchar(3) DEFAULT NULL, 
  codigo_postal char(10) DEFAULT NULL,
  PRIMARY KEY (id)
) ;

CREATE TABLE cross_sede_usuario (
  FK_sede INT NOT NULL DEFAULT 1,
  FK_user INT NOT NULL DEFAULT 1,
  INDEX FK_sede_idx (FK_sede ASC),
  INDEX FK_user_idx (FK_user ASC),
  CONSTRAINT FK_sede
    FOREIGN KEY (FK_sede)
    REFERENCES siacuam.sede (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK_user
    FOREIGN KEY (FK_user)
    REFERENCES siacuam.users (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE formulario (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(65) NOT NULL,
  estatus varchar(3) DEFAULT 'ACT',
  base varchar(45) NOT NULL,
  PRIMARY KEY (id)
) ;

CREATE TABLE tipo_dato (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(65) NOT NULL,
  estatus VARCHAR(3) NULL DEFAULT 'ACT',
  estructura VARCHAR(150) NULL,
  PRIMARY KEY (id));

CREATE TABLE atributo (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(65) NOT NULL,
  tipo int(11) DEFAULT '1',
  estatus varchar(3) DEFAULT 'ACT',
  base varchar(45) NOT NULL,
  PRIMARY KEY (id)
) ;

CREATE TABLE cross_formulario_rol (
  FK_rol INT NOT NULL DEFAULT 1,
  FK_formulario INT NOT NULL DEFAULT 1,
  INDEX FK_rol_idx (FK_rol ASC),
  INDEX FK_formulario_idx (FK_formulario ASC),
  CONSTRAINT FK_rol
    FOREIGN KEY (FK_rol)
    REFERENCES siacuam.cat_tipo_usuario (id_tipo_usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK_formulario
    FOREIGN KEY (FK_formulario)
    REFERENCES siacuam.formulario (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE cross_formularios (
  formulario INT NOT NULL DEFAULT 1,
  seccion INT NOT NULL DEFAULT 1,
  `order` INT NULL DEFAULT 1); 
  
CREATE TABLE cross_formulario_atributo (
  FK_formulario int(11) NOT NULL DEFAULT '1',
  FK_atributo int(11) NOT NULL DEFAULT '1',
  `order` int(11) DEFAULT '1',
  estatus varchar(3) DEFAULT 'ACT'
) ; 

CREATE TABLE organizacion (
  sede int(11) NOT NULL DEFAULT '1',
  usuario int(11) NOT NULL DEFAULT '1',
  jefe int(11) NOT NULL DEFAULT '1',
  cargo varchar(65) DEFAULT 'empleado'
) ;

CREATE TABLE  categorizacion  (
  id INT NOT NULL,
  nombre VARCHAR(65) NOT NULL,
  descripcion VARCHAR(65) NOT NULL,
  estatus VARCHAR(3) NULL DEFAULT 'ACT',
  `order` INT NULL DEFAULT 1,
  PRIMARY KEY (id));

CREATE TABLE curso (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(65) NOT NULL,
  descripcion varchar(150) DEFAULT NULL,
  FK_oferta int(11) DEFAULT '1',
  FK_facultad int(11) DEFAULT '1',
  estatus varchar(3) DEFAULT 'ACT',
  PRIMARY KEY (id)
)  ;

CREATE TABLE  cross_curso_img (
  FK_curso INT NOT NULL DEFAULT 1,
  FK_img INT NOT NULL DEFAULT 1,
  `order` INT NULL DEFAULT 1);

CREATE TABLE galeria (
  FK_curso int(11) NOT NULL DEFAULT '1',
  FK_img int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE evento (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(65) DEFAULT '',
  descripcion varchar(150) DEFAULT '',
  inicio date NOT NULL,
  fin date NOT NULL,
  FK_sede int(11) DEFAULT '1',
  FK_curso int(11) DEFAULT '1',
  FK_docente int(11) DEFAULT '1',
  FK_costo int(11) DEFAULT '1',
  entradas int(11) DEFAULT '1',
  precio float DEFAULT '0',
  reserva int(11) DEFAULT '1',
  observaciones varchar(150) DEFAULT NULL,
  estatus varchar(3) DEFAULT 'ACT',
  hora0 varchar(10) DEFAULT '0',
  hora1 varchar(10) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

