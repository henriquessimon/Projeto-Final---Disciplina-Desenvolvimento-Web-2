<?php
class InimigoController {
    public function listarInimigos() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $enemy = new Inimigo();
        $enemys = $enemy->getEnemys();

        include_once __DIR__ . "/../Views/inimigos.php";
    }
}
?>