<?php 
class Local {
    private $nome;
    private $res_fisica;
    private $res_magica;
    private $res_fogo;
    private $res_eletrico;

    public function getLocais() {
        $conn = connection();

        $sql =  "SELECT id, nome FROM local";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $results = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }
}
?>