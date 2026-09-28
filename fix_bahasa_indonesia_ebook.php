<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$class = App\Models\ClassModel::where('name', 'X')->first();
if (! $class) {
    echo "CLASS_X_NOT_FOUND\n";
    exit(1);
}

$properSubject = App\Models\Subject::firstOrCreate(
    ['class_id' => $class->id, 'name' => 'Bahasa Indonesia'],
    ['code' => null, 'description' => 'Mata pelajaran dibuat otomatis.', 'is_active' => true]
);

$ebook = App\Models\Ebook::where('title', 'Kimia')->first();
if ($ebook) {
    $ebook->subject_id = $properSubject->id;
    $ebook->title = 'Bahasa Indonesia Cerdas Cergas Berbahasa dan Bersastra Indonesia';
    $ebook->description = 'Bahasa Indonesia Cerdas Cergas Berbahasa dan Bersastra Indonesia untuk kelas X.';
    $ebook->save();
    echo "UPDATED_EBOOK=" . $ebook->id . "\n";
} else {
    echo "EBOOK_NOT_FOUND\n";
}

$wrongSubject = App\Models\Subject::where('name', 'Bahasa Indonesia Cerdas Cergas Berbahasa dan Bersastra Indonesia')->first();
if ($wrongSubject && $wrongSubject->id !== $properSubject->id) {
    $wrongSubject->update(['is_active' => false]);
    echo "DISABLED_WRONG_SUBJECT=" . $wrongSubject->id . "\n";
}
