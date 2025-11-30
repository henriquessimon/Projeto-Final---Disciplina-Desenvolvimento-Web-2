<?php
class UsuarioDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function salvar(Usuario $usuario) {
        $sql = "INSERT INTO usuario 
                (nome_completo, email, senha, telefone, sys_termos_uso, sys_ativo)
                VALUES (:nome, :email, :senha, :telefone, :termos, :ativo)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":nome", $usuario->getNomeCompleto());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":senha", $usuario->getSenha());
        $stmt->bindValue(":telefone", $usuario->getTelefone());
        $stmt->bindValue(":termos", $usuario->getSysTermosDeUso());
        $stmt->bindValue(":ativo", $usuario->getSysAtivo());

        $stmt->execute();
    }
}
?>