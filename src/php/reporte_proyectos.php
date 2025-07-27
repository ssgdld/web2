<?php
require_once 'conexion.php';

$sql = "SELECT
          p.id_proyecto,
          p.nombre AS proyecto,
          COUNT(d.id_donacion) AS num_donaciones,
          SUM(d.monto)           AS total_recaudado
        FROM PROYECTO p
        JOIN DONACION d ON d.id_proyecto = p.id_proyecto
        GROUP BY p.id_proyecto, p.nombre
        HAVING COUNT(d.id_donacion) > 2
        ORDER BY total_recaudado DESC";
$resultados = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proyectos con Alta Participación</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>

<body>
    <nav>
        <a href="../../index.php">← Inicio</a>
    </nav>
    <section class="box">
        <h2>Proyectos con más de 2 donaciones</h2>
        <?php if (empty($resultados)): ?>
            <p>No hay proyectos con más de dos donaciones.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Proyecto</th>
                        <th>Nombre</th>
                        <th># Donaciones</th>
                        <th>Total Recaudado (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['id_proyecto']) ?></td>
                            <td><?= htmlspecialchars($r['proyecto']) ?></td>
                            <td><?= htmlspecialchars($r['num_donaciones']) ?></td>
                            <td>$<?= number_format($r['total_recaudado'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</body>

</html>