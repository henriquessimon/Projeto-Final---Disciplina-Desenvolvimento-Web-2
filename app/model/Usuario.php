<?php

class Usuario {
    public function cadastrar($data) {
        $conn = connection();

        $stmt = $conn->prepare("
            INSERT INTO usuario 
            (email, senha, nome_completo, telefone, sys_termos_uso, sys_ativo, role_user) 
            VALUES 
            (:email, :senha, :nome_completo, :telefone, :sys_termos_uso, :sys_ativo, :role_user)
        ");

        $timestamp = (new DateTime())->format('Y-m-d H:i:s');

        $ativo = 1;

        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $data['pass'], PDO::PARAM_STR);
        $stmt->bindParam(':nome_completo', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':sys_termos_uso', $timestamp, PDO::PARAM_BOOL);
        $stmt->bindParam(':sys_ativo', $ativo, PDO::PARAM_BOOL);
        $stmt->bindParam(':role_user', $data['role_user'], PDO::PARAM_STR);

        $stmt->execute();

        return [
            'user_id' => $conn->lastInsertId()
        ];
    }

    public static function findEmailById($id) {
        $conn = connection();
        $sql = "SELECT nomeCompleto FROM usuario WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        } else {
            return $row['email'];
        }
    }
}
?>