<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $ipaSubjects = DB::table('subjects')
            ->whereIn(DB::raw('LOWER(name)'), ['ipa', 'ilmu pengetahuan alam'])
            ->get();

        foreach ($ipaSubjects as $ipaSubject) {
            $branchSubjectIds = collect(['Kimia', 'Fisika', 'Biologi'])
                ->mapWithKeys(function (string $subjectName) use ($ipaSubject) {
                    $existingSubject = DB::table('subjects')
                        ->where('class_id', $ipaSubject->class_id)
                        ->whereRaw('LOWER(name) = ?', [strtolower($subjectName)])
                        ->first();

                    if ($existingSubject) {
                        DB::table('subjects')->where('id', $existingSubject->id)->update([
                            'is_active' => true,
                            'updated_at' => now(),
                        ]);

                        return [$subjectName => $existingSubject->id];
                    }

                    $subjectId = DB::table('subjects')->insertGetId([
                        'class_id' => $ipaSubject->class_id,
                        'name' => $subjectName,
                        'code' => null,
                        'description' => 'Mata pelajaran pengganti IPA.',
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    return [$subjectName => $subjectId];
                });

            $ebooks = DB::table('ebooks')->where('subject_id', $ipaSubject->id)->get();

            foreach ($ebooks as $ebook) {
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

            DB::table('subjects')->where('id', $ipaSubject->id)->delete();
        }

        $classes = DB::table('classes')->get();

        foreach ($classes as $class) {
            $branchSubjectIds = collect(['Kimia', 'Fisika', 'Biologi'])
                ->mapWithKeys(function (string $subjectName) use ($class) {
                    $subject = DB::table('subjects')
                        ->where('class_id', $class->id)
                        ->whereRaw('LOWER(name) = ?', [strtolower($subjectName)])
                        ->first();

                    return $subject ? [$subjectName => $subject->id] : [];
                });

            if ($branchSubjectIds->count() < 2) {
                continue;
            }

            $scienceEbooks = DB::table('ebooks')
                ->whereIn('subject_id', $branchSubjectIds->values())
                ->get()
                ->filter(function ($ebook) {
                    $source = strtolower(($ebook->title ?? '') . ' ' . ($ebook->description ?? ''));
                    $isGenericIpa = str_contains($source, 'ipa') || str_contains($source, 'ilmu pengetahuan alam');
                    $hasSpecificBranch = str_contains($source, 'kimia')
                        || str_contains($source, 'fisika')
                        || str_contains($source, 'biologi');

                    return $isGenericIpa && ! $hasSpecificBranch;
                });

            foreach ($scienceEbooks as $ebook) {
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
