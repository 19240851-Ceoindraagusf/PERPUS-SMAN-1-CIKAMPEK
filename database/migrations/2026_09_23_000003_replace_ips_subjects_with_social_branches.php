<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $ipsSubjects = DB::table('subjects')
            ->whereIn(DB::raw('LOWER(name)'), ['ips', 'ilmu pengetahuan sosial'])
            ->get();

        foreach ($ipsSubjects as $ipsSubject) {
            $branchSubjectIds = $this->branchSubjectIds($ipsSubject->class_id);
            $ebooks = DB::table('ebooks')->where('subject_id', $ipsSubject->id)->get();

            foreach ($ebooks as $ebook) {
                $this->copyEbookToBranches($ebook, $branchSubjectIds);
            }

            DB::table('subjects')->where('id', $ipsSubject->id)->delete();
        }

        foreach (DB::table('classes')->get() as $class) {
            $branchSubjectIds = $this->branchSubjectIds($class->id);
            $ipsEbooks = DB::table('ebooks')
                ->whereIn('subject_id', $branchSubjectIds->values())
                ->where(function ($query) {
                    $query->whereRaw('LOWER(title) LIKE ?', ['%ips%'])
                        ->orWhereRaw('LOWER(title) LIKE ?', ['%ilmu pengetahuan sosial%'])
                        ->orWhereRaw('LOWER(description) LIKE ?', ['%ips%'])
                        ->orWhereRaw('LOWER(description) LIKE ?', ['%ilmu pengetahuan sosial%']);
                })
                ->get();

            foreach ($ipsEbooks as $ebook) {
                $this->copyEbookToBranches($ebook, $branchSubjectIds);
            }
        }
    }

    public function down(): void
    {
        //
    }

    private function branchSubjectIds(int $classId)
    {
        return collect(['Sosiologi', 'Geologi', 'Ekonomi'])
            ->mapWithKeys(function (string $subjectName) use ($classId) {
                $subject = DB::table('subjects')
                    ->where('class_id', $classId)
                    ->whereRaw('LOWER(name) = ?', [strtolower($subjectName)])
                    ->first();

                if ($subject) {
                    DB::table('subjects')->where('id', $subject->id)->update([
                        'is_active' => true,
                        'updated_at' => now(),
                    ]);

                    return [$subjectName => $subject->id];
                }

                $subjectId = DB::table('subjects')->insertGetId([
                    'class_id' => $classId,
                    'name' => $subjectName,
                    'code' => null,
                    'description' => 'Mata pelajaran pengganti IPS.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return [$subjectName => $subjectId];
            });
    }

    private function copyEbookToBranches(object $ebook, $branchSubjectIds): void
    {
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
};
