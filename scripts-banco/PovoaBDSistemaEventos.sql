INSERT INTO usuario(nome_usuario, cpf, email, sexo, cep, bairro, cidade, estado, numero, eh_admin, data_nascimento, senha)
VALUES
	('Usuario', '11111111111', 'usuario@email.com', 'Masculino', '68000-000', 'Jardim Santarém', 'Santarém', 'PA', '1457', '0', '2002/04/02', '$2y$12$Vat3YJMD0n4fQMFHTwPlx.uCG8CaEVsO.of920nFrPKeQJqqR3/qi'),
	('Admin', '22222222222', 'admin@admin.com', 'Feminino', '62000-000', 'Aeroporto Velho', 'Santarém', 'PA', '1245', '1', '1985/03/13', '$2y$12$Vat3YJMD0n4fQMFHTwPlx.uCG8CaEVsO.of920nFrPKeQJqqR3/qi');



INSERT INTO telefone_usuario(fk_idusuario, telefone)
VALUES 
	(1, '93998243821'),
	(1, '93995212547');
	

INSERT INTO modalidade(modalidade)
VALUES 
	('Circuito de Bike'),
	('Corrida de Rua');	
		
/*
Reiniciar sequencia de banco

TRUNCATE TABLE usuario RESTART IDENTITY CASCADE;
TRUNCATE TABLE evento RESTART IDENTITY CASCADE;
TRUNCATE TABLE categoria_evento RESTART IDENTITY CASCADE;
TRUNCATE TABLE kit RESTART IDENTITY CASCADE;
TRUNCATE TABLE evento_kit RESTART IDENTITY CASCADE;
TRUNCATE TABLE participante_evento RESTART IDENTITY CASCADE;
TRUNCATE TABLE telefone_usuario RESTART IDENTITY CASCADE;
*/

