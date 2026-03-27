/* =============================================
   NAVIGATION — PAGE SWITCHING
============================================= */
function navigate(page) {
  // Hide all pages
  document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
  // Show target page
  const targetPage = document.getElementById('page-' + page);
  if (targetPage) targetPage.classList.add('active');

  // Update desktop nav active state
  document.querySelectorAll('#topnav-menu .nav-item').forEach(el => {
    el.classList.toggle('active', el.dataset.page === page);
  });

  // Update drawer nav active state
  document.querySelectorAll('.mobile-drawer .drawer-nav-item').forEach(el => {
    el.classList.toggle('active', el.dataset.page === page);
  });
}

/* =============================================
   MOBILE DRAWER
============================================= */
function openDrawer()  { document.getElementById('mobile-drawer').classList.add('open'); }
function closeDrawer() { document.getElementById('mobile-drawer').classList.remove('open'); }

/* =============================================
   ADMIN DROPDOWN
============================================= */
function toggleDropdown() {
  document.getElementById('admin-dropdown').classList.toggle('open');
}
function closeDropdown() {
  document.getElementById('admin-dropdown').classList.remove('open');
}
// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
  if (!e.target.closest('#admin-av') && !e.target.closest('#admin-dropdown')) {
    closeDropdown();
  }
});

/* =============================================
   MODAL SYSTEM
============================================= */
function openModal(id) {
  document.getElementById(id).classList.add('open');
}
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}
// Close modal when clicking the overlay background
function closeModalOuter(e, id) {
  if (e.target.id === id) closeModal(id);
}
// Close modals on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-overlay.open').forEach(m => m.classList.remove('open'));
  }
});

/* =============================================
   TOAST NOTIFICATION SYSTEM
============================================= */
function showToast(type, message) {
  const container = document.getElementById('toast-container');
  if (!container) return;
  const icons = {
    success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
    error:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
    info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
  };
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `<div class="toast-icon">${icons[type]||icons.info}</div><div class="toast-msg">${message}</div>`;
  container.appendChild(toast);
  // Auto-remove after 3.5s with fade-out
  setTimeout(() => { toast.style.opacity='0'; toast.style.transform='translateX(30px)'; toast.style.transition='.3s'; setTimeout(()=>toast.remove(), 310); }, 3500);
}

/* =============================================
   BAR CHART RENDERER (Dashboard)
============================================= */
function renderBarChart(trends) {
  const chart = document.getElementById('bar-chart');
  if (!chart || !trends || trends.length === 0) return;

  // Find max value for scaling
  const maxVal = Math.max(...trends.map(t => t.count), 10); // min 10 for better visuals

  chart.innerHTML = trends.map(t => {
    const height = Math.max((t.count / maxVal) * 100, 5); // min 5% height
    return `
      <div class="bar-wrap">
        <div class="bar" data-val="${t.count}" title="${t.month}: ${t.count}" style="height:${height}%;"></div>
        <div class="bar-label">${t.month}</div>
      </div>
    `;
  }).join('');
}

/* =============================================
   REVENUE CHART RENDERER (Analytics)
============================================= */
function renderRevenueChart(trends) {
  const chart = document.getElementById('revenue-chart');
  if (!chart || !trends || trends.length === 0) return;

  // Find max value for scaling
  const maxVal = Math.max(...trends.map(t => t.amount), 1000000); 

  chart.innerHTML = trends.map(t => {
    const height = Math.max((t.amount / maxVal) * 100, 5);
    const labelVal = t.amount >= 1000000 ? (t.amount / 1000000).toFixed(1) + 'jt' : (t.amount / 1000).toFixed(0) + 'rb';
    return `
      <div class="bar-wrap">
        <div class="bar" data-val="Rp ${labelVal}" title="${t.month}: Rp ${t.amount.toLocaleString()}" style="height:${height}%;background:linear-gradient(180deg,#22C55E,#16A34A);"></div>
        <div class="bar-label">${t.month}</div>
      </div>
    `;
  }).join('');
}
