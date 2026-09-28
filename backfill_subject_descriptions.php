<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Subject::with('ebooks')->orderBy('id')->get() as $subject) {
    $current = trim((string) ($subject->description ?? ''));
    $generic = strtolower($current);
    $isGeneric = $current === ''
        || str_contains($generic, 'mata pelajaran dibuat otomatis')
        || str_contains($generic, 'materi pembelajaran')
        || str_contains($generic, 'berisi materi pembelajaran');

    if (! $isGeneric) {
        continue;
    }

    $ebook = $subject->ebooks()->where('is_active', true)->orderBy('id')->first();

    if ($ebook) {
        $summary = trim((string) ($ebook->description ?: $ebook->title));
        $summary = preg_replace('/\s+/', ' ', $summary) ?: $summary;
        $value = $subject->name . ': ' . $summary;
    } else {
        $value = 'Mata pelajaran ' . $subject->name . ' yang berisi materi pembelajaran dan latihan sesuai kurikulum.';
    }

    $subject->description = strlen($value) > 500 ? substr($value, 0, 497) . '...' : $value;
    $subject->save();

    echo $subject->id . ' | ' . $subject->name . ' | ' . $subject->description . PHP_EOL;
}
