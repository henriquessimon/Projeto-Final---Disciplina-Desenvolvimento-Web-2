<?php 
class Local {
    use DataAccess;

    private $id;
    private $nome;    

    public function getLocais() {
        $conn = connection();

        $sql =  "SELECT id, nome FROM local ORDER BY nome ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $results = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }

    public function getOne($loc_id) {
        $conn = connection();

        $stmt = $conn->prepare("
            SELECT 
                l.id,
                l.nome,
                l.descricao,
                l.dificuldade,
                l.link_img,
                e.nome AS enemy_nome
            FROM local l
            LEFT JOIN locais_enemys le ON le.local_id = l.id
            LEFT JOIN enemy e ON e.id = le.enemy_id
            WHERE l.id = :id
        ");

        $stmt->bindValue(":id", $loc_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$rows) {
            return []; 
        }

        // dados do local
        $local = [
            'id' => $rows[0]['id'],
            "nome" => $rows[0]["nome"],
            "descricao" => $rows[0]["descricao"],
            "dificuldade" => $rows[0]["dificuldade"],
            "link_img" => $rows[0]["link_img"]
        ];

        // inimigos (pode vir null)
        $enemys = [];
        foreach($rows as $row) {
            if ($row["enemy_nome"] !== null) {
                $enemys[] = ['enemy_nome' => $row["enemy_nome"]];
            }
        }

        return [
            'local' => $local,
            'enemys' => $enemys
        ];
    }

    public function getAllLocalName() {
        $conn = connection();

        $stmt = $conn->prepare("SELECT id, nome FROM local");
        $stmt->execute();

        $results = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = [
                'id' => $row['id'],
                'nome' => $row['nome']
            ];
        }

        return $results;
    }

    public function createLocal($data) {
        $conn = connection();

        $stmt = $conn->prepare("INSERT INTO local (nome, descricao, dificuldade, link_img) VALUES (:nome, :descricao, :dificuldade, :link_img)");
        $stmt->bindParam(":nome", $data['nome']);
        $stmt->bindParam(":descricao", $data['descricao']);
        $stmt->bindParam(":dificuldade", $data['dificuldade']);
        $stmt->bindParam(":link_img", $data['link_img']);

        if($stmt->execute()) {
            return json_encode([
                'message' => "Cadastro realizado"
            ]);
        }

        return json_encode([
            'message' => 'Erro ao realizar cadastro'
        ]);
    }

    public function deleteLocal($id) {
        $conn = connection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("DELETE FROM locais_enemys WHERE local_id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt2 = $conn->prepare("DELETE FROM local WHERE id = :id");
            $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
            $result = $stmt2->execute();

            $conn->commit();
            return $result;

        } catch (PDOException $e) {
            error_log("Erro ao deletar local: " . $e->getMessage());
            return false;
        }
    }
}
?>