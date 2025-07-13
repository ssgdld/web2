<?php
require_once 'conexion.php';

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');

$errores = [];
if ($nombre === '')
    $errores[] = 'El nombre es obligatorio.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errores[] = 'Email inválido.';

if (!$errores) {
    $chk = $pdo->prepare("SELECT COUNT(*) FROM DONANTE WHERE email = ?");
    $chk->execute([$email]);
    if ($chk->fetchColumn() > 0) {
        $errores[] = 'El email ya está registrado.';
    }
}

if ($errores) {
    echo "<section class='box'><h3>Errores al registrar:</h3><ul>";
    foreach ($errores as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><p><a href='donante_form.html'>Volver</a></p></section>";
    exit;
}

$sql = "INSERT INTO DONANTE (nombre, email, direccion, telefono)
        VALUES (:nom, :mail, :dir, :tel)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nom' => $nombre,
    ':mail' => $email,
    ':dir' => $direccion,
    ':tel' => $telefono,
]);

echo "<section class='box'><p>Donante registrado con éxito.</p>
      <p><a href='donante_form.html'>Registrar otro</a> | <a href='index.html'>Inicio</a></p></section>";