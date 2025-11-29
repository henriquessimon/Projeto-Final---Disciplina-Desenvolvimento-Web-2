<?php

class UsuarioController {
    public function cadastrarUsuario() {
        $data = json_decode(file_get_contents('php://input'), true);

        $erros_campos = [];

        if(empty($data['name'])) {
            $erros_campos[] = 'name';
        }

        if(empty($data['email'])) {
            $erros_campos[] = 'email';
        }

        if(empty($data['pass'])) {
            $erros_campos[] = 'pass';
        }

        if(empty($data['sys_termos_uso'])) {
            $erros_campos[] = 'sys_termos_uso';
        }

        if(empty($data['phone'])) {
            $erros_campos[] = 'phone';
        }

        if(empty($data['role_user'])) {
            $erros_campos[] = 'role_user';
        }

        if(!empty($erros_campos)) {
            echo json_encode([
                'erros_campos' => $erros_campos,
                'erro' => true
            ]);
        }

        $usuario = new Usuario();
        $userId = $usuario->cadastrar($data);

        $_SESSION['user_id'] = $userId;
        $_SESSION['logged_in'] = true;
        $_SESSION['role_user'] = $data['role_user'];

        echo json_encode([
            'success' => true
        ]);
    }

    public function getOneUser() {
        $user_id = $_SESSION['user_id'];

        $results = (new Usuario())->findEmailById($user_id);

        echo json_encode([
            'results' => $results
        ]);
    }
}
?>