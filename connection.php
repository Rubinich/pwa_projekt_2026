<?php
// \n + empty_lines
foreach (file('server.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    [$key, $value] = explode('=', $line, 2);
    // whitespace
    $_ENV[trim($key)] = trim($value);
}

try{
    $conn = new PDO(
        "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=cp1250", 
        $_ENV['DB_USER'], 
        $_ENV['DB_PASS'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch (PDOException $e) {
    die('Greška prilikom spajanja na bazu: ' . $e->getMessage());
}
?>