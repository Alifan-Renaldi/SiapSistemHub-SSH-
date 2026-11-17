# Planning Fitur Jobdesc KPI — SiapSystemHub

> Dokumen perencanaan implementasi sistem KPI pada modul Jobdesc Management.
> Status: **Disetujui — Dalam Implementasi** (revisi 1: bobot hanya ditampilkan di `kpi_nilai_view`; revisi 2: indikator fleksibel 5–12 diisi berurutan dari Indikator 1, edit di `kpi_management` dapat mengubah nilai sekaligus bobot)
> Tanggal planning: 02 November 2026

---

## 1. Ringkasan Konsep

Sistem KPI dengan 2 halaman utama:

| Halaman | Isi |
|---|---|
| `kpi_management.php` | Data KPI **lengkap** (sudah memiliki nilai indikator, nilai konversi, total KPI, dan status) |
| `kpi_nilai_management.php` | Data KPI yang **belum ada nilai indikator** (list hanya menampilkan detail indikator; bobot dilihat di halaman `kpi_nilai_view`) |

### Alur End-to-End

```
[1] kpi_management.php (Data KPI Lengkap — sudah ada nilai)
     └─ tombol "Tambah Indikator" ──► [2] kpi_add_indikator.php
          isi: divisi, karyawan, detail indikator 1–12, bobot 1–12 (skala 1–100)
          │  (bobot disimpan sebagai nilai/100 → 80 menjadi 0.80)
          ▼ submit
[3] kpi_nilai_management.php (Data KPI yang BELUM ada nilai)
     └─ tombol "Tambah Nilai" ──► [4] kpi_add_nilai.php
          detail indikator + bobot terisi otomatis (bobot tampil sebagai %, mis. 80%)
          user isi nilai per indikator (skala 1–100)
          │  (konversi = nilai × bobot → 90 × 0.8 = 72)
          ▼ submit
[5] redirect ke kpi_management.php
     menampilkan nilai konversi 1–12, total KPI (Σ konversi), dan status
```

---

## 2. Keputusan Desain (Sudah Dikunci)

| Keputusan | Nilai Final |
|---|---|
| Sumber divisi & karyawan | Input manual (free text) di form — tidak ada tabel master |
| Nama tabel database | `jobdesc_kpi` |
| Jumlah indikator | **Dinamis 5–12** — diisi berurutan mulai dari Indikator 1 tanpa melompat; baris yang tidak dipakai dikosongkan (revisi 2) |
| Total bobot | Wajib tepat 100 (divalidasi client + server) |
| Skala bobot input | 1–100, disimpan sebagai `input / 100` (80 → 0.80) |
| Skala nilai input | 1–100 |
| Rumus konversi | `nilai × bobot` (contoh: 90 × 0.8 = 72) |
| Total KPI | Σ 12 nilai konversi |
| Status KPI | ≥90 Sangat Baik, 80–89.99 Baik, 70–79.99 Cukup, 60–69.99 Kurang, <60 Sangat Kurang |
| Permission | Ya, kolom `lr_kpi_*` baru di tabel `login_roles` |
| Dokumen rencana | `jobdesc_kpi.md` di root project (konvensi `project.md` / `implementation.md`) |

---

## 3. Kondisi Existing (Temuan Saat Eksplorasi)

