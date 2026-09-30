<?php

namespace App\Console\Commands;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class EnsureAdminAndBaseData extends Command
{
    protected $signature = 'admin:ensure-base
        {--email=admin@perpus.test : Email admin}
        {--name=Admin Perpustakaan : Nama admin}
        {--password=password : Password admin}
        {--no-subjects : Jangan membuat subject dasar jika tidak diperlukan}';

    protected $description = 'Create a safe admin account and base school classes/subjects without deleting existing data.';

    public function handle(): int
    {
        $email = trim((string) $this->option('email'));
        $name = trim((string) $this->option('name'));
        $password = (string) $this->option('password');

        if ($email === '') {
            $this->error('Email admin tidak boleh kosong.');

            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name !== '' ? $name : 'Admin Perpustakaan';
        $user->role = 'admin';
        $user->password = Hash::make($password !== '' ? $password : 'password');
        $user->save();

        $this->info('Akun admin siap dipakai: '.$user->email);

        if ($this->option('no-subjects')) {
            return self::SUCCESS;
        }

        $baseClassNames = ['X', 'XI', 'XII'];
        $majorClassMap = [
            'XI' => ['IPA', 'IPS', 'Bahasa'],
            'XII' => ['IPA', 'IPS', 'Bahasa'],
        ];

        foreach ($baseClassNames as $grade) {
            $gradeClass = ClassModel::firstOrCreate(
                ['name' => $grade],
                ['description' => 'Kelas '.$grade, 'is_active' => true],
            );

            $defaultSubjects = $grade === 'X'
                ? ['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika']
                : ['Informatika'];

            foreach ($defaultSubjects as $subjectName) {
                Subject::firstOrCreate(
                    ['class_id' => $gradeClass->id, 'name' => $subjectName],
                    ['description' => 'Mata pelajaran dasar untuk '.$gradeClass->name, 'is_active' => true],
                );
            }

            foreach ($majorClassMap[$grade] ?? [] as $major) {
                $majorClassName = $grade.' '.$major;
                $majorClass = ClassModel::firstOrCreate(
                    ['name' => $majorClassName],
                    ['description' => 'Kelas '.$majorClassName, 'is_active' => true],
                );

                $majorSubjects = match ($major) {
                    'IPA' => [
                        'Kimia', 'Fisika', 'Biologi', 'Matematika', 'Bahasa Indonesia',
                        'Bahasa Inggris', 'Sejarah', 'Pendidikan Pancasila',
                        'Pendidikan Agama Islam dan Budi Pekerti',
                    ],
                    'IPS' => [
                        'Ekonomi', 'Geografi', 'Sosiologi', 'Pendidikan Pancasila',
                        'Bahasa Indonesia', 'Bahasa Inggris', 'Matematika',
                        'Pendidikan Agama Islam dan Budi Pekerti', 'Sejarah',
                    ],
                    'Bahasa' => ['Bahasa Indonesia', 'Bahasa Inggris', 'Bahasa Sunda'],
                    default => ['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika'],
                };

                foreach ($majorSubjects as $subjectName) {
                    Subject::firstOrCreate(
                        ['class_id' => $majorClass->id, 'name' => $subjectName],
                        ['description' => 'Mata pelajaran '.$subjectName.' untuk '.$majorClassName, 'is_active' => true],
                    );
                }
            }
        }

        $this->info('Struktur kelas, jurusan, dan subject dasar berhasil dibuat atau dipastikan ada tanpa menghapus data lama.');

        return self::SUCCESS;
    }
}
