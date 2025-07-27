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
  <title>Registrar Evento</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <section class="box">
    <h2>Registrar Nuevo Evento</h2>
    <form action="procesarEvento.php" method="post">
      <label for="descripcion">Descripción:</label>
      <input type="text" id="descripcion" name="descripcion" required>

      <label for="tipo">Tipo de evento:</label>
      <select id="tipo" name="tipo" required>
        <option value="">--Seleccione--</option>
        <option>Deportivo</option>
        <option>Cultural</option>
        <option>Social</option>
      </select>

      <label for="lugar">Lugar:</label>
      <input type="text" id="lugar" name="lugar" required>

      <label for="fecha">Fecha:</label>
      <input type="date" id="fecha" name="fecha" required>

      <label for="hora">Hora:</label>
      <input type="time" id="hora" name="hora" required>

      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <button type="submit">Registrar Evento</button>
    </form>
  </section>
</body>
</html>