| Item | Status Saat Ini |
|---|---|
| Route `jobdesc/kpi_management` | Sudah ada → `Jobdescs::kpi_list` (app/Config/Routes.php:171) |
| Controller `Jobdescs.php` | Hanya stub `kpi_list()` yang me-return view tanpa data |
| `app/Views/jobdesc/` | 7 file sudah dibuat: `kpi_management.php` (isi = copy-an halaman BAP, placeholder), `kpi_nilai_management.php`, `kpi_add_indikator.php`, `kpi_add_nilai.php`, `kpi_view.php`, `kpi_nilai_view.php`, `kpi_report.php` — 6 file sisanya kosong 0 bytes |
| Sidebar | Menu "KPI Jobdesc" sudah ada di grup Jobdesc Management (app/Views/layout/sidebar.php:228), tetapi kondisi active-state-nya masih salah (mengecek segment `incentive`, bukan `jobdesc`) dan permission-nya dikomentari |
| Model / Tabel DB | Belum ada tabel, model, maupun migrasi KPI |
| Master divisi / karyawan | Belum ada di seluruh codebase |
| Konvensi project | Prefix kolom per tabel (`d_`, `b_`, `u_`, `lr_`), migration via `$this->forge`, view pakai `layout/header` + `layout/sidebar` + `layout/footer`, DataTables, SweetAlert untuk confirm delete, `userpermission('lr_*')` untuk gate aksi, flashdata untuk notifikasi, form memakai `csrf_field()` |
| Permission loading | `LoginModel::getUserRoles()` memindai semua kolom `lr_*` bernilai 1 secara dinamis (app/Models/LoginModel.php:33-37) — kolom permission baru otomatis masuk session tanpa perubahan kode login |

---

## 4. File yang Akan Dibuat / Diubah

### A. Dibuat baru

1. `jobdesc_kpi.md` — dokumen rencana fitur (file ini)
2. `app/Database/Migrations/2025-11-02-100000_CreateTableJobdescKpi.php`
3. `app/Database/Migrations/2025-11-02-100001_AddKpiPermissionsToLoginRoles.php`
4. `app/Database/Migrations/2025-11-03-100000_AlterTableJobdescKpiNullableIndikator.php` — `jk_indikator_*` & `jk_bobot_*` menjadi NULL-able (revisi 2)
5. `app/Models/KpiModel.php`

### B. Diubah / Diisi

1. `app/Controllers/Jobdescs.php` — di-expand dari stub 1 method menjadi 11 method
2. `app/Views/jobdesc/kpi_management.php` — rewrite dari placeholder BAP
3. `app/Views/jobdesc/kpi_nilai_management.php` — diisi (saat ini kosong)
4. `app/Views/jobdesc/kpi_add_indikator.php` — diisi (saat ini kosong)
5. `app/Views/jobdesc/kpi_add_nilai.php` — diisi (saat ini kosong)
6. `app/Views/jobdesc/kpi_view.php` — diisi (saat ini kosong)
7. `app/Views/jobdesc/kpi_nilai_view.php` — diisi (saat ini kosong)
8. `app/Config/Routes.php` — tambah blok route jobdesc/KPI
9. `app/Views/layout/sidebar.php` — 2 menu + perbaikan bug active-state + aktifkan permission gate
10. `app/Views/users/user_add.php` — section checkbox permission "Jobdesc KPI"

### C. Di luar scope

- `app/Views/jobdesc/kpi_report.php` — dibiarkan kosong (tidak termasuk konsep yang dirancang)

---

## 5. Desain Database

### 5.1 Tabel `jobdesc_kpi` (prefix kolom `jk_`, InnoDB, utf8mb4_unicode_ci)

| Kolom | Tipe | Keterangan |
|---|---|---|
| `jk_id` | INT(11) UNSIGNED AUTO_INCREMENT, PK | ID indikator — dasar action edit/detail/delete |
| `jk_divisi` | VARCHAR(100) NOT NULL | Input manual |
| `jk_nama_karyawan` | VARCHAR(150) NOT NULL | Input manual |
| `jk_indikator_1` … `jk_indikator_12` | VARCHAR(255) **NULL** | Detail indikator; baris tidak terpakai disimpan NULL (minimal 5 terisi, berurutan dari 1) |
| `jk_bobot_1` … `jk_bobot_12` | DECIMAL(5,2) **NULL** | Sudah dibagi 100 (0.01–1.00); Σ bobot indikator terisi wajib = 1.00 |
| `jk_nilai_1` … `jk_nilai_12` | DECIMAL(5,2) NULL | Nilai asli 1–100; NULL = belum dinilai |
| `jk_total_kpi` | DECIMAL(5,2) NULL | Σ nilai konversi; NULL selama belum dinilai |
| `jk_status` | VARCHAR(50) NULL | Hasil mapping rentang status |
| `jk_created_by` | VARCHAR(100) NOT NULL DEFAULT 'None' | Username dari session |
| `jk_created_date` | TIMESTAMP | Waktu dibuat |
| `jk_modified_date` | DATETIME NULL | Waktu terakhir diubah |

