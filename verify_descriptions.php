<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Subject::orderBy('id')->get() as $s) {
    echo $s->id . ' | ' . $s->name . ' | ' . $s->description . PHP_EOL;
}
