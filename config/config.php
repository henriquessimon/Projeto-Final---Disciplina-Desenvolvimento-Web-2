<?php
define('BASE_URL', '/');

function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // ignora comentários
        }

        if (!str_contains($line, '=')) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        // Remove aspas caso o usuário coloque
        $value = trim($value, "\"'");

        $_ENV[$key] = $value;
    }
}

?>