**Catatan desain:**

- Nilai konversi **tidak disimpan** di kolom terpisah — dihitung on-the-fly (`nilai × bobot`) di Model/view agar tidak ada redundansi data.
- Kriteria pemisah halaman: record tampil di `kpi_nilai_management` selama masih ada `jk_nilai_*` yang NULL; berpindah ke `kpi_management` setelah semua nilai terisi.
- Alternatif skema ternormalisasi (header + child 12 baris) tidak dipakai karena indikator fixed 12 dan konvensi project memakai tabel lebar.

### 5.2 Tabel `login_roles` (migration ALTER, tambah 7 kolom INT(11) default 0)

| Kolom | Mengontrol |
|---|---|
| `lr_kpi_list` | Akses halaman `kpi_management` (data lengkap) |
| `lr_kpi_pending_list` | Akses halaman `kpi_nilai_management` (belum dinilai) |
| `lr_kpi_add` | Tombol Tambah Indikator |
| `lr_kpi_add_nilai` | Tombol Tambah Nilai (`kpi_add_nilai`) |
| `lr_kpi_edit` | Tombol Edit indikator |
| `lr_kpi_view` | Tombol Detail (`kpi_view` / `kpi_nilai_view`) |
| `lr_kpi_delete` | Tombol Delete |

**Catatan:** setelah migrate, permission user existing perlu di-checklist ulang via halaman User Management (kolom baru default 0 = tidak ada akses).

---

## 6. Routes Baru (app/Config/Routes.php)

```php
//jobdesc - KPI
$routes->get('jobdesc/kpi_management', 'Jobdescs::kpi_list');                                  // sudah ada
$routes->get('jobdesc/kpi_nilai_management', 'Jobdescs::kpi_nilai_list');
$routes->match(['get','post'], 'jobdesc/add_indikator', 'Jobdescs::add_indikator');
$routes->post('jobdesc/insert_indikator', 'Jobdescs::insert_indikator');
$routes->get('jobdesc/add_nilai/(:num)', 'Jobdescs::add_nilai/$1');
$routes->post('jobdesc/insert_nilai', 'Jobdescs::insert_nilai');
$routes->get('jobdesc/edit_indikator/(:num)', 'Jobdescs::edit_indikator/$1');
$routes->post('jobdesc/update_indikator', 'Jobdescs::update_indikator');
$routes->get('jobdesc/view_kpi/(:num)', 'Jobdescs::view_kpi/$1');
$routes->get('jobdesc/view_kpi_nilai/(:num)', 'Jobdescs::view_kpi_nilai/$1');
$routes->post('jobdesc/kpi_delete/(:num)', 'Jobdescs::kpi_delete/$1');
```

---

## 7. Model — `app/Models/KpiModel.php`

