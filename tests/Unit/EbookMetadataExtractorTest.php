<?php

namespace Tests\Unit;

use App\Services\EbookMetadataExtractor;
use PHPUnit\Framework\TestCase;

class EbookMetadataExtractorTest extends TestCase
{
    public function test_it_detects_science_subjects_from_ipa_text(): void
    {
        $extractor = new EbookMetadataExtractor();

        $this->assertSame('Kimia', $extractor->detectScienceSubjectNameFromText('Buku IPA Kimia kelas X untuk SMA'));
        $this->assertSame('Fisika', $extractor->detectScienceSubjectNameFromText('Modul Fisika kelas XI dengan materi listrik dan magnet'));
        $this->assertSame('Biologi', $extractor->detectScienceSubjectNameFromText('Ringkasan Biologi tentang sel, ekosistem, dan makhluk hidup'));
    }
}
