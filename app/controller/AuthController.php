<?php
class AuthController {
    public function login() {
        $conn = connection();
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $senha = $data['senha'] ?? '';
        $sql = 'SELECT id, sys_ativo, role_user FROM usuario WHERE email = :email AND senha = :senha';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        if($row) {
            if($row['sys_ativo'] == 1) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['logged_in'] = true;
                $_SESSION['role_user'] = $row['row_user'];

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
        header("Content-Type: application/json");

        $inactive = 1; 

        if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive)) {
            session_unset();
            session_destroy();

            echo json_encode([
                "logged_in" => false,
                "expirou"   => true
            ]);
            exit;
        }

        if(!isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
        }

        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            echo json_encode([
                "logged_in" => true,
                "expirou"   => false,
            ]);
        } else {
            echo json_encode([
                "logged_in" => false,
                "expirou"   => true
            ]);
        }
    }

    public function cadastroPage() {
        include_once __DIR__ . '/../Views/cadastro.php';
    }

    public function termosUsoPage() {
        include_once __DIR__ . '/../Views/termos_uso.php';
    }
}
?>