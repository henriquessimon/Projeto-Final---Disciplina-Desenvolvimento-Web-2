<?php
//Conexão
function connection() {
        $host = "mysql:host=ftp.lhsimonclk.provisorio.ws;dbname=ds1_wiki";
        $user = "lhsimonclkprovis1";
        $password = 'Henrique2004#';

        try {
            $conn = new PDO($host, $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
?>