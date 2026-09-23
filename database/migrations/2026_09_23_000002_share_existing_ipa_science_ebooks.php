<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (DB::table('classes')->get() as $class) {
            $branchSubjectIds = collect(['Kimia', 'Fisika', 'Biologi'])
                ->mapWithKeys(function (string $subjectName) use ($class) {
                    $subject = DB::table('subjects')
                        ->where('class_id', $class->id)
                        ->whereRaw('LOWER(name) = ?', [strtolower($subjectName)])
                        ->first();

                    if ($subject) {
                        return [$subjectName => $subject->id];
                    }

                    $subjectId = DB::table('subjects')->insertGetId([
                        'class_id' => $class->id,
                        'name' => $subjectName,
                        'code' => null,
                        'description' => 'Mata pelajaran pengganti IPA.',
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    return [$subjectName => $subjectId];
                });

            $ipaEbooks = DB::table('ebooks')
                ->whereIn('subject_id', $branchSubjectIds->values())
                ->where(function ($query) {
                    $query->whereRaw('LOWER(title) LIKE ?', ['%ipa%'])
                        ->orWhereRaw('LOWER(title) LIKE ?', ['%ilmu pengetahuan alam%'])
                        ->orWhereRaw('LOWER(description) LIKE ?', ['%ipa%'])
                        ->orWhereRaw('LOWER(description) LIKE ?', ['%ilmu pengetahuan alam%']);
                })
                ->get();

            foreach ($ipaEbooks as $ebook) {
                foreach ($branchSubjectIds as $subjectId) {
                    $alreadyExists = DB::table('ebooks')
                        ->where('subject_id', $subjectId)
                        ->where('title', $ebook->title)
                        ->where('file_path', $ebook->file_path)
                        ->exists();

                    if ($alreadyExists) {
                        continue;
                    }

                    DB::table('ebooks')->insert([
                        'subject_id' => $subjectId,
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
    }

    public function down(): void
    {
        //
    }
};
