# Panduan Deploy Aman untuk Database

## Aturan utama

- Jangan pernah menjalankan `php artisan migrate:fresh` di database produksi.
- Jangan pernah menjalankan `php artisan db:wipe` di database produksi.
- Jangan menjalankan restore tanpa konfirmasi eksplisit dan parameter `-Force`.
- Selalu backup sebelum update, perubahan schema, atau upload data besar.
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

## Restore database

Restore destruktif harus disetujui secara eksplisit:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\restore-db.ps1 -BackupFile .\backups\perpus_digital_sman1_cikampek_2026-09-28_132129.sql -Force
```

Sistem akan menampilkan permintaan konfirmasi untuk memastikan Anda benar-benar ingin menghapus database lama.

## Proses upgrade aman

1. Backup database
2. Pastikan file backup valid
3. Jalankan `php artisan down`
4. Jalankan `git pull` atau upload update
5. Jalankan `composer install --no-interaction --prefer-dist`
6. Jalankan `php artisan migrate`
7. Jalankan `php artisan optimize:clear`
8. Jalankan `php artisan up`
9. Cek data pengguna, kelas, subject, ebook setelah update
10. Simpan backup di lokasi aman di luar folder project bila memungkinkan

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
