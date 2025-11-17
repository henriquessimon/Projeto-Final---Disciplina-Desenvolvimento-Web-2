<?php
class HomeController {
    public function index(){
        if(!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            header("Location: ?controller=equipamento&method=listarEquipamentos");
            exit;
        }

        require_once __DIR__ . '/../Views/login.php';
    }
}
?>