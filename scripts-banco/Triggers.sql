CREATE OR REPLACE FUNCTION checarVagaseUsuario() 
RETURNS trigger AS $$
DECLARE
	qtd_vagas int;
	usuario text;
BEGIN
	SELECT total_participante INTO qtd_vagas
	FROM evento e 
	WHERE e.id_evento = NEW.fk_evento;
	
	SELECT tipo_usuario INTO usuario
	FROM usuario u
	WHERE u.id_usuario = NEW.fk_usuario;
	
	IF(qtd_vagas < 1) THEN
		UPDATE evento
		SET situacao = 'Esgotado'
		WHERE evento.id_evento = NEW.fk_evento;
		
		RAISE EXCEPTION 'Lamento! A quantidade de vagas do evento esgotou.';
	END IF;

	RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER tg_checarVagaseUsuario
BEFORE INSERT ON participante_evento
FOR EACH ROW 
EXECUTE PROCEDURE checarVagaseUsuario();

CREATE OR REPLACE FUNCTION atualizarQtdVagasEvento() 
RETURNS trigger AS $$
BEGIN
	UPDATE evento
	SET numero_participante = numero_participante - 1
	WHERE evento.id_evento = NEW.fk_evento;
	
	RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER tg_atualizarQtdVagasEvento
AFTER INSERT ON participante_evento
FOR EACH ROW 
EXECUTE PROCEDURE atualizarQtdVagasEvento();

CREATE OR REPLACE FUNCTION checarCPF() 
RETURNS trigger AS $$
DECLARE
	i int;
	cpf_array int[];
	soma1 int := 0;
	soma2 int := 0;
BEGIN

	IF regexp_like(NEW.cpf, '\W') OR length(NEW.cpf) < 11 THEN
    	RAISE EXCEPTION 'Insira o CPF sem caracteres especiais ou insira 11 digitos.';
  END IF;
	
	FOR i IN 1..length(NEW.cpf) LOOP
		cpf_array[i] := CAST(SUBSTRING(NEW.cpf FROM i FOR 1) AS int);
	END LOOP;
	
	FOR i IN 1..9 LOOP
		soma1 := soma1 + cpf_array[i] * (11 - i);
	END LOOP;
	
	soma1 := (soma1 * 10) % 11;
	
	IF soma1 = 10 THEN
        soma1 := 0;
  	END IF;
	
	FOR i IN 1..10 LOOP
		soma2 := soma2 + cpf_array[i] * (12 - i);
	END LOOP;
	
	soma2 := (soma2 * 10) % 11;
	
	IF soma2 = 10 THEN
        soma2 := 0;
  	END IF;

	IF soma1 = cpf_array[10] AND soma2 = cpf_array[11] THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'O CPF inserido não é válido';
    END IF;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER tg_checarCPF
BEFORE INSERT ON usuario
FOR EACH ROW 
EXECUTE PROCEDURE checarCPF();