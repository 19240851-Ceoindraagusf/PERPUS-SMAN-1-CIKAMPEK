<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Subject::with('class')->whereIn('name', ['Kimia', 'Fisika', 'Biologi'])->orderBy('id')->get() as $subject) {
    echo 'SUBJECT: ' . $subject->name . ' class=' . $subject->class->name . PHP_EOL;
    foreach ($subject->ebooks()->orderBy('id')->get() as $ebook) {
        echo '  ebook id=' . $ebook->id . ' cover=' . ($ebook->cover_path ?: 'NULL') . PHP_EOL;
    }
}
