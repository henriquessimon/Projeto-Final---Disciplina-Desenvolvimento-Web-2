<?php
class EquipamentoController {
    public function listarEquipamentos() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $equipamento = new Equipamento();
        $equipamentos = $equipamento->getAllArmasEscudos($_SESSION['user_id']);
        $equipamentosPorCategoria = [];

        foreach ($equipamentos as $equip) {
            $categoriaNome = $equip['categoria_nome'];
            $tipo = $equip['tipo'];

            $chave = $tipo . '-' . $categoriaNome;

            if(!isset($equipamentosPorCategoria[$chave])) {
                $equipamentosPorCategoria[$chave] = [
                    'tipo' => $tipo,
                    'categoria' => $categoriaNome,
                    'items' => []
                ];
            }

            $equipamentosPorCategoria[$chave]['items'][] = $equip;
        }

        ksort($equipamentosPorCategoria);

        include  __DIR__ . '/../Views/mainPage.php';
    }

    public function createEqp() {
        if (empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $result = (new Equipamento())->createEqp($data);

        echo json_encode($result);

    }
}
?>