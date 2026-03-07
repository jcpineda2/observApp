import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './charts/observatorio';

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;
