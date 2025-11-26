<?php 
class Inimigo {

    private $nome;
    private $res_fisica;
    private $res_magica;
    private $res_fogo;
    private $res_eletrico;

    public function getEnemys() {
        $conn = connection();

        $sql = "SELECT 
                    id, 
                    nome, 
                    res_fisica, 
                    res_magica, 
                    res_fogo, 
                    res_eletrico
                FROM enemy
                ORDER BY nome ASC;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }

    public function getOne($enemy_id) {
        $conn = connection();

        $sql = "
            SELECT 
                e.*, 
                l.nome AS local_nome
            FROM enemy e
            LEFT JOIN locais_enemys le ON le.enemy_id = e.id
            LEFT JOIN local l ON l.id = le.local_id
            WHERE e.id = :enemy_id
            ORDER BY l.nome ASC;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":enemy_id", $enemy_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($rows)) {
            return [];
        }

        $tipo_text = '';

        switch ($rows[0]['tipo']) {
            case 'normal':
                $tipo_text = 'Inimigos comuns, depois abatido, renascerá sempre que descançar em uma fogueira.';
                break;

            case 'especial':
                $tipo_text = 'Inimigos especiais, depois de abatido, não reaparecem ao descançar em uma fogueira.';
                break;
            case '':
                $tipo_text = 'Inimigos especiais, depois de abatido, não reaparecem ao descançar em uma fogueira.';
                break;
            case 'boss':
                $tipo_text = 'Inimigos boss, são inimigos únicos, e costumam ser mais fortes que os inimigos padrões, tendo mais vida, ost própria e uma arena de batalha fechada';
                break;
            case 'normal/especial':
                $tipo_text = 'Inimigos normal/especiais, existe alguns deste inimigo durante o jogo que depois de abatido renascem e outros que não renascem.';
                break;
            case 'normal/npc':
                $tipo_text = 'Inimigos normal/npc, existe algum npc que é igual a este inimigo, porém, é interagivel de outras formas, com dialogos, decisões e etc.';
                break;
            case 'boss/normal':
                $tipo_text = 'Inimigos boss/normal, são inimigos que normalmente a primeira vez que aparece é um boss, mas posteriormente vira um inimigo comun, que renascem, mas a versão dele de boss não renasce';
                break;
            case 'normal/npc':
                $tipo_text = 'Inimigos especiais, depois de abatido, não reaparecem ao descançar em uma fogueira ';
                break;
            case 'online':
                $tipo_text = 'Inimigo que só aparece com o online ativado';
                break;
        }


        $tipo = ucfirst(strtolower($rows[0]['tipo']));
        $enemy = [
            'nome' => $rows[0]['nome'],
            'res_fisica' => $rows[0]['res_fisica'],
            'res_magica' => $rows[0]['res_magica'],
            'res_fogo' => $rows[0]['res_fogo'],
            'res_eletrica' => $rows[0]['res_eletrico'],
            'tipo' => $tipo,
            'tipo_text' => $tipo_text,
            'descricao' => $rows[0]['descricao']
        ];

        $locais = [];

        foreach($rows as $row) {
            if(!empty($row['local_nome'])) {
                $locais[] = [
                    'local_id' => $row['local_id'],
                    'local_nome' => $row['local_nome']
                ];
            }
        }

        $enemy['locais'] = $locais;

        return $enemy;
    }

    public function createInimigo($data) {
        $conn = connection();

        $stmt = $conn->prepare("
            INSERT INTO enemy 
            (nome, res_fisica, res_magica, res_fogo, res_eletrico, tipo, descricao)
            VALUES 
            (:nome, :res_fisica, :res_magica, :res_fogo, :res_eletrico, :tipo, :descricao)
        ");

        $stmt->bindParam(":nome", $data['nome']);
        $stmt->bindParam(":res_fisica", $data['res_fisica']);
        $stmt->bindParam(":res_magica", $data['res_magica']);
        $stmt->bindParam(":res_fogo", $data['res_fogo']);
        $stmt->bindParam(":res_eletrico", $data['res_eletrico']);
        $stmt->bindParam(":tipo", $data['tipo']);
        $stmt->bindParam(":descricao", $data['descricao']);


        if(!$stmt->execute()) {
            return json_encode([
                'message' => "Erro ao realizar cadastro"
            ]);
        }
        
        $enemy_id = $conn->lastInsertId();

        $stmtLoc = $conn->prepare("
            INSERT INTO locais_enemys (enemy_id, local_id)
            VALUES (:enemy_id, :local_id)
        ");

        foreach($data['local'] as $locID) {
            $stmtLoc->bindParam(":enemy_id", $enemy_id);
            $stmtLoc->bindParam(":local_id", $locID);
            $stmtLoc->execute();
        }


        return json_encode([
            'success' => true,
            'message' => "Cadastro realizado!"
        ]);

        return json_encode([
            'success' => false,
            'message' => "Erro ao realizar cadastro"
        ]);
    }

}
?>