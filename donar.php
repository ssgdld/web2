<?php
require_once 'session_config.php';

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Donar — ONG Ejemplo</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>

  <div id="notification-container" class="hidden"></div>

  <section class="box">
    <h2>Realizar Donación</h2>
    <form action="procesarDonacion.php" method="post" id="donation-form">
      <label for="donante">Nombre del donante:</label>
      <input type="text" id="donante" name="donante" required>

      <label for="monto">Monto (USD):</label>
      <input type="number" id="monto" name="monto" min="1" step="0.01" required>

      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <button type="submit">Donar</button>
    </form>
  </section>

  <script type="module" src="notifications.js"></script>

  <!-- 🔁 Script de ping automático -->
  <script>
    // Enviar ping cada 60 segundos para mantener la sesión activa
    setInterval(() => {
      fetch('ping.php', { method: 'GET' });
    }, 60000); // 60000 ms = 1 minuto
  </script>
</body>
</html>