<?php
require_once 'conexion.php';

$proyectos = $pdo->query("SELECT * FROM PROYECTO")->fetchAll();
$donantes = $pdo->query("SELECT * FROM DONANTE")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listados</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <nav>
        <a href="index.html">← Inicio</a>
    </nav>
    <section class="box">
        <h2>Proyectos Registrados</h2>
        <ul>
            <?php foreach ($proyectos as $p): ?>
                <li>
                    <?= htmlspecialchars($p['nombre']) ?> —
                    Inicio: <?= $p['fecha_inicio'] ?>,
                    Presupuesto: $<?= number_format($p['presupuesto'], 2) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="box">
        <h2>Donantes Registrados</h2>
        <ul>
            <?php foreach ($donantes as $d): ?>
                <li>
                    <?= htmlspecialchars($d['nombre']) ?> —
                    <?= htmlspecialchars($d['email']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>

</html>