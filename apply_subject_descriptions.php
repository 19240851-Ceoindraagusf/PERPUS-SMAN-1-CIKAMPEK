<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$map = [
    'Bahasa Indonesia' => 'Mata pelajaran ini membekali peserta didik dengan kemampuan membaca, menulis, berbicara, dan memahami teks sastra serta non-sastra agar dapat berkomunikasi secara efektif dan berkarakter.',
    'Bahasa Inggris' => 'Mata pelajaran ini melatih kemampuan menyimak, berbicara, membaca, dan menulis dalam bahasa Inggris untuk mendukung komunikasi global dan pembelajaran lintas disiplin.',
    'Matematika' => 'Mata pelajaran ini mengembangkan kemampuan berpikir logis, analitis, dan kritis melalui pemecahan masalah numerik, pola, dan hubungan matematis.',
    'Informatika' => 'Mata pelajaran ini memperkenalkan konsep teknologi informasi, algoritma, pemrograman, dan literasi digital untuk mendukung kemampuan berpikir komputasional.',
    'Biologi' => 'Mata pelajaran ini membahas kehidupan makhluk hidup, proses biologis, ekosistem, dan hubungan antarmakhluk hidup dalam lingkungan.',
    'Fisika' => 'Mata pelajaran ini mempelajari fenomena alam, hukum-hukum fisika, dan konsep energi, gaya, serta gerak dalam kehidupan sehari-hari.',
    'Kimia' => 'Mata pelajaran ini membahas struktur materi, reaksi kimia, sifat zat, dan penerapannya dalam kehidupan serta teknologi.',
    'IPS' => 'Mata pelajaran ini membahas kehidupan sosial, ekonomi, geografi, sejarah, dan peran manusia dalam masyarakat serta lingkungan.',
    'Ekonomi' => 'Mata pelajaran ini membahas kegiatan ekonomi, kebutuhan, produksi, distribusi, konsumsi, serta perilaku ekonomi individu dan masyarakat.',
    'Geografi' => 'Mata pelajaran ini mempelajari ruang, wilayah, lingkungan, serta interaksi manusia dengan alam dan kondisi geosfer.',
    'Sosiologi' => 'Mata pelajaran ini mempelajari hubungan sosial, interaksi manusia, kelompok, dan dinamika kehidupan masyarakat.',
    'Sejarah' => 'Mata pelajaran ini menelaah peristiwa masa lalu, nilai sejarah, dan perubahan peradaban untuk menumbuhkan kesadaran kebangsaan.',
    'Pendidikan Agama Islam dan Budi Pekerti' => 'Mata pelajaran ini menumbuhkan keimanan, akhlak mulia, serta pemahaman ajaran Islam dalam kehidupan sehari-hari.',
    'Pendidikan Pancasila' => 'Mata pelajaran ini menanamkan nilai-nilai Pancasila, semangat kebangsaan, dan sikap bela negara dalam kehidupan bermasyarakat.',
    'Bahasa Sunda' => 'Mata pelajaran ini memperkenalkan budaya, bahasa, serta keterampilan berbahasa Sunda untuk menjaga kelestarian warisan budaya lokal.',
    'Bahasa Indonesia Cerdas Cergas Berbahasa dan Bersastra Indonesia' => 'Mata pelajaran ini membekali peserta didik dengan kemampuan membaca, menulis, berbicara, dan memahami teks sastra serta non-sastra agar dapat berkomunikasi secara efektif dan berkarakter.',
    'Bahasa Indonesia Edisi Revisi' => 'Mata pelajaran ini membekali peserta didik dengan kemampuan membaca, menulis, berbicara, dan memahami teks sastra serta non-sastra agar dapat berkomunikasi secara efektif dan berkarakter.',
    'Bahasa Inggris Work in Progress' => 'Mata pelajaran ini melatih kemampuan menyimak, berbicara, membaca, dan menulis dalam bahasa Inggris untuk mendukung komunikasi global dan pembelajaran lintas disiplin.',
    'IPA / Fisika' => 'Mata pelajaran ini mempelajari fenomena alam, hukum-hukum fisika, dan konsep energi, gaya, serta gerak dalam kehidupan sehari-hari.',
    'IPA / Kimia' => 'Mata pelajaran ini membahas struktur materi, reaksi kimia, sifat zat, dan penerapannya dalam kehidupan serta teknologi.',
    'IPA / Biologi' => 'Mata pelajaran ini membahas kehidupan makhluk hidup, proses biologis, ekosistem, dan hubungan antarmakhluk hidup dalam lingkungan.',
    'IPS / Ekonomi' => 'Mata pelajaran ini membahas kegiatan ekonomi, kebutuhan, produksi, distribusi, konsumsi, serta perilaku ekonomi individu dan masyarakat.',
    'IPS / Geografi' => 'Mata pelajaran ini mempelajari ruang, wilayah, lingkungan, serta interaksi manusia dengan alam dan kondisi geosfer.',
    'IPS / Sosiologi' => 'Mata pelajaran ini mempelajari hubungan sosial, interaksi manusia, kelompok, dan dinamika kehidupan masyarakat.',
];

foreach (App\Models\Subject::orderBy('id')->get() as $subject) {
    $name = trim((string) $subject->name);
    $value = $map[$name] ?? 'Mata pelajaran ' . $name . ' yang berisi materi pembelajaran dan latihan sesuai kurikulum.';
    $subject->description = $value;
    $subject->save();
    echo $subject->id . ' | ' . $name . PHP_EOL;
}
