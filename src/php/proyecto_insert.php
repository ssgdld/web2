<?php
require_once 'conexion.php';

$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$presupuesto = $_POST['presupuesto'] ?? '';
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? null;

$errores = [];
if ($nombre === '')
    $errores[] = 'El nombre es obligatorio.';
if ($descripcion === '')
    $errores[] = 'La descripción es obligatoria.';
if (!is_numeric($presupuesto) || $presupuesto < 0)
    $errores[] = 'Presupuesto inválido.';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_inicio))
    $errores[] = 'Fecha Inicio inválida.';
if ($fecha_fin && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_fin))
    $errores[] = 'Fecha Fin inválida.';
if ($fecha_fin && $fecha_fin < $fecha_inicio)
    $errores[] = 'Fecha Fin anterior a Fecha Inicio.';

if ($errores) {
    echo "<section class='box'><h3>Errores al registrar:</h3><ul>";
    foreach ($errores as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><p><a href='proyecto_form.html'>Volver</a></p></section>";
    exit;
}

$sql = "INSERT INTO PROYECTO (nombre, descripcion, presupuesto, fecha_inicio, fecha_fin)
        VALUES (:nom, :desc, :pres, :fini, :ffin)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nom' => $nombre,
    ':desc' => $descripcion,
    ':pres' => $presupuesto,
    ':fini' => $fecha_inicio,
    ':ffin' => $fecha_fin,
]);

echo "<section class='box'><p>Proyecto registrado con éxito.</p>
      <p><a href='proyecto_form.html'>Registrar otro</a> | <a href='index.html'>Inicio</a></p></section>";