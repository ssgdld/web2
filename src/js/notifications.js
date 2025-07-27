// Selecciona el contenedor de notificaciones por su ID
const notificationContainer = document.getElementById('notification-container');

// Función para mostrar una notificación temporal
function showNotification(message, duration = 4000) {
  if (!notificationContainer) return;

  notificationContainer.textContent = message;
  notificationContainer.classList.remove('hidden');

  setTimeout(() => {
    notificationContainer.classList.add('hidden');
  }, duration);
}

// Mostrar notificación automáticamente al cargar la página
window.addEventListener('load', () => {
  showNotification('Campaña activa: ¡Escuela Rural necesita tu ayuda!');
});

// -- Heartbeat para mantener sesión viva cada 5 min --
setInterval(() => {
  fetch('ping.php', { credentials: 'include' }).catch(console.error);
}, 300000);