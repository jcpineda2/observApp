import './bootstrap';

// Alpine.js (necesario para x-data / x-init)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Charts (esto ya expone window.observatorioChart desde observatorio.js)
import './charts/observatorio';

// Leaflet (si lo usás en mapas)
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;
