<?php

class UsuarioController {
    public function cadastrarUsuario() {
        $pdo = connection();

        $usuario = new Usuario();

        $usuario->setNomeCompleto($_POST['name']);
        $usuario->setEmail($_POST['email']);
        $usuario->setSenha($_POST['pass']);
        $usuario->setTelefone($_POST['phone']);
        if (!empty($_POST['sys_termos_uso'])) {
            $data = date('Y-m-d H:i:s');
            $usuario->setSysTermosDeUso($data);
        }

        $usuario->setSysAtivo(1);

        $dao = new UsuarioDAO($pdo);
        $dao->salvar($usuario);
    }
}

$controller = new UsuarioController();

?>