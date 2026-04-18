## Pengembangan dan Implementasi Sistem Informasi Berbasis Web untuk Evaluasi Kerja Sama Kampus–Industri (Studi Kasus: Politeknik Negeri Manado)

### Role Akses:
- Admin → full control
- Pimpinan → Memberi penilaian evaluasi & melakukan monitoring
- Unit Kerja:
    - Jurusan (Semua Jurusan) → Input kegiatan (Tidak ada Evaluasi)

![Struktur Organisasi]([https://myoctocat.com/assets/images/base-octocat.svg](https://github.com/MrPhilosopher04/wd4/blob/wd4_delon/resources/image/Struktur-Organisasi-Polimdo-1536x871.png))

### Flow:
Jurusan / Unit Kerja
        ↓ (input data)
   Data Kerjasama
        ↓
   Notifikasi ke Pimpinan
        ↓
   Pimpinan Monitoring
        ↓
   Evaluasi & Catatan
        ↓
   Data Final + Laporan

### PATH FILE MENU JURUSAN
JURUSAN -> Fokus: INPUT DATA SAJA -> resources/views/auth/jurusan.blade.php
Dashboard -> resources/views/auth/layout/jurusan/dashboard.blade.php
Data Kerjasama -> resources/views/auth/layout/jurusan/dkerjasama.blade.php
Laporan Data -> resources/views/auth/layout/jurusan/laporan.blade.php

## PROSES CARA KERJA HAK AKSES UNIT KERJA DAN PIMPINAN
Berikut adalah penjelasan detail di mana proses "memberikan" dan "melihat" data tersebut terjadi:

1. Di mana Pimpinan MEMBERIKAN Ringkasan & Saran untuk Unit Kerja?
Proses ini dilakukan di dalam menu Evaluasi & Validasi pada hak akses Pimpinan.
Agar Pimpinan tidak bingung membedakan mana laporan Jurusan dan mana laporan Unit Kerja, Anda bisa membagi tampilan di menu ini menjadi dua Tab atau menggunakan Filter:

Tab Laporan Jurusan: Merender query data dengan status menunggu_evaluasi.

Tab Laporan Unit Kerja: Merender query data dengan status menunggu_validasi_pimpinan.

Ketika Pimpinan menekan tombol "Beri Penilaian" pada salah satu laporan Unit Kerja di tab tersebut, sistem akan memunculkan form di mana Pimpinan bisa mengetikkan Ringkasan Evaluasi dan Saran Tindak Lanjut, lalu mengubah statusnya menjadi Selesai.

2. Di mana Unit Kerja MELIHAT Hasil Ringkasan & Saran dari Pimpinan?
Setelah Pimpinan selesai melakukan evaluasi akhir, Unit Kerja dapat membaca hasilnya di dalam menu Data Kerjasama milik mereka (bukan di menu Evaluasi Internal).

Cara kerjanya:

Unit Kerja masuk ke menu Data Kerjasama.

Mereka mencari dokumen yang statusnya sudah Selesai.

Mereka menekan tombol "Detail" pada dokumen tersebut.

Di halaman detail tersebut (biasanya diletakkan di posisi paling bawah atau pada tab khusus bernama "Hasil Validasi Pimpinan"), sistem akan merender data teks Ringkasan Evaluasi, Saran Tindak Lanjut, dan Status Kelayakan yang telah diketik oleh Pimpinan.

3. Apa yang Diinput Unit Kerja di Menu "Evaluasi Internal"?
Sebagai pengingat, pada menu Evaluasi Internal milik Unit Kerja, mereka tidak membuat Ringkasan Evaluasi dan Saran Tindak Lanjut.

Di menu tersebut, Unit Kerja murni hanya melakukan Self-Assessment (mengisi metrik skoring form evaluasi) yang merujuk pada tabel evaluasis:

Kesesuaian dengan rencana (1-5)

Kualitas pelaksanaan (1-5)

Keterlibatan mitra (1-5)

Efisiensi penggunaan sumber daya (1-5)

Kepuasan pihak terkait (1-5)

Setelah Unit Kerja menyimpan nilai-nilai angka/skoring ini, barulah dokumen tersebut terlempar ke menu Pimpinan (menunggu_validasi_pimpinan) untuk diberikan kesimpulan akhir berupa teks (Ringkasan & Saran).

## PROSES CARA KERJA HAK AKSES JURUSAN DAN PIMPINAN
1. Untuk Hak Akses JURUSAN
A. Apa yang Diinput oleh Jurusan?
Jurusan tidak memiliki menu evaluasi. Mereka murni bekerja di menu Data Kerjasama.

Saat mengklik "Tambah Data", mereka hanya mengisi form fakta di lapangan (Informasi Umum, Tujuan, Pelaksanaan, Hasil, Kendala, dan Bukti Lampiran).

Mereka tidak melihat form skor angka (1-5) atau form teks ringkasan/saran.

Setelah selesai, mereka klik "Kirim ke Pimpinan" (Status berubah menjadi menunggu_evaluasi).

B. Di mana Jurusan MELIHAT Penilaian, Ringkasan, dan Saran?
Sama seperti Unit Kerja, Jurusan melihat hasil akhirnya di dalam menu Data Kerjasama.

Saat sebuah dokumen sudah berstatus Selesai, Jurusan mengklik tombol "Detail".

Di bagian paling bawah halaman detail tersebut (misalnya di dalam card bernama "Hasil Penilaian Pimpinan"), Jurusan dapat melihat lengkap:

Skor Kinerja (1-5) yang diberikan Pimpinan.

Ringkasan Evaluasi (Teks).

Saran Tindak Lanjut (Teks).

2. Untuk Hak Akses PIMPINAN
Karena Pimpinan menerima dua jenis laporan yang berbeda (dari Jurusan dan dari Unit Kerja), maka form yang muncul di layar Pimpinan akan sedikit berbeda (dinamis) menyesuaikan siapa pengirimnya.

A. Di mana Pimpinan MEMBERIKAN Penilaian & Catatan?
Semuanya terpusat di menu Evaluasi & Validasi. Di menu ini, sistem akan merender form yang berbeda tergantung status dokumen:

Skenario 1: Mengevaluasi Laporan JURUSAN (Status: menunggu_evaluasi)
Saat Pimpinan klik "Beri Penilaian" pada data milik Jurusan, form yang terbuka akan sangat lengkap. Pimpinan harus menginput:

Skor Angka (1-5) (Kesesuaian, Kualitas, Keterlibatan, Efisiensi, Kepuasan).

Ringkasan Evaluasi (Input Textarea).

Saran Tindak Lanjut (Input Textarea).

Status Validasi Akhir (Layak/Tidak).

Skenario 2: Memvalidasi Laporan UNIT KERJA (Status: menunggu_validasi_pimpinan)
Saat Pimpinan klik "Beri Penilaian" pada data milik Unit Kerja, form yang terbuka lebih ringkas.

Pimpinan akan melihat Skor Angka (1-5) yang sudah diisi secara Self-Assessment oleh Unit Kerja (tampilannya Read-Only, Pimpinan tinggal melihat saja).

Pimpinan hanya perlu menginput:

Ringkasan Evaluasi (Input Textarea).

Saran Tindak Lanjut (Input Textarea).

Status Validasi Akhir (Layak/Tidak).

B. Di mana Pimpinan MELIHAT hasil kerjanya?
Setelah mengeklik "Simpan", dokumen tersebut hilang dari antrean menu Evaluasi & Validasi. Jika Pimpinan ingin melihat kembali dokumen yang sudah selesai mereka nilai, mereka bisa membukanya di menu Monitoring Data atau menarik datanya di menu Laporan Global.

Dengan logika render form yang dinamis di Controller Pimpinan ini, tugas Pimpinan menjadi sangat efisien dan tidak ada form yang tumpang tindih.

Untuk hak 2 tap pada menu "Evaluasi & Validasi" di hak akses di pimpinan yaitu yang pertama:
1. Evaluasi Jurusan
menggunakan tabel databees dari evaluasis dan kesimpulans.
2. Evaluasi Unit Kerja
hanya menggunakan tabel databeses dari kesipulans saja.

## PERAN KERJA NOTIFIKASI
Keputusan yang sangat jeli! Memiliki dua akses untuk menu yang sama (di header dan di sidebar) seringkali membuat tampilan menjadi redundan (tumpang tindih).

Pendekatan terbaik dan paling modern untuk sistem informasi seperti ini adalah menghapus menu Notifikasi dari sidebar dan memusatkan semuanya pada ikon lonceng di header.

Dengan cara ini, sidebar Anda akan benar-benar bersih dan hanya berisi menu inti (Dashboard & Data Kerjasama).

Berikut adalah skenario penerapan UI/UX dan alur sistem yang paling ideal untuk fitur notifikasi Anda:

1. Peran Ikon Lonceng di Header (Quick View)
Ikon di header berfungsi sebagai pusat perhatian instan karena posisinya selalu terlihat di halaman mana pun user berada.

Badge Angka: Menampilkan jumlah notifikasi yang belum dibaca (berdasarkan kolom is_read = 0 di tabel notifikasis).

Dropdown Pop-up: Saat ikon diklik, muncul dropdown yang menampilkan 3 hingga 5 notifikasi terbaru.

Aksi Cepat: User bisa mengklik salah satu notifikasi di dropdown tersebut, dan sistem akan langsung mengarahkan mereka ke halaman detail kegiatan yang bersangkutan, sekaligus mengubah status is_read menjadi 1 (sudah dibaca).

---


## Setup Standar

README ini sebelumnya lebih fokus ke alur bisnis dan arsitektur. Bagian ini ditambahkan supaya developer baru bisa menjalankan project lebih cepat di local.

### Kebutuhan Minimum
- PHP 8.2
- Composer
- SQLite atau MySQL
- Node.js dan npm opsional, hanya jika ingin mengelola aset frontend Vite

### Setup Cepat
1. Clone project lalu masuk ke root folder project.
2. Install dependency PHP:

```bash
composer install
```

3. Buat file environment dari `.env.example` menjadi `.env`.
4. Generate application key:

```bash
php artisan key:generate
```

5. Siapkan database.

Default project pada `.env.example` memakai SQLite:
- pastikan file `database/database.sqlite` ada
- lalu jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

Jika ingin memakai MySQL:
- ubah `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`
- lalu jalankan:

```bash
php artisan migrate --seed
```

6. Jalankan aplikasi:

```bash
php artisan serve
```

7. Buka aplikasi di browser:
- Landing page: `http://127.0.0.1:8000/`
- Login user: `http://127.0.0.1:8000/login`
- Login admin: `http://127.0.0.1:8000/admin/login`

### Akun Awal Seeder

Seeder bawaan project membuat 4 role dan akun awal berikut. Semua akun memakai password default `password`.

| Role | NIK | Nama |
| --- | --- | --- |
| unit_kerja | `123456` | Admin Unit |
| jurusan | `222222` | Admin Jurusan |
| pimpinan | `012460` | Admin Pimpinan |
| admin | `120604` | Admin |

### Catatan Menjalankan Project
- Field login yang dipakai adalah `nik` dan `password`, bukan email.
- Seeder utama dipanggil lewat `DatabaseSeeder` dan saat ini menjalankan `UsersSeeder`.
- Aset utama aplikasi saat ini masih banyak dimuat dari `public/css` dan `public/js`, jadi frontend inti tetap bisa jalan tanpa `npm run dev`.
- Jika ingin menyiapkan tool frontend bawaan Laravel, jalankan:

```bash
npm install
npm run dev
```

### Testing

Untuk menjalankan test bawaan:

```bash
php artisan test
```

## Gambaran Besar

Project ini adalah aplikasi web Laravel yang dipakai untuk mengelola data kerja sama kampus-industri dari awal sampai akhir: input data, evaluasi, validasi pimpinan, notifikasi, monitoring, dan laporan. Secara arsitektur, ini adalah monolith server-rendered: satu aplikasi Laravel menangani halaman, logika bisnis, database, dan export laporan sekaligus.

Kalau disederhanakan, sistem ini punya 4 aktor utama:

- **admin** mengelola user dan master data.
- **jurusan** menginput data kerja sama dan melihat hasil evaluasi.
- **unit_kerja** menginput data kerja sama, mengisi evaluasi internal, lalu mengirim ke pimpinan.
- **pimpinan** memonitor, menilai, memberi kesimpulan, dan menghasilkan laporan global.

## Alur Dasar Sistem

Cara kerja satu request di web ini kira-kira begini:

1. Browser masuk ke `public/index.php`. File ini adalah "pintu depan" aplikasi.
2. Laravel di-boot lewat `bootstrap/app.php`, termasuk pendaftaran middleware seperti role.
3. Request dicocokkan ke route di `routes/web.php`. Kalau route dilindungi, middleware seperti `RoleMiddleware.php` mengecek apakah user sudah login dan punya role yang tepat.
4. Controller menjalankan logika bisnis, mengambil atau menyimpan data lewat model Eloquent.
5. Controller mengirim data ke Blade view di `resources/views/...`.
6. Setelah HTML tampil, JavaScript di `public/js/...` menambahkan perilaku interaktif seperti notifikasi, pencarian tabel, pagination, chart, dan modal.

Jadi urutannya adalah: browser -> route -> middleware -> controller -> model/database -> view -> JavaScript frontend.

## Struktur Folder Utama

Berikut fungsi bagian-bagian penting project ini:

- `app/Http/Controllers` adalah pusat logika aplikasi. Di sinilah alur bisnis ditulis: login, dashboard, CRUD kerja sama, evaluasi, notifikasi, dan laporan.
- `app/Models` adalah representasi tabel database. Model dipakai untuk membaca relasi dan data dengan gaya Laravel Eloquent.
- `routes/web.php` mendefinisikan URL web. File ini menentukan halaman mana menuju controller mana, dan role apa yang boleh mengakses.
- `resources/views` berisi tampilan Blade. Ini adalah wajah aplikasi yang dirender di server.
- `database/migrations` mendefinisikan struktur tabel database. Semua kolom, foreign key, dan pivot table dibentuk dari sini.
- `database/seeders` mengisi data awal, misalnya role dan user awal. Contohnya ada di `UsersSeeder.php`.
- `public/js` dan `public/css` menyimpan aset frontend yang langsung dipakai halaman.
- `app/Exports` dipakai untuk export Excel. PDF dibuat lewat controller dengan DomPDF.
- `config` berisi konfigurasi Laravel seperti database, session, mail, cache.
- `tests` disiapkan untuk pengujian, walau saat ini isinya masih sangat dasar.

## Bagian Backend dan Fungsinya

Backend project ini bisa dibaca sebagai beberapa kelompok besar:

- **Auth**: Login user biasa ditangani `LoginController.php`, sedangkan admin punya login terpisah di `AdminAuthController.php`. Setelah login, user diarahkan ke dashboard sesuai role.
- **Dashboard**: `DashboardController.php` dan `DashboardJurusanController.php` menyiapkan angka statistik, grafik, dan daftar ringkas data untuk tiap role.
- **Kerjasama Jurusan**: `KerjasamaJurusanController.php` menangani pembuatan, edit, hapus, detail, sub-data, dan submit ke pimpinan untuk data yang dimiliki jurusan.
- **Kerjasama Unit**: `KerjasamaUnitController.php` menangani hal yang mirip untuk unit kerja: CRUD data utama dan sub-data kerja sama.
- **Evaluasi Unit**: `UnitPageController.php` juga memegang menu evaluasi kinerja milik unit kerja, termasuk menyimpan skor evaluasi internal dan mengirimkannya ke pimpinan.
- **Evaluasi Pimpinan**: `EvaluasiPimpinanController.php` adalah titik akhir penilaian pimpinan. Di sinilah skor dan kesimpulan akhir ditulis, status kegiatan diubah, lalu notifikasi dikirim balik ke pengusul.
- **Laporan**: Ada controller laporan per role: `LaporanJurusanController.php`, `LaporanPimpinanController.php`, dan method laporan di `UnitPageController.php`. Mereka menyaring data, menampilkan preview, lalu export ke PDF atau Excel.
- **Notifikasi**: `NotifikasiController.php` menyediakan endpoint kecil berbasis JSON untuk mengambil notifikasi, menandai satu notif dibaca, atau menandai semua dibaca.

## Model dan Hubungan Data

Kalau mau memahami sistem ini, model terpentingnya adalah `KegiatanKerjasama.php`. Ini adalah "inti" sistem. Hampir semua modul berputar di sekitar satu kegiatan kerja sama.

Relasi datanya secara sederhana seperti ini:

- `User.php` belongsTo `Role.php` dan hasOne `Profile.php`. `Profile` menghubungkan user ke jurusan atau unit_kerja.
- `KegiatanKerjasama` belongsTo creator user, lalu terhubung ke: `JenisKerjasama`, `Jurusan`, `UnitKerja`, `Mitra`, `Tujuan`, `Pelaksanaan`, `Hasil`, `Dokumentasi`, `PermasalahanSolusi`, `Evaluasi`, dan `Kesimpulan`.
- `Evaluasi.php` menyimpan skor-skor penilaian.
- `Kesimpulan.php` menyimpan ringkasan, saran, dan tindak lanjut final.
- `Dokumentasi.php` menyimpan link bukti/lampiran.
- `Notifikasi.php` menghubungkan penerima, pengirim, sumber kegiatan, tipe notifikasi, dan link tujuan.

Artinya, satu kegiatan_kerjasama adalah kepala dokumen, sedangkan tabel lain adalah detail-detail yang menempel pada dokumen itu.

## Struktur Database Secara Konsep

Database dibangun bertahap lewat migration. Beberapa yang paling penting:

- `create_roles_table.php` untuk role.
- `create_users_table.php` untuk akun.
- `create_profiles_table.php` untuk identitas tambahan user.
- `create_kegiatan_kerjasamas_table.php` untuk data inti kerja sama.
- `add_status_to_kegiatan_kerjasamas_table.php` menambah status workflow.
- `refactor_kegiatan_to_many_to_many.php` mengubah relasi jenis, jurusan, dan unit dari model lama menjadi many-to-many lewat pivot table.
- `create_notifikasis_table.php` dan `add_details_to_notifikasis_table.php` untuk sistem notifikasi. Ini menunjukkan project sempat berkembang dari skema yang lebih sederhana ke skema yang lebih fleksibel.

## Bagaimana Halaman Disusun

Tampilan per role memakai pola "halaman pembungkus + isi dinamis":

- `resources/views/auth/unit.blade.php`
- `resources/views/auth/jurusan.blade.php`
- `resources/views/auth/pimpinan.blade.php`
- `resources/views/admin/dashboard.blade.php`

File pembungkus ini berisi navbar, sidebar, notifikasi, logout, dan asset umum. Lalu berdasarkan route aktif, file tersebut meng-include partial seperti:
- dashboard
- dkerjasama
- create_kerjasama
- detail_kerjasama
- form_evaluasi
- laporan

Jadi satu layout bisa memuat banyak isi tanpa harus membuat shell halaman baru untuk setiap menu.

## Bagaimana Frontend Bekerja

Frontend project ini bukan SPA penuh. Mayoritas halaman tetap dirender dari server, lalu dipercantik oleh JavaScript.

File yang paling penting adalah `public/js/auth/user.js`. Di situ ada:
- dark mode
- buka/tutup sidebar
- pencarian global tabel
- pagination tabel
- chart dashboard
- modal confirm hapus/logout
- datepicker
- bintang penilaian evaluasi
- sistem notifikasi yang memanggil endpoint `/api/notifikasi`

Untuk admin, interaksi UI ada di `public/js/admin/dashboard.js`.

Jadi frontend di project ini sifatnya enhancement: backend tetap yang utama, JavaScript menambahkan kenyamanan penggunaan.

## Alur Bisnis Antar Role

Secara operasional, sistem bergerak seperti ini:

1. **admin** menyiapkan akun user, role, jurusan, unit pelaksana, mitra, dan jenis kerja sama.
2. **jurusan** atau **unit kerja** membuat data kegiatan kerja sama. Data inti kegiatan lalu dilengkapi dengan tujuan, pelaksanaan, hasil, dokumentasi, dan permasalahan/solusi.
3. Ketika dikirim, sistem mengubah status kegiatan dan membuat notifikasi ke **pimpinan**.
4. **unit kerja** punya tambahan menu evaluasi internal untuk mengisi skor.
5. **pimpinan** melihat antrean, membuka detail, lalu menyimpan evaluasi dan kesimpulan akhir.
6. Setelah itu status kegiatan berubah menjadi selesai atau revisi, dan pengusul menerima notifikasi.
7. Data yang sudah terkumpul bisa disaring dan diexport menjadi PDF/Excel.

## Laporan dan Export

Modul laporan bekerja dengan pola yang sama:

1. Controller membangun query berdasarkan filter.
2. Relasi yang dibutuhkan di-load.
3. Jika user klik preview, data dikirim sebagai JSON atau langsung dirender di tabel.
4. Jika user klik PDF, controller memanggil DomPDF.
5. Jika user klik Excel, controller memanggil export class seperti `LaporanKerjasamaExport.php` atau `GlobalLaporanExport.php`.

Dengan kata lain, modul laporan adalah lapisan baca dari data yang sebelumnya sudah disusun oleh modul kerja sama dan evaluasi.

## Ringkasan Sederhana

Kalau diringkas dengan bahasa paling mudah:

- `database/migrations` membangun "gudang arsip".
- `models` adalah peta untuk membaca arsip itu.
- `controllers` adalah petugas yang memproses permintaan user.
- `routes` menentukan pintu masuk ke petugas yang benar.
- `middleware` menjaga siapa yang boleh masuk ke ruangan mana.
- `views` menampilkan hasil ke layar.
- `public/js` membuat pengalaman pakai web jadi lebih hidup.
- `exports` mengubah data menjadi laporan siap unduh.
