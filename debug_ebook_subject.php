<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ebook = App\Models\Ebook::find(15);
if ($ebook) {
    echo $ebook->id . ' | ' . $ebook->title . ' | subject=' . optional($ebook->subject)->name . "\n";
} else {
    echo "NOT_FOUND\n";
}
