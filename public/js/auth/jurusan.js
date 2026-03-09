/* ─ Dark Mode ─ */
const html = document.documentElement;
const dmBtn = document.getElementById('darkModeBtn');
const dmIcon = document.getElementById('themeIcon');

function applyTheme(t) {
    if (t === 'dark') {
        html.setAttribute('data-theme', 'dark');
        dmIcon.className = 'fas fa-sun';
    } else {
        html.removeAttribute('data-theme');
        dmIcon.className = 'fas fa-moon';
    }
    localStorage.setItem('theme', t);
}

// Apply saved theme
applyTheme(localStorage.getItem('theme') || 'light');

dmBtn.addEventListener('click', () => {
    applyTheme(localStorage.getItem('theme') === 'dark' ? 'light' : 'dark');
});

/* ─ Sidebar Toggle (mobile) ─ */
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const hamburger = document.getElementById('hamburger');

function toggleSidebar() {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
}

hamburger.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);

/* ─ Data Master Submenu ─ */
const dmBtn2 = document.getElementById('dataMasterBtn');
const dmSub = document.getElementById('dataMasterSub');

dmBtn2.addEventListener('click', (e) => {
    e.preventDefault();
    dmBtn2.classList.toggle('submenu-open');
    dmSub.classList.toggle('open');
});

/* ─ Active menu item ─ */
const menuItems = document.querySelectorAll('[data-page]');
const titles = {
    dashboard: ['Dashboard', 'Ringkasan data sistem informasi kerjasama Polimdo & DUDIKA'],
    mitra: ['Mitra Kerjasama', 'Kelola data mitra kerjasama'],
    jenis_kerjasama: ['Jenis Kerjasama', 'Kategori dan jenis kerjasama yang tersedia'],
    unit_pelaksana: ['Unit Pelaksana', 'Unit-unit pelaksana kerjasama di Polimdo'],
    program_kerjasama: ['Program Kerjasama', 'Daftar seluruh program kerjasama aktif'],
    hasil_capaian: ['Hasil & Capaian', 'Pencapaian dan realisasi program kerjasama'],
    evaluasi_kinerja: ['Evaluasi Kinerja', 'Penilaian kinerja mitra dan program'],
    permasalahan_solusi: ['Solusi & Masalah', 'Permasalahan yang muncul beserta solusinya'],
};

menuItems.forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        const page = item.dataset.page;
        // Remove active from all
        document.querySelectorAll('.menu-item.active, .submenu-item.active')
            .forEach(el => el.classList.remove('active'));
        item.classList.add('active');
        // Update header
        if (titles[page]) {
            document.getElementById('pageTitle').textContent = titles[page][0];
            document.getElementById('pageDesc').textContent = titles[page][1];
            document.getElementById('breadcrumbCurrent').textContent = titles[page][0];
        }
        // Close sidebar on mobile
        if (window.innerWidth < 768) toggleSidebar();
    });
});

/* ─ Show navSearch on wider screens ─ */
function checkSearch() {
    document.getElementById('navSearch').style.display = window.innerWidth > 900 ? 'flex' : 'none';
}
checkSearch();
window.addEventListener('resize', checkSearch);

/* ─ Logout confirm ─ */
document.getElementById('logoutBtn').addEventListener('click', () => {
    if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
        alert('Logout berhasil. (Demo mode)');
    }
});