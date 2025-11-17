<?php
class FavoritosController {
    public function Favoritar() {
        if (empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $eqp_id = $_GET['eqp_id'];

        if(empty($eqp_id) || empty($user_id)) {
            http_response_code(400);
            echo json_encode(['message' => "Equipamento ou ususário não encontrado"]);
            exit;
        }

        $eqp_favorito = new Favoritos();
        $result = $eqp_favorito->favoritar($user_id, $eqp_id);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function listarFavoritos() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $favorito = new Favoritos();
        $favoritos = $favorito->getFavoritos($user_id);

        include_once __DIR__ . "/../Views/favoritos.php";
    }
}
?>