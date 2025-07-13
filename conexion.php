<?php
// conexion.php

$servername = "localhost";
$username = "root";
$password = "thlWgT_6jD/Mka";
$database = "organizacion";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>