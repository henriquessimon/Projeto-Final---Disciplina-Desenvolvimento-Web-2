<?php
require_once '../../core/connection.php';

class Usuario {
    use DataAccess;

    private $id;
    private $nomeCompleto;
    private $senha;
    private $email;
    private $cpf;
    private $telefone;
    private $sysTermosDeUso;
    private $sysAtivo;

    public static function findNameById($id) {
        $conn = connection();

        $sql = "SELECT nomeCompleto FROM usuario WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        } else {
            return $row['nomeCompleto'];
        }
    }
}
?>