<?php
require_once 'conexion.php';

$sql = "SELECT d.id_donacion, d.monto, d.fecha,
               p.nombre AS proyecto,
               dn.nombre AS donante
        FROM DONACION d
        JOIN PROYECTO p ON p.id_proyecto = d.id_proyecto
        JOIN DONANTE  dn ON dn.id_donante   = d.id_donante
        ORDER BY d.fecha DESC";
$donaciones = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Donaciones</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>

<body>
    <nav>
        <a href="../../index.php">← Inicio</a>
    </nav>
    <section class="box">
        <h2>Donaciones Registradas (Total: <?= count($donaciones) ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proyecto</th>
                    <th>Donante</th>
                    <th>Monto (USD)</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donaciones as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['id_donacion']) ?></td>
                        <td><?= htmlspecialchars($d['proyecto']) ?></td>
                        <td><?= htmlspecialchars($d['donante']) ?></td>
                        <td>$<?= number_format($d['monto'], 2) ?></td>
                        <td><?= htmlspecialchars($d['fecha']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

</html>