// ============================================
// Premium Portfolio Admin Panel JS
// ============================================

// --- Flash Messages --- 
// Flash function moved to notify.js

// --- Modals & Slideovers ---
const openModal = (id) => {
  const modal = document.getElementById(id);
  if (modal) modal.classList.add('open');
};

const closeModal = (modal) => {
  if (modal) modal.classList.remove('open');
};

document.addEventListener('click', (e) => {
  // Open modal/slideover
  const trigger = e.target.closest('[data-modal], [data-slideover]');
  if (trigger) {
    e.preventDefault();
    const id = trigger.dataset.modal || trigger.dataset.slideover;
    openModal(id);
  }
  
  // Close modal/slideover via close button
  const closeBtn = e.target.closest('[data-modal-close]');
  if (closeBtn) {
    e.preventDefault();
    closeModal(closeBtn.closest('.modal-backdrop'));
  }
  
  // Close modal/slideover via backdrop click
  if (e.target.classList.contains('modal-backdrop')) {
    closeModal(e.target);
  }
});

// Close modals on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-backdrop.open').forEach(closeModal);
  }
});

// --- User Dropdown ---
const userDropdownTrigger = document.getElementById('userDropdownTrigger');
const userDropdown = document.getElementById('userDropdown');

if (userDropdownTrigger && userDropdown) {
  userDropdownTrigger.addEventListener('click', (e) => {
    e.stopPropagation();
    userDropdown.classList.toggle('active');
  });
  
  document.addEventListener('click', (e) => {
    if (!userDropdownTrigger.contains(e.target)) {
      userDropdown.classList.remove('active');
    }
  });
}

// --- Command Palette ---
const searchTrigger = document.getElementById('searchTrigger');
const cmdModal = document.getElementById('cmdModal');
const cmdInput = document.getElementById('cmdInput');
const cmdItems = document.querySelectorAll('.cmd-item');

if (searchTrigger) {
  searchTrigger.addEventListener('click', () => {
    openModal('cmdModal');
    setTimeout(() => cmdInput?.focus(), 100);
  });
}

document.addEventListener('keydown', (e) => {
  if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
    e.preventDefault();
    openModal('cmdModal');
    setTimeout(() => cmdInput?.focus(), 100);
  }
});

if (cmdInput) {
  cmdInput.addEventListener('input', (e) => {
    const q = e.target.value.toLowerCase();
    cmdItems.forEach(item => {
      const text = item.textContent.toLowerCase();
      item.style.display = text.includes(q) ? 'flex' : 'none';
    });
  });
}

cmdItems.forEach(item => {
  item.addEventListener('click', () => {
    const action = item.dataset.action;
    closeModal(cmdModal);
    cmdInput.value = ''; // reset
    cmdItems.forEach(i => i.style.display = 'flex');
    
    if (action.startsWith('modal:')) {
      setTimeout(() => openModal(action.split(':')[1]), 300);
    } else if (action.startsWith('slideover:')) {
      setTimeout(() => openModal(action.split(':')[1]), 300);
    } else if (action.startsWith('link:')) {
      flash(`Navigating to ${action.split(':')[1]} (mock)`, 'info');
    }
  });
});


// --- Forms & Mock Actions ---
document.querySelectorAll('form[data-mock-save]').forEach(form => {
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : 'Save';
    
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="animate-pulse"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Saving...`;
      submitBtn.style.opacity = '0.7';
    }

    setTimeout(() => {
      const modal = form.closest('.modal-backdrop');
      if (modal) closeModal(modal);
      flash(form.dataset.mockSave || 'Saved successfully.', 'success');
      form.reset();
      
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        submitBtn.style.opacity = '1';
      }
    }, 800);
  });
});

// Logout
document.querySelectorAll('[data-logout]').forEach(el => {
  el.addEventListener('click', (e) => {
    e.preventDefault();
    flash('Logged out successfully.', 'info');
    // window.location.href = 'index.html'; // Mocked
  });
});

// Mobile Sidebar
document.addEventListener('click', (e) => {
  if (e.target.closest('.menu-btn')) {
    document.querySelector('.sidebar')?.classList.toggle('open');
  }
});

// --- Chart.js Initialization ---
document.addEventListener('DOMContentLoaded', () => {
  // Initialize Quill if the container exists
  if (document.getElementById('quillEditor') && window.Quill) {
    new Quill('#quillEditor', {
      theme: 'snow',
      placeholder: 'Write your message...',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          ['blockquote', 'code-block'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'color': [] }, { 'background': [] }],
          ['link'],
          ['clean']
        ]
      }
    });
  }

  const ctx = document.getElementById('audienceChart');
  if (ctx && window.Chart) {
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = "'Inter', sans-serif";
    
    // Create gradient
    const canvasContext = ctx.getContext('2d');
    const gradient = canvasContext.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');
    
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Page Views',
          data: [6500, 7800, 6900, 8100, 9500, 10200, 11500, 10800, 11200, 12500, 12300, 14000],
          borderColor: '#6366f1',
          backgroundColor: gradient,
          borderWidth: 3,
          pointBackgroundColor: '#0b0f19',
          pointBorderColor: '#6366f1',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(15, 23, 42, 0.9)',
            titleColor: '#fff',
            bodyColor: '#94a3b8',
            borderColor: 'rgba(255, 255, 255, 0.1)',
            borderWidth: 1,
            padding: 12,
            displayColors: false,
            callbacks: {
              label: function(context) {
                return context.parsed.y.toLocaleString() + ' views';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(255, 255, 255, 0.05)',
              drawBorder: false,
            },
            ticks: {
              callback: function(value) {
                return value / 1000 + 'k';
              }
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false,
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
      }
    });
  }
});
