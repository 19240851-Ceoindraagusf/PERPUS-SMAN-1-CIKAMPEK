<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const MAJOR_SUBJECTS = [
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
    ];

    private const MOVED_GENERAL_SUBJECTS = [
        'Matematika',
        'Sejarah',
        'Pendidikan Agama Islam dan Budi Pekerti',
    ];

    public function up(): void
    {
        foreach (['XI', 'XII'] as $grade) {
            $generalClass = DB::table('classes')->where('name', $grade)->first();

            foreach (self::MAJOR_SUBJECTS as $major => $subjectNames) {
                $majorClass = DB::table('classes')->where('name', $grade.' '.$major)->first();

                if (! $majorClass) {
                    continue;
                }

                foreach ($subjectNames as $subjectName) {
                    $subjectId = $this->ensureSubject($majorClass->id, $subjectName);

                    // Bahasa Indonesia dan Bahasa Inggris tetap tersedia pada jurusan
                    // Bahasa, sekaligus dapat dibaca dari jurusan IPA dan IPS.
                    if (in_array($subjectName, ['Bahasa Indonesia', 'Bahasa Inggris'], true) && $major !== 'Bahasa') {
                        $this->copyEbooksFromSubject(
                            $this->subjectId($grade.' Bahasa', $subjectName),
                            $subjectId,
                        );
                    }

                    // Ebook Matematika, Sejarah, dan PAI lama dari kelas umum
                    // dipindahkan secara aman ke masing-masing jurusan IPA dan IPS.
                    if ($major !== 'Bahasa' && in_array($subjectName, self::MOVED_GENERAL_SUBJECTS, true) && $generalClass) {
                        $this->copyEbooksFromSubject(
                            $this->subjectId($generalClass->name, $subjectName),
                            $subjectId,
                        );
                    }
                }
            }

            if ($generalClass) {
                DB::table('subjects')
                    ->where('class_id', $generalClass->id)
                    ->whereIn('name', self::MOVED_GENERAL_SUBJECTS)
                    ->update(['is_active' => false, 'updated_at' => now()]);

                $this->ensureSubject($generalClass->id, 'Informatika');
            }
        }
    }

    public function down(): void
    {
        foreach (['XI', 'XII'] as $grade) {
            $generalClass = DB::table('classes')->where('name', $grade)->first();

            if ($generalClass) {
                DB::table('subjects')
                    ->where('class_id', $generalClass->id)
                    ->whereIn('name', self::MOVED_GENERAL_SUBJECTS)
                    ->update(['is_active' => true, 'updated_at' => now()]);
            }
        }
    }

    private function ensureSubject(int $classId, string $subjectName): int
    {
        $subject = DB::table('subjects')
            ->where('class_id', $classId)
            ->whereRaw('LOWER(name) = ?', [mb_strtolower($subjectName)])
            ->first();

        if ($subject) {
            DB::table('subjects')->where('id', $subject->id)->update([
                'is_active' => true,
                'updated_at' => now(),
            ]);

            return $subject->id;
        }

        return DB::table('subjects')->insertGetId([
            'class_id' => $classId,
            'name' => $subjectName,
            'code' => null,
            'description' => 'Mata pelajaran '.$subjectName.'.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function subjectId(string $className, string $subjectName): ?int
    {
        return DB::table('subjects')
            ->join('classes', 'classes.id', '=', 'subjects.class_id')
            ->where('classes.name', $className)
            ->whereRaw('LOWER(subjects.name) = ?', [mb_strtolower($subjectName)])
            ->value('subjects.id');
    }

    private function copyEbooksFromSubject(?int $sourceSubjectId, int $targetSubjectId): void
    {
        if (! $sourceSubjectId || $sourceSubjectId === $targetSubjectId) {
            return;
        }

        foreach (DB::table('ebooks')->where('subject_id', $sourceSubjectId)->get() as $ebook) {
            $alreadyCopied = DB::table('ebooks')
                ->where('subject_id', $targetSubjectId)
                ->where('title', $ebook->title)
                ->where('file_path', $ebook->file_path)
                ->exists();

            if (! $alreadyCopied) {
                DB::table('ebooks')->insert([
                    'subject_id' => $targetSubjectId,
                    'title' => $ebook->title,
                    'description' => $ebook->description,
                    'author' => $ebook->author,
                    'publisher' => $ebook->publisher,
                    'publication_year' => $ebook->publication_year,
                    'file_path' => $ebook->file_path,
                    'cover_path' => $ebook->cover_path,
                    'is_active' => $ebook->is_active,
                    'created_at' => $ebook->created_at,
                    'updated_at' => $ebook->updated_at,
                ]);
            }
        }
    }
};
