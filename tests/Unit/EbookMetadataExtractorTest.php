<?php

namespace Tests\Unit;

use App\Services\EbookMetadataExtractor;
use PHPUnit\Framework\TestCase;

class EbookMetadataExtractorTest extends TestCase
{
    public function test_it_detects_science_subjects_from_ipa_text(): void
    {
        $extractor = new EbookMetadataExtractor();

        $this->assertSame('IPA', $extractor->detectScienceSubjectNameFromText('Buku IPA kelas X untuk SMA'));
        $this->assertSame('IPA', $extractor->detectScienceSubjectNameFromText('Buku IPA Kimia kelas X untuk SMA'));
        $this->assertSame('IPA', $extractor->detectScienceSubjectNameFromText('Buku IPA dengan bab sel dan ekosistem'));
        $this->assertSame('Kimia', $extractor->detectScienceSubjectNameFromText('Buku IPA Kimia kelas XII untuk SMA', false));
        $this->assertNull($extractor->detectScienceSubjectNameFromText('Buku IPA kelas XII untuk SMA', false));
        $this->assertSame('Kimia', $extractor->detectScienceSubjectNameFromText('Buku Kimia kelas X untuk SMA'));
        $this->assertSame('Fisika', $extractor->detectScienceSubjectNameFromText('Modul Fisika kelas XI dengan materi listrik dan magnet'));
        $this->assertSame('Biologi', $extractor->detectScienceSubjectNameFromText('Ringkasan Biologi tentang sel, ekosistem, dan makhluk hidup'));
        $this->assertSame('IPS', $extractor->detectScienceSubjectNameFromText('Buku IPS kelas X untuk SMA'));
        $this->assertSame('IPS', $extractor->detectScienceSubjectNameFromText('Buku IPS dengan materi sosiologi dan ekonomi'));
        $this->assertNull($extractor->detectScienceSubjectNameFromText('Buku IPS kelas XII untuk SMA', false));
    }
}
