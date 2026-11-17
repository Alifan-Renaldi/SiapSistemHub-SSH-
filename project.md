# Dokumentasi Teknis SiapSystemHub

**Versi:** 2.0-ringkas  
**Tanggal:** 19 Oktober 2026  
**Framework:** CodeIgniter 4.6.1  
**PHP:** ^8.1  
**Database:** MySQL/MariaDB

## 1. Tujuan Dokumen

Dokumen ini menjelaskan struktur aktual project, class, method, alur data, aturan bisnis, keamanan, dan titik integrasi utama. Daftar method diambil dari source code pada `app/`; method yang hanya disebut oleh route tetapi belum tersedia ditandai sebagai **belum diimplementasikan**.

## 2. Teknologi dan Dependensi

| Komponen | Penggunaan |
|---|---|
| CodeIgniter 4 | MVC, routing, request/response, session, validation, Query Builder |
| Dompdf | Pembuatan dan pengiriman PDF |
| PhpSpreadsheet | Export laporan Excel |
| endroid/qr-code | Pembuatan QR code kendaraan |
| Bootstrap/AdminLTE/jQuery | Antarmuka dan interaksi browser |
| Select2, SweetAlert2, DataTables | Dropdown, dialog, tabel interaktif |
| html2canvas | Mengubah tampilan survey menjadi gambar |

Dependensi Composer aktual berada di `composer.json`: CodeIgniter 4.6.1, Dompdf 3.1, endroid/qr-code, dan PhpSpreadsheet. PHPUnit tersedia untuk testing.

## 3. Arsitektur dan Alur Request

Aplikasi menggunakan MVC:

1. Request masuk melalui `app/Config/Routes.php`.
2. Filter autentikasi memeriksa session untuk route yang dilindungi.
3. Controller menerima input, menjalankan validasi, memanggil model, lalu memilih response.
4. Model memakai Query Builder untuk mengambil atau mengubah data database.
5. View merender HTML, tabel, form, modal, atau template PDF.
6. Response dikembalikan sebagai halaman, redirect, JSON, PDF, Excel, atau file.

Struktur utama:

```text
app/
├── Config/       konfigurasi dan routes
├── Controllers/  alur request dan business flow
├── Filters/      autentikasi serta pemeriksaan keamanan
├── Helpers/      fungsi utilitas global
├── Models/       akses database
└── Views/        halaman HTML dan template export
public/assets/   asset browser dan file training publik
writable/        cache, log, session, upload internal, QR code
vendor/          dependensi Composer
```

## 4. Class Controller

### 4.1 `BaseController`

File: `app/Controllers/BaseController.php`

Base class controller yang mewarisi `CodeIgniter\Controller`. `initController()` menjalankan inisialisasi parent dan menyediakan request, response, serta logger untuk controller turunan.

### 4.2 `Login`

File: `app/Controllers/Login.php`

- `index()` menampilkan form login dan meneruskan flash message error.
- `auth()` mengambil username/password, menolak input kosong, memanggil `LoginModel::checkLogin()`, memuat permission melalui `getUserRoles()`, lalu mengisi session `user_id`, `username`, `name`, `permissions`, `logged_in`, dan `last_activity`. Login gagal diarahkan kembali ke `/login`.
- `logout()` menghancurkan session dan mengarahkan user ke login.

### 4.3 `Dashboard`

File: `app/Controllers/Dashboard.php`

- `index()` mengambil statistik, reminder, data grafik income/expense, expiry kendaraan, kendaraan siap, dan inventaris siap dari `DashboardModel`, memformat tanggal expiry, kemudian merender view dashboard.
- `dateToString($date, $format)` mengubah tanggal menggunakan `strtotime()` dan mengembalikan `-` untuk nilai kosong.
- `setTheme()` menerima hanya `dark` atau `light`, menyimpannya di session, dan mengembalikan JSON. Nilai lain menghasilkan HTTP 400.

### 4.4 `Drivers`

File: `app/Controllers/Drivers.php`

Controller terbesar. Controller ini menangani driver, BAP, survey, training, dan loan. Constructor membuat `DriversModel`, `VehicleModel`, session, serta memuat helper form, URL, string, dan custom.

#### Method umum dan generator kode

