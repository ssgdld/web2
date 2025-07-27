<?php
// conexion.php

$host = 'localhost';
$port = 3306;
$dbname = 'ORGANIZACION';
$user = 'root';
$password = '';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    error_log("Error de conexión BD: " . $e->getMessage());
    die("Error de conexión. Por favor, inténtalo más tarde.");
}