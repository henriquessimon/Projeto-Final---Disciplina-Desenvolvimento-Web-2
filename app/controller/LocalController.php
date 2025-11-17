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
}
?>