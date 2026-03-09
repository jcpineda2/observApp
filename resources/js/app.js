import './bootstrap';

import Alpine from 'alpinejs'
import { paraguayDepartmentMap } from './maps/paraguay-department-map'

window.Alpine = Alpine
window.paraguayDepartmentMap = paraguayDepartmentMap

Alpine.start()


import './charts/observatorio';

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;


import { initThemeToggle } from './theme-toggle';

initThemeToggle();
