/* Enums e Dominios */

CREATE TYPE enum_situacao_evento AS ENUM ('Em andamento', 'Finalizado', 'Esgotado');

CREATE TYPE enum_situacao_inscricao AS ENUM ('Inscrito', 'Pendente');

CREATE TYPE enum_sexo AS ENUM ('Masculino', 'Feminino');

CREATE DOMAIN dm_data_evento AS timestamp
NOT NULL
CHECK(VALUE > CURRENT_DATE + 7);

CREATE DOMAIN dm_data_nascimento AS date
NOT NULL
CHECK(VALUE > '1950/01/01');


/* Criação do Banco */

CREATE TABLE usuario (
	id_usuario serial,
	nome_usuario varchar(45) NOT NULL,
	cpf varchar(11) NOT NULL UNIQUE,
	email varchar(45) NOT NULL UNIQUE,
	sexo enum_sexo NOT NULL,
	data_nascimento dm_data_nascimento,
	cep varchar(15) NOT NULL,
	bairro varchar(30) NOT NULL,
	cidade varchar(30) NOT NULL,
	estado char(2) NOT NULL,
	numero varchar(10) NOT NULL,
	eh_admin boolean NOT NULL DEFAULT '0',
	PRIMARY KEY (id_usuario)
);

CREATE TABLE telefone_usuario(
	fk_idusuario serial NOT NULL,
	telefone varchar(11) NOT NULL,
	PRIMARY KEY(fk_idusuario, telefone),
	FOREIGN KEY (fk_idusuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE modalidade(
	id_modalidade serial,
	modalidade VARCHAR(45) NOT NULL,
	PRIMARY KEY (id_modalidade)
);

CREATE TABLE evento(
	id_evento serial,
	nome_evento varchar(45) NOT NULL,
	descricao text,
	premiacao text,
	data_hora dm_data_evento,
	total_participante integer NOT NULL,
	situacao enum_situacao_evento DEFAULT 'Em andamento',
	kit text NOT NULL,
	categoria text,
	distancia text NOT NULL,
	inscricao text,
	imagem_arte text,
	detalhe_entrega_kit text,
	fk_idmodalidade serial,
	PRIMARY KEY (id_evento),
	FOREIGN KEY (fk_idmodalidade) REFERENCES modalidade(id_modalidade) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE participante_evento (
	fk_idusuario serial NOT NULL,
	fk_idevento serial NOT NULL,
	situacao_inscricao enum_situacao_inscricao DEFAULT 'Inscrito',
	PRIMARY KEY(fk_idusuario, fk_idevento),
	FOREIGN KEY (fk_idusuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE SET NULL,
	FOREIGN KEY (fk_idevento) REFERENCES evento(id_evento) ON UPDATE CASCADE ON DELETE SET NULL
);
