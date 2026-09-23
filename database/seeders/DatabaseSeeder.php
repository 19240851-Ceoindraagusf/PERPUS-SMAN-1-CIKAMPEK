<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@perpus.test'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $classes = [
            ['name' => 'X', 'description' => 'Kelas X'],
            ['name' => 'XI', 'description' => 'Kelas XI'],
            ['name' => 'XII', 'description' => 'Kelas XII'],
        ];

        foreach ($classes as $classData) {
            ClassModel::firstOrCreate(['name' => $classData['name']], $classData);
        }

        $classX = ClassModel::where('name', 'X')->first();

        // Data contoh untuk development. Data resmi akan dimasukkan setelah validasi dari perpustakaan.
        foreach (['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika', 'Kimia', 'Fisika', 'Biologi'] as $subjectName) {
            Subject::firstOrCreate(
                ['class_id' => $classX->id, 'name' => $subjectName],
                ['description' => 'Contoh mata pelajaran untuk pengembangan awal.']
            );
        }
    }
}
