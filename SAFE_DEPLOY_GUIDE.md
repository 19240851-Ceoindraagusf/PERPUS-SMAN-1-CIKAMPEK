# Panduan Deploy Aman untuk Database

## Aturan utama

- Jangan pernah menjalankan `php artisan migrate:fresh` di database produksi.
- Jangan pernah menjalankan `php artisan db:wipe` di database produksi.
- Jangan menjalankan restore tanpa konfirmasi eksplisit dan parameter `-Force`.
- Selalu backup sebelum update, perubahan schema, atau upload data besar.
- Jangan menjalankan `php artisan test` sebelum memastikan test memakai database `*_testing` atau SQLite `:memory:`.
- Pastikan `APP_ALLOW_DESTRUCTIVE_MIGRATIONS=false` tetap aktif.
- Gunakan maintenance mode saat deploy.

## Backup database

PowerShell:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\backup-db.ps1
```

Backup otomatis Laravel juga tersedia melalui command:

```powershell
php artisan backup:database
```

Skrip backup memeriksa hasil dump sebelum menyatakan backup berhasil dan menyimpan salinan kedua di folder `Documents\PerpusBackups`.

## Restore database

Restore destruktif harus disetujui secara eksplisit:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\restore-db.ps1 -BackupFile .\backups\perpus_digital_sman1_cikampek_2026-09-28_132129.sql -Force
```

Sistem akan menampilkan permintaan konfirmasi untuk memastikan Anda benar-benar ingin menghapus database lama.

## Proses upgrade aman

1. Jalankan `git pull` atau upload update kode.
2. Jalankan `composer install --no-interaction --prefer-dist` bila ada perubahan dependency.
3. Jalankan skrip berikut; skrip ini membuat backup tervalidasi, mengaktifkan maintenance mode, menjalankan migrasi, lalu membuka website kembali:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\update-with-backup.ps1
```

4. Cek data pengguna, kelas, subject, dan e-book setelah update.
5. Simpan backup di lokasi aman di luar folder project bila memungkinkan.

## Pengaman test

Konfigurasi test memakai `perpus_digital_sman1_cikampek_testing`. Selain itu, bootstrap test akan membatalkan seluruh test bila database bukan SQLite `:memory:` atau nama database yang diakhiri `_testing`. Dengan begitu, `RefreshDatabase` tidak dapat lagi menghapus data perpustakaan utama.

## Jika ada masalah

- Kembalikan database dari backup terakhir secara eksplisit
- Jalankan `php artisan migrate` ulang jika diperlukan
- Jangan menghapus data sebelum restore selesai
- Jangan pernah menjalankan restore tanpa konfirmasi manual

## Catatan penting

- Backup harus disimpan di tempat lain dari server utama.
- Simpan salinan backup ke cloud atau hard drive eksternal.
- Jangan hanya menyimpan backup di folder lokal project.
- File backup lama harus dibersihkan secara berkala agar ruang tidak habis.
