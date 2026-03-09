<div
    x-data="{
        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
        init() {
            window.addEventListener('public-theme-changed', (event) => {
                this.theme = event.detail.theme;
            });
        },
        toggle() {
            window.publicTheme.toggle();
            this.theme = window.publicTheme.get();
        }
    }"
    class="inline-flex"
>
    <button
        type="button"
        @click="toggle()"
        class="group inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
        aria-label="Cambiar tema"
        title="Cambiar tema"
    >
        <span class="text-base" x-text="theme === 'dark' ? '🌙' : '☀️'"></span>
        <span class="hidden sm:inline" x-text="theme === 'dark' ? 'Oscuro' : 'Claro'"></span>
    </button>
</div>