- `__construct()` menyiapkan dependency dan helper.
- `index()` mengambil driver, menyaring status aktif, serta menyiapkan data loan, BAP, dan provinsi untuk view.
- `generateDriverCode($last_nis)` menghasilkan NIS dengan prefix periode tahun-bulan dan nomor urut.
- `generateBapCode($last_bcode, $created_at)` menghasilkan format `BAP/nomor/bulan-romawi/tahun`.
- `generateSurveyCode($last_scode, $created_at)` menghasilkan kode survey berurutan berdasarkan periode.
- `generateTrainingCode($last_trcode, $created_at)` menghasilkan kode training berurutan berdasarkan periode.
- `generateCode()` menyediakan response kode untuk kebutuhan AJAX/form.
- `getRegencies($province_id)`, `getDistricts($regency_id)`, dan `getVillages($district_id)` mengembalikan data wilayah dari model sebagai JSON.

#### Driver

- `adddrivers()` menampilkan form tambah driver.
- `insertdriver()` membaca POST, membuat NIS, mengisi audit user, memvalidasi serta memindahkan foto/dokumen, lalu menyimpan driver.
- `viewdriver()` mengambil detail berdasarkan ID dan mengembalikan fragment view untuk modal.
- `editdriver()` mengambil data driver dan menampilkan form edit.
- `updatedriver()` memvalidasi perubahan, mengganti file jika ada file baru, lalu memperbarui data.
- `drivers_delete($d_id)` menghapus driver dan file terkait melalui model.
- `inactivedriver()` menampilkan driver inactive/blacklist.
- `adddriversblacklist()` menampilkan form blacklist.
- `insertdriverblacklist()` membuat record driver blacklist.
- `viewdriver_inactive()` menampilkan detail driver inactive.
- `editdriverblacklist()` menampilkan form edit blacklist.
- `updatedriverblacklist()` memperbarui data blacklist.

#### BAP

- `baplists_drivers()` menampilkan semua BAP.
- `baplist_pending()` menampilkan BAP dengan status pending.
- `addbap()` menampilkan form tambah.
- `insertbap()` membuat kode BAP, memvalidasi data, menangani foto/dokumen, dan menyimpan record.
- `editbap()` mengambil BAP untuk diedit.
- `updatebap()` memperbarui BAP dan file terkait.
- `bap_delete()` menghapus BAP beserta file lama.
- `viewbap()` menampilkan detail BAP.
- `editbap_pending()` dan `updatebap_pending()` menangani alur khusus BAP pending. `updatebap_pending()` menormalisasi `b_tanggal_muat`, `b_tanggal_kejadian`, dan `b_tanggal`: nilai kosong, `'0000-00-00'`, atau `'1000-01-01'` disimpan sebagai `NULL`, sedangkan format `dd-mm-yyyy` dikonversi ke `Y-m-d`. Saat `b_tanggal` bernilai `NULL`, `b_is_status` diset `1` dan user diarahkan ke `baps/bap_pending`; saat tanggal terisi, `b_is_status` diset `0` dan user diarahkan ke `baps/bap_management`.
- `bap_pendingedit.php` menampilkan `b_tanggal_muat` dan `b_tanggal_kejadian` kosong saat nilai database `NULL`/`'0000-00-00'` (tidak lagi `01-01-1970`), dan memformat tanggal valid ke `dd-mm-yyyy` sesuai datepicker.
- `bappending_delete()` menghapus record pending.
- `viewbappending()` menampilkan detail BAP pending.
- `printbap($bap_id)` merender template cetak/PDF BAP.
- `deleteOldPhoto()`, `deleteOldPdf()`, `deleteOldDocumentBap()`, dan `deleteOldPdfBap()` membersihkan file lama.
- `generateDocumentBap()` membuat nama file aman berdasarkan nama driver, nomor BAP, dan ekstensi.
- `upload_documentbap()` serta `upload_pdfbap()` memvalidasi dan menyimpan upload BAP.

#### Survey

- `surveylist_drivers()` menampilkan daftar survey.
- `get_driver_surveydetails()` mengembalikan detail survey driver.
- `addsurvey()` menampilkan form tambah survey.
- `insertsurvey()` membuat kode survey, menyimpan data, dan menangani foto.
- `editsurvey()` menampilkan form edit.
- `updatesurvey()` memperbarui survey dan file terkait.
- `viewsurvey()` menampilkan detail survey.
- `survey_delete()` menghapus survey dan file dengan bantuan `deleteSurveyFiles()`.
- `printsurvey($survey_id)` menampilkan versi siap cetak, termasuk resolusi nama wilayah.
- `downloadSurveyPdf($survey_id)` membuat PDF satu survey menggunakan `streamPdf()`.
- `downloadSurveyImage($survey_id)` menampilkan wrapper yang ditangkap `html2canvas` di browser.
- `deleteSurveyFiles($surveyinfo)` menghapus asset survey yang tersimpan.

