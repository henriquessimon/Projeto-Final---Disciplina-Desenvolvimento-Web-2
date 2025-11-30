<?php
class Escudo {
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
}
?>