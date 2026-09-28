<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$genericPatterns = [
    '/^(ipa|ips|bahasa|matematika|informatika|kimia|fisika|biologi|geografi|ekonomi|sosiologi|pendidikan)$/i',
    '/^(bahasa indonesia|bahasa inggris|bahasa sunda|pendidikan pancasila|pendidikan agama islam)$/i',
    '/^(kementerian pendidikan|kekementerian pendidikan)/i',
];

$updated = 0;

foreach (App\Models\Ebook::with('subject')->orderBy('id')->get() as $ebook) {
    $originalTitle = trim((string) $ebook->title);
    $subjectName = trim((string) ($ebook->subject?->name ?? ''));

    $needsGenericTitleFix = $originalTitle === ''
        || preg_match('/^(ipa|ips|bahasa|bahasa indonesia|bahasa inggris|matematika|informatika|kimia|fisika|biologi|geografi|ekonomi|sosiologi|pendidikan|pendidikan pancasila|kementerian pendidikan)$/i', $originalTitle)
        || preg_match('/^(kekementerian pendidikan|ke kementerian pendidikan)/i', $originalTitle)
        || str_contains(strtoupper($originalTitle), 'KEMENTERIAN')
        || str_contains(strtoupper($originalTitle), 'KEKEMENTERIAN');

    if ($needsGenericTitleFix && $subjectName !== '') {
        $ebook->title = $subjectName;
        $updated++;
    }

    $matchingSubject = App\Models\Subject::query()
        ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim((string) $ebook->title))])
        ->first();

    if ($matchingSubject && $ebook->subject_id !== $matchingSubject->id) {
        $ebook->subject_id = $matchingSubject->id;
        $updated++;
    }

    if ($ebook->description === null || trim((string) $ebook->description) === '') {
        $ebook->description = $ebook->subject?->description
            ?? 'Mata pelajaran ' . ($ebook->subject?->name ?? 'E-book') . ' yang berisi materi pembelajaran dan latihan sesuai kurikulum.';
        $updated++;
    }

    $ebook->save();
}

echo "UPDATED_ROWS={$updated}\n";
foreach (App\Models\Ebook::with('subject')->orderBy('id')->get() as $ebook) {
    echo $ebook->id . ' | ' . $ebook->title . ' | ' . optional($ebook->subject)->name . PHP_EOL;
}
