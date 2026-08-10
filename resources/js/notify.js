// --- Custom Notification System ---
function flash(message, type = 'success', title = null) {
  let stack = document.querySelector('.flash-stack');
  if (!stack) {
    stack = document.createElement('div');
    stack.className = 'flash-stack';
    document.body.appendChild(stack);
  }
  
  const icons = {
    success: `<svg class="flash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`,
    error: `<svg class="flash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`,
    info: `<svg class="flash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`
  };

  const el = document.createElement('div');
  el.className = `flash ${type}`;
  
  el.innerHTML = `
    ${icons[type] || icons.info}
    <div class="flash-content" style="flex:1;">
      ${title ? `<strong>${title}</strong>` : ''}
      <span>${message}</span>
    </div>
    <button class="flash-close" aria-label="Dismiss">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>
  `;
  
  stack.appendChild(el);
  
  const remove = () => {
    el.classList.add('hiding');
    setTimeout(() => el.remove(), 300);
  };
  
  el.querySelector('.flash-close').onclick = remove;
  setTimeout(remove, 5000);
}
window.flash = flash;
