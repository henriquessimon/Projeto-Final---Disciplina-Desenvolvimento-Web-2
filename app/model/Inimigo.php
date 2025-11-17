<?php 
class Inimigo {
    public function getEnemys() {
        $conn = connection();

        $sql = "SELECT id, nome, res_fisica, res_magica, res_fogo, res_eletrico FROM enemy";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }
}
?>