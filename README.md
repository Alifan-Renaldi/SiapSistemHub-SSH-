# SiapSistemHub (SSH)

[![Bahasa Indonesia](https://img.shields.io/badge/lang-ID-blue)](#-bahasa-indonesia) [![English](https://img.shields.io/badge/lang-EN-green)](#-english)

Sistem manajemen armada & supir terintegrasi berbasis web — mencakup pengelolaan supir, kendaraan, dokumen BAP, survey, training, pinjaman, inventaris, serah terima aset, hingga laporan siap cetak (Excel/PDF).

---

## 🇮🇩 Bahasa Indonesia

### Apa itu SiapSistemHub?

**SiapSistemHub** adalah aplikasi internal untuk mengelola operasional armada perusahaan (trucking/logistik): mulai dari data supir & kendaraan, dokumen kecelakaan (BAP), survey lokasi, training supir, pinjaman supir, inventaris kendaraan, serah terima aset (ban/velg), insentif mekanik, sampai laporan yang bisa diekspor ke Excel dan PDF.

### Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | PHP ^8.1 · CodeIgniter 4.6.1 |
| Database | MySQL / MariaDB |
| Frontend | AdminLTE 3 (Bootstrap 4) · jQuery · Select2 · SweetAlert2 · Chart.js |
| Dokumen | dompdf (PDF) · PhpSpreadsheet (Excel) · endroid/qr-code (QR kendaraan) |
| Build | Vite · Tailwind CSS 4 (untuk aset tertentu) |

### 🔄 Flow Project

```
┌──────────┐     ┌─────────────┐     ┌──────────────────────┐
│  Login   │────▶│  Dashboard   │────▶│   Master Data        │
│ (auth +  │     │  (ringkasan, │     │ • User & Permission  │
│ session) │     │  reminder,   │     │   (per modul)        │
└──────────┘     │  grafik IE,  │     │ • Driver (aktif/     │
                 │  STNK/KIR    │     │   blacklist)         │
                 │  exp.)       │     │ • Vehicle (grup,     │
                 └──────┬───────┘     │   owner)             │
                        │             └──────────┬───────────┘
                        ▼                        │
             ┌─────────────────────┐            │
             │ Transaksi Operasional│◀───────────┘
             │ • BAP & BAP Pending │
             │ • Survey            │
             │ • Training          │
             │ • Loan (approval)   │
             │ • Inventory         │
             │ • Handover (ban/velg, TTD digital)
             └──────────┬──────────┘
                        ▼
             ┌─────────────────────┐      ┌──────────────────┐
             │ Dokumen & Cetak      │     │  Reports          │
             │ • QR kendaraan       │     │  • 8 jenis laporan│
             │ • Cetak BAP/Inventory│     │  • Export Excel/  │
             │ • PDF Handover       │     │    PDF            │
             └─────────────────────┘      └──────────────────┘
```

**Alur kerja singkat:** User login → dashboard menampilkan ringkasan (jumlah supir/kendaraan, reminder dokumen jatuh tempo, grafik income–expense) → admin mengelola master data → transaksi harian dicatat (BAP kecelakaan, survey, training, pinjaman, inventaris, serah terima) → dokumen dicetak/diunduh (QR, PDF) → manajemen memantau lewat menu **Reports** dan mengekspor ke Excel/PDF.

### ✨ Fitur

| Modul | Fitur |
|---|---|
| **Auth & User** | Login/logout, session timeout, manajemen user, granular permission (108 flag akses per modul) |
| **Dashboard** | Ringkasan jumlah data, reminder dokumen (STNK/KIR), grafik income–expense, daftar kendaraan & inventaris siap pakai |
| **Driver Management** | Data supir aktif, blacklist/inactive, hierarki wilayah (provinsi→kabupaten→kecamatan→desa, dinamis) |
| **BAP** | Berita Acara Pemeriksaan kecelakaan: daftar, pending, edit solusi, cetak PDF |
| **Survey** | Pencatatan survey lokasi/rute |
| **Training** | Riwayat training supir + modal detail training per supir |
| **Loan** | Pinjaman supir + alur approval + penandaan lunas |
| **Vehicle** | Master kendaraan, grup kendaraan, pemilik, **QR code** (view/download/print + label) |
| **Inventory** | Inventaris kendaraan + riwayat perubahan + cetak/PDF |
| **Handover** | Serah terima aset (merk ban & velg), tanda tangan digital di browser, export PDF |
| **Mechanic Incentive** | Insentif mekanik bengkel |
| **Reports** | 8 jenis laporan (driver, BAP, laka, survey, training, loan, vehicle, inventory, handover) — masing-masing export **Excel & PDF** |
| **Settings** | Pengaturan website (nama, logo), template email, konfigurasi SMTP |
| **Lain-lain** | Dark/Light theme, QR generator label kendaraan |

### 📸 Screenshot

| Halaman | Preview |
|---|---|
| Login | ![Login](docs/screenshots/01-login.png) |
| Dashboard | ![Dashboard](docs/screenshots/02-dashboard.png) |
| User Management | ![Users](docs/screenshots/03-users.png) |
| Driver List | ![Drivers](docs/screenshots/04-drivers.png) |
| Driver Inactive/Blacklist | ![Drivers Inactive](docs/screenshots/05-drivers-inactive.png) |
| BAP Management | ![BAP](docs/screenshots/06-bap.png) |
| BAP Pending | ![BAP Pending](docs/screenshots/07-bap-pending.png) |
| Survey | ![Survey](docs/screenshots/08-survey.png) |
| Training | ![Training](docs/screenshots/09-training.png) |
| Loan Management | ![Loan](docs/screenshots/10-loans.png) |
| Loan Approval | ![Loan Approve](docs/screenshots/11-loan-approve.png) |
| Vehicles | ![Vehicles](docs/screenshots/12-vehicles.png) |
| Vehicle Group | ![Vehicle Group](docs/screenshots/13-vehicle-group.png) |
| Vehicle Owner | ![Vehicle Owner](docs/screenshots/14-vehicle-owner.png) |
| Inventory | ![Inventory](docs/screenshots/15-inventory.png) |
| Handover | ![Handover](docs/screenshots/16-handover.png) |
| Handover Merk Ban | ![Merk Ban](docs/screenshots/17-handover-merkban.png) |
| Handover Merk Velg | ![Merk Velg](docs/screenshots/18-handover-merkvelg.png) |
| Mechanic Incentive | ![Incentive](docs/screenshots/19-incentive.png) |
| Report: Driver | ![Report Driver](docs/screenshots/20-report-driver.png) |
| Report: BAP | ![Report BAP](docs/screenshots/21-report-bap.png) |
| Report: Laka | ![Report Laka](docs/screenshots/22-report-laka.png) |
| Report: Survey | ![Report Survey](docs/screenshots/23-report-survey.png) |
| Report: Training | ![Report Training](docs/screenshots/24-report-training.png) |
| Report: Loan | ![Report Loan](docs/screenshots/25-report-loan.png) |
| Report: Vehicle | ![Report Vehicle](docs/screenshots/26-report-vehicle.png) |
| Report: Inventory | ![Report Inventory](docs/screenshots/27-report-inventory.png) |
| Report: Handover | ![Report Handover](docs/screenshots/28-report-handover.png) |
| Website Settings | ![Settings](docs/screenshots/29-settings.png) |
| Form Information | ![Form Info](docs/screenshots/30-form-info.png) |

### 🛠️ Instalasi

```bash
# 1. Clone
git clone https://github.com/Alifan-Renaldi/SiapSistemHub-SSH-.git
cd SiapSistemHub-SSH-

# 2. Install dependencies
composer install
npm install

# 3. Konfigurasi environment
cp env .env          # Windows: copy env .env
# Edit .env: app.baseURL, database.default.* (host, database, username, password)

# 4. Jalankan migration
php spark migrate

# 5. Jalankan server (pilih salah satu)
php spark serve      # http://localhost:8080
# atau gunakan Apache Laragon/XAMPP dan arahkan vhost ke folder /public
```

**Login pertama:** buat user pertama langsung via database (`users` + `login_roles`), atau seed sesuai kebutuhan tim.

### 📁 Struktur Penting

```
app/
├── Controllers/     # Login, Dashboard, Users, Drivers, Vehicle, Workshops, Reports, Settings
├── Models/          # UserModel, DriversModel, VehicleModel, ReportModel, dll
├── Views/           # baps, drivers, vehicles, inventory, handover, loans, reports, ...
├── Filters/         # LoginFilter (session timeout)
├── Helpers/         # custom_helper (userpermission), pdf_helper, custom_tanggal
└── Database/Migrations/
docs/screenshots/    # screenshot tiap halaman (dipakai README ini)
writable/            # logs, cache, session, uploads (runtime)
```

---

## 🇬🇧 English

### What is SiapSistemHub?

**SiapSistemHub** is an integrated web-based fleet & driver management system for trucking/logistics operations. It centralizes driver records (including accident reports/BAP, surveys, training, loans), vehicle administration (groups, owners, QR-coded assets, inventory, handover with digital signatures), mechanic incentives, and printable/exportable reports.

### Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP ^8.1 · CodeIgniter 4.6.1 |
| Database | MySQL / MariaDB |
| Frontend | AdminLTE 3 (Bootstrap 4) · jQuery · Select2 · SweetAlert2 |
| Documents | dompdf (PDF) · PhpSpreadsheet (Excel) · endroid/qr-code |
| Build | Vite · Tailwind CSS 4 |

### 🔄 Project Flow

1. **Authentication** — user logs in; a global `LoginFilter` guards every route (except login/assets) and enforces session timeout.
2. **Dashboard** — overview of counts, document expiry reminders (STNK/KIR/plat), income–expense chart, and ready-to-use vehicle/inventory lists.
3. **Master data** — admins manage **users** (with per-module **permissions**), **drivers** (active + blacklist), and **vehicles** (groups, owners, QR codes).
4. **Operational transactions** — BAP (accident reports), surveys, trainings, loans (with approval flow), inventory, and handover of vehicle parts (tires/rims) with in-browser digital signatures.
5. **Documents** — the system generates printable documents: vehicle QR labels, BAP PDFs, inventory & handover PDFs.
6. **Reporting** — every module has a report page with filters and export to **Excel** or **PDF**.

### ✨ Features

| Module | Highlights |
|---|---|
| **Auth & Users** | Session login, role/permission flags per module (108 permissions), user CRUD |
| **Dashboard** | Stat cards, today's reminders, income/expense chart, STNK/KIR expiry lists |
| **Drivers** | Active driver list, inactive/blacklist management, cascading region selects (province → regency → district → village) |
| **BAP** | Accident report (Berita Acara Pemeriksaan) lifecycle: draft → pending → final, print-ready PDF |
| **Survey** | Site/location survey records per driver |
| **Training** | Training history with clickable driver names opening a detail modal of all attended topics |
| **Loan** | Driver loans with approve/reject workflow and paid-off marking |
| **Vehicles** | Vehicle CRUD, groups, owners, QR code generation (view/download/print with label) |
| **Inventory** | Vehicle inventory + history tracking, printable/PDF |
| **Handover** | Asset handover (tire & rim brands), digital signature capture, PDF export |
| **Mechanic Incentive** | Workshop mechanic incentive records |
| **Reports** | Driver, BAP, Laka, Survey, Training, Loan, Vehicle, Inventory, Handover — each with Excel/PDF export |
| **Settings** | Site identity & logo, email template, SMTP configuration |
| **UI** | Dark/light theme toggle persisted per session |

### 📸 Screenshots

| Page | Preview |
|---|---|
| Login | ![Login](docs/screenshots/01-login.png) |
| Dashboard | ![Dashboard](docs/screenshots/02-dashboard.png) |
| Users | ![Users](docs/screenshots/03-users.png) |
| Drivers | ![Drivers](docs/screenshots/04-drivers.png) |
| Drivers Inactive | ![Drivers Inactive](docs/screenshots/05-drivers-inactive.png) |
| BAP | ![BAP](docs/screenshots/06-bap.png) |
| BAP Pending | ![BAP Pending](docs/screenshots/07-bap-pending.png) |
| Survey | ![Survey](docs/screenshots/08-survey.png) |
| Training | ![Training](docs/screenshots/09-training.png) |
| Loans | ![Loans](docs/screenshots/10-loans.png) |
| Loan Approval | ![Loan Approve](docs/screenshots/11-loan-approve.png) |
| Vehicles | ![Vehicles](docs/screenshots/12-vehicles.png) |
| Vehicle Group | ![Vehicle Group](docs/screenshots/13-vehicle-group.png) |
| Vehicle Owner | ![Vehicle Owner](docs/screenshots/14-vehicle-owner.png) |
| Inventory | ![Inventory](docs/screenshots/15-inventory.png) |
| Handover | ![Handover](docs/screenshots/16-handover.png) |
| Handover Tire Brands | ![Merk Ban](docs/screenshots/17-handover-merkban.png) |
| Handover Rim Brands | ![Merk Velg](docs/screenshots/18-handover-merkvelg.png) |
| Mechanic Incentive | ![Incentive](docs/screenshots/19-incentive.png) |
| Report: Driver | ![Report Driver](docs/screenshots/20-report-driver.png) |
| Report: BAP | ![Report BAP](docs/screenshots/21-report-bap.png) |
| Report: Laka | ![Report Laka](docs/screenshots/22-report-laka.png) |
| Report: Survey | ![Report Survey](docs/screenshots/23-report-survey.png) |
| Report: Training | ![Report Training](docs/screenshots/24-report-training.png) |
| Report: Loan | ![Report Loan](docs/screenshots/25-report-loan.png) |
| Report: Vehicle | ![Report Vehicle](docs/screenshots/26-report-vehicle.png) |
| Report: Inventory | ![Report Inventory](docs/screenshots/27-report-inventory.png) |
| Report: Handover | ![Report Handover](docs/screenshots/28-report-handover.png) |
| Settings | ![Settings](docs/screenshots/29-settings.png) |
| Form Information | ![Form Info](docs/screenshots/30-form-info.png) |

### 🛠️ Installation

```bash
git clone https://github.com/Alifan-Renaldi/SiapSistemHub-SSH-.git
cd SiapSistemHub-SSH-

composer install
npm install

cp env .env          # then edit baseURL + database credentials

php spark migrate

php spark serve      # http://localhost:8080
```

> Point your web server's document root to the `public/` folder in production.

---

## License

[MIT](LICENSE)
