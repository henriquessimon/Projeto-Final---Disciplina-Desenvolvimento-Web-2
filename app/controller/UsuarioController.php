<?php

class UsuarioController {
    public function cadastrarUsuario() {
        $data = [
            "name"  => $_POST['name'],
            "email" => $_POST['email'],
            "pass"  => $_POST['pass'],
            "phone" => $_POST['phone'],
            "sys_termos_uso" => $_POST['sys_termos_uso'],
            "sys_ativo" => 1
        ];

        $usuario = new Usuario();
        $userId = $usuario->cadastrar($data);


        $_SESSION['user_id'] = $userId;
        $_SESSION['logged_in'] = true;

        header("Location: " . BASE_URL . "?controller=auth&method=mainPage");
        exit;
    }
}
?>