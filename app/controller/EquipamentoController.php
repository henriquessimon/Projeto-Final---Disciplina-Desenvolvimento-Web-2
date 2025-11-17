<?php
class EquipamentoController {
    public function listarEquipamentos() {
        if(empty($_SESSION['logged_in'])) {
            header("Location: ?controller=home&index");
            exit;
        }

        $equipamento = new Equipamento();
        $equipamentos = $equipamento->getAllArmasEscudos($_SESSION['user_id']);
?>
        <script>
            console.log(<?php echo json_encode($equipamentos)?>);
        </script>
<?php
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
}

?>