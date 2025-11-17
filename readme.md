-- Usuário
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    senha VARCHAR(100),
    nome_completo VARCHAR(100),
    telefone VARCHAR(20),
    sys_termos_uso BOOLEAN,
    sys_ativo BOOLEAN
);

-- Equipamento
CREATE TABLE equipamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao VARCHAR(255),
    raridade_id INT,
    effect TEXT,
    FOREIGN KEY (raridade_id) REFERENCES raridade_eqp(id)
);

-- Equipamento de combate
CREATE TABLE equipamentocombate (
    id_eqp INT PRIMARY KEY,
    dano_fisico INT DEFAULT 0,
    dano_magico INT DEFAULT 0,
    dano_fogo INT DEFAULT 0,
    dano_eletrico INT DEFAULT 0,
    dano_fisico_reducao INT DEFAULT 0,
    dano_magico_reducao INT DEFAULT 0,
    dano_fogo_reducao INT DEFAULT 0,
    dano_eletrico_reducao INT DEFAULT 0,
    estabilidade INT DEFAULT 0,
    FOREIGN KEY (id_eqp) REFERENCES equipamento(id)
);

-- Armas
CREATE TABLE arma (
    id_eqp INT PRIMARY KEY,
    categoria_id INT,
    FOREIGN KEY (id_eqp) REFERENCES equipamentocombate(id_eqp),
    FOREIGN KEY (categoria_id) REFERENCES categoria_armas(id)
);

-- Escudos
CREATE TABLE escudo (
    id_eqp INT PRIMARY KEY,
    categoria_id INT,
    FOREIGN KEY (id_eqp) REFERENCES equipamentocombate(id_eqp),
    FOREIGN KEY (categoria_id) REFERENCES categoria_escudos(id)
);

-- Anéis
CREATE TABLE aneis (
    id_eqp INT PRIMARY KEY,
    FOREIGN KEY (id_eqp) REFERENCES equipamento(id)
);

-- Locais
CREATE TABLE local (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);

-- Inimigos
CREATE TABLE enemy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);

-- Relação N:N entre locais e inimigos
CREATE TABLE locais_enemys (
    local_id INT,
    enemy_id INT,
    PRIMARY KEY (local_id, enemy_id),
    FOREIGN KEY (local_id) REFERENCES local(id),
    FOREIGN KEY (enemy_id) REFERENCES enemy(id)
);

-- Categorias
CREATE TABLE categoria_armas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);

CREATE TABLE categoria_escudos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);

-- Raridade
CREATE TABLE raridade_eqp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    nvl_max INT
);

CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    equipamento_id INT NOT NULL,    
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (equipamento_id) REFERENCES equipamento(id),
    UNIQUE (usuario_id, equipamento_id)
);
