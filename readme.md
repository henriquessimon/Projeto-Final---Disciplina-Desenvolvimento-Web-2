-- Usuário
Usuario
- id INT AUTO_INCREMENT PRIMARY KEY
- email VARCHAR(100)
- senha VARCHAR(100)
- nome_completo VARCHAR(100)
- telefone VARCHAR(20)
- sys_termos_uso BOOLEAN
- sys_ativo BOOLEAN

-- Equipamentos
Equipamento
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(100)
- descricao VARCHAR(255)
- custo_upgrade INT
- raridade_id INT

-- Equipamentos de combate (arma, escudo, armadura)
EquipamentoCombate
- id_eqp INT PRIMARY KEY REFERENCES Equipamento(id)
- dano_fisico INT DEFAULT 0
- dano_magico INT DEFAULT 0
- dano_fogo INT DEFAULT 0
- dano_eletrico INT DEFAULT 0
- dano_fisico_reducao INT DEFAULT 0
- dano_magico_reducao INT DEFAULT 0
- dano_fogo_reducao INT DEFAULT 0
- dano_eletrico_reducao INT DEFAULT 0
- effect TEXT

-- Armas
Arma
- id_eqp INT PRIMARY KEY REFERENCES EquipamentoCombate(id_eqp)
- categoria_id INT REFERENCES Categoria_armas(id)
- estabilidade INT DEFAULT 0

-- Escudos
Escudo
- id_eqp INT PRIMARY KEY REFERENCES EquipamentoCombate(id_eqp)
- categoria_id INT REFERENCES Categoria_escudos(id)
- estabilidade INT DEFAULT 0

-- Armaduras
Armadura
- id_eqp INT PRIMARY KEY REFERENCES EquipamentoCombate(id_eqp)
- categoria_id INT REFERENCES Categoria_armaduras(id)
-- effect já está em EquipamentoCombate, não precisa repetir

-- Anéis
Aneis
- id_eqp INT PRIMARY KEY REFERENCES Equipamento(id)
- effect TEXT

-- Sets de armaduras
Set_armor
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(100)

Set_equipamento
- id_set_armor INT REFERENCES Set_armor(id)
- id_eqp INT REFERENCES Equipamento(id)
PRIMARY KEY (id_set_armor, id_eqp)

-- Locais
Local
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(100)

-- Inimigos
Enemy
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(100)

-- Relação entre locais e inimigos (N:N)
locais_enemys
- local_id INT REFERENCES Local(id)
- enemy_id INT REFERENCES Enemy(id)
PRIMARY KEY (local_id, enemy_id)

-- Drops de equipamentos por inimigos
enemy_drop_eqp
- enemy_id INT REFERENCES Enemy(id)
- eqp_id INT REFERENCES Equipamento(id)
- chance_drop DECIMAL(5,2)
PRIMARY KEY (enemy_id, eqp_id)

-- Categorias de equipamentos (separadas)
Categoria_armas
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(100)

Categoria_armaduras
- id INT AUTO_INCREMENT PRIMARY KEY
- parte VARCHAR(50)   -- ex: cabeça, torso, mãos, pernas
- nome VARCHAR(100)

Categoria_escudos
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(100)

-- Raridade dos equipamentos
Raridade_eqp
- id INT AUTO_INCREMENT PRIMARY KEY
- nome VARCHAR(50)
- nvl_max INT
