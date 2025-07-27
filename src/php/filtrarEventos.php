<?php
require_once 'session_config.php';
require_once 'Evento.php';

$eventos = [
  new Evento('EVT-001', 'Maratón Solidaria', 'Deportivo', 'Parque Central', '2025-06-30', '08:00'),
  new Evento('EVT-002', 'Taller de Arte',    'Cultural' , 'Casa de la Cultura', '2025-07-15', '14:00'),
  new Evento('EVT-003', 'Feria de Comida',   'Social'   , 'Plaza Principal',    '2025-07-27', '10:00'),
];

$q    = $_GET['q']    ?? '';
$tipo = $_GET['tipo'] ?? '';

if ($tipo) {
  $eventos = Evento::filtrarPorTipo($eventos, $tipo);
}
if ($q) {
  $eventos = Evento::buscarPorClave($eventos, $q);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eventos Filtrados</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <section class="box">
    <h2>Resultados de Búsqueda</h2>
    <?php if (empty($eventos)): ?>
      <p>No se encontraron eventos.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($eventos as $e): ?>
          <li><?= htmlspecialchars($e->resumen()) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <p><a href="index.html">← Volver al inicio</a></p>
  </section>
</body>
</html>