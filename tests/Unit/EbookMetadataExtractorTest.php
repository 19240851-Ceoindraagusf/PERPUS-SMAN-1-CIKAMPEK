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

    public function test_it_ignores_science_keywords_when_a_non_science_subject_is_the_main_title(): void
    {
        $extractor = new EbookMetadataExtractor();

        $source = "Bahasa Indonesia Cerdas Cergas Berbahasa dan Bersastra Indonesia kelas X\n\nBacaan 1: Mengamati perubahan lingkungan\n\nPada saat itu, siswa membahas kimia dalam contoh sederhana.";

        $this->assertNull($extractor->detectScienceSubjectNameFromText($source));
    }

    public function test_it_extracts_clean_publisher_and_year_metadata(): void
    {
        $extractor = new EbookMetadataExtractor();
        $detectPublisher = new \ReflectionMethod(EbookMetadataExtractor::class, 'detectPublisher');
        $detectYear = new \ReflectionMethod(EbookMetadataExtractor::class, 'detectYear');

        $detectPublisher->setAccessible(true);
        $detectYear->setAccessible(true);

        $text = "Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat\n\n2021";

        $this->assertSame('Pusat Kurikulum dan Perbukuan', $detectPublisher->invoke($extractor, $text));
        $this->assertSame(2021, $detectYear->invoke($extractor, $text, $text));
    }

    public function test_it_builds_subject_description_from_uploaded_ebook_content(): void
    {
        $extractor = new EbookMetadataExtractor();

        $description = $extractor->buildSubjectDescription(
            'Bahasa Indonesia',
            'Bahasa Indonesia Cerdas Cergas Berbahasa dan Bersastra Indonesia',
            'Buku ini membahas keterampilan berbahasa, membaca, menulis, dan memahami teks sastra Indonesia.'
        );

        $this->assertStringContainsString('Bahasa Indonesia', $description);
        $this->assertStringContainsString('berbahasa', strtolower($description));
    }

    public function test_it_matches_shared_cover_subjects_for_ipa_and_ips_slash_names(): void
    {
        $controller = new \App\Http\Controllers\Admin\EbookController();
        $method = new \ReflectionMethod($controller, 'sharedCoverMatchPatterns');
        $method->setAccessible(true);

        $scienceSubject = new \App\Models\Subject();
        $scienceSubject->name = 'IPA / Kimia';

        $this->assertContains('kimia', $method->invoke($controller, $scienceSubject));
        $this->assertContains('ipa / kimia', $method->invoke($controller, $scienceSubject));

        $socialSubject = new \App\Models\Subject();
        $socialSubject->name = 'IPS / Ekonomi';

        $this->assertContains('ekonomi', $method->invoke($controller, $socialSubject));
        $this->assertContains('ips / ekonomi', $method->invoke($controller, $socialSubject));
    }
}
