# Fix Bug: Upload Modul Training (PDF) Tidak Tersimpan ke Kolom `tr_document`

## Akar Masalah (Hasil Investigasi)

1. **[PRIMARY] Form Add Training tidak punya `enctype="multipart/form-data"`**
   - File: `app/Views/trainings/training_management.php:198`
   - Tanpa enctype, `$_FILES` kosong → `request->getFile('tr_document')` = null → `upload_modultraining()` return null → kolom `tr_document` tidak terisi.

2. **View mereferensikan variabel `$tainingdetails` yang tidak pernah dikirim controller**
   - Baris 276–292 (copy-paste dari view BAP). Berpotensi error/malformed HTML di modal Add.

3. **Permission salah**: input file dibungkus `userpermission('lr_drivers_edit_bapsolution')` (permission modul BAP, bukan training).

4. **php.ini `upload_max_filesize = 2M`** padahal pesan error controller menyebut "maksimal 5MB". PDF > 2MB gagal diam-diam (return null tanpa flash message).

5. **[Minor] Redirect salah** saat gagal upload: `trainings/training_management/{tr_id}` tidak terdaftar di Routes.php:75 → 404.

6. **[Minor, ditunda]** JS validation memakai ID salah (`addTrainingForm` vs `trainingForm`), dan bug edit modal (line 1811 `redirect()-to` typo, `edit_training()` model salah pemanggilan `table($tr_id)`).

---

## Rencana Eksekusi (Disetujui User: Step 1–5, php.ini ke 5M)

### Step 1 — Tambah enctype di form (WAJIB)
File: `app/Views/trainings/training_management.php:198`
```html
<form id="trainingForm" action="<?= base_url('drivers/inserttraining'); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
```

### Step 2 — Bersihkan blok input file di Add Modal (baris 271–298)
Ganti seluruh blok menjadi:
```php
<div class="form-group">
    <label class="form-label">Upload Modul Training (PDF) <span class="form-required" style="color:red;">*</span></label>
    <input type="file" name="tr_document" id="tr_document" class="form-control" accept=".pdf,application/pdf">
</div>
```
- Hapus semua referensi `$tainingdetails` dan hidden `existing_pdf` (tidak relevan untuk modal Add; `inserttraining()` sudah aman dengan `$oldPdf = null`).
- Hapus wrapper permission `lr_drivers_edit_bapsolution`.

### Step 3 — Perkuat validasi di `upload_modultraining()` (Drivers.php 1670–1705)
Tambah setelah cek mimeType:
```php
if ($file->getSize() > 5 * 1024 * 1024) {
    return false;
}
$ext = strtolower($file->getClientExtension());
if ($file->getMimeType() !== 'application/pdf' && $ext !== 'pdf') {
    return false;
}
```

### Step 4 — Perbaiki redirect gagal upload (Drivers.php:1740)
```php
return redirect()->to('drivers/traininglist_drivers');
```

### Step 5 — Ubah php.ini `upload_max_filesize` 2M → 5M
- Lokasi php.ini aktif Laragon akan dideteksi via `php --ini`.
- **User perlu restart Laragon/Apache secara manual setelahnya.**

---

## Verifikasi Setelah Eksekusi

1. Insert training baru + upload PDF valid → file muncul di `public/assets/uploads/training/` dan kolom `tr_document` terisi.
2. Upload non-PDF (mis. .docx) → flash warning "Format harus PDF...", tidak ada insert.
3. Upload PDF > 5MB → flash warning.
4. Insert tanpa file → training tetap tersimpan, `tr_document` kosong.
5. `DESCRIBE trainings;` → pastikan kolom `tr_document` VARCHAR(255) ada.

## Di Luar Scope (Ditunda)
- Step 6: dukung upload PDF di Edit Training modal + fix typo `redirect()-to` (line 1811) + fix `edit_training()` model (line 479).
- Fix JS validation ID `addTrainingForm` → `trainingForm` (line 784).
