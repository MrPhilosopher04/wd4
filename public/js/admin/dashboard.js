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

// users
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
function closeOnOverlay(e, id) {
    if (e.target === document.getElementById(id)) closeModal(id);
}
function togglePass(id) {
    const el = document.getElementById(id);
    const eye = document.getElementById(id.replace('pass', 'eye'));
    el.type = el.type === 'password' ? 'text' : 'password';
    eye.className = el.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

function openEdit(id, name, nik, email, roleId) {
    document.getElementById('editName').value = name;
    document.getElementById('editNik').value = nik;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = roleId;
    document.getElementById('formEdit').action = `/users/${id}`;
    openModal('modalEdit');
}

function openDelete(id, name) {
    document.getElementById('deleteUserName').textContent = name;
    document.getElementById('formDelete').action = `/users/${id}`;
    openModal('modalDelete');
}

function openDetail(id) {
    openModal('modalDetail');
    fetch(`/users/${id}/detail`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
                    <div class="avatar" style="width:52px;height:52px;font-size:18px;background:#4f46e5;flex-shrink:0;">
                        ${data.name.substring(0, 2).toUpperCase()}
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:15px;">${data.name}</div>
                        <div style="font-size:12px;color:var(--text-sub);">${data.email}</div>
                    </div>
                </div>
                <div class="detail-row"><span class="detail-key">NIK</span><span class="detail-val detail-mono">${data.nik}</span></div>
                <div class="detail-row"><span class="detail-key">Role</span><span class="detail-val">${data.role ?? '-'}</span></div>
                <div class="detail-row"><span class="detail-key">Jabatan</span><span class="detail-val">${data.jabatan ?? '-'}</span></div>
                <div class="detail-row"><span class="detail-key">Unit Kerja</span><span class="detail-val">${data.unit_kerja ?? '-'}</span></div>
                <div class="detail-row"><span class="detail-key">Tanggal Dibuat</span><span class="detail-val">${data.created_at}</span></div>
            `;
        })
        .catch(() => {
            document.getElementById('detailContent').innerHTML = '<p style="color:#ef4444;text-align:center;">Gagal memuat data.</p>';
        });
}

// Filter tabel client-side
function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const role = document.getElementById('filterRole').value.toLowerCase();
    document.querySelectorAll('#usersTable tbody tr').forEach(row => {
        const name = row.dataset.name ?? '';
        const nik = row.dataset.nik ?? '';
        const rowRole = row.dataset.role ?? '';
        const matchQ = name.includes(q) || nik.includes(q);
        const matchRole = role === '' || rowRole.toLowerCase() === role;
        row.style.display = (matchQ && matchRole) ? '' : 'none';
    });
}