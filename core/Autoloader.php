<?php

function load($classe) {
    $dirs = [
        __DIR__ . "/../app/model/",
        __DIR__ . "/../app/DAO/",
        __DIR__ . "/../app/controller/",
        __DIR__ . "/../config/connection.php",
    ];

    foreach($dirs as $dir) {
        $file = $dir . $classe . ".php";
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
}

spl_autoload_register("load");
?>