| Method | Fungsi |
|---|---|
| `isLengkap($row)` | TRUE jika semua indikator terisi sudah punya nilai & min. 1 terisi (kriteria pindah halaman) |
| `hitungJumlahTerisi($row)` | Jumlah baris indikator yang terisi (5–12) |
| `getall_kpi_lengkap()` | Record lengkap (filter via `isLengkap`) untuk `kpi_management` |
| `getall_kpi_pending()` | Record belum lengkap untuk `kpi_nilai_management` |
| `get_kpi_detail($jk_id)` | 1 record lengkap berdasarkan ID |
| `hitungKonversi($nilai, $bobot)` | Mengembalikan `nilai × bobot` |
| `hitungStatus($total)` | Mapping rentang total → label status + kelas badge warna |
| `insert_indikator($data)` | Simpan divisi, karyawan, indikator + bobot terisi (bobot sudah /100); baris kosong = NULL |
| `insert_nilai($jk_id, $nilai)` | Simpan nilai hanya untuk indikator terisi; total = Σ konversi indikator terisi; set status |
| `update_indikator($jk_id, $data)` | Update indikator/bobot (+nilai jika record lengkap); baris yang dikosongkan → indikator, bobot, dan nilai di-NULL-kan; hitung ulang total/status dari indikator terisi |
| `kpi_delete($jk_id)` | Hapus record berdasarkan ID |

---

## 8. Controller — `app/Controllers/Jobdescs.php` (11 method)

| Method | Logika Kunci |
|---|---|
| `kpi_list()` | Load `getall_kpi_lengkap()` → view `jobdesc/kpi_management` |
| `kpi_nilai_list()` | Load `getall_kpi_pending()` → view `jobdesc/kpi_nilai_management` |
| `add_indikator()` | Render form kosong (mode add) |
| `insert_indikator()` | Validasi (indikator berurutan dari 1 tanpa melompat, min. 5 maks. 12, pasangan detail+bobot lengkap, bobot 1–100, **Σ bobot terisi = 100**) → bobot dibagi 100 sebelum simpan, baris kosong = NULL → redirect `kpi_nilai_management` + flashdata sukses |
| `add_nilai($jk_id)` | Ambil detail record, kirim ke view dengan bobot diformat persen (0.8 → "80%") |
| `insert_nilai()` | Validasi nilai 1–100 **hanya untuk indikator terisi** → hitung konversi per indikator terisi → total = Σ konversi → set status → redirect `kpi_management` + flashdata |
| `edit_indikator($jk_id)` | GET: render `kpi_add_indikator` mode edit (data terisi, bobot tampil 1–100 lagi) |
| `update_indikator()` | POST: validasi indikator/bobot (Σ = 100) + **nilai indikator (1–100, jika record sudah bernilai)** → update & hitung ulang konversi/total/status dengan nilai & bobot terbaru → **redirect `kpi_management`** untuk data lengkap, `kpi_nilai_management` untuk data pending |
| `view_kpi($jk_id)` | Detail record lengkap → `kpi_view.php` |
| `view_kpi_nilai($jk_id)` | Detail record belum dinilai → `kpi_nilai_view.php` |
| `kpi_delete($jk_id)` | Hapus + flashdata, redirect kembali |

---

## 9. Spesifikasi View

Semua view mengikuti pola existing: `layout/header` + `layout/sidebar` + `layout/footer`, DataTables (pageLength 15, custom filter), SweetAlert untuk confirm delete, flashdata success/error, `csrf_field()` pada semua form.

### 9.1 `kpi_management.php` (rewrite dari placeholder BAP)

- Header card: judul "KPI Management" + breadcrumb + tombol **"Tambah Indikator"** → `jobdesc/add_indikator` + shortcut ke "KPI Nilai (Pending)"
- Tabel: `No | Nama Divisi | Nama Karyawan | Nilai Indikator 1–12 (konversi) | Total Nilai KPI | Status | Action`
- Kolom nilai menampilkan **hasil konversi** (nilai × bobot), bukan nilai mentah
- Total Nilai KPI tampil dengan badge berwarna sesuai status
- Action per baris berdasarkan `jk_id`: **Edit** (`edit_indikator`), **Detail** (`view_kpi`, icon eye), **Delete** (form POST + SweetAlert confirm)
- Tombol-tombol di-gate `userpermission('lr_kpi_*')`

### 9.2 `kpi_nilai_management.php`

