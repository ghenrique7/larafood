CREATE OR REPLACE FUNCTION getQtdParticipantes(id_evento int) 
RETURNS int AS $$
	SELECT COUNT(*)
	FROM participante_evento pe
	WHERE pe.fk_idevento = id_evento;
$$ LANGUAGE sql;

SELECT getQtdParticipantes(1);

CREATE OR REPLACE FUNCTION getEventosModalidade(p_id_modalidade int)
RETURNS setof text AS $$
	SELECT e.nome_evento
	FROM modalidade m
		JOIN evento e ON (m.id_modalidade = e.fk_idmodalidade)
	WHERE e.fk_idmodalidade = p_id_modalidade;
$$ LANGUAGE sql;

SELECT getEventosModalidade(2);

CREATE OR REPLACE FUNCTION getEventosParticipante(p_id_usuario int)
RETURNS TABLE (nome_evento text, nome_usuario text) AS $$
	SELECT e.nome_evento, u.nome_usuario
	FROM evento e
		JOIN participante_evento pe ON (e.id_evento = pe.fk_idevento)
		JOIN usuario u ON (pe.fk_idusuario = u.id_usuario)
	WHERE pe.fk_idusuario = p_id_usuario;
$$ LANGUAGE sql;

SELECT getEventosParticipante(4);