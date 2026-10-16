<?php

use App\Models\AuditLog;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (AuditLog::count() === 0) {
            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Delete',
                'description' => 'Menghapus e-book Fisika Revisi',
                'subject_type' => 'Ebook',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subMinutes(15),
                'updated_at' => now()->subMinutes(15),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Create',
                'description' => 'Menambahkan e-book Ekonomi',
                'subject_type' => 'Ebook',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Update setting',
                'description' => 'Memperbarui identitas perpustakaan dan pengaturan laporan',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subHours(4),
                'updated_at' => now()->subHours(4),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Approve',
                'description' => 'Menyetujui komentar siswa pada e-book Matematika',
                'subject_type' => 'EbookComment',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Create',
                'description' => 'Menambahkan e-book Pendidikan Pancasila Revisi',
                'subject_type' => 'Ebook',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Delete',
                'description' => 'Menghapus e-book Kimia Edisi Lama',
                'subject_type' => 'Ebook',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Create',
                'description' => 'Menambahkan mata pelajaran Geografi (Kelas XI)',
                'subject_type' => 'Subject',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(3)->addHours(2),
                'updated_at' => now()->subDays(3)->addHours(2),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Create',
                'description' => 'Menambahkan kelas X',
                'subject_type' => 'ClassModel',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ]);

            AuditLog::create([
                'user_name' => 'Admin Perpustakaan',
                'action' => 'Login',
                'description' => 'Admin (Admin Perpustakaan) berhasil login ke sistem',
                'ip_address' => '127.0.0.1',
                'created_at' => now()->subDays(4)->addMinutes(5),
                'updated_at' => now()->subDays(4)->addMinutes(5),
            ]);
        }
    }

    public function down(): void
    {
        // Keep logs
    }
};
