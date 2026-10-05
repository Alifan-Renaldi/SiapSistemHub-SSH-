/* SSH Global Theme Toggle (vanilla JS, no jQuery dependency).
 * Works on every page using layout/header + layout/footer.
 * Persists locally (localStorage) + server session via POST theme/set.
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'ssh_theme';
  var GLOBAL_BTN_ID = 'theme-toggle-global';
  var LEGACY_BTN_ID = 'theme-toggle';

  function readStoredTheme() {
    try {
      var t = localStorage.getItem(STORAGE_KEY);
      if (t === 'dark' || t === 'light') return t;
    } catch (e) {}
    return null;
  }

  function bodyEl() {
    return document.body || document.getElementsByTagName('body')[0];
  }

  function syncIcon(theme) {
    var iconClass = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    [GLOBAL_BTN_ID, LEGACY_BTN_ID].forEach(function (id) {
      try {
        var btn = document.getElementById(id);
        if (!btn) return;
        var icon = btn.querySelector('i');
        if (icon) icon.className = iconClass;
        btn.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
        btn.setAttribute('title', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
      } catch (e) {}
    });
  }

  function persistServer(theme) {
    try {
      var baseInput = document.getElementById('base');
      var base = baseInput && baseInput.value ? baseInput.value : '/';
      if (base.slice(-1) !== '/') base += '/';
      var csrfName = null;
      var csrfHash = null;
      try {
        var metaToken = document.querySelector('meta[name=csrf-token]');
        if (metaToken) csrfHash = metaToken.getAttribute('content');
      } catch (e) {}
      var payload = 'theme=' + encodeURIComponent(theme);
      fetch(base + 'theme/set', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: payload,
        credentials: 'same-origin'
      }).catch(function () {});
    } catch (e) {}
  }

  function applyTheme(theme, persist) {
    if (theme !== 'dark' && theme !== 'light') theme = 'light';
    try {
      var body = bodyEl();
      if (body) {
        if (theme === 'dark') body.classList.add('dark-mode');
        else body.classList.remove('dark-mode');
      }
      try { document.documentElement.classList.remove('dark-mode-pre'); } catch (e) {}
      try { localStorage.setItem(STORAGE_KEY, theme); } catch (e) {}
      syncIcon(theme);
      try {
        document.dispatchEvent(new CustomEvent('theme:changed', { detail: { theme: theme } }));
      } catch (e) {}
      if (persist !== false) persistServer(theme);
    } catch (e) {}
    return theme;
  }

  function currentTheme() {
    try {
      var body = bodyEl();
      if (body && body.classList.contains('dark-mode')) return 'dark';
    } catch (e) {}
    return readStoredTheme() || 'light';
  }

  function bindButton(id) {
    try {
      var btn = document.getElementById(id);
      if (!btn || btn.getAttribute('data-theme-bound') === '1') return;
      btn.setAttribute('data-theme-bound', '1');
      btn.addEventListener('click', function (ev) {
        try { ev.preventDefault(); } catch (e) {}
        applyTheme(currentTheme() === 'dark' ? 'light' : 'dark', true);
      });
    } catch (e) {}
  }

  function init() {
    var initial = readStoredTheme();
    if (!initial) {
      try {
        var body = bodyEl();
        initial = (body && body.classList.contains('dark-mode')) ? 'dark' : 'light';
      } catch (e) { initial = 'light'; }
    }
    applyTheme(initial, false);
    bindButton(GLOBAL_BTN_ID);
    bindButton(LEGACY_BTN_ID);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  window.SSHTheme = {
    get: currentTheme,
    set: function (t) { return applyTheme(t, true); },
    toggle: function () { return applyTheme(currentTheme() === 'dark' ? 'light' : 'dark', true); }
  };
})();