Data wilayah menggunakan API eksternal dengan cache lokal tujuh hari di `DriversModel`. Kegagalan API menggunakan stale cache agar halaman/PDF tetap dapat dirender.

#### Training

- `traininglist_drivers()` menampilkan daftar training.
- `addtraining()` menampilkan form tambah.
- `inserttraining()` memvalidasi data dan upload `tr_document` PDF maksimal 5 MB.
- `edittraining($tr_id)` mengambil training untuk diedit.
- `updatetraining()` mengganti data dan mempertahankan dokumen lama jika file baru tidak dikirim.
- `training_delete($tr_id)` menghapus training.
- `viewtraining($tr_id)` mengembalikan detail training sebagai JSON.
- `getDetailTrainingByDriver()` melayani AJAX riwayat training berdasarkan driver.
- `getDetailTrainingByTema()` melayani AJAX riwayat berdasarkan tema.
- `generateDocumentTraining()` membuat nama file uppercase yang aman dan dibatasi 255 karakter.
- `upload_modultraining()` membedakan tiga hasil: `null` jika tidak ada file, `false` jika invalid, atau nama file jika berhasil. File lama dihapus saat diganti.

#### Loan

- `loanlist_drivers()` menampilkan loan, dengan filter status dari parameter route jika tersedia.
- `loanlist_approve()` menampilkan loan untuk proses approval.
- `addloan()` menampilkan form tambah loan.
- `editloan()` mengambil loan untuk diedit.
- `viewloan()` menampilkan detail loan.

Route juga menunjuk `insertloan()`, `updateloan()`, `loan_delete()`, `mark_debt_paid()`, dan `update_loan_status()`, tetapi method tersebut tidak ditemukan dalam source `Drivers.php`. Route terkait akan gagal sampai method dibuat atau route dihapus.

### 4.5 `Vehicle`

File: `app/Controllers/Vehicle.php`

Menangani kendaraan, inventaris, dan serah-terima.

- `__construct()` membuat `VehicleModel`, `DriversModel`, session, dan helper.
- `index()` menampilkan kendaraan, grup, dan owner.
- `addvehicle()`, `editvehicle()`, `viewvehicle()`, `insertvehicle()`, `updatevehicle()`, `vehicle_delete()` menjalankan CRUD kendaraan.
- `view_qrcode()`, `download_qrcode()`, `print_qrcode()` menampilkan, mengunduh, atau mencetak QR kendaraan.
- `vehiclegroup()`, `addgroup()`, `vehiclegroup_delete()` mengelola grup.
- `vehicleowner()`, `addowner()`, `vehicleowner_delete()` mengelola owner.
- `generateAndSaveQrCode($vehicleId, $qrData)` membuat PNG QR dengan endroid, menyimpannya di `writable/uploads/qrcodes/vehicles/`, lalu mencatat path dan nama file ke database.
- `inventorylist_vehicle()`, `addinventory()`, `editinventory()`, `viewinventory()`, `insertinventory()`, `updateinventory()`, `inventory_delete()` menjalankan CRUD inventaris.
- `printinventory()` dan `downloadInventoryPdf()` menyediakan output inventaris.
- `handoverlist_vehicle()`, `addhandover()`, `edithandover()`, `viewhandover()`, `inserthandover()`, `updatehandover()`, `handover_delete()` menjalankan CRUD serah-terima.
- `viewhandoverinventory()`, `edithandoverinventory()`, dan `updateinventoryandproceed()` mengelola inventaris dalam proses serah-terima.
- `preview()`, `printhandover()`, dan `downloadHandoverPdf()` menangani preview/cetak/PDF.
- `save_signature()` menerima signature base64 dari canvas.
- `handovermerkban()`, `addhandovermerkban()`, `handovermerkban_delete()` mengelola merk ban.
- `handovermerkvelg()`, `addhandovermerkvelg()`, `handovermerkvelg_delete()` mengelola merk velg.
- `generateHdoCode()` dan `generateInvCode()` membuat nomor urut handover/inventaris.
- `saveBase64Photo()` serta `saveInventoryPhoto()` mendecode dan menyimpan foto.
- `deleteUploadedFiles()` dan `deleteUploadFiles()` membersihkan file terkait saat record dihapus.

