<?php

class UsuarioController {

    public function cadastrarUsuario() {
        $data = json_decode(file_get_contents('php://input'), true);

        $erros_campos = [];

        if(empty($data['name'])) $erros_campos[] = 'name';
        if(empty($data['email'])) $erros_campos[] = 'email';
        if(empty($data['pass'])) $erros_campos[] = 'pass';
        if(empty($data['sys_termos_uso'])) $erros_campos[] = 'sys_termos_uso';
        if(empty($data['phone'])) $erros_campos[] = 'phone';
        if(empty($data['role_user'])) $erros_campos[] = 'role_user';

        if(!empty($erros_campos)) {
            echo json_encode([
                'erros_campos' => $erros_campos,
                'erro' => true
            ]);
            return;
        }

        $usuario = new Usuario();
        $result = $usuario->cadastrar($data);

        if(isset($result['error'])) {
            echo json_encode([
                'success' => false,
                'error' => $result['error']
            ]);
            return;
        }

        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['logged_in'] = true;
        $_SESSION['role_user'] = $data['role_user'];

        echo json_encode(['success' => true]);
    }

    public function getOneUser() {
        $user_id = $_SESSION['user_id'];

        $results = (new Usuario())->getOne($user_id);

        echo json_encode([
            'results' => $results
        ]);
    }

    public function attUser() {
        $data = json_decode(file_get_contents('php://input'), true);

        $data['user_id'] = $_SESSION['user_id'];

        $erros_campos = [];

        if (empty($data['nome_completo'])) $erros_campos[] = 'nome_completo';
        if (empty($data['email'])) $erros_campos[] = 'email';
        if (empty($data['senha'])) $erros_campos[] = 'senha';
        if (empty($data['telefone'])) $erros_campos[] = 'telefone';

        if (!empty($erros_campos)) {
            echo json_encode([
                'success' => false,
                'erros_campos' => $erros_campos
            ]);
            return;
        }

        $success = (new Usuario())->att($data);

        echo json_encode(['success' => $success]);
    }

    public function deleteUser() {
        $model = new Usuario();
        $result = $model->deleteUser();

        if ($result['success']) {
            session_destroy();
            echo json_encode(['success' => true]);
            exit;
        }

        echo json_encode(['success' => false]);
        exit;
    }
}

?>
