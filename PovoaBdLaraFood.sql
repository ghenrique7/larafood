-- insert into plans(name, url, price, description)
-- values
-- 	('Plano-01', 'plano-01', 24.99, 'Apenas um plano legal'),
-- 	('Plano Prime', 'plano-prime', 85.99, 'Um plano otimo');

insert into plans(name, url, price)
values
	('BUSINESS', 'business', 499.99),
	('FREE', 'free', 0.00),
	('PREMIUM', 'premium', 299.99);


insert into profiles(name, description)
values 
	('usuario 1', 'descricao teste'),
	('usuario 2', 'descricao teste 2');

insert into details_plan(plan_id, name)
values
	(1, 'Categorias'),
	(1, 'Produtos');