Route `generate_qrcode_with_label` dan `generate_qrcode_preview` menunjuk method yang tidak tersedia di `Vehicle.php`.

### 4.6 `Reports`

File: `app/Controllers/Reports.php`

Constructor menyiapkan `DriversModel`, `VehicleModel`, `ReportModel`, session, dan helper URL.

- `driver()`, `bap()`, `laka()`, `survey()`, `training()`, `loan()`, `vehicle()`, `inventory()`, `handover()`, `jobdesc()` menerima filter request, memanggil report model, dan merender view laporan.
- `export_*_excel()` membuat workbook PhpSpreadsheet, menulis header/data, menerapkan style, lalu mengirim file `.xlsx`.
- `export_*_pdf()` mengambil data terfilter dan memanggil helper PDF.
- `resolveWilayahNames()` mengubah ID wilayah menjadi nama.
- `resolveWilayahNamesSurvey()` mendelegasikan resolusi survey ke `DriversModel`.

Jenis laporan: driver, BAP, laka, survey, training, loan, vehicle, inventory, handover, dan jobdesc KPI.

Laporan jobdesc (`jobdesc()`) memiliki dua filter dropdown (Nama Divisi dan Nama Karyawan yang diambil dari nilai DISTINCT tabel `jobdesc_kpi`) dan merender hasil sebagai satu card per karyawan — header card menampilkan nama karyawan dan divisi, body berisi tabel 2 kolom yang memuat Indikator 1–12 (kiri 1–6, kanan 7–12). Export `export_jobdesc_excel()` memakai kolom No | Nama Divisi | Nama Karyawan | Indikator 1..12; `export_jobdesc_pdf()` merender view `jobdesc/jobdesc_pdf`.

### 4.7 `Users`

File: `app/Controllers/Users.php`

- `__construct()` membuat `UserModel`, session, dan helper.
- `index()` menampilkan seluruh user.
- `adduser()` menampilkan form tambah.
- `insertuser()` membaca user dan permissions, lalu memanggil model untuk membuat user.
- `edituser($u_id)` mengambil user dan role untuk form edit.
- `updateuser()` memperbarui profil, melakukan bcrypt jika password baru diisi, lalu memperbarui permission.
- `deleteuser($u_id)` hanya menerima POST dan menghapus user melalui model.

### 4.8 `Settings`

File: `app/Controllers/Settings.php`

- `initController()` membuat koneksi database, session, dan helper.
- `websitesetting()` mengambil settings dan merender form.
- `websitesetting_save()` memvalidasi field wajib, memvalidasi logo JPG/JPEG/PNG maksimal 1 MB dan dimensi maksimal 250x250, lalu insert/update settings.
- `logodelete()` mengosongkan field logo dan mengembalikan JSON.

### 4.9 `Workshops`, `Development`, dan `Home`

- `Workshops::__construct()` menyiapkan model driver/kendaraan, session, dan helper.
- `Workshops::incentive_list()` hanya menampilkan `mechanics/incentive_management`.
- `Development::index()` menampilkan `form_information`.
- `Home::index()` menampilkan `welcome_message`.

`WorkshopModel` ada sebagai subclass `CodeIgniter\Model`, tetapi belum mendefinisikan method atau konfigurasi tabel.

### 4.10 `Jobdescs`

File: `app/Controllers/Jobdescs.php`

Menangani modul Jobdesc KPI. Constructor membuat `JobdescModel`, session, serta helper form/url.

- `kpi_list()` menampilkan data KPI lengkap (sudah dinilai) ke `jobdesc/kpi_management`.
- `kpi_nilai_list()` menampilkan data KPI yang belum lengkap (belum dinilai) ke `jobdesc/kpi_nilai_management`.
- `add_indikator()` menampilkan form kosong; `edit_indikator($jk_id)` menampilkan form mode edit.
- `insert_indikator()` memvalidasi indikator (berurutan dari 1, minimal 5 maksimal 12, pasangan detail+bobot lengkap, bobot 1–100, Σ bobot = 100), membagi bobot dengan 100, lalu menyimpan.
- `update_indikator()` memperbarui indikator/bobot (dan nilai bila record sudah bernilai) serta menghitung ulang total/status.
- `add_nilai($jk_id)` menampilkan form isi nilai; `insert_nilai()` memvalidasi nilai 1–100 untuk indikator terisi, menghitung konversi (`nilai × bobot`), total, dan status.
- `view_kpi($jk_id)` dan `view_kpi_nilai($jk_id)` menampilkan detail record.
- `kpi_delete($jk_id)` menghapus record (hanya POST).
- `validasi_indikator_input()` adalah helper validasi bersama untuk input indikator/bobot.

