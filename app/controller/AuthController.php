<?php
    require_once '../config/connection.php' ;
    session_start();

class AuthController {
    public function login() {
        $conn = connection();
        error_log(print_r($conn, true));
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $senha = $data['senha'] ?? '';
        $sql = 'SELECT id, nome_completo, email, senha, sys_ativo FROM usuario WHERE email = :email AND senha = :senha';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        error_log(print_r($row, true));

        if($row) {
            error_log('Entrou');
            if($row['sys_ativo'] == 1) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nome'] = $row['nome_completo'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['senha'] = $row['senha'];
                $_SESSION['logged_in'] = true;

                echo json_encode([
                    "success" => true,
                    "Message" => "Login realizado com sucesso"
                ]);
                exit;
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Usuário inativo"
                ]);
                exit;
            }

        } else {
            echo json_encode([
                "success" => false,
                "message" => 'E-mail/senha incorretos'
            ]);
            exit;
        }
    }

    public function verifica_login() {
        session_start();
        header("Content-Type: application/json");

        $inactive = 60; //1 MINUTO

        if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive)) {
            session_unset();
            session_destroy();

            echo json_encode([
                "logged_in" => false,
                "expirou"   => true
            ]);
            exit;
        }

        $_SESSION['last_activity'] = time();

        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            echo json_encode([
                "logged_in" => true,
                "expirou"   => false
            ]);
        } else {
            echo json_encode([
                "logged_in" => false,
                "expirou"   => true
            ]);
        }
    }
}
?>