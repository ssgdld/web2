<?php
require_once 'session_config.php';
require_once 'Evento.php';

function sanitizar(string $v): string {
    return htmlspecialchars(stripslashes(trim($v)), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acceso no autorizado.');
}

$tk = $_POST['csrf_token'] ?? '';
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $tk)) {
    die('Error: token inválido.');
}

$desc  = sanitizar($_POST['descripcion'] ?? '');
$tipo  = sanitizar($_POST['tipo'] ?? '');
$lugar = sanitizar($_POST['lugar']  ?? '');
$fecha = $_POST['fecha'] ?? '';
$hora  = $_POST['hora']  ?? '';

$errores = [];
if ($desc === '')  $errores[] = 'Descripción obligatoria.';
if ($tipo === '')  $errores[] = 'Tipo obligatorio.';
if ($lugar === '') $errores[] = 'Lugar obligatorio.';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) $errores[] = 'Fecha inválida.';
if (!preg_match('/^\d{2}:\d{2}$/', $hora))       $errores[] = 'Hora inválida.';

if ($errores) {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Errores</title></head><body>
          <section class='box'><h3>Errores:</h3><ul>";
    foreach ($errores as $e) echo "<li>".htmlspecialchars($e)."</li>";
    echo "</ul><p><a href='registrarEvento.php'>Volver</a></p></section></body></html>";
    exit;
}

$id = uniqid('EVT-');
$e  = new Evento($id, $desc, $tipo, $lugar, $fecha, $hora);

echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Evento Registrado</title></head><body>
      <section class='box'>
        <h2>¡Evento registrado!</h2>
        <p><strong>ID:</strong> {$e->id}</p>
        <p><strong>Descripción:</strong> ".htmlspecialchars($e->descripcion)."</p>
        <p><strong>Tipo:</strong> ".htmlspecialchars($e->tipo)."</p>
        <p><strong>Lugar:</strong> ".htmlspecialchars($e->lugar)."</p>
        <p><strong>Fecha y hora:</strong> {$e->fecha} {$e->hora}</p>
        <p><a href='registrarEvento.php'>Registrar otro</a> | <a href='index.html'>Inicio</a></p>
      </section>
    </body></html>";