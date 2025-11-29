<?php
function connection() {
        $host = "mysql:host=localhost;dbname=php_atv";
        $user = "root";
        $password = '';

        try {
            $conn = new PDO($host, $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
?>