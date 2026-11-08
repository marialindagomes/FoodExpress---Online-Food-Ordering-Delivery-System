function ajaxForm(form, action, msgId) {
  form.addEventListener('submit', async e => {
    e.preventDefault();
    const fd = new FormData(form);
    fd.append('action', action);
    const r = await fetch(BASE_URL + '/ajax/auth.php', { method: 'POST', body: fd });
    const d = await r.json();
    document.getElementById(msgId).textContent = d.message || '';
    if (d.ok && d.url) location.href = d.url;
    else if (d.ok && action === 'register') setTimeout(() => location.href = BASE_URL + '/login.php', 700);
  });
}
const rf = document.getElementById('registerForm');
if (rf) ajaxForm(rf, 'register', 'registerMsg');
const lf = document.getElementById('loginForm');
if (lf) ajaxForm(lf, 'login', 'loginMsg');