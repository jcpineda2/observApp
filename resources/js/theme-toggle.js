export function initThemeToggle() {
    const storageKey = 'public-theme';

    const applyTheme = (theme) => {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    const resolveInitialTheme = () => {
        const saved = localStorage.getItem(storageKey);

        if (saved === 'dark' || saved === 'light') {
            return saved;
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    };

    const setTheme = (theme) => {
        applyTheme(theme);
        localStorage.setItem(storageKey, theme);
        window.dispatchEvent(new CustomEvent('public-theme-changed', {
            detail: { theme },
        }));
    };

    const toggleTheme = () => {
        const current = document.documentElement.classList.contains('dark')
            ? 'dark'
            : 'light';

        setTheme(current === 'dark' ? 'light' : 'dark');
    };

    applyTheme(resolveInitialTheme());

    window.publicTheme = {
        get: () => (
            document.documentElement.classList.contains('dark')
                ? 'dark'
                : 'light'
        ),
        set: setTheme,
        toggle: toggleTheme,
    };
}
