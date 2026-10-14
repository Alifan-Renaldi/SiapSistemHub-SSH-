# DOKUMENTASI TEKNIS SIAP SISTEM HUB (SSH)

**Versi Dokumentasi:** 1.0  
**Tanggal Update:** 10 Oktober 2026  
**Framework:** CodeIgniter 4.6.1  
**PHP Version:** ^8.1

---

## DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
2. [Arsitektur Sistem](#2-arsitektur-sistem)
3. [Flow Sistem](#3-flow-sistem)
4. [Struktur Database](#4-struktur-database)
5. [Modul & Fitur](#5-modul--fitur)
6. [Controllers](#6-controllers)
7. [Models](#7-models)
8. [Views](#8-views)
9. [Helpers](#9-helpers)
10. [Filters](#10-filters)
11. [Routing](#11-routing)
12. [Library & Package](#12-library--package)
13. [Keamanan](#13-keamanan)
14. [Error Handling](#14-error-handling)
15. [Panduan Pengembangan](#15-panduan-pengembangan)

---

## 1. PENDAHULUAN

### 1.1 Deskripsi Sistem

**SiapSistemHub (SSH)** adalah aplikasi web berbasis CodeIgniter 4 yang dirancang untuk mengelola operasional armada perusahaan trucking/logistik. Sistem ini mengintegrasikan berbagai modul mulai dari manajemen supir, kendaraan, dokumen kecelakaan (BAP), hingga laporan yang dapat diekspor ke Excel/PDF.

### 1.2 Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| **Backend Framework** | CodeIgniter 4.6.1 |
| **Bahasa Pemrograman** | PHP 8.1+ |
| **Database** | MySQL / MariaDB |
| **Frontend Framework** | AdminLTE 3 (Bootstrap 4) |
| **JavaScript Library** | jQuery, Select2, SweetAlert2, Chart.js |
| **PDF Generator** | Dompdf |
| **Excel Generator** | PhpSpreadsheet |
| **QR Code** | endroid/qr-code |
| **Build Tools** | Vite, Tailwind CSS 4 |

### 1.3 Tujuan Dokumentasi

Dokumentasi ini dibuat untuk:
- Memudahkan developer baru memahami arsitektur sistem
- Menyediakan referensi teknis untuk maintenance dan pengembangan
- Mendokumentasikan seluruh method, function, dan logic sistem
- Memberikan panduan troubleshooting dan error handling

---

## 2. ARSITEKTUR SISTEM

### 2.1 Pola Arsitektur

Sistem menggunakan pola **MVC (Model-View-Controller)** dengan tambahan **Helper** dan **Filter** layer:

```
┌─────────────────────────────────────────────────────────────┐
│                         REQUEST                              │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                     FILTER LAYER                             │
│  - LoginFilter (autentikasi & session timeout)              │
│  - SecurityChecklist (security validation)                  │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                   ROUTING (Routes.php)                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                     CONTROLLER                               │
│  - Business Logic                                            │
│  - Request Handling                                          │
│  - Response Generation                                       │
└─────────────────────────────────────────────────────────────┘
                              │
                    ┌─────────┴─────────┐
                    ▼                   ▼
        ┌──────────────────┐   ┌──────────────────┐
        │      MODEL       │   │      VIEW        │
        │  - Data Access   │   │  - Presentation  │
        │  - Query Builder │   │  - HTML Template │
        └──────────────────┘   └──────────────────┘
                    │
                    ▼
        ┌──────────────────────────────┐
        │       DATABASE               │
        └──────────────────────────────┘
```

### 2.2 Struktur Direktori

```
SiapSystemHubCIDevelopment/
├── app/
│   ├── Config/              # Konfigurasi sistem
│   │   ├── Routes.php       # Definisi routing
│   │   ├── Filters.php      # Konfigurasi filter
│   │   ├── Database.php     # Konfigurasi database
│   │   ├── App.php          # Konfigurasi aplikasi
│   │   ├── Session.php      # Konfigurasi session
│   │   └── Pdf.php          # Konfigurasi PDF
│   │
│   ├── Controllers/         # Controller logic
│   │   ├── Login.php        # Autentikasi
│   │   ├── Dashboard.php    # Halaman dashboard
│   │   ├── Drivers.php      # Modul supir
│   │   ├── Vehicle.php      # Modul kendaraan
│   │   ├── Reports.php      # Modul laporan
│   │   ├── Users.php        # Manajemen user
│   │   ├── Settings.php     # Pengaturan website
│   │   └── Workshops.php    # Insentif mekanik
│   │
│   ├── Models/              # Data access layer
│   │   ├── LoginModel.php
│   │   ├── DriversModel.php
│   │   ├── VehicleModel.php
│   │   ├── DashboardModel.php
│   │   ├── ReportModel.php
│   │   └── UserModel.php
│   │
│   ├── Views/               # Template HTML
│   │   ├── layout/          # Layout template
│   │   ├── drivers/         # Views modul supir
│   │   ├── vehicles/        # Views modul kendaraan
│   │   ├── baps/            # Views modul BAP
│   │   ├── loans/           # Views modul pinjaman
│   │   ├── inventory/       # Views modul inventaris
│   │   ├── handover/        # Views modul serah terima
│   │   ├── reports/         # Views modul laporan
│   │   └── settings/        # Views pengaturan
│   │
│   ├── Helpers/             # Helper functions
│   │   ├── custom_helper.php      # Helper utama
│   │   ├── custom_tanggal.php     # Helper tanggal
│   │   └── pdf_helper.php         # Helper PDF
│   │
│   ├── Filters/             # Filter middleware
│   │   ├── LoginFilter.php         # Filter autentikasi
│   │   └── SecurityChecklist.php   # Filter keamanan
│   │
│   └── Database/
│       └── Migrations/      # Database migrations
│
├── public/
│   └── assets/              # Static files (CSS, JS, images)
│
├── writable/                # Writable directory
│   ├── uploads/             # File uploads
│   ├── cache/               # Cache files
│   ├── logs/                # Application logs
│   └── session/             # Session files
│
└── vendor/                  # Composer dependencies
```

---

## 3. FLOW SISTEM

### 3.1 Flow Autentikasi

```
User → Login Page
    │
    ├─ Input Username & Password
    │
    ▼
POST /login/auth
    │
    ├─ LoginModel::checkLogin()
    │   ├─ Verify username exists
    │   └─ Verify password hash (password_verify)
    │
    ├─ Jika berhasil:
    │   ├─ LoginModel::getUserRoles()
    │   ├─ Set session data:
    │   │   - user_id
    │   │   - username
    │   │   - name
    │   │   - permissions (array)
    │   │   - logged_in = true
    │   │   - last_activity = timestamp
    │   └─ Redirect → /dashboard
    │
    └─ Jika gagal:
        └─ Redirect → /login (dengan error message)
```

### 3.2 Flow Request dengan Filter

```
Request masuk
    │
    ▼
LoginFilter::before()
    │
    ├─ Cek session 'logged_in'
    │   └─ Jika false → Redirect ke /login
    │
    ├─ Cek session timeout
    │   ├─ Jika (current_time - last_activity) > timeout
    │   │   └─ Destroy session → Redirect ke /login
    │   └─ Update last_activity
    │
    ▼
Controller Method
    │
    ▼
Model Processing
    │
    ▼
View Rendering
    │
    ▼
Response ke User
```

### 3.3 Flow CRUD Driver

```
Halaman Drivers Management
    │
    ├─ Drivers::index()
    │   ├─ DriversModel::getall_drivers()
    │   ├─ Filter driver aktif (d_is_active = '1' atau '3')
    │   └─ Load view: drivers/drivers_management.php
    │
    ├─ Tambah Driver:
    │   ├─ GET /drivers/adddrivers → Form
    │   ├─ POST /drivers/insertdriver
    │   │   ├─ Validasi input
    │   │   ├─ Generate NIS (DriversModel::get_last_nis)
    │   │   ├─ Handle file upload (foto, PDF)
    │   │   └─ Insert ke database
    │   └─ Redirect dengan flash message
    │
    ├─ Edit Driver:
    │   ├─ GET /drivers/editdriver → Form dengan data existing
    │   ├─ POST /drivers/updatedriver
    │   │   └─ Update database
    │   └─ Redirect dengan flash message
    │
    └─ Delete Driver:
        └─ POST /drivers/drivers_delete/$id
            └─ DriversModel::drivers_delete($id)
```

### 3.4 Flow Generate QR Code Kendaraan

```
Input data kendaraan
    │
    ▼
Vehicle::insertvehicle()
    │
    ├─ Insert data ke database
    │
    ├─ Generate QR Code:
    │   ├─ Builder::create()
    │   │   - Data: JSON {Nopol, Pemilik, Type, Jenis, Tahun, Riwayat Waktu}
    │   │   - Encoding: UTF-8
    │   │   - ErrorCorrectionLevel: Quartile
    │   │   - Size: 300px
    │   │   - Margin: 10px
    │   │
    │   ├─ Save to: writable/uploads/qrcodes/vehicles/
    │   └─ Update database: v_qr_code_path, v_qr_code_filename
    │
    └─ Redirect ke list kendaraan
```

### 3.5 Flow Export Laporan

```
User pilih filter laporan
    │
    ▼
POST /reports/driver (contoh)
    │
    ├─ Ambil parameter filter:
    │   - driver_from, driver_to (tanggal)
    │   - driver_name
    │   - age_from, age_to
    │   - bpjs_status
    │   - work_period_from, work_period_to
    │
    ├─ ReportModel::driver_reports()
    │   └─ Query dengan filter
    │
    └─ Load view: reports/report_driver.php

Export Excel:
    │
    ▼
/reports/export_driver_excel
    │
    ├─ PhpSpreadsheet::create()
    ├─ Set header row
    ├─ Fill data rows
    ├─ Apply styling
    └─ Download file .xlsx

Export PDF:
    │
    ▼
/reports/export_driver_pdf
    │
    ├─ streamPdf() atau renderPdf()
    │   ├─ Load view khusus PDF
    │   ├─ Dompdf::render()
    │   └─ Stream/download file
    └─ Return Response object
```

---

## 4. STRUKTUR DATABASE

### 4.1 Entity Relationship Diagram (Sederhana)

```
┌──────────────┐         ┌──────────────┐
│    users     │         │  login_roles │
│──────────────│         │──────────────│
│ u_id (PK)    │◄────────┤ lr_u_id (FK) │
│ u_username   │         │ lr_driver_*  │
│ u_password   │         │ lr_vehicle_* │
│ u_name       │         │ ... (108     │
└──────────────┘         │   flags)     │
                         └──────────────┘

┌──────────────┐         ┌──────────────┐
│   drivers    │         │     baps     │
│──────────────│         │──────────────│
│ d_id (PK)    │◄────────┤ b_nis (FK)   │
│ d_nis        │         │ b_id (PK)    │
│ d_name       │         │ b_tanggal    │
│ d_address    │         │ b_lokasi_*   │
│ d_province   │         │ b_kronologi  │
│ d_city       │         └──────────────┘
│ ...          │
└──────────────┘         ┌──────────────┐
                         │   surveys    │
┌──────────────┐         │──────────────│
│   loans      │         │ s_id (PK)    │
│──────────────│         │ s_nis (FK)   │◄── drivers
│ l_id (PK)    │         │ s_tanggal    │
│ l_nis (FK)   │◄──      │ s_lokasi     │
│ l_amount     │         └──────────────┘
│ l_status     │
└──────────────┘         ┌──────────────┐
                         │  trainings   │
┌──────────────┐         │──────────────│
│   vehicles   │         │ tr_id (PK)   │
│──────────────│         │ tr_nis (FK)  │◄── drivers
│ v_id (PK)    │         │ tr_tema      │
│ v_reg_no     │         │ tr_tanggal   │
│ v_type       │         └──────────────┘
│ v_qr_code    │
└──────────────┘         ┌──────────────┐
        │                │  inventory   │
        │                │──────────────│
        └───────────────►│ iv_id (PK)   │
                         │ iv_nopol(FK) │◄── vehicles
                         │ iv_item      │
                         └──────────────┘

┌──────────────┐         ┌──────────────┐
│   handover   │         │handover_hist │
│──────────────│         │──────────────│
│ ho_id (PK)   │         │ hh_id (PK)   │
│ ho_nopol(FK) │◄───────►│ ho_id (FK)   │
│ ho_supir_*   │         │ hh_*         │
└──────────────┘         └──────────────┘
```

### 4.2 Tabel Utama

#### 4.2.1 Tabel `users`

Menyimpan data pengguna sistem.

| Field | Type | Description |
|-------|------|-------------|
| u_id | INT(11) AUTO_INCREMENT | Primary Key |
| u_username | VARCHAR(50) | Username untuk login |
| u_password | VARCHAR(255) | Password ter-hash (bcrypt) |
| u_name | VARCHAR(100) | Nama lengkap user |
| u_email | VARCHAR(100) | Email user |
| u_role | VARCHAR(50) | Role user (admin, user, dll) |
| u_created_at | TIMESTAMP | Waktu pembuatan |
| u_modified_at | TIMESTAMP | Waktu update terakhir |

#### 4.2.2 Tabel `login_roles`

Menyimpan permission user per modul (108 flag akses).

| Field | Type | Description |
|-------|------|-------------|
| lr_id | INT(11) | Primary Key |
| lr_u_id | INT(11) | Foreign Key → users.u_id |
| lr_driver_view | TINYINT(1) | Permission view driver |
| lr_driver_add | TINYINT(1) | Permission add driver |
| lr_driver_edit | TINYINT(1) | Permission edit driver |
| lr_driver_delete | TINYINT(1) | Permission delete driver |
| lr_vehicle_* | TINYINT(1) | Permission modul vehicle |
| lr_bap_* | TINYINT(1) | Permission modul BAP |
| ... | ... | (total 108 permission flags) |

**Contoh Permission Flags:**
```php
// Permissions yang tersedia
$permissions = [
    'lr_driver_view',
    'lr_driver_add', 
    'lr_driver_edit',
    'lr_driver_delete',
    'lr_vehicle_view',
    'lr_vehicle_add',
    'lr_vehicle_edit',
    'lr_vehicle_delete',
    'lr_bap_view',
    'lr_bap_add',
    'lr_bap_edit',
    'lr_bap_delete',
    'lr_loan_view',
    'lr_loan_approve',
    // ... dan seterusnya
];
```

#### 4.2.3 Tabel `drivers`

Menyimpan data supir aktif dan tidak aktif.

| Field | Type | Description |
|-------|------|-------------|
| d_id | INT(11) | Primary Key |
| d_nis | VARCHAR(50) | Nomor Induk Supir (unique) |
| d_name | VARCHAR(100) | Nama lengkap |
| d_nickname | VARCHAR(100) | Nama panggilan |
| d_pob | VARCHAR(100) | Tempat lahir |
| d_dob | DATE | Tanggal lahir |
| d_age | INT(11) | Usia (auto-calculated) |
| d_married | VARCHAR(50) | Status pernikahan |
| d_education | VARCHAR(50) | Pendidikan terakhir |
| d_mobile | VARCHAR(20) | Nomor HP |
| d_address | VARCHAR(250) | Alamat lengkap |
| d_province | VARCHAR(100) | ID Provinsi (dari API wilayah) |
| d_city | VARCHAR(100) | ID Kabupaten/Kota |
| d_subdistrict | VARCHAR(100) | ID Kecamatan |
| d_village | VARCHAR(100) | ID Kelurahan/Desa |
| d_identityno | VARCHAR(20) | Nomor KTP |
| d_identity_expdate | DATE | Tanggal expired KTP |
| d_licenseno | VARCHAR(50) | Nomor SIM |
| d_license_expdate | DATE | Tanggal expired SIM |
| d_cardbpjs | VARCHAR(50) | Nomor BPJS |
| d_accountno | VARCHAR(50) | Nomor rekening |
| d_bank | VARCHAR(50) | Nama bank |
| d_accountname | VARCHAR(100) | Nama pemilik rekening |
| d_experience | TEXT | Pengalaman kerja |
| d_total_exp | VARCHAR(50) | Total pengalaman (tahun) |
| d_doj | DATE | Tanggal gabung |
| d_resigndate | DATE | Tanggal resign |
| d_is_active | ENUM('0','1','2','3') | Status: 0=aktif, 1=inactive, 2=blacklist, 3=inactive+blacklist |
| d_photo | VARCHAR(255) | Path foto supir |
| d_pdf_document | VARCHAR(255) | Path dokumen PDF |
| d_notes_blacklist | TEXT | Alasan blacklist |
| d_created_by | INT(11) | ID user yang membuat |
| d_modified_date | DATETIME | Tanggal update terakhir |

#### 4.2.4 Tabel `vehicles`

Menyimpan data kendaraan/armada.

| Field | Type | Description |
|-------|------|-------------|
| v_id | INT(11) | Primary Key |
| v_registration_no | VARCHAR(20) | Nomor polisi (nopol) |
| v_type | VARCHAR(50) | Tipe kendaraan |
| v_name | VARCHAR(100) | Nama/jenis kendaraan |
| v_group | VARCHAR(50) | Grup kendaraan |
| v_owner | VARCHAR(50) | Pemilik kendaraan |
| v_legal | VARCHAR(100) | Nama pemilik legal |
| v_reg_exp_date | YEAR | Tahun registrasi |
| v_stnk_expdate | DATE | Tanggal expired STNK |
| v_plat_expdate | DATE | Tanggal expired plat |
| v_kir_expdate | DATE | Tanggal expired KIR |
| v_kir_process_date | DATE | Tanggal proses KIR (auto: H+31 dari expired) |
| v_chassis_no | VARCHAR(100) | Nomor rangka |
| v_engine_no | VARCHAR(100) | Nomor mesin |
| v_uji_no | VARCHAR(100) | Nomor uji |
| v_lokasi_kir | VARCHAR(100) | Lokasi KIR |
| v_insurance | VARCHAR(100) | Nama asuransi |
| v_polis_no | VARCHAR(100) | Nomor polis |
| v_exp_insurance | DATE | Tanggal expired asuransi |
| v_notes | TEXT | Catatan |
| v_qr_code_path | VARCHAR(255) | Path file QR code |
| v_qr_code_filename | VARCHAR(255) | Nama file QR code |
| v_created_by | INT(11) | ID user pembuat |
| v_created_date | DATETIME | Tanggal pembuatan |
| v_is_active | TINYINT(1) | Status aktif (1=aktif) |

#### 4.2.5 Tabel `baps`

Menyimpan Berita Acara Pemeriksaan kecelakaan.

| Field | Type | Description |
|-------|------|-------------|
| b_id | INT(11) | Primary Key |
| b_code | VARCHAR(50) | Kode BAP (format: BAP/0001/I/2026) |
| b_tanggal | DATE | Tanggal pembuatan BAP |
| b_tanggal_kejadian | DATE | Tanggal kejadian |
| b_nis | VARCHAR(50) | NIS supir (FK ke drivers) |
| b_supir | VARCHAR(100) | Nama supir |
| b_nopol | VARCHAR(50) | Nomor polisi kendaraan |
| b_muatan | VARCHAR(50) | Jenis muatan |
| b_keberangkatan | VARCHAR(50) | Lokasi keberangkatan |
| b_lokasi_muat | VARCHAR(50) | Lokasi muat |
| b_lokasi_bongkar | VARCHAR(50) | Lokasi bongkar |
| b_lokasi_kejadian | VARCHAR(100) | Lokasi kejadian |
| b_jenis_kasus | VARCHAR(50) | Jenis kasus |
| b_kondisi_barang | VARCHAR(100) | Kondisi barang |
| b_kronologi_kejadian | TEXT | Kronologi kejadian |
| b_korelasi_kasus | TEXT | Korelasi kasus |
| b_estimasi_klaim | VARCHAR(100) | Estimasi klaim |
| b_solution | TEXT | Solusi/penyelesaian |
| b_status | ENUM('pending','completed') | Status BAP |
| b_photo | VARCHAR(255) | Path foto kejadian |
| b_pdf_document | VARCHAR(255) | Path dokumen PDF |
| b_created_by | INT(11) | ID user pembuat |
| b_created_at | DATETIME | Tanggal pembuatan |

#### 4.2.6 Tabel `surveys`

Menyimpan data survey lokasi/rute.

| Field | Type | Description |
|-------|------|-------------|
| s_id | INT(11) | Primary Key |
| s_code | VARCHAR(50) | Kode survey (format: SRV/0001/I/2026) |
| s_tanggal | DATE | Tanggal survey |
| s_nis | VARCHAR(50) | NIS supir (FK) |
| s_supir | VARCHAR(100) | Nama supir |
| s_nopol | VARCHAR(50) | Nomor polisi |
| s_prov | VARCHAR(100) | ID Provinsi |
| s_kab | VARCHAR(100) | ID Kabupaten |
| s_kec | VARCHAR(100) | ID Kecamatan |
| s_kel | VARCHAR(100) | ID Kelurahan |
| s_lokasi | VARCHAR(255) | Nama lokasi |
| s_keterangan | TEXT | Keterangan |
| s_photo | VARCHAR(255) | Path foto survey |
| s_pdf_document | VARCHAR(255) | Path dokumen PDF |
| s_created_by | INT(11) | ID user pembuat |

#### 4.2.7 Tabel `trainings`

Menyimpan riwayat training supir.

| Field | Type | Description |
|-------|------|-------------|
| tr_id | INT(11) | Primary Key |
| tr_code | VARCHAR(50) | Kode training |
| tr_tanggal | DATE | Tanggal training |
| tr_nis | VARCHAR(50) | NIS supir (FK) |
| tr_supir | VARCHAR(100) | Nama supir |
| tr_tema | VARCHAR(255) | Tema training |
| tr_lokasi | VARCHAR(255) | Lokasi training |
| tr_peserta | INT(11) | Jumlah peserta |
| tr_biaya | DECIMAL(15,2) | Biaya training |
| tr_keterangan | TEXT | Keterangan |
| tr_modul | VARCHAR(255) | Path file modul |
| tr_created_by | INT(11) | ID user pembuat |

#### 4.2.8 Tabel `loans`

Menyimpan data pinjaman supir.

| Field | Type | Description |
|-------|------|-------------|
| l_id | INT(11) | Primary Key |
| l_code | VARCHAR(50) | Kode pinjaman |
| l_tanggal | DATE | Tanggal pinjaman |
| l_nis | VARCHAR(50) | NIS supir (FK) |
| l_supir | VARCHAR(100) | Nama supir |
| l_amount | DECIMAL(15,2) | Jumlah pinjaman |
| l_reason | TEXT | Alasan pinjaman |
| l_due_date | DATE | Tanggal jatuh tempo |
| l_status | ENUM('pending','approved','rejected','paid') | Status pinjaman |
| l_approved_by | INT(11) | ID user yang approve |
| l_approved_at | DATETIME | Tanggal approval |
| l_notes | TEXT | Catatan |
| l_created_by | INT(11) | ID user pembuat |

#### 4.2.9 Tabel `inventory`

Menyimpan inventaris kendaraan.

| Field | Type | Description |
|-------|------|-------------|
| iv_id | INT(11) | Primary Key |
| iv_code | VARCHAR(50) | Kode inventaris |
| iv_nopol | VARCHAR(50) | Nomor polisi (FK) |
| iv_tanggal | DATE | Tanggal input |
| iv_item | VARCHAR(255) | Nama item |
| iv_qty | INT(11) | Jumlah |
| iv_condition | VARCHAR(50) | Kondisi (baik/rusak) |
| iv_photo | VARCHAR(255) | Path foto |
| iv_notes | TEXT | Catatan |
| iv_created_by | INT(11) | ID user pembuat |

#### 4.2.10 Tabel `handover`

Menyimpan serah terima aset kendaraan.

| Field | Type | Description |
|-------|------|-------------|
| ho_id | INT(11) | Primary Key |
| ho_code | VARCHAR(50) | Kode handover |
| ho_tanggal | DATE | Tanggal serah terima |
| ho_lokasi | VARCHAR(50) | Lokasi |
| ho_nopol | VARCHAR(50) | Nomor polisi |
| ho_jenis | VARCHAR(50) | Jenis serah terima |
| ho_km | VARCHAR(100) | Kilometer |
| ho_solar | VARCHAR(50) | Level solar |
| ho_supirlama | VARCHAR(50) | NIS supir lama |
| ho_supirbaru | VARCHAR(50) | NIS supir baru |
| ho_kabin | VARCHAR(50) | Kondisi kabin |
| ho_kabel | VARCHAR(50) | Kondisi kabel |
| ho_lampubesar | VARCHAR(50) | Kondisi lampu besar |
| ho_lampurem | VARCHAR(50) | Kondisi lampu rem |
| ho_seindpn | VARCHAR(50) | Kondisi sein depan |
| ho_seinblk | VARCHAR(50) | Kondisi sein belakang |
| ho_wiper | VARCHAR(50) | Kondisi wiper |
| ho_spion | VARCHAR(50) | Kondisi spion |
| ho_signature_old | TEXT | Tanda tangan digital supir lama (base64) |
| ho_signature_new | TEXT | Tanda tangan digital supir baru (base64) |
| ho_notes | TEXT | Catatan |
| ho_created_by | INT(11) | ID user pembuat |

#### 4.2.11 Tabel `settings`

Menyimpan konfigurasi website.

| Field | Type | Description |
|-------|------|-------------|
| id | INT(11) | Primary Key |
| site_name | VARCHAR(100) | Nama website |
| site_logo | VARCHAR(255) | Path logo |
| site_email | VARCHAR(100) | Email kontak |
| site_phone | VARCHAR(20) | Nomor telepon |
| site_address | TEXT | Alamat |
| smtp_host | VARCHAR(100) | Host SMTP |
| smtp_user | VARCHAR(100) | Username SMTP |
| smtp_pass | VARCHAR(100) | Password SMTP |
| smtp_port | INT(5) | Port SMTP |

---

## 5. MODUL & FITUR

### 5.1 Modul Autentikasi & User Management

#### Fitur:
- Login/Logout dengan session management
- Session timeout (default: 86400 detik / 24 jam)
- Granular permission system (108 flag akses per modul)
- Manajemen user (CRUD)

#### Logic:
```php
// Alur Autentikasi
User::login()
    → LoginModel::checkLogin($username, $password)
        → Verify username exists in database
        → Verify password using password_verify()
    → LoginModel::getUserRoles($userId)
        → Fetch all permission flags dari login_roles
        → Convert ke array of enabled permissions
    → Session::set([
        'user_id' => $userId,
        'username' => $username,
        'name' => $name,
        'permissions' => $permissionsArray,
        'logged_in' => true,
        'last_activity' => time()
    ])
```

#### Permission Check:
```php
// Helper function
function userpermission($link) {
    $permissions = session()->get('permissions');
    return is_array($permissions) && in_array($link, $permissions);
}

// Penggunaan di controller/view
if (userpermission('lr_driver_add')) {
    // Tampilkan tombol add driver
}
```

### 5.2 Modul Dashboard

#### Fitur:
- Statistik ringkasan (jumlah supir, kendaraan, dll)
- Reminder dokumen jatuh tempo (STNK, KIR, Plat)
- Grafik income vs expense (Chart.js)
- Daftar kendaraan ready
- Daftar inventaris ready

#### Method Dashboard::index():
```php
public function index() {
    $dashboardModel = new DashboardModel();
    
    $data = [
        'dashboard' => $dashboardModel->getDashboardCounts(),
        'todayreminder' => $dashboardModel->get_todayreminder(),
        'iechart' => $dashboardModel->get_iechartdata(),
        'vehicles' => $dashboardModel->get_vehicle_expdate(),
        'reminderYellow' => $dashboardModel->get_reminders_yellow(),
        'reminderRed' => $dashboardModel->get_reminders_red(),
        'vehicleReadyList' => $dashboardModel->get_vehicle_ready_list(),
        'inventoryReadyList' => $dashboardModel->get_inventory_ready_list()
    ];
    
    return view('dashboard', $data);
}
```

### 5.3 Modul Driver Management

#### Fitur:
- Daftar supir aktif
- Daftar supir inactive/blacklist
- CRUD data supir
- Upload foto dan dokumen
- Hierarki wilayah dinamis (API emsifa)
- Generate NIS otomatis

#### Method Utama Drivers Controller:

##### `Drivers::index()`
```php
public function index() {
    // Ambil semua driver
    $driverslist = $this->driversModel->getall_drivers();
    
    // Filter hanya yang aktif
    $inactive_drivers = array_filter($driverslist, function($driver) {
        return $driver['d_is_active'] == '1' || $driver['d_is_active'] == '3';
    });
    
    $data = [
        'driverslist' => $inactive_drivers,
        'loanlist_drivers' => $this->driversModel->get_loan(),
        'baplist_drivers' => $this->driversModel->getBap(),
        'provinces' => $this->driversModel->getProvinces()
    ];
    
    return view('drivers/drivers_management', $data);
}
```

##### `Drivers::insertdriver()`
```php
public function insertdriver() {
    $data = $this->request->getPost();
    
    // Generate NIS
    $last_nis = $this->driversModel->get_last_nis();
    $new_nis = $this->generateDriverCode($last_nis);
    $data['d_nis'] = $new_nis;
    
    // Set audit fields
    $data['d_created_by'] = session('user_id');
    
    // Handle file upload
    if ($photo = $this->request->getFile('d_photo')) {
        if ($photo->isValid()) {
            $photoName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/drivers/', $photoName);
            $data['d_photo'] = 'writable/uploads/drivers/' . $photoName;
        }
    }
    
    // Insert ke database
    $insert_id = $this->driversModel->add_drivers($data);
    
    if ($insert_id) {
        session()->setFlashdata('successmessage', 'Driver added successfully.');
        return redirect()->to('drivers/drivers_management');
    }
}
```

##### Generate NIS:
```php
public function generateDriverCode($last_nis) {
    // Format: D{YYYYMM}{0001}
    // Contoh: D202610001
    
    $prefix = 'D' . date('Ym');
    
    if ($last_nis && strpos($last_nis, $prefix) === 0) {
        $last_number = (int)substr($last_nis, -4);
        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $new_number = '0001';
    }
    
    return $prefix . $new_number;
}
```

### 5.4 Modul BAP (Berita Acara Pemeriksaan)

#### Fitur:
- Daftar BAP per supir
- BAP pending (belum selesai)
- CRUD BAP
- Upload foto dan dokumen
- Cetak PDF
- Generate kode BAP otomatis

#### Alur Kode BAP:
```php
// Format: BAP/0001/I/2026
public function generateBapCode($last_bcode, $created_at = null) {
    $date = $created_at ? new \DateTime($created_at) : new \DateTime();
    $year = $date->format('Y');
    $month = $date->format('n');
    
    // Konversi bulan ke romawi
    $romawi = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    ];
    $bulan_romawi = $romawi[$month];
    
    // Extract nomor terakhir
    $last_number = 0;
    if ($last_bcode) {
        $pattern = '/\/(\d+)\/[IVX]+\/\d{4}$/';
        if (preg_match($pattern, $last_bcode, $matches)) {
            $last_number = (int)$matches[1];
        }
    }
    
    $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
    
    return "BAP/{$new_number}/{$bulan_romawi}/{$year}";
}
```

### 5.5 Modul Survey

#### Fitur:
- CRUD survey lokasi
- Integrasi API wilayah Indonesia
- Upload foto survey
- Cetak PDF

#### API Wilayah:
```php
// Menggunakan API emsifa dengan caching 7 hari
private function fetchData($endpoint) {
    $cacheKey = 'wilayah_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $endpoint) . '.json';
    $cacheFile = WRITEPATH . 'cache/' . $cacheKey;
    $cacheTtl = 7 * 24 * 3600; // 7 hari
    
    // Cek cache
    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTtl) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    
    // Fetch dari API
    $url = "https://www.emsifa.com/api-wilayah-indonesia/api/" . $endpoint;
    // ... curl request dengan timeout
    
    // Simpan ke cache
    file_put_contents($cacheFile, json_encode($data));
    
    return $data;
}

// Penggunaan
public function getProvinces() {
    return $this->fetchData('provinces.json');
}

public function getRegencies($province_id) {
    return $this->fetchData("regencies/{$province_id}.json");
}

public function getDistricts($regency_id) {
    return $this->fetchData("districts/{$regency_id}.json");
}

public function getVillages($district_id) {
    return $this->fetchData("villages/{$district_id}.json");
}
```

### 5.6 Modul Training

#### Fitur:
- CRUD training
- Riwayat training per supir
- Upload modul training
- Modal detail training

#### Query Training per Tema:
```php
// Model: DriversModel.php
public function getTrainingsByTema($tema) {
    return $this->db->table('trainings')
        ->where('tr_tema', $tema)
        ->orderBy('tr_tanggal', 'DESC')
        ->get()
        ->getResultArray();
}

public function countTrainingsByTema($tema) {
    return $this->db->table('trainings')
        ->where('tr_tema', $tema)
        ->countAllResults();
}
```

### 5.7 Modul Loan (Pinjaman)

#### Fitur:
- CRUD pinjaman
- Approval workflow (pending → approved/rejected)
- Mark as paid
- Laporan pinjaman

#### Status Pinjaman:
- `pending`: Menunggu approval
- `approved`: Disetujui
- `rejected`: Ditolak
- `paid`: Lunas

#### Approval Flow:
```php
public function update_loan_status() {
    $loan_id = $this->request->getPost('loan_id');
    $status = $this->request->getPost('status'); // approved/rejected
    
    $data = [
        'l_status' => $status,
        'l_approved_by' => session('user_id'),
        'l_approved_at' => date('Y-m-d H:i:s')
    ];
    
    $this->driversModel->update_loan_status($loan_id, $data);
    
    return redirect()->to('loans/loan_approve');
}
```

### 5.8 Modul Vehicle

#### Fitur:
- CRUD kendaraan
- Grup kendaraan
- Owner kendaraan
- Generate QR Code
- Download/Print QR Code

#### Generate QR Code:
```php
private function generateAndSaveQrCode(int $vehicleId, string $qrData): void {
    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($qrData)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::Quartile)
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
        ->build();
    
    $qrDir = WRITEPATH . 'uploads/qrcodes/vehicles/';
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0777, true);
    }
    
    $filename = 'qrcode_' . preg_replace('/[^A-Za-z0-9_]/', '_', trim($qrData)) . '_' . md5(uniqid()) . '.png';
    $filepath = $qrDir . $filename;
    
    file_put_contents($filepath, $result->getString());
    
    $this->vehicleModel->update($vehicleId, [
        'v_qr_code_path' => 'writable/uploads/qrcodes/vehicles/' . $filename,
        'v_qr_code_filename' => $filename
    ]);
}
```

### 5.9 Modul Inventory

#### Fitur:
- CRUD inventaris kendaraan
- Riwayat perubahan inventaris
- Upload foto inventaris
- Cetak/PDF

### 5.10 Modul Handover (Serah Terima)

#### Fitur:
- CRUD serah terima
- Digital signature (canvas)
- Preview dan cetak PDF
- Merk ban dan velg

#### Digital Signature:
```javascript
// View: handover_add.php
var canvas = document.getElementById('signature-pad');
var signaturePad = new SignaturePad(canvas);

// Save signature
function saveSignature() {
    var dataURL = signaturePad.toDataURL('image/png'); // base64
    document.getElementById('signature_data').value = dataURL;
}
```

```php
// Controller: Vehicle.php
public function save_signature() {
    $signature_data = $this->request->getPost('signature_data'); // base64
    $type = $this->request->getPost('type'); // old/new
    
    // Simpan ke session atau langsung ke database
    session()->set('signature_' . $type, $signature_data);
    
    return $this->response->setJSON(['status' => 'success']);
}
```

### 5.11 Modul Reports

#### Fitur:
- 9 jenis laporan (driver, BAP, laka, survey, training, loan, vehicle, inventory, handover)
- Export ke Excel (PhpSpreadsheet)
- Export ke PDF (Dompdf)
- Filter berdasarkan tanggal dan parameter lain

#### Contoh Export Excel:
```php
public function export_driver_excel() {
    $drivers = $this->reportModel->driver_reports(/* filters */);
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set header
    $sheet->setCellValue('A1', 'NIS');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'Alamat');
    // ...
    
    // Set data
    $row = 2;
    foreach ($drivers as $driver) {
        $sheet->setCellValue('A' . $row, $driver['d_nis']);
        $sheet->setCellValue('B' . $row, $driver['d_name']);
        $sheet->setCellValue('C' . $row, $driver['d_address']);
        // ...
        $row++;
    }
    
    // Style
    $sheet->getStyle('A1:Z1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
    ]);
    
    // Download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="drivers_report.xlsx"');
    $writer->save('php://output');
}
```

#### Contoh Export PDF:
```php
public function export_driver_pdf() {
    $drivers = $this->reportModel->driver_reports(/* filters */);
    
    $data = ['drivers' => $drivers];
    
    // Gunakan helper streamPdf() untuk kompatibilitas mobile
    return streamPdf('reports/driver_pdf', $data, 'drivers_report.pdf', true);
}
```

### 5.12 Modul Settings

#### Fitur:
- Konfigurasi nama website
- Upload/delete logo
- Konfigurasi SMTP email

---

## 6. CONTROLLERS

### 6.1 BaseController

**Lokasi:** `app/Controllers/BaseController.php`

Base controller yang di-extend oleh semua controller lain.

```php
<?php
namespace App\Controllers;

use CodeIgniter\Controller;

abstract class BaseController extends Controller
{
    protected $helpers = ['url', 'form'];
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, 
                                    \CodeIgniter\HTTP\ResponseInterface $response,
                                    \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        // Additional initialization
    }
}
```

### 6.2 Login Controller

**Lokasi:** `app/Controllers/Login.php`

**Tanggung Jawab:** Autentikasi user

#### Methods:

| Method | Type | Deskripsi |
|--------|------|-----------|
| `index()` | GET | Menampilkan halaman login |
| `auth()` | POST | Memproses autentikasi |
| `logout()` | GET | Mengakhiri session |

#### Implementasi:

```php
<?php
namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index() {
        $data = [];
        if (session()->getFlashdata('error')) {
            $data['error'] = session()->getFlashdata('error');
        }
        return view('login', $data);
    }
    
    public function auth() {
        $session = session();
        $loginModel = new LoginModel();
        
        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));
        
        // Validasi input kosong
        if (empty($username) || empty($password)) {
            $session->setFlashdata('error', 'Username dan password harus diisi');
            return redirect()->to('/login');
        }
        
        // Cek kredensial
        $user = $loginModel->checkLogin($username, $password);
        
        if ($user) {
            // Ambil permissions
            $roles = $loginModel->getUserRoles($user['u_id']);
            
            // Set session
            $session->set([
                'user_id' => $user['u_id'],
                'username' => $user['u_username'],
                'name' => $user['u_name'],
                'permissions' => $roles,
                'logged_in' => true,
                'last_activity' => time()
            ]);
            
            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('error', 'Username atau password salah');
            return redirect()->to('/login');
        }
    }
    
    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}
```

### 6.3 Dashboard Controller

**Lokasi:** `app/Controllers/Dashboard.php`

**Tanggung Jawab:** Menampilkan halaman dashboard

#### Methods:

| Method | Type | Deskripsi |
|--------|------|-----------|
| `index()` | GET | Menampilkan dashboard |
| `setTheme()` | POST | Mengubah tema (dark/light) |
| `dateToString()` | private | Helper konversi tanggal |

### 6.4 Drivers Controller

**Lokasi:** `app/Controllers/Drivers.php`

**Tanggung Jawab:** Mengelola semua modul terkait supir (driver, BAP, survey, training, loan)

#### Dependencies:
```php
protected $driversModel;
protected $vehicleModel;
protected $session;

public function __construct() {
    $this->driversModel = new DriversModel();
    $this->vehicleModel = new VehicleModel();
    $this->session = session();
    helper(['form', 'url', 'string', 'custom']);
}
```

#### Methods - Driver Management:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `index()` | GET /drivers/drivers_management | Menampilkan daftar supir aktif |
| `adddrivers()` | GET/POST /drivers/adddrivers | Form dan proses tambah supir |
| `editdriver()` | POST /drivers/editdriver | Edit data supir |
| `viewdriver()` | POST /drivers/viewdriver | Detail supir (modal) |
| `insertdriver()` | POST /drivers/insertdriver | Simpan supir baru |
| `updatedriver()` | POST /drivers/updatedriver | Update data supir |
| `drivers_delete($id)` | POST /drivers/drivers_delete/$id | Hapus supir |
| `inactivedriver()` | GET /drivers/drivers_inactive | Daftar supir tidak aktif |
| `adddriversblacklist()` | GET/POST /drivers/adddriversblacklist | Tambah supir blacklist |

#### Methods - BAP:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `baplists_drivers()` | GET /baps/bap_management | Daftar BAP |
| `baplist_pending()` | GET /baps/bap_pending | Daftar BAP pending |
| `addbap()` | GET/POST /baps/addbap | Tambah BAP |
| `editbap()` | POST /baps/editbap | Edit BAP |
| `editbap_pending($id)` | GET/POST /baps/editbap_pending/$id | Edit BAP pending |
| `insertbap()` | POST /drivers/insertbap | Simpan BAP baru |
| `updatebap()` | POST /drivers/updatebap | Update BAP |
| `updatebap_pending()` | POST /drivers/updatebap_pending | Update BAP pending |
| `viewbap()` | POST /baps/bap_view | Detail BAP |
| `viewbappending()` | POST /baps/bap_pendingview | Detail BAP pending |
| `bap_delete($id)` | POST /drivers/bap_delete/$id | Hapus BAP |
| `bappending_delete($id)` | POST /drivers/bappending_delete/$id | Hapus BAP pending |
| `printbap($id)` | GET /drivers/printbap/$id | Cetak PDF BAP |

#### Methods - Survey:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `surveylist_drivers()` | GET /surveys/survey_management | Daftar survey |
| `addsurvey()` | GET/POST /surveys/addsurvey | Tambah survey |
| `editsurvey()` | POST /surveys/editsurvey | Edit survey |
| `insertsurvey()` | POST /drivers/insertsurvey | Simpan survey |
| `updatesurvey()` | POST /drivers/updatesurvey | Update survey |
| `viewsurvey()` | POST /surveys/survey_view | Detail survey |
| `survey_delete($id)` | POST /drivers/survey_delete/$id | Hapus survey |
| `printsurvey($id)` | GET /surveys/survey_print/$id | Cetak PDF survey |
| `downloadSurveyPdf($id)` | GET /surveys/data_survey_pdf/$id | Download PDF survey |

#### Methods - Training:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `traininglist_drivers()` | GET /trainings/training_management | Daftar training |
| `addtraining()` | GET/POST /trainings/addtraining | Tambah training |
| `edittraining($id)` | GET/POST /trainings/edittraining/$id | Edit training |
| `inserttraining()` | POST /drivers/inserttraining | Simpan training |
| `updatetraining()` | POST /drivers/updatetraining | Update training |
| `training_delete($id)` | POST /drivers/training_delete/$id | Hapus training |
| `viewtraining($id)` | GET /trainings/viewtraining/$id | Detail training |
| `getDetailTrainingByDriver()` | POST /trainings/getDetailByDriver | Get training by driver (AJAX) |
| `getDetailTrainingByTema()` | POST /trainings/getDetailByTema | Get training by tema (AJAX) |

#### Methods - Loan:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `loanlist_drivers($status)` | GET /loans/loan_management | Daftar pinjaman |
| `addloan()` | GET/POST /loans/addloan | Tambah pinjaman |
| `editloan()` | POST /loans/editloan | Edit pinjaman |
| `insertloan()` | POST /drivers/insertloan | Simpan pinjaman |
| `updateloan()` | POST /drivers/updateloan | Update pinjaman |
| `viewloan()` | POST /loans/viewloan | Detail pinjaman |
| `loan_delete($id)` | POST /drivers/loan_delete/$id | Hapus pinjaman |
| `loanlist_approve()` | GET /loans/loan_approve | Daftar pinjaman untuk approval |
| `update_loan_status()` | POST /loans/update_loan_status | Update status pinjaman |

#### Methods - Helper:

| Method | Deskripsi |
|--------|-----------|
| `generateDriverCode($last_nis)` | Generate NIS baru |
| `generateBapCode($last_bcode)` | Generate kode BAP |
| `generateSurveyCode($last_scode)` | Generate kode survey |
| `generateTrainingCode($last_trcode)` | Generate kode training |
| `getRegencies($province_id)` | Get kabupaten/kota (AJAX) |
| `getDistricts($regency_id)` | Get kecamatan (AJAX) |
| `getVillages($district_id)` | Get kelurahan (AJAX) |

### 6.5 Vehicle Controller

**Lokasi:** `app/Controllers/Vehicle.php`

**Tanggung Jawab:** Mengelola modul kendaraan, inventaris, dan handover

#### Dependencies:
```php
protected $vehicleModel;
protected $driversModel;
protected $session;

public function __construct() {
    $this->vehicleModel = new VehicleModel();
    $this->driversModel = new DriversModel();
    $this->session = session();
    helper(['form', 'url', 'string', 'text', 'custom']);
}
```

#### Methods - Vehicle Management:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `index()` | GET /vehicles/vehicles_management | Daftar kendaraan |
| `addvehicle()` | GET/POST /vehicles/addvehicle | Tambah kendaraan |
| `editvehicle()` | POST /vehicles/editvehicle | Edit kendaraan |
| `viewvehicle()` | POST /vehicles/viewvehicle | Detail kendaraan |
| `insertvehicle()` | POST /vehicles/insertvehicle | Simpan kendaraan |
| `updatevehicle()` | POST /vehicles/updatevehicle | Update kendaraan |
| `vehicle_delete($id)` | POST /vehicles/vehicle_delete/$id | Hapus kendaraan |
| `view_qrcode($id)` | GET /vehicles/view_qrcode/$id | Lihat QR code |
| `download_qrcode($id)` | GET /vehicles/download_qrcode/$id | Download QR code |
| `print_qrcode($id)` | GET /vehicles/print_qrcode/$id | Cetak QR code |

#### Methods - Vehicle Group & Owner:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `vehiclegroup()` | GET/POST /vehicles/vehiclegroup | Kelola grup kendaraan |
| `addgroup()` | POST /vehicle/addgroup | Tambah grup |
| `vehiclegroup_delete($id)` | GET /vehicle/vehiclegroup_delete/$id | Hapus grup |
| `vehicleowner()` | GET/POST /vehicles/vehicleowner | Kelola owner |
| `addowner()` | POST /vehicle/addowner | Tambah owner |
| `vehicleowner_delete($id)` | GET /vehicle/vehicleowner_delete/$id | Hapus owner |

#### Methods - Inventory:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `inventorylist_vehicle()` | GET /inventory/inventory_management | Daftar inventaris |
| `addinventory()` | GET/POST /inventory/addinventory | Tambah inventaris |
| `editinventory()` | POST /inventory/editinventory | Edit inventaris |
| `viewinventory()` | POST /inventory/inventory_view | Detail inventaris |
| `insertinventory()` | POST /vehicles/insertinventory | Simpan inventaris |
| `updateinventory()` | POST /vehicles/updateinventory | Update inventaris |
| `inventory_delete($id)` | POST /inventory/inventory_delete/$id | Hapus inventaris |
| `printinventory($id)` | GET /vehicles/printinventory/$id | Cetak PDF inventaris |
| `downloadInventoryPdf($id)` | GET /inventory/inventory_download_pdf/$id | Download PDF inventaris |

#### Methods - Handover:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `handoverlist_vehicle()` | GET /handover/handover_management | Daftar handover |
| `addhandover()` | GET/POST /handover/addhandover | Tambah handover |
| `edithandover()` | POST /handover/edithandover | Edit handover |
| `viewhandover()` | POST /handover/handover_view | Detail handover |
| `inserthandover()` | POST /vehicles/inserthandover | Simpan handover |
| `updatehandover()` | POST /vehicles/updatehandover | Update handover |
| `handover_delete($id)` | POST /handover/handover_delete/$id | Hapus handover |
| `viewhandoverinventory()` | GET /handover/viewhandoverinventory | Lihat inventaris handover |
| `edithandoverinventory()` | GET /handover/edithandoverinventory | Edit inventaris handover |
| `updateinventoryandproceed()` | POST /handover/updateinventoryandproceed | Update & proses handover |
| `preview()` | GET /handover/preview | Preview handover |
| `printhandover($id)` | GET /handover/handover_print/$id | Cetak PDF handover |
| `downloadHandoverPdf($id)` | GET /handover/handover_download_pdf/$id | Download PDF handover |
| `save_signature()` | POST /handover/save_signature | Simpan tanda tangan digital |
| `handovermerkban()` | GET/POST /handover/handovermerkban | Kelola merk ban |
| `addhandovermerkban()` | POST /handover/addhandovermerkban | Tambah merk ban |
| `handovermerkban_delete($id)` | GET /handover/handovermerkban_delete/$id | Hapus merk ban |
| `handovermerkvelg()` | GET/POST /handover/handovermerkvelg | Kelola merk velg |
| `addhandovermerkvelg()` | POST /handover/addhandovermerkvelg | Tambah merk velg |
| `handovermerkvelg_delete($id)` | GET /handover/handovermerkvelg_delete/$id | Hapus merk velg |

#### Private Methods:

| Method | Deskripsi |
|--------|-----------|
| `generateAndSaveQrCode($vehicleId, $qrData)` | Generate dan simpan QR code |
| `generateInvCode($last_ivcode)` | Generate kode inventaris |
| `generateHdoCode($last_hcode)` | Generate kode handover |
| `saveBase64Photo()` | Simpan foto base64 |
| `saveInventoryPhoto()` | Simpan foto inventaris |
| `deleteUploadedFiles()` | Hapus file upload |
| `deleteUploadFiles()` | Hapus file upload (plural) |

### 6.6 Reports Controller

**Lokasi:** `app/Controllers/Reports.php`

**Tanggung Jawab:** Generate laporan (Excel & PDF)

#### Dependencies:
```php
protected $driversModel;
protected $vehicleModel;
protected $reportModel;
protected $session;

public function __construct() {
    $this->driversModel = model('DriversModel');
    $this->vehicleModel = model('VehicleModel');
    $this->reportModel = model('ReportModel');
    $this->session = \Config\Services::session();
    helper('url');
}
```

#### Methods:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `driver()` | POST /reports/driver | Laporan driver |
| `export_driver_excel()` | POST /reports/export_driver_excel | Export Excel driver |
| `export_driver_pdf()` | POST /reports/export_driver_pdf | Export PDF driver |
| `bap()` | POST /reports/bap | Laporan BAP |
| `export_bap_excel()` | POST /reports/export_bap_excel | Export Excel BAP |
| `export_bap_pdf()` | POST /reports/export_bap_pdf | Export PDF BAP |
| `laka()` | POST /reports/laka | Laporan laka |
| `export_laka_excel()` | POST /reports/export_laka_excel | Export Excel laka |
| `export_laka_pdf()` | POST /reports/export_laka_pdf | Export PDF laka |
| `survey()` | POST /reports/survey | Laporan survey |
| `export_survey_excel()` | POST /reports/export_survey_excel | Export Excel survey |
| `export_survey_pdf()` | POST /reports/export_survey_pdf | Export PDF survey |
| `training()` | POST /reports/training | Laporan training |
| `export_training_excel()` | POST /reports/export_training_excel | Export Excel training |
| `export_training_pdf()` | POST /reports/export_training_pdf | Export PDF training |
| `loan()` | POST /reports/loan | Laporan loan |
| `export_loan_pdf()` | POST /reports/export_loan_pdf | Export PDF loan |
| `vehicle()` | POST /reports/vehicle | Laporan vehicle |
| `export_vehicle_excel()` | POST /reports/export_vehicle_excel | Export Excel vehicle |
| `export_vehicle_pdf()` | POST /reports/export_vehicle_pdf | Export PDF vehicle |
| `inventory()` | POST /reports/inventory | Laporan inventory |
| `export_inventory_excel()` | POST /reports/export_inventory_excel | Export Excel inventory |
| `export_inventory_pdf()` | POST /reports/export_inventory_pdf | Export PDF inventory |
| `handover()` | POST /reports/handover | Laporan handover |
| `export_handover_excel()` | POST /reports/export_handover_excel | Export Excel handover |
| `export_handover_pdf()` | POST /reports/export_handover_pdf | Export PDF handover |

#### Private Methods:

| Method | Deskripsi |
|--------|-----------|
| `resolveWilayahNames($rows)` | Resolve ID wilayah menjadi nama |
| `resolveWilayahNamesSurvey($rows)` | Resolve ID wilayah untuk survey |

### 6.7 Users Controller

**Lokasi:** `app/Controllers/Users.php`

**Tanggung Jawab:** Manajemen user dan permission

#### Methods:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `index()` | GET /users/user_management | Daftar user |
| `adduser()` | GET/POST /users/adduser | Tambah user |
| `edituser($id)` | GET/POST /users/edituser/$id | Edit user |
| `insertuser()` | POST /users/insertuser | Simpan user |
| `updateuser()` | POST /users/updateuser | Update user |
| `deleteuser($id)` | POST /users/deleteuser/$id | Hapus user |

### 6.8 Settings Controller

**Lokasi:** `app/Controllers/Settings.php`

**Tanggung Jawab:** Pengaturan website

#### Methods:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `websitesetting()` | GET /settings/websitesetting | Halaman pengaturan |
| `websitesetting_save()` | POST /settings/websitesetting_save | Simpan pengaturan |
| `logodelete()` | POST /settings/logodelete | Hapus logo |

### 6.9 Workshops Controller

**Lokasi:** `app/Controllers/Workshops.php`

**Tanggung Jawab:** Insentif mekanik

#### Methods:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| `incentive_list()` | GET /mechanics/incentive_management | Daftar insentif |

---

## 7. MODELS

### 7.1 LoginModel

**Lokasi:** `app/Models/LoginModel.php`

**Tabel:** `users`

#### Methods:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `checkLogin($username, $password)` | string, string | array/false | Cek kredensial login |
| `getUserRoles($userId)` | int | array | Ambil permission user |

#### Implementasi:

```php
<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'u_id';
    protected $allowedFields = ['u_username', 'u_password'];
    
    public function checkLogin($username, $password) {
        $query = $this->where('u_username', $username)->first();
        
        if ($query && password_verify($password, $query['u_password'])) {
            return $query;
        }
        
        return false;
    }
    
    public function getUserRoles($userId) {
        $builder = $this->db->table('login_roles');
        $roles = $builder->where('lr_u_id', $userId)
                         ->get()
                         ->getRowArray();
        
        $permissions = [];
        if ($roles) {
            foreach ($roles as $key => $value) {
                // Ambil hanya field dengan prefix 'lr_' dan value = '1'
                if (strpos($key, 'lr_') === 0 && $value == '1') {
                    $permissions[] = $key;
                }
            }
        }
        
        return $permissions;
    }
}
```

### 7.2 DriversModel

**Lokasi:** `app/Models/DriversModel.php`

**Tabel:** `drivers`

#### Allowed Fields:
```php
protected $allowedFields = [
    'd_nis', 'd_name', 'd_nickname', 'd_pob', 'd_dob', 'd_age', 'd_married',
    'd_education', 'd_mobile', 'd_address', 'd_province', 'd_city', 
    'd_subdistrict', 'd_village', 'd_identityno', 'd_identity_expdate',
    'd_licenseno', 'd_license_expdate', 'd_cardbpjs', 'd_accountno',
    'd_bank', 'd_accountname', 'd_experience', 'd_total_exp', 'd_infoexp',
    'd_expstatus', 'd_ref', 'd_doj', 'd_notes', 'd_resigndate', 'd_is_active',
    'd_docstatus', 'd_docremarks', 'd_photo', 'd_pdf_document', 'd_created_by',
    'd_modified_date', 'd_notes_blacklist'
];
```

#### Methods - Driver:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getall_drivers()` | - | array | Ambil semua driver |
| `getDriversById($id)` | int | array | Ambil driver by ID |
| `get_driverdetails($id)` | int | array | Detail driver lengkap |
| `get_driver_by_nis($nis)` | string | array | Ambil driver by NIS |
| `add_drivers($data)` | array | int/bool | Tambah driver |
| `edit_driver($id, $data)` | int, array | bool | Update driver |
| `drivers_delete($id)` | int | bool | Hapus driver |
| `get_last_nis()` | - | string | Ambil NIS terakhir |
| `generateDriverCode()` | - | string | Generate NIS baru |
| `get_driver_inactive_blacklist()` | - | array | Daftar driver blacklist |
| `insert_driversblacklist($data)` | array | int/bool | Tambah driver blacklist |
| `edit_driverblacklist($id, $data)` | int, array | bool | Update driver blacklist |

#### Methods - Wilayah:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getProvinces()` | - | array | Ambil semua provinsi |
| `getRegencies($province_id)` | int | array | Ambil kabupaten/kota |
| `getDistricts($regency_id)` | int | array | Ambil kecamatan |
| `getVillages($district_id)` | int | array | Ambil kelurahan |
| `getProvinceName($id)` | int | string | Nama provinsi |
| `getRegencyName($id)` | int | string | Nama kabupaten |
| `getDistrictName($id)` | int | string | Nama kecamatan |
| `getVillageName($id)` | int | string | Nama kelurahan |
| `resolveWilayahNamesSurvey($rows)` | array | array | Resolve ID ke nama |

#### Methods - BAP:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getBap()` | - | array | Ambil semua BAP |
| `getBapById($id)` | int | array | Ambil BAP by ID |
| `get_bapdetails($id)` | int | array | Detail BAP lengkap |
| `get_baps_by_nis($nis)` | string | array | Ambil BAP by NIS |
| `get_bap_by_date($from, $to)` | string, string | array | Ambil BAP by tanggal |
| `add_bap($data)` | array | int/bool | Tambah BAP |
| `edit_bap($id, $data)` | int, array | bool | Update BAP |
| `editpending_bap($id, $data)` | int, array | bool | Update BAP pending |
| `bap_delete($id)` | int | bool | Hapus BAP |
| `get_last_bcode()` | - | string | Ambil kode BAP terakhir |

#### Methods - Survey:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `get_survey()` | - | array | Ambil semua survey |
| `getSurveyById($id)` | int | array | Ambil survey by ID |
| `get_surveydetails($id)` | int | array | Detail survey lengkap |
| `get_survey_by_nis($nis)` | string | array | Ambil survey by NIS |
| `get_driver_survey($nis)` | string | array | Ambil survey driver |
| `add_survey($data)` | array | int/bool | Tambah survey |
| `edit_survey($id, $data)` | int, array | bool | Update survey |
| `survey_delete($id)` | int | bool | Hapus survey |
| `generateSurveyCode()` | - | string | Generate kode survey |
| `get_last_scode()` | - | string | Ambil kode survey terakhir |

#### Methods - Training:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `get_training()` | - | array | Ambil semua training |
| `get_trainingdetails($id)` | int | array | Detail training lengkap |
| `get_training_by_nis($nis)` | string | array | Ambil training by NIS |
| `getTrainingsByDriver($nis)` | string | array | Training per driver |
| `getTrainingsByTema($tema)` | string | array | Training per tema |
| `countTrainingsByDriver($nis)` | string | int | Jumlah training driver |
| `countTrainingsByTema($tema)` | string | int | Jumlah training per tema |
| `add_training($data)` | array | int/bool | Tambah training |
| `edit_training($id, $data)` | int, array | bool | Update training |
| `training_delete($id)` | int | bool | Hapus training |
| `generateTrainingCode()` | - | string | Generate kode training |
| `get_last_trcode()` | - | string | Kode training terakhir |

#### Methods - Loan:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `get_loan()` | - | array | Ambil semua pinjaman |
| `getLoanById($id)` | int | array | Ambil pinjaman by ID |
| `get_loandetails($id)` | int | array | Detail pinjaman |
| `get_loan_by_nis($nis)` | string | array | Pinjaman by NIS |
| `get_loan_bystatus($status)` | string | array | Pinjaman by status |
| `get_combined_loan_bap($nis)` | string | array | Combined loan & BAP |
| `add_loan($data)` | array | int/bool | Tambah pinjaman |
| `edit_loan($id, $data)` | int, array | bool | Update pinjaman |
| `update_loan_status($id, $data)` | int, array | bool | Update status pinjaman |
| `get_last_lcode()` | - | string | Kode pinjaman terakhir |

#### Private Method - fetchData:
```php
/**
 * Fetch data dari API wilayah emsifa dengan caching 7 hari
 * Tujuan: Menghindari dependency pada API eksternal setiap request
 */
private function fetchData($endpoint) {
    $cacheKey = 'wilayah_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $endpoint) . '.json';
    $cacheFile = WRITEPATH . 'cache/' . $cacheKey;
    $cacheTtl = 7 * 24 * 3600; // 7 hari
    
    // 1) Cek cache
    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTtl) {
        $cached = @file_get_contents($cacheFile);
        if ($cached !== false && $cached !== '') {
            $decoded = json_decode($cached, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }
    }
    
    // 2) Fetch dari API dengan timeout
    $url = "https://www.emsifa.com/api-wilayah-indonesia/api/" . $endpoint;
    
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 detik timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            
            // Simpan ke cache
            @file_put_contents($cacheFile, json_encode($data));
            
            return $data;
        }
    } catch (\Exception $e) {
        // Fallback ke cache lama jika ada
        if (is_file($cacheFile)) {
            return json_decode(file_get_contents($cacheFile), true);
        }
    }
    
    return [];
}
```

### 7.3 VehicleModel

**Lokasi:** `app/Models/VehicleModel.php`

**Tabel:** `vehicles`

#### Allowed Fields:
```php
protected $allowedFields = [
    'v_registration_no', 'v_type', 'v_name', 'v_group', 'v_owner',
    'v_reg_exp_date', 'v_is_active', 'v_stnk_expdate', 'v_plat_expdate',
    'v_kir_expdate', 'v_kir_process_date', 'v_legal', 'v_chassis_no',
    'v_engine_no', 'v_uji_no', 'v_lokasi_kir', 'v_notes_lokasikir',
    'v_insurance', 'v_polis_no', 'v_exp_insurance', 'v_notes',
    'v_created_by', 'v_created_date', 'v_modified_date',
    'v_qr_code_path', 'v_qr_code_filename'
];
```

#### Methods - Vehicle:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getall_vehicle()` | - | array | Ambil semua kendaraan |
| `get_vehicledetails($id)` | int | array | Detail kendaraan lengkap |
| `get_last_vcode()` | - | string | Kode kendaraan terakhir |
| `vehicle_delete($id)` | int | bool | Hapus kendaraan |

#### Methods - Vehicle Group & Owner:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `get_vehiclegroup()` | - | array | Ambil semua grup |
| `vehiclegroup_delete($id)` | int | bool | Hapus grup |
| `get_vehicleowner()` | - | array | Ambil semua owner |
| `vehicleowner_delete($id)` | int | bool | Hapus owner |
| `get_distinct_owners()` | - | array | Owner unik |
| `get_distinct_types()` | - | array | Tipe unik |

#### Methods - Inventory:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getInventory()` | - | array | Ambil semua inventaris |
| `getInventoryById($id)` | int | array | Inventaris by ID |
| `get_inventorydetails($id)` | int | array | Detail inventaris |
| `get_inventory_columns()` | - | array | Kolom inventaris |
| `get_distinct_inventory_data()` | - | array | Data inventaris unik |
| `insert_inventory($data)` | array | int/bool | Tambah inventaris |
| `update_inventory($id, $data)` | int, array | bool | Update inventaris |
| `inventory_delete($id)` | int | bool | Hapus inventaris |
| `get_last_ivcode()` | - | string | Kode inventaris terakhir |

#### Methods - Handover:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getHandover()` | - | array | Ambil semua handover |
| `getHandoverById($id)` | int | array | Handover by ID |
| `get_handoverdetails($id)` | int | array | Detail handover |
| `get_handover_by_hocode($code)` | string | array | Handover by kode |
| `get_distinct_handover_vehicles()` | - | array | Kendaraan di handover |
| `add_handover($data)` | array | int/bool | Tambah handover |
| `edit_handover($id, $data)` | int, array | bool | Update handover |
| `handover_delete($id)` | int | bool | Hapus handover |
| `get_last_hcode()` | - | string | Kode handover terakhir |
| `get_handovermerkban()` | - | array | Merk ban |
| `handovermerkban_delete($id)` | int | bool | Hapus merk ban |
| `get_handovermerkvelg()` | - | array | Merk velg |
| `handovermerkvelg_delete($id)` | int | bool | Hapus merk velg |
| `get_distinct_merk_ban()` | - | array | Merk ban unik |

### 7.4 DashboardModel

**Lokasi:** `app/Models/DashboardModel.php`

**Tabel:** Multiple (drivers, vehicles, inventory, income_expense, reminder)

#### Methods:

| Method | Return | Deskripsi |
|--------|--------|-----------|
| `getDashboardCounts()` | array | Hitung jumlah data (driver, vehicle, dll) |
| `get_todayreminder()` | array | Reminder hari ini |
| `get_reminders_yellow()` | array | Reminder warning (kuning) |
| `get_reminders_red()` | array | Reminder urgent (merah) |
| `get_iechartdata()` | array | Data grafik income-expense |
| `get_vehicle_expdate()` | array | Kendaraan dengan dokumen exp |
| `get_vehicle_ready_list()` | array | Daftar kendaraan ready |
| `get_inventory_ready_list()` | array | Daftar inventaris ready |
| `getaddress($lat, $lng)` | string | Alamat dari koordinat |
| `createDateRangeArray($start, $end)` | array | Array range tanggal |

### 7.5 ReportModel

**Lokasi:** `app/Models/ReportModel.php`

**Tabel:** Multiple (semua tabel untuk reporting)

#### Methods:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `driver_reports($filters)` | array | array | Laporan driver |
| `bap_reports($filters)` | array | array | Laporan BAP |
| `laka_reports($filters)` | array | array | Laporan laka |
| `survey_reports($filters)` | array | array | Laporan survey |
| `training_reports($filters)` | array | array | Laporan training |
| `loan_reports($filters)` | array | array | Laporan pinjaman |
| `vehicle_reports($filters)` | array | array | Laporan kendaraan |
| `inventory_reports($filters)` | array | array | Laporan inventaris |
| `handover_reports($filters)` | array | array | Laporan handover |

### 7.6 UserModel

**Lokasi:** `app/Models/UserModel.php`

**Tabel:** `users`, `login_roles`

#### Methods:

| Method | Parameter | Return | Deskripsi |
|--------|-----------|--------|-----------|
| `getall_user()` | - | array | Ambil semua user |
| `get_userdetails($id)` | int | array | Detail user |
| `add_user($data)` | array | int/bool | Tambah user |
| `update_user($id, $data)` | int, array | bool | Update user |
| `user_delete($id)` | int | bool | Hapus user |

---

## 8. VIEWS

### 8.1 Struktur View

```
app/Views/
├── layout/
│   ├── header.php          # Header template
│   ├── footer.php          # Footer template
│   └── sidebar.php         # Sidebar navigation
│
├── login.php               # Halaman login
├── dashboard.php           # Halaman dashboard
├── pagenotfound.php        # Halaman 404
├── form_information.php    # Informasi form
│
├── drivers/                # Views modul driver
│   ├── drivers_management.php
│   ├── drivers_add.php
│   ├── drivers_view.php
│   ├── drivers_inactive.php
│   ├── driversblacklist_add.php
│   ├── drivers_viewinactive.php
│   └── drivers_pdf.php
│
├── baps/                   # Views modul BAP
│   ├── bap_management.php
│   ├── bap_add.php
│   ├── bap_view.php
│   ├── bap_pending.php
│   ├── bap_pendingview.php
│   ├── bap_pendingedit.php
│   ├── bap_print.php
│   ├── bap_pdf.php
│   └── laka_pdf.php
│
├── surveys/                # Views modul survey
│   ├── survey_management.php
│   ├── survey_add.php
│   ├── survey_view.php
│   ├── survey_print.php
│   ├── survey_pdf.php
│   └── data_survey_pdf.php
│
├── trainings/              # Views modul training
│   ├── training_management.php
│   └── training_pdf.php
│
├── loans/                  # Views modul loan
│   ├── loan_management.php
│   ├── loan_add.php
│   ├── loan_view.php
│   ├── loan_approve.php
│   └── loan_pdf.php
│
├── vehicles/               # Views modul vehicle
│   ├── vehicles_management.php
│   ├── vehicles_add.php
│   ├── vehicles_view.php
│   ├── vehicles_group.php
│   ├── vehicles_owner.php
│   ├── vehicle_qrcode_label.php
│   ├── vehicle_print.php
│   └── vehicle_pdf.php
│
├── inventory/              # Views modul inventory
│   ├── inventory_management.php
│   ├── inventory_add.php
│   ├── inventory_view.php
│   ├── inventory_print.php
│   ├── inventory_pdf.php
│   └── data_inventory_pdf.php
│
├── handover/               # Views modul handover
│   ├── handover_management.php
│   ├── handover_add.php
│   ├── handover_view.php
│   ├── handover_inventory_view.php
│   ├── handover_inventory_edit.php
│   ├── preview_handover_inventory.php
│   ├── handover_merkban.php
│   ├── handover_merkvelg.php
│   ├── handover_print.php
│   ├── handover_pdf.php
│   └── data_handover_pdf.php
│
├── reports/                # Views modul reports
│   ├── report_driver.php
│   ├── report_bap.php
│   ├── report_laka.php
│   ├── report_survey.php
│   ├── report_training.php
│   ├── report_loan.php
│   ├── report_vehicle.php
│   ├── report_inventory.php
│   └── report_handover.php
│
├── mechanics/              # Views modul mekanik
│   ├── incentive_management.php
│   └── incentive_add.php
│
├── users/                  # Views modul user
│   ├── user_management.php
│   └── user_add.php
│
├── settings/               # Views settings
│   └── websitesetting.php
│
└── errors/                 # Error pages
    ├── cli/
    └── html/
```

### 8.2 Layout Template

#### Header (`layout/header.php`)

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'SiapSistemHub' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/favicon.ico') ?>">
    
    <!-- AdminLTE & Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">
    
    <!-- Plugin CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
    
    <!-- Custom CSS -->
    <style>
        /* Dark mode support */
        <?= session()->get('theme') === 'dark' ? 'body { background-color: #1a1a2e; color: #eee; }' : '' ?>
    </style>
</head>
<body class="hold-transition sidebar-mini <?= session()->get('theme') === 'dark' ? 'dark-mode' : '' ?>">
<div class="wrapper">
```

#### Sidebar (`layout/sidebar.php`)

```php
<aside class="main-sidebar sidebar-dark-primary">
    <a href="<?= base_url('/dashboard') ?>" class="brand-link">
        <img src="<?= base_url(sitedata()['site_logo'] ?? 'assets/img/logo.png') ?>" 
             alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">
            <?= sitedata()['site_name'] ?? 'SiapSistemHub' ?>
        </span>
    </a>
    
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= activate_menu('dashboard') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Driver Management -->
                <?php if (userpermission('lr_driver_view')): ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Driver Management <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('/drivers/drivers_management') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active Drivers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/drivers/drivers_inactive') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inactive/Blacklist</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <!-- BAP -->
                <?php if (userpermission('lr_bap_view')): ?>
                <li class="nav-item">
                    <a href="<?= base_url('/baps/bap_management') ?>" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>BAP</p>
                    </a>
                </li>
                <?php endif; ?>
                
                <!-- ... menu lainnya ... -->
                
            </ul>
        </nav>
    </div>
</aside>
```

#### Footer (`layout/footer.php`)

```php
<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#"><?= sitedata()['site_name'] ?? 'SiapSistemHub' ?></a>.</strong>
    All rights reserved.
</footer>

<!-- jQuery -->
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/js/adminlte.min.js') ?>"></script>

<!-- Plugin JS -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>

<!-- Custom JS -->
<script src="<?= base_url('assets/js/custom.js') ?>"></script>

<script>
    // Initialize Select2
    $(function () {
        $('.select2').select2();
    });
    
    // Auto-logout timer
    var autoLogoutTimeout = <?= config('Session')->expiration ?? 86400 ?> * 1000;
    setTimeout(function() {
        Swal.fire({
            title: 'Session Expired',
            text: 'Your session has expired. Please login again.',
            icon: 'warning'
        }).then(() => {
            window.location.href = '<?= base_url("/logout") ?>';
        });
    }, autoLogoutTimeout);
</script>

</div><!-- ./wrapper -->
</body>
</html>
```

### 8.3 Contoh View - Drivers Management

```php
<!-- File: app/Views/drivers/drivers_management.php -->
<?= $this->include('layout/header') ?>
<?= $this->include('layout/sidebar') ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Driver Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Driver Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            
            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('successmessage')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= session()->getFlashdata('successmessage') ?>
            </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('warningmessage')): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= session()->getFlashdata('warningmessage') ?>
            </div>
            <?php endif; ?>
            
            <!-- Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Active Drivers List</h3>
                    
                    <div class="card-tools">
                        <?php if (userpermission('lr_driver_add')): ?>
                        <a href="<?= base_url('drivers/adddrivers') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Driver
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-body">
                    <table id="driverTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($driverslist as $driver): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($driver['d_nis']) ?></td>
                                <td><?= esc($driver['d_name']) ?></td>
                                <td><?= esc($driver['d_mobile']) ?></td>
                                <td><?= esc($driver['d_address']) ?></td>
                                <td>
                                    <?php if ($driver['d_is_active'] == '0'): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" 
                                            onclick="viewDriver(<?= $driver['d_id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <?php if (userpermission('lr_driver_edit')): ?>
                                    <a href="<?= base_url('drivers/editdriver?id=' . $driver['d_id']) ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (userpermission('lr_driver_delete')): ?>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteDriver(<?= $driver['d_id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </section>
</div>

<!-- Modal View Driver -->
<div class="modal fade" id="viewDriverModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Driver Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="driverDetails">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    // Initialize DataTable
    $('#driverTable').DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});

// View Driver
function viewDriver(id) {
    $.ajax({
        url: '<?= base_url("drivers/viewdriver") ?>',
        type: 'POST',
        data: { driver_id: id },
        success: function(response) {
            $('#driverDetails').html(response);
            $('#viewDriverModal').modal('show');
        }
    });
}

// Delete Driver
function deleteDriver(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("drivers/drivers_delete/") ?>' + id,
                type: 'POST',
                success: function(response) {
                    Swal.fire('Deleted!', 'Driver has been deleted.', 'success')
                        .then(() => location.reload());
                }
            });
        }
    });
}
</script>

<?= $this->include('layout/footer') ?>
```

---

## 9. HELPERS

### 9.1 Custom Helper

**Lokasi:** `app/Helpers/custom_helper.php`

Helper utama yang berisi fungsi-fungsi utilitas.

#### Functions:

| Function | Parameter | Return | Deskripsi |
|----------|-----------|--------|-----------|
| `xssclean($post)` | array | bool | Validasi input dari XSS |
| `output($data)` | mixed | string | Escape output HTML |
| `sitedata()` | - | array | Ambil konfigurasi website |
| `userpermission($link)` | string | bool | Cek hak akses user |
| `dateToString($date, $format)` | string, string | string | Konversi tanggal ke string |
| `capitalEachWord($value)` | string | string | Title case setiap kata |
| `capitalizeEachWord($value)` | string | string | Alias capitalEachWord |
| `pointInPolygon($point, $polygon)` | string, array | string | Cek titik dalam polygon |
| `pointOnVertex($point, $vertices)` | array, array | bool | Cek titik di vertex |
| `pointStringToCoordinates($pointString)` | string | array | Konversi string ke koordinat |

#### Implementasi:

```php
<?php

use CodeIgniter\Database\Database;

/**
 * Bersihkan input dari potensi XSS
 */
function xssclean($post) {
    $rtn = true;
    if ($post) {
        foreach ($post as $key => $data) {
            if (is_array($data)) {
                $rtn = xssclean($data);
                if (!$rtn) break;
            } else {
                if (preg_match("/</i", $data)) {
                    $rtn = false;
                }
            }
        }
    }
    return $rtn;
}

/**
 * Escape output HTML
 */
function output($data) {
    return isset($data) ? esc($data) : '';
}

/**
 * Ambil data konfigurasi dari tabel settings
 */
function sitedata() {
    $db = \Config\Database::connect();
    $builder = $db->table('settings');
    $query = $builder->get();
    $siteinfo = $query->getResultArray();
    
    return count($siteinfo) >= 1 ? $siteinfo[0] : [];
}

/**
 * Cek hak akses user terhadap suatu link
 */
function userpermission($link) {
    $permissions = session()->get('permissions');
    return is_array($permissions) && in_array($link, $permissions);
}

/**
 * Konversi tanggal ke string dengan format tertentu
 */
if (!function_exists('dateToString')) {
    function dateToString($date, $format = 'Y-m-d') {
        if (empty($date)) {
            return '-';
        }
        
        return date($format, strtotime($date));
    }
}

/**
 * Title Case per kata: huruf pertama tiap kata KAPITAL, sisa huruf kecil
 * Contoh: "JAWA BARAT" => "Jawa Barat"
 */
if (!function_exists('capitalEachWord')) {
    function capitalEachWord($value) {
        if ($value === null || $value === '') {
            return null;
        }
        
        return ucwords(strtolower($value));
    }
}

/**
 * Alias untuk capitalEachWord
 */
if (!function_exists('capitalizeEachWord')) {
    function capitalizeEachWord($value) {
        return capitalEachWord($value);
    }
}

/**
 * Cek apakah titik berada di dalam polygon
 * Return: "inside", "outside", "boundary", "vertex"
 */
function pointInPolygon($point, $polygon, $pointOnVertex = true) {
    $point = pointStringToCoordinates($point);
    $vertices = [];
    
    foreach ($polygon as $vertex) {
        $vertices[] = pointStringToCoordinates($vertex);
    }
    
    // Check if point is exactly on vertex
    if ($pointOnVertex && pointOnVertex($point, $vertices)) {
        return "vertex";
    }
    
    // Check if point is inside polygon
    $intersections = 0;
    $vertices_count = count($vertices);
    
    for ($i = 1; $i < $vertices_count; $i++) {
        $vertex1 = $vertices[$i - 1];
        $vertex2 = $vertices[$i];
        
        // Check if point is on horizontal boundary
        if ($vertex1['y'] == $vertex2['y'] &&
            $vertex1['y'] == $point['y'] &&
            $point['x'] > min($vertex1['x'], $vertex2['x']) &&
            $point['x'] < max($vertex1['x'], $vertex2['x'])) {
            return "boundary";
        }
        
        // Check if point is inside
        if ($point['y'] > min($vertex1['y'], $vertex2['y']) &&
            $point['y'] <= max($vertex1['y'], $vertex2['y']) &&
            $point['x'] <= max($vertex1['x'], $vertex2['x']) &&
            $vertex1['y'] != $vertex2['y']) {
            
            $xinters = ($point['y'] - $vertex1['y']) * 
                       ($vertex2['x'] - $vertex1['x']) / 
                       ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
            
            if ($xinters == $point['x']) {
                return "boundary";
            }
            
            if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                $intersections++;
            }
        }
    }
    
    return ($intersections % 2 != 0) ? "inside" : "outside";
}

/**
 * Cek apakah titik berada tepat di vertex
 */
function pointOnVertex($point, $vertices) {
    foreach ($vertices as $vertex) {
        if ($point == $vertex) {
            return true;
        }
    }
    return false;
}

/**
 * Konversi string titik ke koordinat array
 * Format input: "x y"
 */
function pointStringToCoordinates($pointString) {
    $coordinates = explode(" ", $pointString);
    return ["x" => $coordinates[0], "y" => $coordinates[1]];
}
```

### 9.2 Custom Tanggal Helper

**Lokasi:** `app/Helpers/custom_tanggal.php`

Helper untuk format tanggal.

```php
<?php

if (!function_exists('dateToString')) {
    /**
     * Konversi tanggal ke string dengan format tertentu
     * 
     * @param string $date   Tanggal dalam format apapun yang diterima strtotime()
     * @param string $format Format output (default: 'Y-m-d')
     * @return string        Tanggal terformat atau '-' jika kosong
     */
    function dateToString($date, $format = 'Y-m-d') {
        if (empty($date)) {
            return '-';
        }
        
        return date($format, strtotime($date));
    }
}
```

### 9.3 PDF Helper

**Lokasi:** `app/Helpers/pdf_helper.php`

Helper untuk generate PDF menggunakan Dompdf.

#### Functions:

| Function | Parameter | Return | Deskripsi |
|----------|-----------|--------|-----------|
| `renderPdf($view, $data, $filename, $download)` | string, array, string, bool | void | Render view ke PDF dan stream/download |
| `streamPdf($view, $data, $filename, $download)` | string, array, string, bool | ResponseInterface | Return PDF sebagai Response object |
| `pdf_local_image($relativePath)` | string | string/null | Resolve path untuk gambar di PDF |

#### Implementasi:

```php
<?php

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Render view jadi PDF dan langsung download/preview
 * 
 * @param string $view      Nama view
 * @param array  $data      Data untuk view
 * @param string $filename  Nama file output
 * @param bool   $download  true = download, false = inline (preview)
 */
function renderPdf(string $view, array $data = [], string $filename = 'document.pdf', bool $download = true) {
    // Increase limits untuk PDF besar
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 120);
    ini_set('pcre.backtrack_limit', '500000');
    
    // Load config
    $config = config('Pdf');
    
    // Setup Dompdf options
    $options = new Options();
    $options->set('defaultFont', $config->defaultFont);
    // PENTING: isRemoteEnabled HARUS false untuk menghindari deadlock
    // Gambar harus diakses via local path, bukan HTTP
    $options->set('isRemoteEnabled', false);
    $options->set('chroot', FCPATH);
    
    $dompdf = new Dompdf($options);
    unset($options);
    
    // Set paper
    $dompdf->setPaper($config->defaultPaperSize, $config->defaultPaperOrientation);
    
    // Margin dari config
    $style = "<style>@page { margin: {$config->marginTop}mm {$config->marginRight}mm {$config->marginBottom}mm {$config->marginLeft}mm; }</style>";
    unset($config);
    
    // Render view
    $html = view($view, $data);
    unset($data);
    
    $dompdf->loadHtml($style . $html);
    unset($html, $style);
    
    $dompdf->render();
    
    // Bersihkan output buffer
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    
    $dompdf->stream($filename, ["Attachment" => $download]);
    unset($dompdf);
}

/**
 * Generate PDF dan return sebagai CI4 Response object.
 * Kompatibel dengan semua browser termasuk mobile (Chrome Android, Safari iOS).
 * 
 * @param string $view      Nama view
 * @param array  $data      Data untuk view
 * @param string $filename  Nama file output
 * @param bool   $download  true = download (attachment), false = inline (preview)
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
function streamPdf(string $view, array $data = [], string $filename = 'document.pdf', bool $download = true): \CodeIgniter\HTTP\ResponseInterface {
    // Increase limits
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 120);
    ini_set('pcre.backtrack_limit', '500000');
    
    $config = config('Pdf');
    
    $options = new Options();
    $options->set('defaultFont', $config->defaultFont);
    $options->set('isRemoteEnabled', false);
    $options->set('chroot', FCPATH);
    
    $dompdf = new Dompdf($options);
    unset($options);
    
    $dompdf->setPaper($config->defaultPaperSize, $config->defaultPaperOrientation);
    
    $style = "<style>@page { margin: {$config->marginTop}mm {$config->marginRight}mm {$config->marginBottom}mm {$config->marginLeft}mm; }</style>";
    unset($config);
    
    $html = view($view, $data);
    unset($data);
    
    $dompdf->loadHtml($style . $html);
    unset($html, $style);
    
    $dompdf->render();
    
    $pdfOutput = $dompdf->output();
    unset($dompdf);
    
    // Bersihkan output buffer untuk menghindari binary corruption
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    
    $disposition = $download ? 'attachment' : 'inline';
    $safeFilename = rawurlencode($filename);
    
    $response = service('response');
    return $response
        ->setStatusCode(200)
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Transfer-Encoding', 'binary')
        ->setHeader('Content-Disposition', $disposition . '; filename="' . $filename . '"; filename*=UTF-8\'\'' . $safeFilename)
        ->setHeader('Content-Length', (string) strlen($pdfOutput))
        ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->setHeader('Pragma', 'no-cache')
        ->setHeader('Expires', '0')
        ->setHeader('Accept-Ranges', 'none')
        ->setHeader('X-Content-Type-Options', 'nosniff')
        ->setBody($pdfOutput);
}

/**
 * Resolve relative path ke absolute path untuk gambar di Dompdf
 * 
 * Dompdf TIDAK BOLEH fetch gambar via HTTP dari server yang sama
 * (deadlock risk). Selalu gunakan local path.
 * 
 * @param string $relativePath e.g. 'assets/uploads/survey/foto.jpg'
 * @return string|null Absolute path jika file exists, null otherwise
 */
function pdf_local_image(string $relativePath): ?string {
    if ($relativePath === '') {
        return null;
    }
    
    $path = FCPATH . ltrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $relativePath), DIRECTORY_SEPARATOR);
    $real = realpath($path);
    
    // Security check: pastikan file ada dalam FCPATH
    if ($real === false || stripos($real, realpath(FCPATH)) !== 0) {
        return null;
    }
    
    return is_file($real) ? $real : null;
}
```

---

## 10. FILTERS

### 10.1 LoginFilter

**Lokasi:** `app/Filters/LoginFilter.php`

Filter untuk autentikasi dan session timeout.

#### Implementasi:

```php
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{
    protected $timeout = 86400; // 24 jam dalam detik
    
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        
        // 1. Cek apakah sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // 2. Cek session timeout
        $lastActivity = $session->get('last_activity');
        $currentTime = time();
        
        if ($lastActivity && ($currentTime - $lastActivity > $this->timeout)) {
            $session->destroy();
            return redirect()->to('/login')
                             ->with('error', 'Sesi Anda berakhir, silakan login kembali.');
        }
        
        // 3. Update timestamp aktivitas terakhir
        $session->set('last_activity', $currentTime);
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Tidak ada action setelah request
    }
}
```

### 10.2 SecurityChecklist

**Lokasi:** `app/Filters/SecurityChecklist.php`

Filter untuk validasi keamanan tambahan.

#### Implementasi:

```php
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SecurityChecklist implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null) {
        // 1. XSS Check pada POST data
        if ($request->getMethod() === 'post') {
            $post = $request->getPost();
            if (!xssclean($post)) {
                return redirect()->back()
                                 ->with('error', 'Invalid characters detected in input.');
            }
        }
        
        // 2. Rate limiting (optional)
        // Implementation depends on requirements
        
        // 3. HTTPS check (production only)
        // if (ENVIRONMENT === 'production' && !$request->isSecure()) {
        //     return redirect()->to('https://' . $request->getServer('HTTP_HOST') . $request->getUri());
        // }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Add security headers
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
    }
}
```

### 10.3 Konfigurasi Filter

**Lokasi:** `app/Config/Filters.php`

```php
<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf' => \CodeIgniter\Filters\CSRF::class,
        'toolbar' => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'invalidchars' => \CodeIgniter\Filters\InvalidChars::class,
        'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
        'cors' => \CodeIgniter\Filters\Cors::class,
        'forcehttps' => \CodeIgniter\Filters\ForceHTTPS::class,
        'pagecache' => \CodeIgniter\Filters\PageCache::class,
        'performance' => \CodeIgniter\Filters\PerformanceMetrics::class,
        'login' => \App\Filters\LoginFilter::class,
        'securityChecklist' => \App\Filters\SecurityChecklist::class,
    ];
    
    public array $globals = [
        'before' => [
            'honeypot',
            'csrf',
            'invalidchars',
        ],
        'after' => [
            'toolbar',
            'honeypot',
        ],
    ];
    
    public array $methods = [
        'post' => ['csrf', 'login'],
        'get' => ['login'],
        'put' => ['csrf', 'login'],
        'delete' => ['csrf', 'login'],
    ];
    
    public array $filters = [
        'login' => [
            'before' => ['dashboard/*', 'drivers/*', 'vehicles/*', 'reports/*', 'settings/*'],
            'after' => [],
        ],
    ];
}
```

---

## 11. ROUTING

### 11.1 Konfigurasi Routes

**Lokasi:** `app/Config/Routes.php`

### 11.2 Route Groups

| Group | Prefix | Controller | Deskripsi |
|-------|--------|------------|-----------|
| Auth | `/login`, `/logout` | Login | Autentikasi |
| Dashboard | `/dashboard` | Dashboard | Halaman utama |
| Users | `/users/*` | Users | Manajemen user |
| Drivers | `/drivers/*` | Drivers | Modul supir |
| BAP | `/baps/*` | Drivers | Modul BAP |
| Surveys | `/surveys/*` | Drivers | Modul survey |
| Trainings | `/trainings/*` | Drivers | Modul training |
| Loans | `/loans/*` | Drivers | Modul pinjaman |
| Vehicles | `/vehicles/*` | Vehicle | Modul kendaraan |
| Inventory | `/inventory/*` | Vehicle | Modul inventaris |
| Handover | `/handover/*` | Vehicle | Modul serah terima |
| Reports | `/reports/*` | Reports | Modul laporan |
| Settings | `/settings/*` | Settings | Pengaturan |

### 11.3 Contoh Route Definition

```php
// Auth
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');

// Dashboard
$routes->get('/dashboard', 'Dashboard::index');

// Drivers
$routes->get('/drivers/drivers_management', 'Drivers::index');
$routes->match(['get', 'post'], 'drivers/adddrivers', 'Drivers::adddrivers');
$routes->post('drivers/insertdriver', 'Drivers::insertdriver');

// AJAX Routes
$routes->get('drivers/getRegencies/(:num)', 'Drivers::getRegencies/$1');
$routes->get('drivers/getDistricts/(:num)', 'Drivers::getDistricts/$1');
$routes->get('drivers/getVillages/(:num)', 'Drivers::getVillages/$1');

// Reports
$routes->match(['get', 'post'], 'reports/driver', 'Reports::driver');
$routes->match(['get', 'post'], 'reports/export_driver_excel', 'Reports::export_driver_excel');
$routes->match(['get', 'post'], 'reports/export_driver_pdf', 'Reports::export_driver_pdf');
```

---

## 12. LIBRARY & PACKAGE

### 12.1 Composer Dependencies

| Package | Versi | Fungsi |
|---------|-------|--------|
| `codeigniter4/framework` | ^4.6.1 | Framework utama |
| `dompdf/dompdf` | ^2.0 | Generate PDF |
| `phpoffice/phpspreadsheet` | ^1.29 | Generate Excel |
| `endroid/qr-code` | ^5.0 | Generate QR Code |
| `mpdf/mpdf` | ^8.2 | Alternative PDF generator |

### 12.2 NPM Dependencies

| Package | Fungsi |
|---------|--------|
| `admin-lte` | Admin template |
| `bootstrap` | CSS framework |
| `jquery` | JavaScript library |
| `select2` | Select dropdown enhancement |
| `sweetalert2` | Alert dialogs |
| `chart.js` | Chart library |
| `datatables.net` | Table management |
| `moment` | Date manipulation |

### 12.3 PDF Configuration

**Lokasi:** `app/Config/Pdf.php`

```php
<?php

namespace Config;

class Pdf
{
    public string $defaultFont = 'DejaVu Sans';
    public string $defaultPaperSize = 'A4';
    public string $defaultPaperOrientation = 'portrait';
    
    // Margins in mm
    public int $marginTop = 10;
    public int $marginRight = 10;
    public int $marginBottom = 10;
    public int $marginLeft = 10;
}
```

---

## 13. KEAMANAN

### 13.1 Authentication Flow

```
1. User submit login form
2. LoginModel::checkLogin() verify credentials
3. Session created with:
   - user_id
   - username
   - permissions (array of enabled flags)
   - logged_in = true
   - last_activity = timestamp
4. LoginFilter checks every request:
   - Is logged_in = true?
   - Is session still valid?
   - Update last_activity
```

### 13.2 Authorization (Permission System)

```php
// Total 108 permission flags di tabel login_roles
// Contoh permission flags:
$permissions = [
    'lr_driver_view',
    'lr_driver_add',
    'lr_driver_edit',
    'lr_driver_delete',
    'lr_vehicle_view',
    // ... dan seterusnya
];

// Cek permission di view/controller
if (userpermission('lr_driver_add')) {
    // Tampilkan tombol atau izinkan akses
}
```

### 13.3 Security Best Practices

| Aspek | Implementasi |
|-------|--------------|
| Password Hashing | `password_hash()` dengan bcrypt |
| XSS Prevention | `esc()` untuk output, `xssclean()` untuk input |
| CSRF Protection | CSRF filter aktif di semua POST request |
| Session Security | Timeout 24 jam, regenerate pada login |
| File Upload | Validasi tipe file, rename file, simpan di `writable/` |
| SQL Injection | Menggunakan Query Builder, tidak ada raw query |

### 13.4 File Upload Security

```php
// Validasi file upload
$validationRules = [
    'd_photo' => [
        'rules' => 'uploaded[d_photo]|max_size[d_photo,2048]|is_image[d_photo]|mime_in[d_photo,image/jpg,image/jpeg,image/png]',
        'errors' => [
            'uploaded' => 'File harus diupload',
            'max_size' => 'Ukuran file maksimal 2MB',
            'is_image' => 'File harus berupa gambar',
            'mime_in' => 'Format file harus JPG, JPEG, atau PNG'
        ]
    ]
];

// Rename file dengan random name
$photoName = $photo->getRandomName();

// Simpan di writable (bukan public)
$photo->move(WRITEPATH . 'uploads/drivers/', $photoName);
```

---

## 14. ERROR HANDLING

### 14.1 Common Errors

| Error | Penyebab | Solusi |
|-------|----------|--------|
| `404 Not Found` | Route tidak terdaftar | Cek `Routes.php` |
| `500 Internal Server Error` | Error PHP/database | Cek `writable/logs/` |
| `Session expired` | Timeout session | Login ulang |
| `Permission denied` | Tidak ada hak akses | Hubungi admin |
| `File not found` | Path file salah | Cek lokasi file |
| `SQL Error` | Query salah/tabel tidak ada | Cek migration |

### 14.2 Log Files

**Lokasi:** `writable/logs/`

```php
// Enable logging di .env
logger.default.handlers = ['file']

// Level: emergency, alert, critical, error, warning, notice, info, debug
log_threshold = 4 // Warning ke atas
```

### 14.3 Debug Mode

```php
// .env
CI_ENVIRONMENT = development  // Enable debug toolbar
CI_ENVIRONMENT = production   // Disable debug, show generic error page
```

### 14.4 Try-Catch Pattern

```php
try {
    $result = $this->driversModel->add_drivers($data);
    if ($result) {
        session()->setFlashdata('successmessage', 'Data berhasil disimpan');
        return redirect()->to('/drivers/drivers_management');
    }
} catch (\Exception $e) {
    log_message('error', 'Failed to add driver: ' . $e->getMessage());
    session()->setFlashdata('warningmessage', 'Terjadi kesalahan: ' . $e->getMessage());
    return redirect()->back()->withInput();
}
```

---

## 15. PANDUAN PENGEMBANGAN

### 15.1 Menambah Modul Baru

1. **Buat Migration**
```bash
php spark make:migration CreateTableNamamodul
```

2. **Buat Model**
```bash
php spark make:model NamamodulModel
```

3. **Buat Controller**
```bash
php spark make:controller Namamodul
```

4. **Tambah Route** di `app/Config/Routes.php`

5. **Buat Views** di `app/Views/namamodul/`

6. **Tambah Permission** di tabel `login_roles`

7. **Tambah Menu** di `app/Views/layout/sidebar.php`

### 15.2 Coding Standards

- **PSR-4** autoloading
- **PSR-12** coding style
- Gunakan **type hints** untuk PHP 8.1+
- **DocBlock** untuk setiap method
- **escape** semua output HTML

### 15.3 Git Workflow

```bash
# Feature branch
git checkout -b feature/nama-fitur

# Commit message format
git commit -m "feat: tambah modul baru"
git commit -m "fix: perbaiki bug login"
git commit -m "docs: update dokumentasi"
git commit -m "refactor: optimasi query"
git commit -m "style: format code"
git commit -m "test: tambah unit test"
```

### 15.4 Testing

```bash
# Run tests
php vendor/bin/phpunit

# Test specific file
php vendor/bin/phpunit tests/app/Models/DriversModelTest.php
```

### 15.5 Deployment Checklist

- [ ] Set `CI_ENVIRONMENT = production` di `.env`
- [ ] Disable debug toolbar
- [ ] Clear cache: `php spark cache:clear`
- [ ] Run migration: `php spark migrate`
- [ ] Check file permissions `writable/`
- [ ] Set proper database credentials
- [ ] Configure SMTP for emails
- [ ] Enable HTTPS

---

## APPENDIX

### A. Daftar Singkatan

| Singkatan | Kepanjangann |
|-----------|--------------|
| BAP | Berita Acara Pemeriksaan |
| NIS | Nomor Induk Supir |
| STNK | Surat Tanda Nomor Kendaraan |
| KIR | Kenderaan Bermotor Umum |
| QR | Quick Response |
| SSH | SiapSistemHub |

### B. Referensi

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [AdminLTE 3 Documentation](https://adminlte.io/docs/3.0/)
- [Dompdf Documentation](https://github.com/dompdf/dompdf)
- [PhpSpreadsheet Documentation](https://phpspreadsheet.readthedocs.io/)

---

**Dokumentasi ini dibuat untuk memudahkan developer baru dalam memahami dan mengembangkan sistem SiapSistemHub. Untuk pertanyaan lebih lanjut, silakan hubungi tim development.**

---

*End of Document*
