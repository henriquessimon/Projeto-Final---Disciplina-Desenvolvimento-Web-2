<?php
class Equipamento {
    use DataAccess;

    private $id;
    private $nome;
    private $descricao;
    private $categoria_id;
    private $raridade_id;
    private $estabilidade;
    
    // Dano ofensivo
    private $dano_fisico;
    private $dano_magico;
    private $dano_fogo;
    private $dano_eletrico;
    
    // Redução de dano
    private $dano_fisico_reducao;
    private $dano_magico_reducao;
    private $dano_fogo_reducao;
    private $dano_eletrico_reducao;

    public function getAllArmasEscudos($usuarioId) {
        $conn = connection();
        $stmt = $conn->prepare("
            SELECT 
                e.id,
                e.nome,
                e.descricao,
                r.nome AS raridade,
                e.effect,
                ec.dano_fisico,
                ec.dano_magico,
                ec.dano_fogo,
                ec.dano_eletrico,
                ec.dano_fisico_reducao,
                ec.dano_magico_reducao,
                ec.dano_fogo_reducao,
                ec.dano_eletrico_reducao,
                ec.estabilidade,
                a.categoria_id,
                ca.nome AS categoria_nome,
                'arma' AS tipo,
                f.id AS favorito_id,
                CASE WHEN f.id IS NOT NULL THEN 1 ELSE 0 END AS favoritado
            FROM equipamento e
            INNER JOIN raridade_eqp r ON e.raridade_id = r.id
            INNER JOIN equipamentocombate ec ON e.id = ec.id_eqp
            INNER JOIN arma a ON ec.id_eqp = a.id_eqp
            INNER JOIN categoria_armas ca ON a.categoria_id = ca.id
            LEFT JOIN favoritos f ON f.equipamento_id = e.id AND f.usuario_id = :usuarioId
            
            UNION ALL
            
            SELECT 
                e.id,
                e.nome,
                e.descricao,
                r.nome AS raridade,
                e.effect,
                ec.dano_fisico,
                ec.dano_magico,
                ec.dano_fogo,
                ec.dano_eletrico,
                ec.dano_fisico_reducao,
                ec.dano_magico_reducao,
                ec.dano_fogo_reducao,
                ec.dano_eletrico_reducao,
                ec.estabilidade,
                es.categoria_id,
                ce.nome AS categoria_nome,
                'escudo' AS tipo,
                f.id AS favorito_id,
                CASE WHEN f.id IS NOT NULL THEN 1 ELSE 0 END AS favoritado
            FROM equipamento e
            INNER JOIN raridade_eqp r ON e.raridade_id = r.id
            INNER JOIN equipamentocombate ec ON e.id = ec.id_eqp
            INNER JOIN escudo es ON ec.id_eqp = es.id_eqp
            INNER JOIN categoria_escudos ce ON es.categoria_id = ce.id
            LEFT JOIN favoritos f ON f.equipamento_id = e.id AND f.usuario_id = :usuarioId
            ORDER BY tipo, nome
        ");

        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }

    public function createEqp($data) {
        $conn = connection();

        try {

            $conn->beginTransaction();

            $stmt = $conn->prepare("
                INSERT INTO equipamento (nome, descricao, raridade_id, effect)
                VALUES (:nome, :descricao, :raridade, :effect)
            ");

            $stmt->execute([
                ':nome'      => $data['nome'],
                ':descricao' => $data['descricao'],
                ':raridade'  => $data['raridade'],
                ':effect'    => $data['effect']
            ]);

            $eqpId = $conn->lastInsertId();

            if ($data['tipo'] === 'anel') {

                $stmt = $conn->prepare("
                    INSERT INTO aneis (id_eqp) VALUES (:id)
                ");
                $stmt->execute([':id' => $eqpId]);

                // Commit final
                $conn->commit();

                return [
                    'message' => 'Anel criado com sucesso!',
                    'eqp_id' => $eqpId
                ];
            }

            $stmt = $conn->prepare("
                INSERT INTO equipamentocombate (
                    id_eqp, dano_fisico, dano_magico, dano_fogo, dano_eletrico,
                    dano_fisico_reducao, dano_magico_reducao, dano_fogo_reducao,
                    dano_eletrico_reducao, estabilidade
                )
                VALUES (
                    :id, :df, :dm, :dfg, :de,
                    :rdf, :rdm, :rdfg, :rde,
                    :est
                )
            ");

            $stmt->execute([
                ':id'   => $eqpId,
                ':df'   => $data['dano_fisico'],
                ':dm'   => $data['dano_magico'],
                ':dfg'  => $data['dano_fogo'],
                ':de'   => $data['dano_eletrico'],

                ':rdf'  => $data['dano_fisico_reducao'],
                ':rdm'  => $data['dano_magico_reducao'],
                ':rdfg' => $data['dano_fogo_reducao'],
                ':rde'  => $data['dano_eletrico_reducao'],

                ':est'  => $data['estabilidade']
            ]);

            if ($data['tipo'] === 'arma') {

                $stmt = $conn->prepare("
                    INSERT INTO arma (id_eqp, categoria_id)
                    VALUES (:id, :cat)
                ");
                $stmt->execute([
                    ':id'  => $eqpId,
                    ':cat' => $data['categoria']
                ]);

            } elseif ($data['tipo'] === 'escudo') {

                $stmt = $conn->prepare("
                    INSERT INTO escudo (id_eqp, categoria_id)
                    VALUES (:id, :cat)
                ");
                $stmt->execute([
                    ':id'  => $eqpId,
                    ':cat' => $data['categoria_id']
                ]);
            }

            $conn->commit();

            return [
                'message' => ucfirst($data['tipo']) . ' criado com sucesso!',
                'eqp_id' => $eqpId
            ];
        }

        catch (Exception $e) {
            $conn->rollBack();
            return [
                'message' => 'Erro ao criar equipamento: ' . $e->getMessage(),
                'eqp_id' => null
            ];
        }
    }

    public function delete($id) {
        $conn = connection();

        try {
            $conn->beginTransaction();

            // 1. Deleta arma (se existir)
            $stmt = $conn->prepare("DELETE FROM arma WHERE id_eqp = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // 2. Deleta escudo (se existir)
            $stmt = $conn->prepare("DELETE FROM escudo WHERE id_eqp = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // 3. Deleta equipamentocombate (se existir)
            $stmt = $conn->prepare("DELETE FROM equipamentocombate WHERE id_eqp = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // 4. Deleta aneis (se existir)
            $stmt = $conn->prepare("DELETE FROM aneis WHERE id_eqp = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // 5. Deleta dos favoritos (se existir)
            $stmt = $conn->prepare("DELETE FROM favoritos WHERE equipamento_id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // 6. Finalmente deleta o equipamento
            $stmt = $conn->prepare("DELETE FROM equipamento WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();

            return ["success" => true, "message" => "Equipamento deletado com sucesso"];

        } catch (Exception $e) {
            $conn->rollBack();
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
?>