## 5. Class Model

### `LoginModel`

File: `app/Models/LoginModel.php`, tabel `users`.

- `checkLogin($username, $password)` mencari username dan memeriksa hash memakai `password_verify()`.
- `getUserRoles($userId)` mengambil satu row `login_roles`, lalu mengubah setiap field `lr_*` bernilai `1` menjadi array permission.

### `UserModel`

File: `app/Models/UserModel.php`, tabel `users` dan `login_roles`.

- `getall_user()` mengambil user terbaru.
- `get_userdetails($u_id)` melakukan join user dengan role.
- `add_user($userData, $roleData)` bcrypt password, insert user, mengambil ID baru, lalu insert role.
- `update_user($u_id, $userData, $roleData)` update user dan update/insert role.
- `user_delete($u_id)` memulai transaksi, menghapus role dan user, commit jika sukses, rollback jika gagal.

### `DriversModel`

File: `app/Models/DriversModel.php`.

#### Wilayah

- `fetchData($endpoint)` membaca cache tujuh hari, request API dengan timeout, menyimpan response valid, lalu memakai stale cache jika API gagal.
- `getProvinces()`, `getRegencies()`, `getDistricts()`, `getVillages()` mengambil data wilayah.
- `getProvinceName()`, `getRegencyName()`, `getDistrictName()`, `getVillageName()` melakukan resolusi ID ke nama.
- `resolveWilayahNamesSurvey($rows)` menambahkan nama provinsi/kota/kecamatan/kelurahan ke setiap row.

#### Data driver dan BAP

- `get_driver_by_nis()`, `getall_drivers()`, `getDriversById()`, `get_driverdetails()` mengambil data driver.
- `add_drivers()`, `edit_driver()`, `drivers_delete()` menjalankan perubahan driver.
- `get_last_nis()` mengambil kode terakhir; `generateDriverCode()` menghasilkan kode berikutnya.
- `get_driver_inactive_blacklist()`, `insert_driversblacklist()`, `edit_driverblacklist()` menangani blacklist.
- `get_last_bcode()`, `getBap()`, `get_bap()`, `get_bapdetails()`, `get_baps_by_nis()`, `getBapById()`, `get_bap_date()`, `get_bap_by_date()` mengambil data BAP.
- `add_bap()`, `edit_bap()`, `editpending_bap()`, `bap_delete()` mengubah data BAP.
- `deleteOldPhoto()` dan `deleteOldPdf()` menghapus dokumen lama.

#### Data survey, training, loan

- `get_survey()`, `getSurveyById()`, `get_surveydetails()`, `get_survey_by_nis()`, `get_driver_survey()` mengambil survey.
- `add_survey()`, `edit_survey()`, `survey_delete()` mengubah survey.
- `get_last_scode()` dan `generateSurveyCode()` menangani kode survey.
- `get_training()`, `get_trainingdetails()`, `get_training_by_nis()` mengambil training.
- `add_training()`, `edit_training()`, `training_delete()` mengubah training.
- `get_last_trcode()` dan `generateTrainingCode()` menangani kode training.
- `getTrainingsByDriver()`, `countTrainingsByDriver()`, `getTrainingsByTema()`, `countTrainingsByTema()` mendukung modal AJAX dan ringkasan training.
- `get_last_lcode()`, `get_loan()`, `get_loandetails()`, `get_loan_bystatus()`, `getLoanById()`, `get_loan_by_nis()`, `get_combined_loan_bap()` mengambil loan/kombinasi data.
- `add_loan()`, `edit_loan()`, `update_loan_status()` mengubah loan.
- `get_all_baps_by_nis()` mengambil seluruh BAP driver.

### `VehicleModel`

File: `app/Models/VehicleModel.php`.

