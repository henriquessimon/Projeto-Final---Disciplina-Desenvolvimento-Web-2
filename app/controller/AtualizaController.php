<?php
class AtualizaController {
    public function attPage() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        include_once __DIR__ . '/../Views/attUser.php';
    }
}
?>