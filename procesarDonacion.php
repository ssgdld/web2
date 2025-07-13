<?php
require_once 'session_config.php';

function sanitizar($v) {
  return htmlspecialchars(stripslashes(trim($v)), ENT_QUOTES, 'UTF-8');
}

function procesarDonacion($nombre, $monto, $token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return "Error: solicitud no autorizada.";
    }
    if ($nombre === '' || !is_numeric($monto) || $monto <= 0) {
        return "Error: datos inválidos.";
    }
    $id = uniqid('DON-');
    return "¡Gracias, {$nombre}! Donación de \${$monto} registrada (ID: {$id}).";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = sanitizar($_POST['donante'] ?? '');
    $m = sanitizar($_POST['monto']  ?? '');
    $t = $_POST['csrf_token']      ?? '';
    $msg = procesarDonacion($n, $m, $t);
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Resultado Donación</title></head><body>
            <section class='box'><p>{$msg}</p><p><a href='donar.php'>Volver</a></p></section>
          </body></html>";
}