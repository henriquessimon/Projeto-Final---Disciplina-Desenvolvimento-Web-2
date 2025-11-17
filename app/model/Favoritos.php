<?php
class Favoritos {
    use DataAccess;

    private $id;
    private $usuario_id;
    private $equipamento_id;

    public function favoritar($user_id, $eqp_id) {
        $conn = connection();

        $stmt = $conn->prepare("
            SELECT id 
            FROM favoritos 
            WHERE usuario_id = :user_id 
              AND equipamento_id = :eqp_id
            LIMIT 1
        ");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':eqp_id', $eqp_id, PDO::PARAM_INT);

        $stmt->execute();

        $favorito =  $stmt->fetch(PDO::FETCH_ASSOC);

        if($favorito) {
            $delete = $conn->prepare("DELETE FROM favoritos WHERE id = :id");
            $delete->execute([':id' => $favorito['id']]);
            return ['favorito' => false];
        } else {
            $insert = $conn->prepare("INSERT INTO favoritos (usuario_id, equipamento_id) VALUES (:user_id, :eqp_id)");
            $insert->execute([':user_id' => $user_id, ':eqp_id' => $eqp_id]);
            return ['favorito' => true];
        }
    }

    public function getFavoritos($user_id) {
        $conn = connection();

        $sql = "
            SELECT 
                f.equipamento_id,
                e.nome AS equipamento_nome,
                e.descricao,
                e.effect,
                r.nome AS raridade,
                
                ec.dano_fisico,
                ec.dano_magico,
                ec.dano_fogo,
                ec.dano_eletrico,
                ec.dano_fisico_reducao,
                ec.dano_magico_reducao,
                ec.dano_fogo_reducao,
                ec.dano_eletrico_reducao,
                ec.estabilidade,

                ca.nome AS categoria_arma,
                ce.nome AS categoria_escudo,

                CASE 
                    WHEN a.id_eqp IS NOT NULL THEN 'arma'
                    WHEN s.id_eqp IS NOT NULL THEN 'escudo'
                    WHEN an.id_eqp IS NOT NULL THEN 'anel'
                    ELSE 'desconhecido'
                END AS tipo

            FROM favoritos f
            INNER JOIN equipamento e 
                ON e.id = f.equipamento_id

            LEFT JOIN raridade_eqp r
                ON r.id = e.raridade_id

            LEFT JOIN equipamentocombate ec
                ON ec.id_eqp = e.id

            LEFT JOIN arma a
                ON a.id_eqp = ec.id_eqp

            LEFT JOIN categoria_armas ca
                ON ca.id = a.categoria_id

            LEFT JOIN escudo s
                ON s.id_eqp = ec.id_eqp

            LEFT JOIN categoria_escudos ce
                ON ce.id = s.categoria_id

            LEFT JOIN aneis an
                ON an.id_eqp = e.id

            WHERE f.usuario_id = :user_id;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $results = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }

        return $results;
    }
}
?>