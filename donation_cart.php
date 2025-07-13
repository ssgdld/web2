<?php
require_once 'session_config.php';

$campaigns = [
  ['id' => 1, 'name' => 'Construcción de Pozo', 'goal' => 55000],
  ['id' => 2, 'name' => 'Escuela Rural', 'goal' => 900000],
  ['id' => 3, 'name' => 'Banco de Alimentos', 'goal' => 74000],
];

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campaign_id'], $_POST['amount'])) {
  $cid = (int) $_POST['campaign_id'];
  $amount = floatval($_POST['amount']);
  if ($amount > 0) {
    $_SESSION['cart'][$cid] = ($_SESSION['cart'][$cid] ?? 0) + $amount;
  }
  header('Location: donation_cart.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Carrito de Donaciones — ONG</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f6f6f6;
      color: #333;
      padding: 20px;
    }

    h1,
    h2 {
      color: #0056b3;
    }

    .campaign-list,
    .cart-list {
      list-style: none;
      padding: 0;
    }

    .campaign-list li,
    .cart-list li {
      background: #fff;
      margin-bottom: 10px;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .campaign-list form {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .campaign-list input[type="number"] {
      width: 80px;
      padding: 5px;
    }

    .btn {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn:hover {
      background: #0056b3;
    }
  </style>
</head>

<body>
  <h1>Selecciona una Campaña</h1>
  <ul class="campaign-list">
    <?php foreach ($campaigns as $c): ?>
      <li>
        <strong><?= htmlspecialchars($c['name']) ?></strong>
        <form method="post" action="donation_cart.php">
          <input type="hidden" name="campaign_id" value="<?= $c['id'] ?>">
          <label>
            Monto (USD):
            <input type="number" name="amount" step="0.01" min="1" required>
          </label>
          <button type="submit" class="btn">Agregar</button>
        </form>
      </li>
    <?php endforeach; ?>
  </ul>

  <h2>Tu Carrito de Donaciones</h2>
  <?php if (empty($_SESSION['cart'])): ?>
    <p>No has agregado ninguna donación.</p>
  <?php else: ?>
    <ul class="cart-list">
      <?php foreach ($_SESSION['cart'] as $cid => $amt):
        $name = array_column($campaigns, 'name', 'id')[$cid] ?? 'Campaña desconocida';
        ?>
        <li>
          <?= htmlspecialchars($name) ?>: <strong>$<?= number_format($amt, 2) ?> USD</strong>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <!-- 🔁 Script de ping automático -->
  <script>
    // Enviar ping cada 60 segundos para mantener la sesión activa
    setInterval(() => {
      fetch('ping.php', { method: 'GET' });
    }, 60000); // 60000 ms = 1 minuto
  </script>
</body>

</html>