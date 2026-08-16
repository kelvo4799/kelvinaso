// Theme Setup
(function () {
  const root = document.documentElement;

  const applyTheme = (theme) => {
    if (theme === 'dark') {
      root.setAttribute('data-theme', 'dark');
    } else {
      root.removeAttribute('data-theme');
    }

    root.style.colorScheme = theme;
  };

  try {
    const savedTheme = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initialTheme = savedTheme || (systemDark ? 'dark' : 'light');
    applyTheme(initialTheme);
  } catch (e) {
    applyTheme('light');
  }

  window.addEventListener('DOMContentLoaded', () => {
    const themeToggleBtn = document.querySelector('[data-theme-toggle]');
    if (themeToggleBtn) {
      themeToggleBtn.addEventListener('click', () => {
        const isDark = root.getAttribute('data-theme') === 'dark';
        const newTheme = isDark ? 'light' : 'dark';

        applyTheme(newTheme);

        try {
          localStorage.setItem('theme', newTheme);
        } catch (e) {
          // Ignore storage access issues.
        }
      });
    }
  });
})();