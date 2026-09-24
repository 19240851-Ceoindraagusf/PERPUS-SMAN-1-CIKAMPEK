<?php

namespace App\Services;

use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Throwable;

class EbookMetadataExtractor
{
    public function extract(UploadedFile $file): array
    {
        $text = $this->extractText($file);
        $source = $this->normalize($file->getClientOriginalName() . "\n" . $text);
        $lines = $this->meaningfulLines($text);

        $class = $this->detectClass($source);
        $isScienceUmbrella = $this->isScienceUmbrellaSource($source);
        $isSocialUmbrella = $this->isSocialUmbrellaSource($source);
        $shouldExpandUmbrellaSubject = $this->shouldExpandUmbrellaSubject($class);
        $subject = (($isScienceUmbrella || $isSocialUmbrella) && $shouldExpandUmbrellaSubject) ? null : $this->detectSubject($source, $class);
        $detectedSubjectName = null;

        if ($subject && $this->isScienceUmbrellaSubject($subject)) {
            $subject = null;
        }

        if (! $class && $subject) {
            $class = $subject->class;
        }

        if (! $subject) {
            $detectedSubjectName = match (true) {
                $isScienceUmbrella && $shouldExpandUmbrellaSubject => 'IPA',
                $isSocialUmbrella && $shouldExpandUmbrellaSubject => 'IPS',
                default => $this->detectKnownSubjectName($source, $shouldExpandUmbrellaSubject),
            };

            if ((! $isScienceUmbrella && ! $isSocialUmbrella) || ! $shouldExpandUmbrellaSubject) {
                $class = $class ?: $this->fallbackClass();
            }
        }

        $displaySubjectName = $subject?->name ?: $detectedSubjectName;
        $title = $this->detectTitle($file, $lines, $displaySubjectName);

        return [
            'class' => $class,
            'subject' => $subject,
            'detected_subject_name' => $detectedSubjectName,
            'title' => $title,
            'author' => $this->extractBlockValue($text, ['penulis', 'author', 'pengarang']) ?: 'Tidak diketahui',
            'publisher' => $this->extractBlockValue($text, ['penerbit', 'publisher'], 4, false) ?: $this->detectPublisher($text),
            'publication_year' => $this->detectYear($text, $source),
            'description' => $this->detectDescription($lines) ?: 'Materi pembelajaran ' . ($displaySubjectName ?: 'e-book') . ' dari file ' . $file->getClientOriginalName() . '.',
            'text_found' => trim($text) !== '',
        ];
    }

    private function extractText(UploadedFile $file): string
    {
        try {
            $layoutProcess = new Process([$this->pdftotextPath(), '-l', '20', '-layout', $file->getRealPath(), '-']);
            $layoutProcess->setTimeout(20);
            $layoutProcess->run();

            $rawProcess = new Process([$this->pdftotextPath(), '-l', '20', '-raw', $file->getRealPath(), '-']);
            $rawProcess->setTimeout(20);
            $rawProcess->run();
        } catch (Throwable) {
            return '';
        }

        if (! $layoutProcess->isSuccessful() && ! $rawProcess->isSuccessful()) {
            return '';
        }

        return trim(($layoutProcess->isSuccessful() ? $layoutProcess->getOutput() : '') . "\n" . ($rawProcess->isSuccessful() ? $rawProcess->getOutput() : ''));
    }

    private function pdftotextPath(): string
    {
        $laragonPath = 'C:\\laragon\\bin\\git\\mingw64\\bin\\pdftotext.exe';

        return file_exists($laragonPath) ? $laragonPath : 'pdftotext';
    }

    private function detectClass(string $source): ?ClassModel
    {
        if ($class = $this->detectExplicitClass($source)) {
            return $class;
        }

        return ClassModel::where('is_active', true)
            ->orderByRaw('LENGTH(name) DESC')
            ->get()
            ->first(fn (ClassModel $class) => collect($this->classAliases($class))
                ->contains(fn (string $alias) => $this->containsToken($source, $alias)));
    }

