<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $geologiSubjects = DB::table('subjects')
            ->whereRaw('LOWER(name) = ?', ['geologi'])
            ->get(['id', 'class_id']);

        foreach ($geologiSubjects as $subject) {
            $geografiSubject = DB::table('subjects')
                ->where('class_id', $subject->class_id)
                ->whereRaw('LOWER(name) = ?', ['geografi'])
                ->first(['id']);

            if (! $geografiSubject) {
                DB::table('subjects')->where('id', $subject->id)->update([
                    'name' => 'Geografi',
                    'updated_at' => now(),
                ]);

                continue;
            }

            DB::table('ebooks')
                ->where('subject_id', $subject->id)
                ->update([
                    'subject_id' => $geografiSubject->id,
                    'updated_at' => now(),
                ]);

            DB::table('subjects')->where('id', $subject->id)->delete();
        }
    }

    public function down(): void
    {
        // A rollback must not rename legitimate Geografi records back to Geologi.
    }
};
