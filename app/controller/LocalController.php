<?php
class LocalController {
    public function listarLocais() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $local = new Local();
        $locais = $local->getLocais();

        include  __DIR__ . '/../Views/locais.php';
    }

    public function getOneLocal() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $loc_id = $_GET['local_id'];

        $loc = new Local;
        $local = $loc->getOne($loc_id);
        $loc = $local['local'] ?? null;
        $enemys = $local['enemys'] ?? [];

        echo "<script>console.log(" . json_encode($local) . ");</script>";

        include_once __DIR__ . '/../Views/oneLocal.php';
    }

    public function createLocal() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        
        $data = json_decode(file_get_contents('php://input'), true);

        $newLocal = json_decode((new Local())->createLocal($data), true);

        echo json_encode([
            'message' => $newLocal['message']
        ]);
    }
}
?>