- `getall_vehicle()`, `get_vehicledetails()`, `get_last_vcode()`, `vehicle_delete()`, `getall_bookings()` menangani kendaraan dan perjalanan.
- `get_distinct_owners()`, `get_distinct_types()`, `get_vehiclegroup()`, `vehiclegroup_delete()`, `get_vehicleowner()`, `vehicleowner_delete()` menangani master kendaraan.
- `get_last_ivcode()`, `insert_inventory()`, `getInventory()`, `get_inventory_columns()`, `get_distinct_inventory_data()`, `get_inventorydetails()`, `update_inventory()`, `inventory_delete()`, `getInventoryById()` menangani inventaris.
- `get_last_hocode()`, `getHandover()`, `get_distinct_handover_vehicles()`, `get_handoverdetails()`, `getHandoverById()`, `get_handover_by_hocode()`, `add_handover()`, `edit_handover()`, `handover_delete()` menangani serah-terima.
- `get_distinct_merk_ban()`, `get_handovermerkban()`, `handovermerkban_delete()`, `get_handovermerkvelg()`, `handovermerkvelg_delete()` menangani master merk.

### `DashboardModel`

File: `app/Models/DashboardModel.php`.

- `getDashboardCounts()` menghitung statistik lintas tabel.
- `getDriverStatusCounts()` menghitung jumlah supir per status untuk pie chart "Status Supir": Aktif (`d_is_active` 1 dan 3), Inactive (`0`), dan Blacklist (`2`).
- `get_driverdetails()` mengambil driver untuk dashboard.
- `get_todayreminder()`, `get_reminders_yellow()`, `get_reminders_red()` mengambil reminder berdasarkan tanggal dan tingkat urgensi.
- `get_iechartdata()` membentuk data grafik income/expense.
- `get_vechicle_currentlocation()` dan `getvechicle_status()` mengambil posisi/status kendaraan.
- `get_vehicle_expdate()` mengambil expiry dokumen kendaraan.
- `get_vehicle_ready_list()` dan `get_inventory_ready_list()` mengelompokkan data siap pakai.
- `createDateRangeArray()` membuat rentang tanggal inklusif.
- `getaddress()` melakukan reverse geocoding dari latitude/longitude.

### `ReportModel`

File: `app/Models/ReportModel.php`.

Method `driver_reports()`, `bap_reports()`, `laka_reports()`, `survey_reports()`, `training_reports()`, `vehicle_reports()`, `inventory_reports()`, `handover_reports()`, dan `jobdesc_reports()` menyusun Query Builder berdasarkan filter tanggal, nama, status, kendaraan, driver, dan parameter modul. Query hanya mengembalikan data yang sesuai filter untuk controller laporan. `jobdesc_reports($divisi, $karyawan)` memfilter tabel `jobdesc_kpi` berdasarkan `jk_divisi` dan `jk_nama_karyawan`.

Method `loan_reports()` terdapat sebagai rancangan/commented code dan bukan method aktif.

### `JobdescModel`

File: `app/Models/JobdescModel.php`, tabel `jobdesc_kpi`.

- `getall_kpi_lengkap()` dan `getall_kpi_pending()` memisahkan record KPI berdasarkan kelengkapan nilai (`isLengkap()`).
- `get_kpi_detail($jk_id)` mengambil satu record berdasarkan ID.
- `isLengkap($row)` memeriksa bahwa seluruh indikator terisi telah memiliki nilai.
- `hitungJumlahTerisi($row)`, `hitungKonversi($nilai, $bobot)`, `hitungStatus($total)`, dan `statusBadgeClass($status)` menangani perhitungan dan label status KPI.
- `insert_indikator()`, `insert_nilai()`, `update_indikator()`, dan `kpi_delete()` menjalankan perubahan data.
- `get_distinct_divisi()` dan `get_distinct_karyawan()` mengambil nilai unik kolom `jk_divisi` dan `jk_nama_karyawan` untuk dropdown filter report.

### `WorkshopModel`

File: `app/Models/WorkshopModel.php`. Class kosong tanpa method aktif, konfigurasi tabel, atau business logic.

## 6. Helper

### `custom_helper.php`

- `xssclean($post)` memeriksa array secara rekursif dan menolak nilai yang mengandung karakter `<`.
- `output($data)` melakukan escaping HTML menggunakan `esc()`.
- `sitedata()` mengambil row pertama dari tabel settings.
- `userpermission($link)` memeriksa permission pada session.
- `dateToString()` memformat tanggal atau mengembalikan `-`.
- `capitalEachWord()` dan `capitalizeEachWord()` melakukan title case.
- `pointStringToCoordinates()` mengubah string `x y` menjadi array koordinat.
- `pointOnVertex()` memeriksa kesamaan titik dengan vertex.
- `pointInPolygon()` memakai metode ray intersection dan mengembalikan `inside`, `outside`, `boundary`, atau `vertex`.
- `dateTimeFormat()` memformat timestamp dan menangani tanggal kosong/invalid.

