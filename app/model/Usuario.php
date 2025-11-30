<?php
class Usuario {

    /* ============================
       CADASTRAR USUÁRIO
    ============================ */
    public function cadastrar($data) {
        $conn = connection();

        try {
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
            $stmt->bindParam(':sys_termos_uso', $timestamp, PDO::PARAM_STR);
            $stmt->bindParam(':sys_ativo', $ativo, PDO::PARAM_INT);
            $stmt->bindParam(':role_user', $data['role_user'], PDO::PARAM_STR);

            $stmt->execute();

            return ['user_id' => $conn->lastInsertId()];

        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getOne($id) {
        $conn = connection();

        $sql = "SELECT nome_completo, telefone, email FROM usuario WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function att($data) {
        $conn = connection();

        $stmt = $conn->prepare("
            UPDATE usuario
            SET 
                nome_completo = :nome_completo,
                email = :email,
                senha = :senha,
                telefone = :telefone
            WHERE id = :id
        ");

        $stmt->bindParam(':nome_completo', $data['nome_completo'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $data['senha'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $data['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $data['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteUser() {
        $conn = connection();
        $userId = $_SESSION['user_id'];
        var_dump($_SESSION['user_id']);

        try {
            $stmt = $conn->prepare("
                DELETE FROM usuario 
                WHERE id = :id
            ");

            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return ['success' => true];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
?>
