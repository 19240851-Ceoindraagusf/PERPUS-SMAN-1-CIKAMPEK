<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Ebook::with('subject')->orderBy('id')->get() as $ebook) {
    echo $ebook->id . ' | ' . $ebook->title . ' | author=' . $ebook->author . ' | publisher=' . $ebook->publisher . ' | year=' . $ebook->publication_year . ' | subject=' . optional($ebook->subject)->name . PHP_EOL;
}