### `custom_tanggal.php`

Menyediakan `dateToString()` dengan deklarasi bersyarat. Fungsinya sama dengan helper tanggal di `custom_helper.php`.

### `pdf_helper.php`

- `renderPdf($view, $data, $filename, $download)` membuat Dompdf, memuat view, merender, lalu stream langsung.
- `streamPdf($view, $data, $filename, $download)` merender PDF dan mengembalikan `ResponseInterface` dengan header PDF, Content-Disposition, panjang content, dan cache-control.
- `pdf_local_image($relativePath)` mengubah path relatif menjadi path lokal aman. Fungsi menolak file yang berada di luar `FCPATH`.

Konfigurasi PDF aktual: Arial, A4 portrait, DPI 96, cache `writable/cache`, margin atas 5 mm, kanan 3 mm, bawah 2 mm, kiri 2 mm.

## 7. Filter dan Keamanan

### `LoginFilter`

File: `app/Filters/LoginFilter.php`.

- `before()` menolak session tanpa `logged_in`, memeriksa timeout 86400 detik, menghancurkan session yang kedaluwarsa, dan memperbarui `last_activity` setiap request.
- `after()` tidak melakukan transformasi response.

### `SecurityChecklist`

File: `app/Filters/SecurityChecklist.php`.

- `before()` memeriksa environment. Saat production, filter mengecek CSRF, HttpOnly cookie, secure cookie ketika HTTPS, HTTPS aktif, dan potensi exposure `.env`. Temuan ditulis ke log warning/critical; method ini tidak menghentikan request.
- `after()` menambahkan `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, dan Content-Security-Policy.

Pengamanan aplikasi juga memakai password hash bcrypt, Query Builder, CSRF filter, escaping output, validasi upload, random filename, session timeout, dan permission berbasis field `lr_*`.

## 8. Routing

File: `app/Config/Routes.php`.

| Area | Prefix | Controller |
|---|---|---|
| Auth | `/`, `/login`, `/logout` | Login |
| Dashboard | `/dashboard`, `/theme` | Dashboard |
| User | `/users/*` | Users |
| Settings | `/settings/*` | Settings |
| Driver | `/drivers/*` | Drivers |
| BAP | `/baps/*` | Drivers |
| Survey | `/surveys/*` | Drivers |
| Training | `/trainings/*` | Drivers |
| Loan | `/loans/*` | Drivers |
| Vehicle | `/vehicles/*`, `/vehicle/*` | Vehicle |
| Inventory | `/inventory/*` | Vehicle |
| Handover | `/handover/*` | Vehicle |
| Jobdesc | `/jobdesc/*` | Jobdescs |
| Reports | `/reports/*` | Reports |
| Mechanics | `/mechanics/*` | Workshops/Vehicle |
| Development | `/form_information` | Development |

Route menggunakan `get`, `post`, dan `match(['get','post'], ...)`. Tidak terdapat route group formal. Sebelum menambah endpoint, pastikan method controller benar-benar tersedia.

Route yang saat ini berpotensi tidak aktif karena target method tidak ada:

- `Drivers::insertloan`, `updateloan`, `loan_delete`, `mark_debt_paid`, `update_loan_status`.
- `Vehicle::generate_qrcode_with_label`, `generate_qrcode_preview`.
- `Workshops::addincentive`, `viewincentive`, `insertincentive`, `updateincentive`.
- Route mechanics tertentu juga menunjuk `Vehicle::editincentive` dan `Vehicle::incentive_delete` yang tidak tersedia.

## 9. View dan UI

View dibagi menjadi:

- Root: login, dashboard, welcome, form information, 404.
- `layout/`: header, sidebar, footer.
- `drivers/`: management, add, view, inactive, blacklist, PDF.
- `baps/`: management, pending, add/edit/view, print, PDF, laka PDF.
- `surveys/`: management, add/edit/view, print, single PDF, collective PDF, image capture.
- `trainings/`: management dan PDF.
- `loans/`: management, add, view, approval, PDF.
- `vehicles/`: management, add/view, group, owner, QR label, print, PDF.
- `inventory/`: management, add/view, print, PDF, data PDF.
- `handover/`: management, add/view/edit inventory, preview, master merk, print, PDF.
- `jobdesc/`: KPI management, KPI nilai management, add indikator/nilai, view detail, dan PDF report.
- `reports/`: satu view per jenis laporan (termasuk `report_jobdesc.php`).
- `mechanics/`, `users/`, `settings/`: view masing-masing modul.

Pola UI utama adalah layout header/sidebar/footer, permission check pada menu/tombol, modal AJAX untuk detail, SweetAlert2 untuk konfirmasi, DataTables untuk tabel, dan Select2 untuk pilihan bertingkat.

Training menggunakan `multipart/form-data`; survey dapat dicetak lewat browser, diubah menjadi gambar dengan `html2canvas`, atau diunduh sebagai PDF.

## 10. Database dan Status Bisnis

Tabel inti: `users`, `login_roles`, `drivers`, `baps`, `surveys`, `trainings`, `loans`, `vehicles`, `inventory`, `handover`, `jobdesc_kpi`, `settings`.

Status penting:

- Driver: `d_is_active` membedakan aktif, inactive, blacklist, dan kombinasi inactive-blacklist.
- BAP: `pending` atau `completed`.
- Loan: `pending`, `approved`, `rejected`, atau `paid`.
- Vehicle: `v_is_active` menentukan kendaraan aktif.

Relasi utama menggunakan ID/NIS driver dan nomor polisi kendaraan. Beberapa data denormalisasi, seperti nama driver atau nomor polisi, disimpan langsung pada tabel transaksi agar mudah ditampilkan di laporan.

## 11. Flow Fitur Utama

### Login

`POST /login/auth` → validasi input → cek hash password → ambil permission → set session → redirect dashboard. Login gagal memakai flash error.

### Driver

Form → validasi dan upload → generate NIS → simpan model → flash message → redirect list. Update mempertahankan file lama jika file baru tidak diberikan.

### Training detail AJAX

Klik nama driver → POST dengan CSRF ke `trainings/getDetailByDriver` → model query berdasarkan driver → controller mengembalikan JSON → JavaScript merender modal, loading, empty, atau error state.

### QR kendaraan

Simpan kendaraan → bentuk payload QR → `endroid/qr-code` membuat PNG → file disimpan → path dicatat ke database → user dapat view/download/print.

### Export

Filter form → controller memanggil `ReportModel` → data diteruskan ke template PDF atau spreadsheet → response dikirim sebagai inline PDF/download atau `.xlsx`.

### PDF gambar lokal

Template menggunakan `pdf_local_image()` agar Dompdf membaca path lokal. Remote image dinonaktifkan melalui konfigurasi untuk mencegah request eksternal dan masalah deadlock.

## 12. Pengembangan dan Verifikasi

Perintah yang tersedia:

```bash
php spark routes
php spark cache:clear
php vendor/bin/phpunit
```

Alur penambahan modul:

1. Buat migration.
2. Buat model dan method query.
3. Buat controller dan validasi input.
4. Tambahkan route.
5. Buat view dan permission.
6. Tambahkan test untuk logic non-trivial.
7. Uji route, form, upload, permission, dan export.

Checklist sebelum deployment:

- Set environment production.
- Pastikan kredensial database tidak masuk repository.
- Aktifkan HTTPS dan cookie aman.
- Pastikan `writable/` dapat ditulis tetapi tidak mengekspos file sensitif.
- Jalankan route check dan PHPUnit.
- Periksa `writable/logs/` setelah smoke test.

## 13. Lokasi Referensi Cepat

| Kebutuhan | File |
|---|---|
| Route | `app/Config/Routes.php` |
| Login | `app/Controllers/Login.php`, `app/Models/LoginModel.php` |
| Auth filter | `app/Filters/LoginFilter.php` |
| Driver/BAP/survey/training/loan | `app/Controllers/Drivers.php` |
| Vehicle/inventory/handover | `app/Controllers/Vehicle.php` |
| Report export | `app/Controllers/Reports.php`, `app/Models/ReportModel.php` |
| Global helper | `app/Helpers/custom_helper.php` |
| PDF | `app/Helpers/pdf_helper.php`, `app/Config/Pdf.php` |
| Permission | `login_roles`, `userpermission()` |
| Error log | `writable/logs/` |

Dokumen ini sengaja berfokus pada implementation aktual dan menghindari rincian database/view yang berulang. Untuk detail field atau markup tertentu, baca model/view terkait langsung.
