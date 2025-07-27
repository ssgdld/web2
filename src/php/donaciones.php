<?php
// donaciones.php
require_once 'session_config.php';
require_once 'conexion.php';

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function sanitizar(string $v): string
{
    return htmlspecialchars(stripslashes(trim($v)), ENT_QUOTES, 'UTF-8');
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar datos
    $nombre = sanitizar($_POST['donante'] ?? '');
    $monto = floatval($_POST['monto'] ?? 0);
    $token = $_POST['csrf_token'] ?? '';

    // Validar CSRF
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        $msg = 'Error: solicitud no autorizada.';
    }
    // Validar campos
    elseif ($nombre === '' || $monto <= 0) {
        $msg = 'Error: datos inválidos. Asegúrate de ingresar nombre y monto mayor que cero.';
    } else {
        // Insertar en BD
        $stmt = $pdo->prepare("
            INSERT INTO DONACION (donante, monto, fecha)
            VALUES (:don, :mon, NOW())
        ");
        $stmt->execute([
            ':don' => $nombre,
            ':mon' => $monto
        ]);
        $msg = "¡Gracias, {$nombre}! Tu donación de \${$monto} USD ha sido registrada.";
        // Regenerar token tras uso
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Donar — ONG Ejemplo</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>

<body>
    <nav class="box">
        <a href="../../index.php" class="btn">← Inicio</a>
    </nav>

    <section class="box">
        <h2>Realizar Donación</h2>

        <?php if ($msg): ?>
            <p class="notification"><?= $msg ?></p>
        <?php endif; ?>

        <form action="donaciones.php" method="post" id="donation-form">
            <label for="donante">Nombre del donante:</label>
            <input type="text" id="donante" name="donante" required>

            <label for="monto">Monto (USD):</label>
            <input type="number" id="monto" name="monto" min="1" step="0.01" required>

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <button type="submit" class="btn">Donar</button>
        </form>
    </section>
</body>

</html>