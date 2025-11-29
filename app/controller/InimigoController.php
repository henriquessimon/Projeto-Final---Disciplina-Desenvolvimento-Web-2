<?php
class InimigoController {
    public function listarInimigos() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $enemy = new Inimigo();
        $enemys = $enemy->getEnemys();

        $local = new Local();
        $locais = $local->getAllLocalName();

        include_once __DIR__ . "/../Views/inimigos.php";
    }

    public function getOneInimigo() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $enemy_id = $_GET['enemy_id'];

        $enemy = new Inimigo();
        $inimigo = $enemy->getOne($enemy_id);

        include_once __DIR__ . '/../Views/one_inimigo.php';
    }

    public function createInimigo() {
        if (empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $newInimigo = json_decode((new Inimigo())->createInimigo($data), true);

        header("Content-Type: application/json");
        echo json_encode([
            'message' => $newInimigo['message']
        ]);

        exit;
    }

    public function deleteInimigo() {
        if (empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $id = (int)$_GET['id'];

        $result = (new Inimigo())->dltInimigo($id);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Sucesso ao deletar inimigo' : 'Erro ao deletar inimigo'
        ]);
    }
}
?>