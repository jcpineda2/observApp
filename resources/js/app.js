import './bootstrap';

import { paraguayDepartmentMap } from './maps/paraguay-department-map'

window.paraguayDepartmentMap = paraguayDepartmentMap



import './charts/observatorio';

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;


// Inicio de scripts para tema claro/oscuro

const THEME_STORAGE_KEY = 'observatorio-theme';

function getSystemTheme() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function getPreferredTheme() {
    try {
        const saved = localStorage.getItem(THEME_STORAGE_KEY);
        if (saved === 'light' || saved === 'dark') {
            return saved;
        }
    } catch (_) {}

    return getSystemTheme();
}

function applyTheme(theme) {
    const root = document.documentElement;
    const isDark = theme === 'dark';

    root.classList.toggle('dark', isDark);
    root.setAttribute('data-theme', theme);

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.setAttribute(
            'aria-label',
            isDark ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro'
        );

        const lightIcon = button.querySelector('.theme-icon-light');
        const darkIcon = button.querySelector('.theme-icon-dark');
        const label = button.querySelector('[data-theme-label]');

        if (lightIcon) {
            lightIcon.classList.toggle('hidden', isDark);
        }

        if (darkIcon) {
            darkIcon.classList.toggle('hidden', !isDark);
        }

        if (label) {
            label.textContent = isDark ? 'Tema oscuro' : 'Tema claro';
        }
    });
}

function setTheme(theme) {
    try {
        localStorage.setItem(THEME_STORAGE_KEY, theme);
    } catch (_) {}

    applyTheme(theme);
}

function toggleTheme() {
    const current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    setTheme(current === 'dark' ? 'light' : 'dark');
}

function registerThemeToggleButtons() {
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        if (button.dataset.themeBound === 'true') return;

        button.dataset.themeBound = 'true';
        button.addEventListener('click', toggleTheme);
    });
}

function initializeThemeSystem() {
    applyTheme(getPreferredTheme());
    registerThemeToggleButtons();
}

document.addEventListener('DOMContentLoaded', initializeThemeSystem);
document.addEventListener('livewire:navigated', initializeThemeSystem);

const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
if (mediaQuery?.addEventListener) {
    mediaQuery.addEventListener('change', () => {
        let saved = null;
        try {
            saved = localStorage.getItem(THEME_STORAGE_KEY);
        } catch (_) {}

        if (saved !== 'light' && saved !== 'dark') {
            applyTheme(getSystemTheme());
        }
    });
}

// Fin de scripts para tema claro/oscuro
