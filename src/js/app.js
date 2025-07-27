import { Event } from './models.js';

const events = [
  new Event(1, 'Maratón Solidaria', '2025-06-30', 'Carrera 5K para recaudar fondos'),
  new Event(2, 'Taller de Arte', '2025-07-15', 'Actividades artísticas para niños'),
  new Event(3, 'Feria de Comida', '2025-07-27', 'Venta de platos típicos para recaudar fondos'),
];

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('event-search');
  const btnSearch = document.getElementById('btn-search');
  const resultsDiv = document.getElementById('results-container');

  function renderEvents(list) {
    resultsDiv.innerHTML = '';
    if (list.length === 0) {
      resultsDiv.textContent = 'No se encontraron eventos.';
      return;
    }
    list.forEach(ev => {
      const card = document.createElement('div');
      card.className = 'event-card';
      card.innerHTML = `
        <h3>${ev.title}</h3>
        <p><strong>Fecha:</strong> ${ev.formattedDate()}</p>
        <p>${ev.description}</p>
      `;
      resultsDiv.appendChild(card);
    });
  }

  function search() {
    const term = searchInput.value.trim().toLowerCase();
    const filtered = events.filter(ev =>
      ev.title.toLowerCase().includes(term) ||
      ev.description.toLowerCase().includes(term)
    );
    renderEvents(filtered);
  }

  btnSearch.addEventListener('click', search);

  // Mostrar todos al inicio
  renderEvents(events);
});

export { events };