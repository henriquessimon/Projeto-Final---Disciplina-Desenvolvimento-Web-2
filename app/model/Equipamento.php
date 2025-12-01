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

    public function getOne($id) {
        $conn = connection();

        $stmt = $conn->prepare("
            SELECT 
                e.id AS equipamento_id,
                e.nome AS equipamento_nome,
                e.descricao,
                e.effect,
                r.id AS raridade_id,
                r.nome AS raridade_nome,
                r.nvl_max AS raridade_nivel_max,

                ec.dano_fisico,
                ec.dano_magico,
                ec.dano_fogo,
                ec.dano_eletrico,
                ec.dano_fisico_reducao,
                ec.dano_magico_reducao,
                ec.dano_fogo_reducao,
                ec.dano_eletrico_reducao,
                ec.estabilidade,

                a.categoria_id AS arma_categoria_id,
                ca.nome AS arma_categoria_nome,

                s.categoria_id AS escudo_categoria_id,
                cs.nome AS escudo_categoria_nome

            FROM equipamento e
            LEFT JOIN equipamentocombate ec ON ec.id_eqp = e.id
            LEFT JOIN arma a ON a.id_eqp = ec.id_eqp
            LEFT JOIN categoria_armas ca ON ca.id = a.categoria_id
            LEFT JOIN escudo s ON s.id_eqp = ec.id_eqp
            LEFT JOIN categoria_escudos cs ON cs.id = s.categoria_id
            LEFT JOIN raridade_eqp r ON r.id = e.raridade_id
            WHERE e.id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

        return $equipment;
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
    
    public function update($data) {
        $conn = connection();

        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("
                UPDATE equipamento
                SET nome = :nome,
                    descricao = :descricao,
                    effect = :effect,
                    raridade_id = :raridade_id
                WHERE id = :id
            ");
            $stmt->execute([
                ':nome' => $data['nome'],
                ':descricao' => $data['descricao'],
                ':effect' => $data['effect'],
                ':raridade_id' => $data['raridade_id'],
                ':id' => $data['id']
            ]);

            if (in_array($data['tipo_equipamento'], ['arma', 'escudo'])) {
                $stmt = $conn->prepare("
                    UPDATE equipamentocombate
                    SET dano_fisico = :dano_fisico,
                        dano_magico = :dano_magico,
                        dano_fogo = :dano_fogo,
                        dano_eletrico = :dano_eletrico,
                        dano_fisico_reducao = :dano_fisico_reducao,
                        dano_magico_reducao = :dano_magico_reducao,
                        dano_fogo_reducao = :dano_fogo_reducao,
                        dano_eletrico_reducao = :dano_eletrico_reducao,
                        estabilidade = :estabilidade
                    WHERE id_eqp = :id
                ");
                $stmt->execute([
                    ':dano_fisico' => $data['dano_fisico'],
                    ':dano_magico' => $data['dano_magico'],
                    ':dano_fogo' => $data['dano_fogo'],
                    ':dano_eletrico' => $data['dano_eletrico'],
                    ':dano_fisico_reducao' => $data['dano_fisico_reducao'],
                    ':dano_magico_reducao' => $data['dano_magico_reducao'],
                    ':dano_fogo_reducao' => $data['dano_fogo_reducao'],
                    ':dano_eletrico_reducao' => $data['dano_eletrico_reducao'],
                    ':estabilidade' => $data['estabilidade'],
                    ':id' => $data['id']
                ]);

                $table = $data['tipo_equipamento'] === 'arma' ? 'arma' : 'escudo';
                $stmt = $conn->prepare("
                    UPDATE $table
                    SET categoria_id = :categoria_id
                    WHERE id_eqp = :id
                ");
                $stmt->execute([
                    ':categoria_id' => $data['categoria_id'],
                    ':id' => $data['id']
                ]);
            }

            $conn->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $conn->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
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