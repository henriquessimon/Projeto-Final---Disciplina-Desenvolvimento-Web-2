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

    public function getOneEqp() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $eqp_id = $_GET['eqp_id'];

        $equipamento = new Equipamento();
        $eqp = $equipamento->getOne($eqp_id);

        include_once __DIR__ . '/../Views/one_eqp.php';
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

    public function deleteEqp() {
        if (empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $id = (int)$_GET['id'];

        $result = (new Equipamento())->delete($id);

        echo json_encode([
            'success' => $result['success'],
            'message' => $result['message']
        ]);
    }
}
?>