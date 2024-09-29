create database Cinemania;
use Cinemania;

create table tb_usuario (
	id_usuario int primary key auto_increment,
    nome_usuario varchar(100) not null,
    email_usuario varchar(100) not null,
    data_nasc_usuario date not null,
    cpf_usuario varchar(15) not null,
    preco_filme varchar(100),
    senha_usuario varchar(255) not null default '123'
);



create table tb_comida (
	id_comida int primary key auto_increment,
    nome_comida varchar(100) not null,
    preco_comida decimal(5,2) not null,
    tipo_comida varchar(50) not null,
    disponibilidade_comida tinyint not null
);

INSERT INTO tb_comida (nome_comida, preco_comida, tipo_comida, disponibilidade_comida) VALUES
('Pipoca Grande', 15.00, 'Aperitivo', 1),
('Pipoca Média', 10.00, 'Aperitivo', 1),
('Pipoca Doce', 12.00, 'Aperitivo', 1),
('Refrigerante Lata', 5.00, 'Bebida', 1),
('Água Mineral', 4.00, 'Bebida', 1),
('Cerveja Long Neck', 9.00, 'Bebida', 1),
('Sanduíche de Frango', 18.00, 'Principal', 1),
('Nachos com Queijo', 12.00, 'Aperitivo', 1),
('Chocolate em Barras', 6.00, 'Sobremesa', 1),
('Bala de Goma', 3.00, 'Sobremesa', 1);


insert into tb_comida (nome_comida, preco_comida, tipo_comida, disponibilidade_comida)
values 
('Coca-Cola', '10.00','bebida', 1);
insert into tb_comida (nome_comida, preco_comida, tipo_comida, disponibilidade_comida)
values 
('Guarana Antártica', '10.50','bebida', 1),
('Pepsi', '10.00','bebida', 1),
('Ruffles', '9.50','salgado', 1);

create table tb_filme (
	id_filme int primary key auto_increment,
    titulo_filme varchar(100) not null,
    genero_filme varchar(50) not null,
    descricao text not null,
    preco_ingresso int,
    duracao_filme int not null,
    diretor_filme varchar(100) not null,
    classind_filme varchar(10) not null,
    capa_filme longblob
);


-- Duração do filme em minutos

create table tb_sala (
	id_sala int primary key auto_increment,
    numero_sala int not null,
    capacidade_sala int not null,
    tipo_sala varchar(20) not null,
    disponibilidade_sala tinyint not null
);

create table tb_ingresso (
	id_ingresso int primary key auto_increment,
    preco_ingresso decimal(5,2) not null,
    data_comprada_ingresso date not null,
    metodo_pag_ingresso varchar(50) not null,
    tb_sala_id_sala int not null,
    tb_filme_id_filme int not null,
    foreign key (tb_sala_id_sala) references tb_sala(id_sala),
    foreign key (tb_filme_id_filme) references tb_filme(id_filme)
);

create table tb_lugar (
	id_lugar int primary key auto_increment,
    numero_lugar int not null,
    reserva_lugar tinyint not null,
    tb_sala_id_sala int not null,
    foreign key (tb_sala_id_sala) references tb_sala(id_sala)
);

-- Tabelas associativas

-- Tabela usuario/comida

create table compra (
	quantidade int not null,
	tb_usuario_id_usuario int not null,
    tb_comida_id_comida int not null,
    foreign key (tb_usuario_id_usuario) references tb_usuario(id_usuario),
    foreign key (tb_comida_id_comida) references tb_comida(id_comida)
);

-- Tabela usuario/lugar

create table aluga (
	data_reserva date not null,
	tb_usuario_id_usuario int not null,
    tb_lugar_id_lugar int not null,
    foreign key (tb_usuario_id_usuario) references tb_usuario(id_usuario),
    foreign key (tb_lugar_id_lugar) references tb_lugar(id_lugar)
);

-- Tabela usuario/ingresso

create table adquiri (
	data_validade date not null,
	tb_usuario_id_usuario int not null,
    tb_ingresso_id_ingresso int not null,
    foreign key (tb_usuario_id_usuario) references tb_usuario(id_usuario),
    foreign key (tb_ingresso_id_ingresso) references tb_ingresso(id_ingresso)
);

-- Tabela filme/sala

create table passa (
	horario_exibicao date not null,
	tb_filme_id_filme int not null,
    tb_sala_id_sala int not null,
    foreign key (tb_filme_id_filme) references tb_filme(id_filme),
    foreign key (tb_sala_id_sala) references tb_sala(id_sala)
);

-- Inserção de dados

insert into tb_usuario (nome_usuario, email_usuario, data_nasc_usuario, cpf_usuario, senha_usuario)
values 
('Aucir Silva', 'aucirsilva01@gmail.com', '1961-03-15', '12312312311', 'senha123'),
('Roberto Mancini', 'robertomancini11@gmail.com', '1999-10-30', '32132132166', 'senha456'),
('Damião Vargas', 'dvog123321@gmail.com', '2004-07-27', '98778987977', 'senha789');



insert into tb_sala (numero_sala, capacidade_sala, tipo_sala, disponibilidade_sala)
values
(1, 180, '2D', true),
(2, 240, '3D', true),
(3, 240, '2D', false);

-- Dados mutáveis

insert into tb_ingresso (preco_ingresso, data_comprada_ingresso, metodo_pag_ingresso, tb_sala_id_sala, tb_filme_id_filme)
values
(22.00, '2024-09-22', 'Débito', 1, 1);

insert into tb_lugar (numero_lugar, reserva_lugar, tb_sala_id_sala)
values 
(110, false, 1);

-- Select para testes

select * from tb_usuario;
select * from tb_comida;
select * from tb_filme;
select * from tb_sala; 

select * from tb_ingresso;
select * from tb_lugar;