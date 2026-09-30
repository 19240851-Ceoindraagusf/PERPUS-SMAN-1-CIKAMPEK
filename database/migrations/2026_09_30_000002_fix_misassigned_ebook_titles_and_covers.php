<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->updateEbooks('X', 'Matematika', ['title' => 'Matematika']);
        $this->updateEbooks('X', 'Informatika', ['title' => 'Informatika']);
        $this->updateEbooks('XI', 'Informatika', ['title' => 'Informatika']);

        $this->updateEbooks('XI IPA', 'Biologi', [
            'title' => 'Biologi',
            'cover_path' => 'covers/2L3Z2KGruKrHSjmJHOfT7ifnJ8uDOhIk4oGPzFNx.jpg',
        ]);
        $this->updateEbooks('XI IPA', 'Fisika', [
            'title' => 'Fisika',
            'cover_path' => 'covers/9DoIMQMPbYZNq7RnLoN96Ul9OfGGQ3Wg4r5jNKFU.jpg',
        ]);
        $this->updateEbooks('XI IPA', 'Kimia', [
            'title' => 'Kimia',
            'cover_path' => 'covers/EHmpqvcxnXv8L2ns7QVXoghtIKOsnlD1OLrdmwX8.jpg',
        ]);

        $this->updateEbooks('XI IPS', 'Ekonomi', [
            'title' => 'Ekonomi',
            'cover_path' => 'covers/1p9nVdXuD7Ft6PFcbGzJl8U27LWadm1om5O9gWRg.jpg',
        ]);
        $this->updateEbooks('XI IPS', 'Geografi', [
            'title' => 'Geografi',
            'cover_path' => 'covers/FtglXXll84jGqOtACUEwaeOWOI3pnogNOgow4YUE.jpg',
        ]);
        $this->updateEbooks('XI IPS', 'Sosiologi', [
            'title' => 'Sosiologi',
            'cover_path' => 'covers/W19PDO8cu6ml1K6Up65eSc9sRWIutx5pP83TiEaU.jpg',
        ]);
    }

    public function down(): void
    {
        // Perubahan ini memperbaiki data yang salah sehingga tidak dibalik otomatis.
    }

    private function updateEbooks(string $className, string $subjectName, array $attributes): void
    {
        $subjectId = DB::table('subjects')
            ->join('classes', 'classes.id', '=', 'subjects.class_id')
            ->where('classes.name', $className)
            ->whereRaw('LOWER(subjects.name) = ?', [mb_strtolower($subjectName)])
            ->value('subjects.id');

        if (! $subjectId) {
            return;
        }

        DB::table('ebooks')
            ->where('subject_id', $subjectId)
            ->update(array_merge($attributes, ['updated_at' => now()]));
    }
};