    private function detectExplicitClass(string $source): ?ClassModel
    {
        if (! preg_match('/(?:kelas|class|grade) (xii|xi|x|12|11|10)(?: |$)/i', $source, $matches)) {
            return null;
        }

        $className = match (strtolower($matches[1])) {
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII',
            default => strtoupper($matches[1]),
        };

        if ($majorClass = $this->detectMajorClass($source, $className)) {
            return $majorClass;
        }

        return ClassModel::where('is_active', true)->where('name', $className)->first();
    }

    private function detectMajorClass(string $source, string $className): ?ClassModel
    {
        if (! in_array($className, ['XI', 'XII'], true)) {
            return null;
        }

        $majorName = match (true) {
            $this->isScienceUmbrellaSource($source) => 'IPA',
            $this->isSocialUmbrellaSource($source) => 'IPS',
            $this->containsToken($source, 'bahasa') || $this->containsToken($source, 'language') => 'Bahasa',
            default => null,
        };

        if (! $majorName) {
            return null;
        }

        return ClassModel::where('is_active', true)
            ->where('name', $className . ' ' . $majorName)
            ->first();
    }

    private function detectSubject(string $source, ?ClassModel $class): ?Subject
    {
        $subjects = Subject::query()
            ->with('class')
            ->when($class, fn ($query) => $query->where('class_id', $class->id))
            ->orderByRaw('LENGTH(name) DESC')
            ->get();

        return $subjects
            ->reject(fn (Subject $subject) => $this->isScienceUmbrellaSubject($subject))
            ->first(fn (Subject $subject) => collect($this->subjectAliases($subject))
                ->contains(fn (string $alias) => $this->containsToken($source, $alias)));
    }

    private function fallbackClass(): ?ClassModel
    {
        $classesWithSubjects = ClassModel::whereHas('subjects')
            ->get();

        if ($classesWithSubjects->count() === 1) {
            return $classesWithSubjects->first();
        }

        return ClassModel::where('is_active', true)->orderBy('name')->first();
    }

    private function detectKnownSubjectName(string $source, bool $allowUmbrellaSubjects = true): ?string
    {
        if ($allowUmbrellaSubjects && $this->isScienceUmbrellaSource($source)) {
            return 'IPA';
        }

        if ($allowUmbrellaSubjects && $this->isSocialUmbrellaSource($source)) {
            return 'IPS';
        }

        if ($scienceSubject = $this->detectScienceSubjectName($source, $allowUmbrellaSubjects)) {
            return $scienceSubject;
        }

        foreach ($this->knownSubjectAliases() as $subjectName => $aliases) {
            if (! $allowUmbrellaSubjects && in_array($subjectName, ['IPA', 'IPS', 'Ilmu Pengetahuan Sosial'], true)) {
                continue;
            }

            foreach ($aliases as $alias) {
                if ($this->containsToken($source, $alias)) {
                    return $subjectName;
                }
            }
        }

        return null;
    }

    public function detectScienceSubjectNameFromText(string $source, bool $allowUmbrellaSubjects = true): ?string
    {
        $source = $this->normalize($source);

        if ($allowUmbrellaSubjects && $this->isScienceUmbrellaSource($source)) {
            return 'IPA';
        }

        if ($allowUmbrellaSubjects && $this->isSocialUmbrellaSource($source)) {
            return 'IPS';
        }

        $scores = [
            'Biologi' => [
                'biologi', 'biology', 'makhluk hidup', 'sel', 'genetik', 'ekosistem',
                'keanekaragaman hayati', 'tumbuhan', 'hewan', 'organisme',
            ],
            'Kimia' => [
                'kimia', 'chemistry', 'atom', 'molekul', 'unsur', 'senyawa',
                'reaksi kimia', 'larutan', 'stoikiometri', 'ikatan kimia',
            ],
            'Fisika' => [
                'fisika', 'physics', 'gerak', 'gaya', 'energi', 'usaha', 'daya',
                'gelombang', 'listrik', 'magnet', 'kalor', 'optik',
            ],
        ];

        $matched = collect($scores)
            ->map(fn (array $keywords, string $subjectName) => [
                'subject' => $subjectName,
                'score' => collect($keywords)->filter(fn (string $keyword) => $this->containsToken($source, $keyword))->count(),
            ])
            ->filter(fn (array $result) => $result['score'] > 0)
            ->sortByDesc('score')
            ->values();

        return $matched->first()['subject'] ?? null;
    }

