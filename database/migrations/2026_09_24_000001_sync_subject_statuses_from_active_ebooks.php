<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $hiddenSubjectNames = [
            'ipa',
            'ilmu pengetahuan alam',
            'ips',
            'ilmu pengetahuan sosial',
        ];

        DB::table('subjects')
            ->whereIn(DB::raw('LOWER(name)'), $hiddenSubjectNames)
            ->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);

        DB::table('subjects')
            ->whereNotIn(DB::raw('LOWER(name)'), $hiddenSubjectNames)
            ->orderBy('id')
            ->get()
            ->each(function ($subject) {
                $hasActiveEbook = DB::table('ebooks')
                    ->where('subject_id', $subject->id)
                    ->where('is_active', true)
                    ->exists();

                DB::table('subjects')->where('id', $subject->id)->update([
                    'is_active' => $hasActiveEbook,
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        //
    }
};