- Judul "KPI Nilai Management (Belum Dinilai)" + tombol "Tambah Indikator"
- Tabel: `No | Nama Divisi | Nama Karyawan | Detail Indikator 1–12 | Action` — **bobot TIDAK ditampilkan di halaman ini** (revisi); bobot ditampilkan di halaman detail `kpi_nilai_view.php`
- Action: **Tambah Nilai** (tombol utama → `add_nilai/{id}`), Edit indikator, Detail (`view_kpi_nilai`), Delete

### 9.3 `kpi_add_indikator.php` (dipakai mode ADD dan EDIT)

- Form: `Nama Divisi` (text, wajib), `Nama Karyawan` (text, wajib), 12 baris input: `Detail Indikator n` (text) + `Bobot Nilai Indikator n` (number min 1 max 100) — **tidak wajib semua**; diisi berurutan dari Indikator 1, minimal 5 dan maksimal 12 baris; baris tidak terpakai dibiarkan kosong (revisi 2)
- **Badge "N Indikator"** (merah jika < 5) + **counter JS real-time "Total Bobot: X/100"** yang hanya menghitung baris terisi — tombol submit ter-disable sampai N 5–12, tanpa lubang, pasangan lengkap, dan Σ = 100
- Peringatan JS real-time: baris melompat, pasangan tidak lengkap, bobot di luar 1–100, nilai di luar 1–100 (mode edit dengan nilai)
- Preview real-time hasil bagi 100 di samping tiap input bobot (80 → 0.8)
- Mode edit data pending (dari `kpi_nilai_management`): field terisi, bobot dikali 100 kembali (0.8 → 80), hidden `jk_id`
- **Mode edit data lengkap (dari `kpi_management`): kolom `Nilai Indikator n` tampil di samping bobot untuk baris terisi** (muncul/disembunyikan otomatis saat baris diaktifkan/dikosongkan) — disertai preview `Konversi` per baris dan `Preview Total KPI` real-time di header; setelah submit otomatis redirect ke `kpi_management`

### 9.4 `kpi_add_nilai.php`

- Header info readonly: Divisi, Nama Karyawan
- **Hanya merender baris indikator yang terisi** (1..N) — baris kosong tidak ditampilkan (revisi 2); header menampilkan jumlah indikator terisi
- Tiap baris: `Detail Indikator n` (readonly, terisi) | `Bobot (%)` (readonly, terisi, format persen: 80%) | `Input Nilai` (number min 1 max 100, wajib) | preview hasil konversi real-time (JS: `nilai × bobot/100`)
- Footer form: preview Total KPI real-time sebelum submit
- Submit → `insert_nilai` → redirect `kpi_management`

### 9.5 `kpi_view.php` (Detail KPI lengkap)

- Bagian atas: card info **Nama Divisi** dan **Nama Karyawan**
- **Tabel Detail Indikator**: baris Indikator 1–12 → kolom `Detail Indikator` + `Bobot Nilai Indikator (%)`
- **Tabel Nilai Detail Indikator**: baris Indikator 1–12 → kolom `Nilai Indikator (input)` + `Nilai Konversi`
- Bagian bawah: **Total Nilai KPI** + **Status** (badge berwarna)
- Tombol kembali

### 9.6 `kpi_nilai_view.php`

- Versi pending: card info **Nama Divisi** dan **Nama Karyawan** di bagian atas
- **Tabel Detail Indikator**: baris Indikator 1–12 → kolom `Detail Indikator` + `Bobot Nilai Indikator (%)` — halaman inilah tempat bobot ditampilkan untuk data yang belum dinilai (menggantikan tampilan bobot di list)
- Tombol "Isi Nilai Sekarang" → `add_nilai/{id}` + tombol kembali

---

## 10. Perubahan Sidebar & User Management

### 10.1 `app/Views/layout/sidebar.php`