    private function detectScienceSubjectName(string $source, bool $allowUmbrellaSubjects = true): ?string
    {
        return $this->detectScienceSubjectNameFromText($source, $allowUmbrellaSubjects);
    }

    private function shouldExpandUmbrellaSubject(?ClassModel $class): bool
    {
        if (! $class) {
            return true;
        }

        return ! preg_match('/^(XI|XII)(\s|$)/i', trim($class->name));
    }

    private function isScienceUmbrellaSource(string $source): bool
    {
        return $this->containsToken($source, 'ipa')
            || $this->containsToken($source, 'ilmu pengetahuan alam');
    }

    private function isSocialUmbrellaSource(string $source): bool
    {
        return $this->containsToken($source, 'ips')
            || $this->containsToken($source, 'ilmu pengetahuan sosial');
    }

    private function classAliases(ClassModel $class): array
    {
        $name = trim($class->name);
        $aliases = [
            'kelas ' . $name,
            'class ' . $name,
        ];

        $numbers = [
            'X' => '10',
            'XI' => '11',
            'XII' => '12',
        ];

        $upperName = strtoupper($name);
        if (isset($numbers[$upperName])) {
            $aliases[] = 'kelas ' . $numbers[$upperName];
            $aliases[] = 'class ' . $numbers[$upperName];
            $aliases[] = 'grade ' . $numbers[$upperName];
        }

        if (Str::length($name) > 1) {
            $aliases[] = $name;
        }

        return array_values(array_unique($aliases));
    }

    private function subjectAliases(Subject $subject): array
    {
        $name = trim($subject->name);
        $aliases = [$name];

        if ($subject->code) {
            $aliases[] = $subject->code;
        }

        $normalizedName = $this->normalize($name);
        $knownAliases = $this->knownSubjectAliases();

        foreach ($knownAliases as $subjectName => $subjectAliases) {
            if ($normalizedName === $this->normalize($subjectName)) {
                array_push($aliases, ...$subjectAliases);
            }
        }

        if (Str::startsWith($normalizedName, 'bahasa ') && $normalizedName !== 'bahasa indonesia') {
            $aliases[] = Str::after($normalizedName, 'bahasa ');
        }

        return array_values(array_unique(array_filter($aliases)));
    }

    private function knownSubjectAliases(): array
    {
        return [
            'Bahasa Inggris' => ['bahasa inggris', 'inggris', 'english', 'english language'],
            'Bahasa Indonesia' => ['bahasa indonesia', 'indonesian language'],
            'Bahasa Sunda' => ['bahasa sunda', 'sunda', 'sundanese'],
            'Matematika' => ['matematika', 'math', 'mathematics', 'mathematika'],
            'Informatika' => ['informatika', 'tik', 'komputer', 'computer science', 'informatics'],
            'Kimia' => ['kimia', 'chemistry'],
            'IPA' => ['ipa', 'ilmu pengetahuan alam'],
            'Fisika' => ['fisika', 'physics'],
            'Biologi' => ['biologi', 'biology'],
            'IPS' => ['ips', 'ilmu pengetahuan sosial'],
            'Ilmu Pengetahuan Sosial' => ['ilmu pengetahuan sosial', 'ips', 'sejarah indonesia', 'sosiologi', 'ilmu ekonomi'],
            'Pendidikan Agama Islam dan Budi Pekerti' => ['pendidikan agama islam dan budi pekerti', 'pendidikan agama islam', 'agama islam', 'pai', 'budi pekerti'],
            'Pendidikan Pancasila' => ['pendidikan pancasila', 'pancasila', 'ppkn', 'pkn'],
            'Sejarah' => ['sejarah', 'history'],
            'Sosiologi' => ['sosiologi', 'sociology'],
            'Geologi' => ['geologi', 'geology'],
            'Geografi' => ['geografi', 'geography'],
            'Ekonomi' => ['ekonomi', 'economics'],
        ];
    }

