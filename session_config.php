<?php
// session_config.php (para entorno local HTTP)
ini_set('session.gc_maxlifetime', 3600);  // 1 hora

session_set_cookie_params([
  'lifetime' => 3600,
  'path'     => '/',
  'domain'   => '',
  'secure'   => false,
  'httponly' => true,
  'samesite' => 'Lax'
]);

session_start();

// Regenerar ID de sesión cada 15 minutos
if (!isset($_SESSION['last_regeneration'])) {
  $_SESSION['last_regeneration'] = time();
}
if (time() - $_SESSION['last_regeneration'] > 900) {
  session_regenerate_id(true);
  $_SESSION['last_regeneration'] = time();
}

// Expiración de sesión por inactividad (30 min)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
  session_unset();
  session_destroy();
  exit;
}
$_SESSION['last_activity'] = time();