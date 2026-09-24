<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['XI', 'XII'] as $grade) {
            foreach (['IPA', 'IPS', 'Bahasa'] as $major) {
                DB::table('classes')->updateOrInsert(
                    ['name' => $grade . ' ' . $major],
                    [
                        'description' => 'Kelas ' . $grade . ' jurusan ' . $major,
                        'is_active' => true,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    public function down(): void
    {
        DB::table('classes')
            ->whereIn('name', [
                'XI IPA',
                'XI IPS',
                'XI Bahasa',
                'XII IPA',
                'XII IPS',
                'XII Bahasa',
            ])
            ->delete();
    }
};