    private function isScienceUmbrellaSubject(Subject $subject): bool
    {
        return in_array($this->normalize($subject->name), [
            'ipa',
            'ilmu pengetahuan alam',
            'ips',
            'ilmu pengetahuan sosial',
        ], true);
    }

    private function detectTitle(UploadedFile $file, Collection $lines, ?string $subjectName): string
    {
        $title = $lines
            ->first(fn (string $line) => $subjectName && $this->normalize($line) === $this->normalize($subjectName))
            ?: $lines
            ->reject(fn (string $line) => $this->looksLikeMetadataLine($line))
            ->reject(fn (string $line) => $this->looksLikeInstitutionLine($line))
            ->reject(fn (string $line) => preg_match('/^\d{4}$/', trim($line)))
            ->first();

        if ($subjectName && (! $title || $this->looksLikeInstitutionLine($title) || $this->looksLikePersonName($title) || preg_match('/^\d{4}$/', trim($title)))) {
            $title = $subjectName;
        }

        return Str::limit($title ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 255, '');
    }

    private function detectYear(string $text, string $source): ?int
    {
        $plainText = preg_replace('/[^\S\r\n]+/', ' ', $text) ?: $text;
        $singleLineText = preg_replace('/\s+/', ' ', $plainText) ?: $plainText;

        if (preg_match('/Cetakan[^0-9\r\n]*(20[0-4][0-9]|19[5-9][0-9])/i', $plainText, $matches)
            || preg_match('/Cetakan[^0-9]*(20[0-4][0-9]|19[5-9][0-9])/i', $singleLineText, $matches)) {
            return (int) $matches[1];
        }

        if (preg_match('/(?:Jakarta|Bogor|Bandung|Yogyakarta|Surabaya)\s*,\s*[^\r\n]*(20[0-4][0-9]|19[5-9][0-9])/i', $plainText, $matches)) {
            return (int) $matches[1];
        }

        if (preg_match('/(?:tahun terbit|terbit|published|publication year)\s*[:\-]?\s*(20[0-4][0-9]|19[5-9][0-9])/i', $singleLineText, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    private function detectDescription(Collection $lines): ?string
    {
        $description = $lines
            ->reject(fn (string $line) => $this->looksLikeMetadataLine($line))
            ->skip(1)
            ->take(4)
            ->implode(' ');

        return $description ? Str::limit($description, 500, '') : null;
    }

    private function extractValue(string $text, array $labels): ?string
    {
        foreach ($labels as $label) {
            if (preg_match('/^\s*' . preg_quote($label, '/') . '\s*[:\-]\s*(.+)$/imu', $text, $matches)) {
                return Str::limit(trim($matches[1]), 255, '');
            }

            if (preg_match('/^\s*' . preg_quote($label, '/') . '\s*$\R+\s*(.+)$/imu', $text, $matches)) {
                return Str::limit(trim($matches[1]), 255, '');
            }
        }

        return null;
    }

    private function extractBlockValue(string $text, array $labels, int $lineLimit = 12, bool $skipInstitutionLines = true): ?string
    {
        $lineValue = $this->extractBlockValueFromLines($text, $labels, $lineLimit, $skipInstitutionLines);
        if ($lineValue) {
            return $lineValue;
        }

        foreach ($labels as $label) {
            if (preg_match('/^\s*' . preg_quote($label, '/') . '\s*[:\-]\s*(.+)$/imu', $text, $matches)) {
                return Str::limit(trim($matches[1]), 255, '');
            }

            if (preg_match('/^\s*' . preg_quote($label, '/') . '\s*$\R+(.+?)(?=^\s*(Penelaah|Penyelia|Ilustrator|Penata Letak|Penyunting|Penerbit|Cetakan|ISBN|Hak Cipta|Disclaimer|Kata Pengantar|Prakata)\b|^\s*(Penelaah|Penyelia|Ilustrator|Penata Letak|Penyunting|Penerbit|Cetakan|ISBN)\s*[:\-]|\z)/imsu', $text, $matches)) {
                $value = collect(preg_split('/\R+/', trim($matches[1])) ?: [])
                    ->map(fn (string $line) => trim(preg_replace('/\s+/', ' ', $line)))
                    ->filter(fn (string $line) => $line !== '' && (! $skipInstitutionLines || ! $this->looksLikeInstitutionLine($line)))
                    ->take($lineLimit)
                    ->implode(', ');

                return $value ? Str::limit($value, 255, '') : null;
            }
        }

        return $this->extractValue($text, $labels);
    }

    private function extractBlockValueFromLines(string $text, array $labels, int $lineLimit, bool $skipInstitutionLines): ?string
    {
        $lines = collect(preg_split('/\R+/', $text) ?: [])
            ->map(fn (string $line) => trim(preg_replace('/\s+/', ' ', $line)))
            ->values();

        $stopLabels = [
            'penulis', 'author', 'pengarang', 'penelaah', 'penyelia', 'ilustrator',
            'penata letak', 'desainer', 'penyunting', 'penerbit', 'cetakan', 'isbn',
            'hak cipta', 'disclaimer', 'kata pengantar', 'prakata',
        ];

        foreach ($lines as $index => $line) {
            $normalizedLine = $this->normalize($line);
            if (! collect($labels)->contains(fn (string $label) => $normalizedLine === $this->normalize($label))) {
                continue;
            }

            $values = [];
            for ($i = $index + 1; $i < $lines->count(); $i++) {
                $candidate = trim($lines[$i]);
                $normalizedCandidate = $this->normalize($candidate);

                if ($candidate === '') {
                    continue;
                }

                if (collect($stopLabels)->contains(fn (string $label) => $normalizedCandidate === $this->normalize($label))) {
                    break;
                }

                if ($skipInstitutionLines && $this->looksLikeInstitutionLine($candidate)) {
                    continue;
                }

                $values[] = $candidate;

                if (count($values) >= $lineLimit) {
                    break;
                }
            }

            if ($values) {
                return Str::limit(implode(', ', $values), 255, '');
            }
        }

        return null;
    }

    private function detectPublisher(string $text): string
    {
        if (preg_match('/(Pusat\s+Perbukuan[^\r\n]*)/iu', $text, $matches)) {
            return Str::limit(trim($matches[1]), 255, '');
        }

        if (preg_match('/(Kementerian\s+Pendidikan[^\r\n]*)/iu', $text, $matches)) {
            return Str::limit(trim($matches[1]), 255, '');
        }

        return 'Tidak diketahui';
    }

    private function meaningfulLines(string $text): Collection
    {
        return collect(preg_split('/\R+/', $text) ?: [])
            ->map(fn (string $line) => trim(preg_replace('/\s+/', ' ', $line)))
            ->filter(fn (string $line) => $line !== '' && Str::length($line) >= 4)
            ->take(25)
            ->values();
    }

    private function containsToken(string $source, string $needle): bool
    {
        $needle = $this->normalize($needle);

        return $needle !== '' && preg_match('/(^|[^a-z0-9])' . preg_quote($needle, '/') . '([^a-z0-9]|$)/i', $source);
    }

    private function looksLikeMetadataLine(string $line): bool
    {
        return preg_match('/^(penulis|author|pengarang|penerbit|publisher|tahun|kelas|mata pelajaran)\s*[:\-]/i', $line)
            || preg_match('/^(isbn|copyright|daftar isi|kata pengantar)\b/i', $line);
    }

    private function looksLikeInstitutionLine(string $line): bool
    {
        return preg_match('/^(kementerian|republik indonesia|badan|pusat|hak cipta|isbn)\b/i', $line);
    }

    private function looksLikePersonName(string $line): bool
    {
        $words = preg_split('/\s+/', trim($line)) ?: [];

        return count($words) >= 2
            && count($words) <= 4
            && ! preg_match('/\b(kelas|sma|smk|untuk|pendidikan|informatika|matematika|bahasa)\b/i', $line);
    }

    private function normalize(string $value): string
    {
        return Str::of($value)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/i', ' ')
            ->squish()
            ->toString();
    }
}
