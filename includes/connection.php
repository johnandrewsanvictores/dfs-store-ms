<?php

require __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$db_server = $_ENV['DATABASE_HOSTNAME'];
$db_user = $_ENV['DATABASE_USERNAME'];
$db_pass = $_ENV['DATABASE_PASSWORD'];
$db_name = $_ENV['DATABASE_NAME'];

try {
    $connection = new PDO("mysql:host=$db_server;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Could not connect! Error: " . $e->getMessage();
    die();
}