- Grup Jobdesc Management berisi 2 menu: "KPI Management" → `jobdesc/kpi_management` (gate `lr_kpi_list`) dan "KPI Nilai (Pending)" → `jobdesc/kpi_nilai_management` (gate `lr_kpi_pending_list`)
- **Perbaikan bug**: kondisi active-state saat ini mengecek `$firstSegment === 'incentive'` — diganti `'jobdesc'` beserta daftar segment yang sesuai

### 10.2 `app/Views/users/user_add.php`

- Tambah section checkbox "Jobdesc KPI" berisi 7 permission `lr_kpi_*` mengikuti pola existing (hidden input value=0 + checkbox value=1, dipakai untuk form add & edit user)

---

## 11. Validasi & Aturan Bisnis

| Aturan | Sumber |
|---|---|
| Divisi & nama karyawan wajib | Konsep poin 2 |
| Indikator diisi berurutan dari Indikator 1 tanpa melompat (tidak boleh ada "lubang") | Revisi 2 |
| Minimal 5 dan maksimal 12 indikator terisi | Revisi 2 |
| Baris terisi harus pasangan lengkap: detail indikator + bobot | Revisi 2 |
| Bobot per indikator terisi: 1–100 | Konsep poin 2 |
| Σ bobot indikator terisi wajib tepat 100 | Konfirmasi |
| Penyimpanan bobot = input / 100 | Konsep poin 2 |
| Tampilan bobot di add_nilai = (nilai simpan × 100)% | Konsep poin 3 |
| Nilai indikator input: 1–100, hanya untuk indikator terisi | Konfirmasi + revisi 2 |
| Konversi = nilai × bobot desimal | Konsep poin 5 |
| Total KPI = Σ nilai konversi indikator terisi | Konsep poin 8 + revisi 2 |
| Record pindah halaman "nilai" → "lengkap" setelah semua nilai indikator terisi diinputkan | Konsep poin 1 & 4 |
| Status: ≥90 Sangat Baik, 80–89.99 Baik, 70–79.99 Cukup, 60–69.99 Kurang, <60 Sangat Kurang | Konfirmasi |
| Edit indikator pada data bernilai → total & status dihitung ulang | Konsistensi data |
| Edit data lengkap dari `kpi_management`: nilai indikator ikut ditampilkan & dapat diganti di samping bobot; setelah submit redirect ke `kpi_management` | Revisi tambahan |

---

## 12. Urutan Eksekusi

1. Tulis `jobdesc_kpi.md` (dokumen ini) ✅
2. Migration tabel `jobdesc_kpi` → `php spark migrate`
3. Migration permission `login_roles` → migrate
4. `KpiModel.php`
5. Controller `Jobdescs` + Routes
6. Views (urutan: `kpi_add_indikator` → `kpi_nilai_management` → `kpi_add_nilai` → `kpi_management` → `kpi_view` → `kpi_nilai_view`)
7. Sidebar + checkbox permission di `user_add.php`
8. Verifikasi akhir

---

## 13. Checklist Verifikasi

- [ ] `php spark migrate` sukses untuk kedua migration
- [ ] Isi 12 indikator + bobot total 100 → tersimpan sebagai 0.xx; redirect ke `kpi_nilai_management`
- [ ] Bobot 80 tampil "80%" di `kpi_add_nilai`
- [ ] Nilai 90 + bobot 80% → konversi 72 tampil di `kpi_management`
- [ ] Total KPI = Σ 12 konversi; status sesuai rentang
- [ ] Validasi: Σ bobot ≠ 100 ditolak; nilai di luar 1–100 ditolak; indikator kosong ditolak
- [ ] Edit indikator pada data bernilai → total & status terhitung ulang
- [ ] Delete dengan SweetAlert confirm; record hilang dari kedua halaman
- [ ] Permission gate bekerja (user tanpa `lr_kpi_*` tidak melihat menu/tombol)
- [ ] `composer test` (phpunit) tetap hijau
