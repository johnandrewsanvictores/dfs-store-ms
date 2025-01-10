<?php

require __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$db_server = $_ENV['DATABASE_HOSTNAME'];
$db_user = $_ENV['DATABASE_USERNAME'];
$db_pass = $_ENV['DATABASE_PASSWORD'];
$db_name = $_ENV['DATABASE_NAME'];
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception) {
    echo "Could not connect!<br>";
}
