import './bootstrap';

import { paraguayDepartmentMap } from './maps/paraguay-department-map'

window.paraguayDepartmentMap = paraguayDepartmentMap



import './charts/observatorio';

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;


import { initThemeToggle } from './theme-toggle';

initThemeToggle();
