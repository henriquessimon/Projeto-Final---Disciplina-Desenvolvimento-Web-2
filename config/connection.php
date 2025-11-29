<?php
function connection() {
    $host = "ds1_wiki.mysql.dbaas.com.br";
    $db   = "ds1_wiki";
    $user = "ds1_wiki";
    $pass = "Henrique2004#";
    $port = 3306;

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db;port=$port;charset=utf8", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        exit;
    }
}
?>
