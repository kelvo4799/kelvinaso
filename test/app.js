// ============================================
// Portfolio Admin Panel — Mockup JS
// (UI behavior only — no real auth/persistence)
// ============================================

// --- Mobile sidebar toggle ---
document.addEventListener('click', (e) => {
  if (e.target.closest('.menu-btn')) {
    document.querySelector('.sidebar')?.classList.toggle('open');
  }
});

// --- Flash messages ---
function flash(message, type = 'success', title = null) {
  let stack = document.querySelector('.flash-stack');
  if (!stack) {
    stack = document.createElement('div');
    stack.className = 'flash-stack';
    document.body.appendChild(stack);
  }
  const el = document.createElement('div');
  el.className = `flash ${type}`;
  el.innerHTML = `
    <div>
      <strong>${title || (type === 'error' ? 'Error' : type === 'info' ? 'Info' : 'Success')}</strong>
      <span>${message}</span>
    </div>
    <button aria-label="Dismiss">&times;</button>`;
  stack.appendChild(el);
  const remove = () => el.remove();
  el.querySelector('button').onclick = remove;
  setTimeout(remove, 4000);
}
window.flash = flash;

// --- Confirm modal ---
function confirmAction({ title = 'Are you sure?', message = '', confirmText = 'Confirm', danger = true } = {}) {
  return new Promise((resolve) => {
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop open';
    backdrop.innerHTML = `
      <div class="modal" role="dialog" aria-modal="true">
        <h3>${title}</h3>
        <p>${message}</p>
        <div class="actions">
          <button class="btn secondary" data-act="cancel">Cancel</button>
          <button class="btn ${danger ? 'danger' : ''}" data-act="ok">${confirmText}</button>
        </div>
      </div>`;
    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop || e.target.dataset.act === 'cancel') {
        backdrop.remove(); resolve(false);
      } else if (e.target.dataset.act === 'ok') {
        backdrop.remove(); resolve(true);
      }
    });
  });
}
window.confirmAction = confirmAction;

// --- Login form (mock) ---
const loginForm = document.querySelector('#loginForm');
if (loginForm) {
  loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = loginForm.email.value.trim();
    const pwd = loginForm.password.value;
    if (!email || !pwd) { flash('Email and password are required.', 'error'); return; }
    flash('Logged in successfully (mock).', 'success');
    setTimeout(() => { window.location.href = 'dashboard.html'; }, 600);
  });
}

// --- Logout link ---
document.querySelectorAll('[data-logout]').forEach(el => {
  el.addEventListener('click', async (e) => {
    e.preventDefault();
    const ok = await confirmAction({ title: 'Log out?', message: 'You will be returned to the login screen.', confirmText: 'Log out', danger: false });
    if (ok) window.location.href = 'index.html';
  });
});

// --- File-drop preview ---
document.querySelectorAll('.file-drop').forEach(drop => {
  const input = drop.querySelector('input[type=file]');
  const preview = drop.querySelector('.preview-text');
  drop.addEventListener('click', () => input?.click());
  drop.addEventListener('dragover', (e) => { e.preventDefault(); drop.classList.add('drag'); });
  drop.addEventListener('dragleave', () => drop.classList.remove('drag'));
  drop.addEventListener('drop', (e) => {
    e.preventDefault(); drop.classList.remove('drag');
    if (e.dataTransfer.files[0] && input) {
      input.files = e.dataTransfer.files;
      input.dispatchEvent(new Event('change'));
    }
  });
  input?.addEventListener('change', () => {
    if (input.files[0] && preview) preview.textContent = input.files[0].name;
  });
});

// --- Generic save form (mock) ---
document.querySelectorAll('form[data-mock-save]').forEach(form => {
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    flash(form.dataset.mockSave || 'Saved successfully.', 'success');
  });
});

// --- Project table: delete + search ---
document.querySelectorAll('[data-delete-row]').forEach(btn => {
  btn.addEventListener('click', async () => {
    const ok = await confirmAction({
      title: 'Delete project?',
      message: 'This action cannot be undone.',
      confirmText: 'Delete'
    });
    if (ok) {
      btn.closest('tr')?.remove();
      flash('Project deleted.', 'success');
    }
  });
});

const searchInput = document.querySelector('#projectSearch');
if (searchInput) {
  searchInput.addEventListener('input', () => {
    const q = searchInput.value.toLowerCase();
    document.querySelectorAll('#projectsTable tbody tr').forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}

// --- Password change validation ---
const pwdForm = document.querySelector('#changePasswordForm');
if (pwdForm) {
  pwdForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const a = pwdForm.new_password.value;
    const b = pwdForm.confirm_password.value;
    if (a.length < 8) { flash('Password must be at least 8 characters.', 'error'); return; }
    if (a !== b) { flash('Passwords do not match.', 'error'); return; }
    pwdForm.reset();
    flash('Password updated successfully.');
  });
}
