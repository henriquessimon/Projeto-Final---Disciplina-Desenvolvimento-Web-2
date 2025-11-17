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

}
?>